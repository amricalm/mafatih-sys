@extends('layouts.pdf-template')
@section('header')
@endsection
@section('isi')
    <div id="watermark">
        <div id="logo" style="margin-top:-20px; font-size:20px; font-weight:bold; border: solid 2px #000000;">
            <div align="center" style="margin-top: 10px; margin-bottom: -5px; z-index: 2; position: absolute;">
                كشف الدرجات
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
        <div style="padding-left: 2px; padding-right: 2px; margin: 5px 0 5px 0; font-size:18px; font-weight:bold;">
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
        <table style="width:100%; text-align:right; border:solid 2px #000000; vertical-align: middle;" dir="rtl">
            <thead style="font-weight:bold;">
                <tr>
                    <th style="width: 5%; font-size:18px;">الرقم</th>
                    <th style="width: 17%; font-size:18px; border-left: none;">المواد</th>
                    <th style="width: 25%; font-size:18px; border-right: none;">Subjects</th>
                    <th style="width: 10%; font-size:18px;">المتابعة<br/>والحضور</th>
                    <th style="width: 10%; font-size:18px;">الاختبار<br/>النصفي</th>
                    <th style="width: 10%; font-size:18px;">الاختبار<br/>النهائي</th>
                    <th style="width: 10%; font-size:18px;">مجموعة<br/>النتيجة</th>
                    <th style="width: 10%; font-size:18px;">عدد<br/>الحصة<br/>في الأسبوع</th>
                    <th style="width: 10%; font-size:18px;">النتيجة x <br>عدد<br>الحصة</th>
                    <th style="width: 10%; font-size:18px;">المعدل<br>الصفي</th>
                </tr>
            </thead>
            <tbody class="list">
                @php
                    $no = 1; $j=0;
                    $jmlhtot = 0;
                    $anilaitotal = [];
                @endphp
                @foreach ($finaldtl as $key => $val)
                @php
                    $jml = 0;
                    $jmlht = 0;
                    $formative_val = ($val['formative_val']!='') ? $val['formative_val'] : '0';
                    $mid_exam = ($val['mid_exam']!='') ? $val['mid_exam'] : '0';
                    $final_exam = ($val['final_exam']!='') ? $val['final_exam'] : '0';
                @endphp
                    <tr>
                        <td class="arabic" style="text-align:center; font-size:18px;">{{ \App\SmartSystem\General::angka_arab($no) }}</td>
                        <td class="arabic" style="font-size:18px; border-left: none;">{{ $val['name_ar'] }}</td>
                        <td style="text-align:left; font-size:18px; border-right: none;">{{ $val['name_en'] }}</td>
                        <td class="arabic" style="text-align:center; font-size:18px;">{{ \App\SmartSystem\General::angka_arab(round($formative_val)) }}</td>
                        <td class="arabic" style="text-align:center; font-size:18px;">{{ \App\SmartSystem\General::angka_arab(round($mid_exam)) }}</td>
                        <td class="arabic" style="text-align:center; font-size:18px;">{{ \App\SmartSystem\General::angka_arab(round($final_exam)) }}</td>
                        <td class="arabic" style="text-align:center; font-size:18px;">{{ \App\SmartSystem\General::angka_arab(round($val['final_grade'])) }}</td>
                        <td class="arabic" style="text-align:center; font-size:18px;">{{ \App\SmartSystem\General::angka_arab($val['lesson_hours']) }}</td>
                        <td class="arabic" style="text-align:center; font-size:18px;">{{ \App\SmartSystem\General::angka_arab($val['weighted_grade']) }}</td>
                        <td class="arabic" style="text-align:center; font-size:18px;">{{ \App\SmartSystem\General::angka_arab($val['class_avg']) }}</td>
                    </tr>
                @php
                    $anilaitotal[$j]['id'] = $val['id'];
                    $anilaitotal[$j]['val'] = $val['final_grade'];
                    $jmlhtot += $jml;
                    $no++;
                    $j++;
                @endphp
                @endforeach
            </tbody>
        </table>
        <br/>
        <table style="text-align:right; width:100%;" dir="rtl">
            <tr>
                <td style="padding-right:5px; font-size:18px; width:40%;">إجمالي النتيجة للفصل</td>
                <td class="text-align-center" style="font-size:18px; width:7%;">{{ \App\SmartSystem\General::angka_arab(round($final->sum_weighted_grade)) }}</td>
                <td class="text-align-center" rowspan="2" style="font-size:18px; width:8%;">النتيجة</td>
                <td class="text-align-center" rowspan="2" style=" width:1%; border-left: 2px solid #ffffff; border-right: 2px solid #ffffff; font-size:18px;">:</td>
                <td class="text-align-center" rowspan="2" style="font-size:18px; width:10%;">{{ \App\SmartSystem\General::hasil_kelulusan($ipk['ipk']) }}</td>
                <td class="text-align-center" colspan="2" style="font-size:18px; width:20%;">الملاحظة:</td>
                <td class="text-align-center" colspan="2" style="font-size:18px; width:20%;">أيام الغياب:</td>
            </tr>
            <tr>
                <td style="padding-right:5px; font-size:18px;">ساعات الفصل</td>
                <td class="text-align-center" style="font-size:18px;">{{ \App\SmartSystem\General::angka_arab($final->sum_lesson_hours ?? 0) }}</td>
                <td style="font-size:18px;">السلوك</td>
                <td class="text-align-center" style="font-size:18px; width:8%;">{{ $final->behaviour }}</td>
                <td style="font-size:18px;">لمرض</td>
                <td class="text-align-center" style="font-size:18px; width:8%;">{{ \App\SmartSystem\General::angka_arab($final->absent_s ?? 0) }}</td>
            </tr>
            <tr>
                <td style="padding-right:5px; font-size:18px;" rowspan="2">المعدل الفصلي {{ 'ل'.preg_replace('/' ."ا". '/', '', $kelas->desc_ar_dtl, 1) }}</td>
                <td class="text-align-center" rowspan="2" style="font-size:18px;">{{ \App\SmartSystem\General::angka_arab(number_format($final->gpa,2) ?? 0) }}</td>
                <td class="text-align-center" rowspan="2" style="font-size:18px;">التقدير</td>
                <td class="text-align-center" rowspan="2" style="border-left: 2px solid #ffffff; border-right: 2px solid #ffffff; font-size:18px;">:</td>
                <td class="text-align-center" rowspan="2" style="font-size:18px;">{{ \App\SmartSystem\General::predikat($ipk['ipk']) }}</td>
                <td style="font-size:18px;">النظافة</td>
                <td class="text-align-center" style="font-size:18px;">{{ $final->cleanliness }}</td>
                <td style="font-size:18px;">لاستئذان</td>
                <td class="text-align-center" style="font-size:18px;">{{ \App\SmartSystem\General::angka_arab($final->absent_i ?? 0) }}</td>
            </tr>
            <tr>
                <td style="font-size:18px;">المواظبة</td>
                <td class="text-align-center" style="font-size:18px;">{{ $final->discipline  }}</td>
                <td style="font-size:18px;">لـآخر</td>
                <td class="text-align-center" style="font-size:18px;">{{ \App\SmartSystem\General::angka_arab($final->absent_a ?? 0) }}</td>
            </tr>
            <tr>
                <td style="padding-right:5px; font-size:18px;">المعدل التراكمي</td>
                <td class="text-align-center" style="font-size:18px;">{{ \App\SmartSystem\General::angka_arab(number_format($ipk['ipk'],2) ?? 0) }}</td>
                <td colspan="7" style="font-size:18px;">المواد المحمولة : {{  implode(', ',$mahmul)  }}</td>
            </tr>
        </table>
        <br/>
        <div style="text-align: center; font-size:18px; font-weight:normal; padding-bottom:-5px;">
            تحريرا بمعهد شرف الحرمين:
        </div>
        <div style="text-align: center; font-size:18px; font-weight:normal;">
            بوغور، {{ $tgl_hj_raport }} هـ / {{ $tgl_raport }} م
        </div>
        <table style="width:100%; border:none; margin-top:5px;" dir="rtl">
            <thead>
                <tr>
                    <th style="text-align: center; font-size:18px; width:33.3%; font-weight:bold; border:none;">مدير المدرسة</th>
                    <th style="text-align: center; font-size:18px; width:33.3%; font-weight:bold; border:none;">{{ $walikelasGender }} الفصل</th>
                    <th style="text-align: center; font-size:18px; width:33.3%; font-weight:bold; border:none;">ولي الأمر</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="vertical-align:bottom;text-align:center; font-size:18px; font-weight:bold; border:none; height:80px;">{{ $kepalasekolah }}</td>
                    <td style="vertical-align:bottom;text-align:center; font-size:18px; font-weight:bold; border:none;">{{ $walikelas }}</td>
                    <td style="vertical-align:bottom;text-align:center; font-size:18px; font-weight:bold; border:none;">____________________</td>
                </tr>
            </tbody>
        </table>
    </div>
    @if ($term['id']==2)
    <div style="page-break-before: always;"></div>
    <div id="watermark">
        <div id="logo" style="margin-top: 0px; font-size:20px; font-weight:bold; border: solid 2px #000000;">
            <div style="text-align:center; margin-bottom: -8px; padding-top: 8px;">
                بيانات إضافية لمعايير النجاح
            </div>
            <div style="text-align:center; margin-bottom: -8px;">
                المرحلة المتوسطة لكلية الأئمة والحفاظ
            </div>
            <div style="text-align:center; margin-bottom: -8px;">
                {{ $kelas['desc_ar_dtl'] }}/الفصل الدراسي {{ $term['desc_ar'] }} لعام {{ $tahun['arab'] }}هـ/{{ $tahun['masehi'] }} م
            </div>
            <div style="text-align:center; padding-bottom: 8px;">
                معهد شرف الحرمين - بوغور - جاوى الغربية - إندونيسيا
            </div>
        </div>
        <div style="padding-left: 2px; padding-right: 2px; margin: 5px 0 5px 0; font-size:18px; font-weight:bold;">
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
        <table style="width:100%; text-align:right;" dir="rtl">
            <thead>
                <tr>
                    <th style="width: 7%; font-size:18px; font-weight:bold;">الرقم</th>
                    <th colspan="2" style="width: 52%; font-size:18px; font-weight:bold;">معايير النجاح</th>
                    <th style="width: 40%; font-size:18px; font-weight:bold;">النتيجة</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="font-size:18px; text-align:center;">{{ \App\SmartSystem\General::angka_arab(1) }}</td>
                    <td colspan="2" style="font-size:18px; padding-right:10px;">نتيجة كشف الدرجات</td>
                    <td style="font-size:18px;text-align:center;">{{ \App\SmartSystem\General::hasil_kelulusan($ipk['ipk']) }}</td>
                </tr>
                <tr>
                    @php
                        $no=0;
                        $mpGroup = collect($mudalfashl);
                        $tmpgroup = array();
                        $imp = 0;
                        foreach($mpGroup as $kmpg=>$vmpg)
                        {
                            $mp = collect($mf)->get($vmpg['id']);
                            $nilaimp = 0;
                            $tmpgroup[$imp]['id'] = $vmpg['id'];
                            $tmpgroup[$imp]['group'] = $vmpg['name_group'];
                            $tmpgroup[$imp]['group_ar'] = $vmpg['name_group_ar'];
                            foreach($mp as $kmp=>$vmp)
                            {
                                for($annn=0;$annn<count($anilaitotal);$annn++)
                                {
                                    if($anilaitotal[$annn]['id']==$vmp['subject_id'])
                                    {
                                        $nilaimp += (float)$anilaitotal[$annn]['val'];
                                    }
                                }
                            }
                            $tmpgroup[$imp]['val'] = $nilaimp;
                            $tmpgroup[$imp]['count'] = count($mp);
                            $tmpgroup[$imp]['total'] = $tmpgroup[$imp]['val']/$tmpgroup[$imp]['count'];
                            $imp++;
                        }
                    @endphp
                    <td class="arabic" {{ count($tmpgroup)!=0 ? 'rowspan='.count($tmpgroup).'' : '' }} style="font-size:18px; text-align:center; width:5%;">{{ \App\SmartSystem\General::angka_arab(2) }}</td>
                    <td class="arabic" {{ count($tmpgroup)!=0 ? 'rowspan='.count($tmpgroup).'' : '' }} style="font-size:18px; width:25%; padding-right:10px;">نتيجة مواد الأساس</td>
                    @foreach($tmpgroup as $k=>$v)
                    @php
                        if($no!=0)
                        {
                            echo '</tr><tr>';
                        }
                    @endphp
                    <td class="arabic" style="font-size:18px; padding: padding-right: 10px; width:30%;">{{ $v['group_ar'] }}</td>
                    <td class="arabic" style="font-size:18px; width:40%; text-align:center;">{{ \App\SmartSystem\General::angka_arab(number_format($v['total'],0,',','')) }}</td>
                    @php $no++; @endphp
                    @endforeach
                    @if ($no==0)
                    <td class="arabic" style="font-size:18px; padding: padding-right: 10px; width:30%;">&nbsp;</td>
                    <td class="arabic text-center" style="font-size:18px; width:40%;">&nbsp;</td>
                    @endif
                </tr>
                <tr>
                    <td class="arabic" style="font-size:18px; text-align:center;">{{ \App\SmartSystem\General::angka_arab(3) }}</td>
                    <td class="arabic" colspan="2" style="font-size:18px; padding-right: 10px;"> مقرر القرآن (مقرر الحلقة)</td>
                    <td class="arabic text-center" style="font-size:18px; text-align:center;">{{ $nilaiquranhalaqah }}</td>
                </tr>
                <tr>
                    <td class="arabic" style="font-size:18px; text-align:center;">{{ \App\SmartSystem\General::angka_arab(4) }}</td>
                    <td class="arabic" colspan="2" style="font-size:18px; padding-right: 10px;">مقرر القرآن (مقرر المستوى)</td>
                    <td class="arabic text-center" style="font-size:18px; text-align:center;">{{ $nilaiqurantingkat }}</td>
                </tr>
                <tr>
                    <td class="arabic" style="font-size:18px; text-align:center;">{{ \App\SmartSystem\General::angka_arab(5) }}</td>
                    <td class="arabic" colspan="2" style="font-size:18px; padding-right: 10px;">ملاحظة قسم شؤون الطلاب</td>
                    <td style="font-size:18px; text-align:center;">{{ \App\SmartSystem\General::pilihan_ar($final->note_from_student_affairs) }}</td>
                </tr>
                <tr>
                    <td class="arabic" style="font-size:18px; text-align:center;">{{ \App\SmartSystem\General::angka_arab(6) }}</td>
                    <td class="arabic" colspan="2" style="font-size:18px; padding-right: 10px;">فعاليات ولي الأمر</td>
                    <td class="arabic" style="font-size:18px; text-align:center;">{{ \App\SmartSystem\General::pilihan_ar($final->activities_parent) }}</td>
                </tr>
            </tbody>
        </table>
        <br/>
        <table style="text-align:right; width:100%; font-size:18px;" dir="rtl">
            <tr>
                <td style="font-size:18px; width:60%; text-align:center;">النتيجة النهائية</td>
                <td class="text-align-center" style="font-size:18px; width:40%;text-align:center;">{{ \App\SmartSystem\General::pilihan_ar($final->result) }}</td>
            </tr>
            <tr>
                <td style="font-size:18px; text-align:center;">رتبة النتيجة في الدفعة</td>
                <td class="text-align-center" style="font-size:18px;text-align:center;">{{ \App\SmartSystem\General::angka_arab($rankinglevel) }}</td>
            </tr>
            <tr>
                <td style="font-size:18px; text-align:center;">رتبة النتيجة في الصف</td>
                <td class="text-align-center" style="font-size:18px;text-align:center;">{{ \App\SmartSystem\General::angka_arab($rankingkelas) }}</td>
            </tr>
        </table>
        <br>
        <br>
        <div style="text-align: center; font-size:18px; font-weight:normal; padding-bottom:-5px;">
            تحريرا بمعهد شرف الحرمين:
        </div>
        <div style="text-align: center; font-size:18px; font-weight:normal;">
            بوغور، {{ $tgl_hj_raport }} هـ / {{ $tgl_raport }} م
        </div>
        <br>
        <br>
        <table style="width:100%; border:none; margin-top:5px;" dir="rtl">
            <thead>
                <tr>
                    <th style="text-align: center; font-size:18px; width:33.3%; font-weight:bold; border:none;">مدير المدرسة</th>
                    <th style="text-align: center; font-size:18px; width:33.3%; font-weight:bold; border:none;">رئيس قسم شؤون الطلاب</th>
                    <th style="text-align: center; font-size:18px; width:33.3%; font-weight:bold; border:none;">رئيسة قسم التعليم</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="vertical-align:bottom;text-align:center; font-size:18px; font-weight:bold; border:none; height:80px;">{{ $kepalasekolah }}</td>
                    <td style="vertical-align:bottom;text-align:center; font-size:18px; font-weight:bold; border:none;">{{ $kesiswaan }}</td>
                    <td style="vertical-align:bottom;text-align:center; font-size:18px; font-weight:bold; border:none;">{{ $kurikulum }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    @endif
@endsection
