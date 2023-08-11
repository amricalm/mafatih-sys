@extends('layouts.pdf-template')
@section('header')
@endsection
@section('isi')
    <div id="watermark">
        <div id="logo" style="margin-top: 0px; font-size:20px; font-weight:bold; border: solid 2px #000000;">
            <div style="text-align:center; margin-bottom: -8px; padding-top: 8px;">
                كشف الدرجات لتنمية أنشطة الطلاب
            </div>
            <div style="text-align:center; margin-bottom: -8px;">
                المرحلة المتوسطة لكلية الأئمة والحفاظ
            </div>
            <div style="text-align:center; margin-bottom: -8px;">
                الفصل الدراسي {{ $term['desc_ar'] }} لعام {{ $tahun['arab'] }}هـ/{{ $tahun['masehi'] }} م
            </div>
            <div style="text-align:center; padding-bottom: 8px;">
                معهد شرف الحرمين - بوغور - جاوى الغربية - إندونيسيا
            </div>
        </div>
        <div style="padding-left: 2px; padding-right: 2px; margin: 5px 0 5px 0; font-size:16px; font-weight:bold;">
            <div style="float: left; width: 18%;" align="right">
                رقم القيد : {{ \App\SmartSystem\General::angka_arab($student->nis) }}
            </div>
            <div style="float: left; width: 40%; direction: rtl;">
                الصف : {{ $kelas->desc_ar }}/{{ ($kelas->name_ar=='') ? $kelas->name : $kelas->name_ar }}
            </div>
            <div style="float: right; width: 40%; direction: rtl;">
                اسم {{ $studentName }}
            </div>
        </div>
        <div>
            <table style="width:100%; text-align:right; border:solid 2px #000000;" dir="rtl">
                <thead style="font-weight:bold;">
                    <tr style="border-bottom:solid 2px #000000;">
                        <th style="width: 5%; font-size:16px;">الرقم</th>
                        <th style="width: 23%; font-size:16px; border-left:none;">النشاط</th>
                        <th style="width: 23%; font-size:16px; border-right:none;">Activity</th>
                        <th style="width: 27%; font-size:16px;">البيانات</th>
                        <th style="width: 23%; font-size:16px;">النتيجة والتقدير</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($group as $keyGroup => $valGroup)
                        <tr>
                            <td style="text-align: center; font-size:14px;">{{ \App\SmartSystem\General::angka_arab($no) }}</td>
                            <td style="text-align: center; font-size:14px; border-left:none; font-weight:bold;">{{ $valGroup['name_ar'] }}</td>
                            <td style="text-align: left; font-size:14px; border-right:none; font-style: italic;">{{ $valGroup['name_en'] }}</td>
                            <td>
                                <table class="sub-table">
                                    @foreach ($data as $key => $val)
                                        @if ($val['group_id'] == $valGroup['id'])
                                        <tr>
                                            <td style="font-size:14px;">{{ $val['name_ar'] }}</td>
                                        </tr>
                                        @endif
                                    @endforeach
                                </table>
                            </td>
                            <td>
                                <table class="sub-table">
                                    @foreach ($data as $key => $val)
                                        @if ($val['group_id'] == $valGroup['id'])
                                        <tr>
                                            @foreach($finalboardingdtl as $k=>$v)
                                                @if($val['id'] == $v['subject_id'])
                                                    <td style="text-align: center; font-size:14px;" dir="ltr">
                                                        @if ($val['type'] == "ITEM")
                                                            @if (is_numeric($v['letter_grade']))
                                                                {{ \App\SmartSystem\General::angka_arab(trim($v['letter_grade']) ?? 0) }}
                                                            @else
                                                                {{ !empty($v['letter_grade']) ? $v['letter_grade'] : '-' }}
                                                            @endif
                                                        @else
                                                            @php $final_grade = is_numeric($v['final_grade']) ? number_format($v['final_grade']) : 0; @endphp
                                                            {{ \App\SmartSystem\General::angka_arab($final_grade ?? 0) }}
                                                        @endif
                                                    </td>
                                                @endif
                                            @endforeach
                                        </tr>
                                        @endif
                                    @endforeach
                                </table>
                            </td>
                        </tr>
                    @php
                        $no++;
                    @endphp
                    @endforeach
                </tbody>
            </table>
            <div style="width:100%; text-align:right; font-size:16px; font-weight:bold;">الملاحظة</div>
            <div style="width:100%; border: solid 2px #000000; height:50px; vertical-align:middle; padding: 2px 10px 2px 10px; text-align:center; font-size:14px; font-weight:normal;">
                {{ $final->note_boarding ?? '' }}
            </div>
        </div>
        <div style="text-align: center; font-size:16px; font-weight:normal; padding-bottom:-5px;">
            :تحريرا بمعهد شرف الحرمين
        </div>
        <div style="text-align: center; font-size:16px; font-weight:normal;">
            بوغور، {{ $tgl_hj_raport }} هـ / {{ $tgl_raport }} م
        </div>
        <table style="width:100%; border:none; margin-top:5px;" dir="rtl">
            <thead>
                <tr>
                    <th style="text-align: center; font-size:16px; width:33.3%; font-weight:bold; border:none;">رئيس قسم شؤون الطلاب</th>
                    <th style="text-align: center; font-size:16px; width:33.3%; font-weight:bold; border:none;">{{ $musyrifSakanGender ?? '' }} السكن</th>
                    <th style="text-align: center; font-size:16px; width:33.3%; font-weight:bold; border:none;">ولي الأمر</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="vertical-align:bottom;text-align:center; font-size:16px; font-weight:bold; border:none; height:80px;">{{ $kesiswaan ?? '' }}</td>
                    <td style="vertical-align:bottom;text-align:center; font-size:16px; font-weight:bold; border:none;">{{ $musyrifSakan ?? '' }}</td>
                    <td style="vertical-align:bottom;text-align:center; font-size:16px; font-weight:bold; border:none;">____________________</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
