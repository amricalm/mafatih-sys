@extends('layouts.app')

@push('css')
<style>
    td.garistd{
        text-align:center;
        font-size:15px;
        border:solid 1px #000000;
    }
    th.garisdouble{
        border : 1px solid #000000;
        border-bottom: double #000000;
    }
</style>
@endpush
@section('content')
    @php
        App::setLocale('ar');
    @endphp
    <div class="container-fluid pt-7">
        <div class="header">
            <div class="header-body">
                <div class="row">
                    <div class="col-lg-6">
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page"><a href="#">Raport Bayanat Quran</a></li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-lg-6 text-right">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="{{ url('raport/'.$student->id.'/rq/print/pdf') }}" class="btn btn-sm btn-primary"><i class="fa fa-print"></i> Print</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        @php
            $result_decision_level = \App\SmartSystem\General::pilihan_ar($result_decision_level);
        @endphp
        <div id="watermark" class="arabic">
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
            <table style="text-align:right; width:100%; font-weight:bold;">
                <tr>
                    <td class="text-align-right" style="width: 33%; font-size:16px;">اسم {{ $studentName }}</td>
                    <td class="text-align-right" style="width: 33%; font-size:16px;">
                    الصف : {{ $kelas->desc_ar }}/{{ ($kelas->name_ar=='') ? $kelas->name : $kelas->name_ar }}
                    </td>
                    <td class="text-align-right" style="width: 33%; font-size:16px;">مقرر المستوى : {{ Lang::get('juz_has_tasmik.'.$mustawa,[],'ar') }}</td>
                </tr>
                <tr>
                    <td class="text-align-right" style="width: 33%; font-size:16px;">
                        الحلقة : {{ str_replace('(بنات)','',str_replace('(بنين)','',$result_hdr['name_ar'])) }}
                    </td>
                    <td class="text-align-right" style="width: 33%; font-size:16px;">رقم القيد : {{ \App\SmartSystem\General::angka_arab($student['nis']) }}</td>
                    <td class="text-align-right" style="width: 33%; font-size:16px;">الجزء المقرر : {{ ($result_hdr['mm']!='') ? Lang::get('juz_has_tasmik.'.$result_hdr['mm'],[],'ar') : '-' }}</td>
                </tr>
                <tr>
                    <td class="text-align-right" style="width: 33%; font-size:16px;">{{ \App\SmartSystem\General::getGenderAr($result_hdr['teachersex']) }} الحلقة : {{ \App\SmartSystem\General::ustadz($result_hdr['teachersex']).' '.$result_hdr['teachernamear'] }}</td>
                    <td class="text-align-right" style="width: 33%; font-size:16px;">&nbsp;</td>
                    <td class="text-align-right" style="width: 33%; font-size:16px;">الجزء الذي تم تسميعه : @lang('juz_has_tasmik.'.$juz_has_tasmik)</td>
                </tr>
            </table>
            <br>
            <table style="width:100%; text-align:center; border:solid 1px #000000;" dir="rtl">
                <thead style="font-weight:bold;">
                    <tr>
                        <th style="width:5%; font-size:16px;" class="garisdouble">الرقم</th>
                        <th colspan="2" style="font-size:16px;" class="garisdouble">معايير التقويم</th>
                        <th style="width: 35%; font-size:16px;" class="garisdouble">النتيجة</th>
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
            <table style="text-align:center; width:100%; border:solid 1px #000000;" dir="rtl">
                <tr>
                    <td colspan="2" style="font-size:16px;">&nbsp;</td>
                </tr>
                <tr>
                    <td class="text-align-center" style="width: 65%; font-size:16px;  border:solid 1px #000000;">نتيجة مقرر الحلقة </td>
                    <td class="text-align-center" style="width: 35%; font-size:16px; border:solid 1px #000000;">{{ $result_hdr['result_decision_set'] }}</td>
                </tr>
                <tr>
                    <td class="text-align-center" style="font-size:16px; border:solid 1px #000000;">التقدير</td>
                    <td class="text-align-center" style="font-size:16px; border:solid 1px #000000;">{{ $result_hdr['result_appreciation'] }}</td>
                </tr>
                <tr>
                    <td class="text-align-center" style="font-size:16px; border:solid 1px #000000;">مقرر المستوى</td>
                    @php
                        // $r = mb_detect_encoding($result_hdr['result_decision_level'],['ASCII','UTF-8'],false);
                        // $result_decision_level = ($r=='ASCII') ? \App\SmartSystem\General::pilihan_ar($result_hdr['result_decision_level']) : $result_hdr['result_decision_level'];
                    @endphp
                    <td class="text-align-center" style="font-size:16px; border:solid 1px #000000;">{{ $nilaiqurantingkat }}</td>
                </tr>
            </table>
            <br/>
            <table style="text-align:center; width:100%; border:solid 1px #000000;">
                <tr>
                    <td style="font-size:16px;">ملاحظة {{ \App\SmartSystem\General::getGenderAr($result_hdr['teachersex'],'al') }}</td>
                </tr>
                <tr>
                    <td style="font-size:16px; height: 150px; border:solid 1px #000000; direction:ltr;">{{ $result_hdr['result_notes'] }}</td>
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
                        <td style="vertical-align:bottom;text-align:center; font-size:16px; font-weight:bold; border:none; height:80px;">
                            {{ \App\SmartSystem\General::ustadz($result_hdr['teachersex']). ' ' .$result_hdr['teachernamear'] }}
                        </td>
                        <td style="vertical-align:bottom;text-align:center; font-size:16px; font-weight:bold; border:none; height:80px;">
                            ____________________
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        @include('layouts.footers.auth')
    </div>
@endsection
