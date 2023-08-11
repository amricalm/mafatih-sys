@extends('layouts.pdf-template')
@section('header')
@endsection
@section('isi')
    @php
        App::setLocale('ar');
        $result_decision_level = \App\SmartSystem\General::pilihan_ar($result_decision_level);
    @endphp
    <div id="watermark">
        <div id="logo" style="margin-top:-20px; font-size:20px; font-weight:bold;">
            <div align="center" style="margin-bottom: -5px;">
                كشف الدرجات لمادة القرآن الكريم
            </div>
            <div align="center" style="margin-bottom: -5px;">
                المرحلة المتوسطة لكلية الأئمة والحفاظ
            </div>
            <div align="center" style="margin-bottom: -5px;">
                الفصل الدراسي {{ $term['desc_ar'] }} لعام {{ $tahun['arab'] }}هـ /{{ $tahun['masehi'] }} م
            </div>
            <div style="text-align:center; padding-bottom: 8px;">
                معهد شرف الحرمين - بوغور - جاوى الغربية - إندونيسيا
            </div>
        </div>
        <div style="padding-left: 2px; padding-right: 2px; margin: 5px 0 5px 0; font-size:16px; font-weight:bold;">
            <div style="float: left; width: 30%;" align="right">
                مقرر المستوى : {{ Lang::get('juz_has_tasmik.'.$mustawa,[],'ar') }}
            </div>
            <div style="float: left; width: 35%; direction: rtl;">
                الصف : {{ $kelas->desc_ar }}/{{ ($kelas->name_ar=='') ? $kelas->name : $kelas->name_ar }}
            </div>
            <div style="float: right; width: 35%; direction: rtl;">
                اسم {{ $studentName }}
            </div>
        </div>
        <div style="padding-left: 2px; padding-right: 2px; margin: 5px 0 5px 0; font-size:16px; font-weight:bold;">
            <div style="float: left; width: 30%;" align="right">
                الجزء المقرر : {{ ($result_hdr['mm']!='') ? Lang::get('juz_has_tasmik.'.$result_hdr['mm'],[],'ar') : '-' }}
            </div>
            <div style="float: left; width: 35%; direction: rtl;">
                رقم القيد : {{ \App\SmartSystem\General::angka_arab($student['nis']) }}
            </div>
            <div style="float: right; width: 35%; direction: rtl;">
                الحلقة : {{ str_replace('(بنات)','',str_replace('(بنين)','',$result_hdr['name_ar'])) }}
            </div>
        </div>
        <div style="padding-left: 2px; padding-right: 2px; margin: 5px 0 5px 0; font-size:16px; font-weight:bold;">
            <div style="float: left; width: 30%;" align="right">
                الجزء الذي تم تسميعه : @lang('juz_has_tasmik.'.$juz_has_tasmik)
            </div>
            <div style="float: left; width: 35%; direction: rtl;">
                &nbsp;
            </div>
            <div style="float: right; width: 35%; direction: rtl;">
                {{ \App\SmartSystem\General::getGenderAr($result_hdr['teachersex']) }} الحلقة : {{ \App\SmartSystem\General::ustadz($result_hdr['teachersex']).' '.$result_hdr['teachernamear'] }}
            </div>
        </div>
        <table style="width:100%; text-align:center; border:solid 2px #000000;" dir="rtl">
            <thead style="font-weight:bold;">
                <tr>
                    <th style="width: 5%; font-size:16px;">الرقم</th>
                    <th colspan="2" style="font-size:16px;">معايير التقويم</th>
                    <th style="width: 35%; font-size:16px;">النتيجة</th>
                </tr>
            </thead>
            <tbody class="list">
                @php
                    $no = 1;
                    $jmlhtot = 0;
                    $jml = 0;
                @endphp
                @foreach ($result as $key => $val)
                    @php
                        $jml+=$jmlhtot;
                        $colspan = ($val['is_group']=='1') ? '' : 'colspan="2"';
                    @endphp
                    @if ($no==1&&$colspan=='')
                    <tr>
                        <td class="garistd">{{ \App\SmartSystem\General::angka_arab($no) }}</td>
                        <td rowspan="{{ $jmh_group }}" class="garistd">الاختبار الشفهي</td>
                        <td {!! $colspan !!} class="garistd">{{ $val['weightnamear'] }}</td>
                        <td class="garistd">{{ \App\SmartSystem\General::angka_arab(number_format($val['result_evaluation'])) }}</td>
                    </tr>
                    @else
                    <tr>
                        <td class="garistd">{{ \App\SmartSystem\General::angka_arab($no) }}</td>
                        <td {!! $colspan !!} class="garistd">{{ $val['weightnamear'] }}</td>
                        <td class="garistd">{{ \App\SmartSystem\General::angka_arab(number_format($val['result_evaluation'])) }}</td>
                    </tr>
                    @endif
                    @php
                        $jmlhtot += $jml;
                        $no++;
                    @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="garistd">مجموعة النتيجة</td>
                    <td class="garistd">{{ \App\SmartSystem\General::angka_arab(number_format($result_hdr['result_set'],2,'.',',')) }}</td>
                </tr>
            </tfoot>
        </table>
        <br/>
        <table style="text-align:center; width:100%; border:solid 2px #000000;" dir="rtl">
            <tr>
                <td colspan="2" style="font-size:16px;">&nbsp;</td>
            </tr>
            <tr>
                <td class="text-align-center" style="width: 65%; font-size:16px; width:">نتيجة مقرر الحلقة </td>
                <td class="text-align-center" style="width: 35%; font-size:16px;">{{ $result_hdr['result_decision_set'] }}</td>
            </tr>
            <tr>
                <td class="text-align-center" style="font-size:16px;">التقدير</td>
                <td class="text-align-center" style="font-size:16px;">{{ $result_hdr['result_appreciation'] }}</td>
            </tr>
            <tr>
                <td class="text-align-center" style="font-size:16px;">مقرر المستوى</td>
                @php
                    // $r = mb_detect_encoding($result_hdr['result_decision_level'],['ASCII','UTF-8'],false);
                    // $result_decision_level = ($r=='ASCII') ? \App\SmartSystem\General::pilihan_ar($result_hdr['result_decision_level']) : $result_hdr['result_decision_level'];
                @endphp
                <td class="text-align-center" style="font-size:16px;">{{ $result_decision_level }}</td>
            </tr>
        </table>
        <br/>
        <table style="text-align:center; width:100%; border:solid 2px #000000;">
            <tr>
                <td style="font-size:16px;">ملاحظة {{ \App\SmartSystem\General::getGenderAr($result_hdr['teachersex'],'al') }}</td>
            </tr>
            <tr>
                <td style="font-size:16px; height: 150px; direction:ltr;">{{ $result_hdr['result_notes'] }}</td>
            </tr>
        </table>
        <br/>
        <div style="text-align: center; font-size:16px; font-weight:normal; padding-bottom:-5px;">
            تحريرا بمعهد شرف الحرمين:
        </div>
        <div style="text-align: center; font-size:16px; font-weight:normal;">
            بوغور، {{ $tgl_hj_raport }} هـ / {{ $tgl_raport }} م
        </div>
        <table style="width:100%; border:none; margin-top:5px;" dir="rtl">
            <thead>
                <tr>
                    <th style="text-align: center; font-size:16px; width:33.3%; font-weight:bold; border:none;">رئيس المدرسة</th>
                    <th style="text-align: center; font-size:16px; width:33.3%; font-weight:bold; border:none;">{{ \App\SmartSystem\General::getGenderAr($result_hdr['teachersex']) }} الحلقة</th>
                    <th style="text-align: center; font-size:16px; width:33.3%; font-weight:bold; border:none;">ولي الأمر</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="vertical-align:bottom;text-align:center; font-size:16px; font-weight:bold; border:none; height:80px;">
                        {{ \App\SmartSystem\General::ustadz($atribut['headMaster']['sex']). ' ' .$atribut['headMaster']['name_ar'] }}
                    </td>
                    <td style="vertical-align:bottom;text-align:center; font-size:16px; font-weight:bold; border:none;">
                        {{ \App\SmartSystem\General::ustadz($result_hdr['teachersex']). ' ' .$result_hdr['teachernamear'] }}
                    </td>
                    <td style="vertical-align:bottom;text-align:center; font-size:16px; font-weight:bold; border:none;">____________________</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
