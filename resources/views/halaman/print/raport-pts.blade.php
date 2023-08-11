@extends('layouts.pdf-template')
@section('isi')
    @php
    switch ($jmhmapel) {
        case 11:
            $p = 125;
            break;
        case 12:
            $p = 110;
            break;
        case 13:
            $p = 95;
            break;
        case 14:
            $p = 80;
            break;
        case 15:
            $p = 65;
            break;
        case 16:
            $p = 50;
            break;
        case 17:
            $p = 35;
            break;
        case 18:
            $p = 20;
            break;
        case 19:
            $p = 5;
            break;
        case 20:
            $p = -20;
            break;
        default:
            $p = 0;
            break;
    }
    @endphp
    <div id="watermark" style="height: 100%; vertical-align: center; padding-top: {{ $p }}px;">
        <div id="logo" style="font-size:20px; font-weight:bold; border: solid 2px #000000;">
            <div align="center" style="margin-top: 10px; margin-bottom: -5px; z-index: 2; position: absolute;">
                نتائج الاختبار النصفي
            </div>
            <div align="center" style="margin-bottom: -6px;">
                المرحلة المتوسطة لكلية الأئمة والحفاظ
            </div>
            <div align="center" style="margin-bottom: -6px;">
                {{ $kelas['desc_ar_dtl'] }}/  الفصل الدراسي {{ $term['desc_ar'] }} لعام {{ $tahun['arab'] }}هـ /{{ $tahun['masehi'] }} م
            </div>
            <div style="text-align:center; padding-bottom: 15px;">
                معهد شرف الحرمين - بوغور - جاوى الغربية - إندونيسيا
            </div>
        </div>
        <div style="padding-left: 2px; padding-right: 2px; margin: 40px 0 15px 0; font-size:18px; font-weight:bold;">
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
        <table style="width:100%; text-align:right; border:solid 2px #000000;" dir="rtl">
            <thead style="font-weight:bold;">
                <tr style="height: 70px;">
                    <th rowspan="2" style="width: 6%; font-size:18px;">الرقم</th>
                    <th rowspan="2" style="width: 17%; font-size:18px; border-left: none;">المواد</th>
                    <th rowspan="2" style="width: 25%; font-size:18px; border-right: none;">Subjects</th>
                    <th rowspan="2" style="width: 12%; font-size:18px;">معايير اكتمال <br/>الحد الأدنى</th>
                    <th colspan="2" style="width: 35%; font-size:18px;">النتيجة</th>
                    <th rowspan="2" style="width: 8%; font-size:18px;">المعدل<br/>الصفي</th>
                </tr>
                <tr>
                    <th style="width: 8%; font-size:18px;">بالرقم</th>
                    <th style="width: 27%; font-size:18px;">بالكتابة</th>
                </tr>
            </thead>
            <tbody class="list">
                @php
                    $no = 1;
                @endphp
                @foreach ($finaldtl as $key => $val)
                @php
                    $mid_exam = ($val['mid_exam']!='') ? $val['mid_exam'] : '0';
                    $class_avg = ($val['class_avg']!='') ? $val['class_avg'] : '0';
                    $grade_pass = ($val['grade_pass']!='') ? $val['grade_pass'] : '0';
                @endphp
                    <tr>
                        <td class="arabic" style="text-align:center; font-size:18px; height: 28px;">{{ \App\SmartSystem\General::angka_arab($no) }}</td>
                        <td class="arabic" style="font-size:18px; border-left: none;">{{ $val['name_ar'] }}</td>
                        <td style="text-align:left; font-size:18px; border-right: none;">{{ $val['name_en'] }}</td>
                        <td class="arabic" style="text-align:center; font-size:18px;">{{ \App\SmartSystem\General::angka_arab($grade_pass) }}</td>
                        <td class="arabic" style="text-align:center; font-size:18px;">{{ \App\SmartSystem\General::angka_arab(number_format($mid_exam,0,'','')) }}</td>
                        <td class="arabic" style="text-align:center; font-size:18px;">{{ \App\SmartSystem\General::terbilang_ar(number_format($mid_exam,0,'','')) }}</td>
                        <td class="arabic" style="text-align:center; font-size:18px;">{{ \App\SmartSystem\General::angka_arab($class_avg) }}</td>
                    </tr>
                @php
                    $no++;
                @endphp
                @endforeach
            </tbody>
        </table>
        <br/>
        <div style="text-align: center; font-size:18px; font-weight:normal; padding-bottom:0px;">
        :تحريرا بمعهد شرف الحرمين
        </div>
        <div style="text-align: center; font-size:18px; font-weight:normal;">
            بوغور، {{ $tgl_hj_raport }} هـ / {{ $tgl_raport }} م
        </div>
        <br/>
        <br/>
        <div style="width:100%;">
            <div style="width:40%; float:left; text-align:center; font-size:18px; z-index:2;">{{ $walikelasGender }} الفصل</div>
            <div style="width:20%;"></div>
            <div style="width:40%; float:right; text-align:center; font-size:18px; z-index:2;">مدير المدرسة</div>
        </div>
        <div style="width:100%;">
            <div style="width:40%; float:left; text-align:center; margin-top:-17px; margin-bottom:-13px;">
                <div style="height:66px;"></div>
            </div>
            <div style="width:20%;"></div>
            <div style="width:40%; float:right; text-align:center; margin-top:-10px; margin-bottom:-13px; position: absolute;">
                <div style="height:66px;"></div>
            </div>
        </div>
        <div style="width:100%;">
            <div style="width:40%; float:left; text-align:center; font-size:18px; font-weight:bold;">{{ $walikelas }}</div>
            <div style="width:20%;"></div>
            <div style="width:40%; float:right; text-align:center; font-size:18px; font-weight:bold;">{{ $kepalasekolah }}</div>
        </div>
    </div>
@endsection
