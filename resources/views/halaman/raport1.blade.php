@extends('layouts.app')

@section('content')
    <div class="container-fluid pt-7">
        <div class="header">
            <div class="header-body">
                <div class="row">
                    <div class="col-lg-6">
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page"><a href="#">Raport Halaman 1</a></li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-lg-6 text-right">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="{{ url('raport/'.$student->id.'/1/print/pdf') }}" class="btn btn-sm btn-primary"><i class="fa fa-print"></i> Print</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="row" style="background-image:url('/assets/img/adn/logo-msh-emas.png') no-repeat;">
            <div class="col-md-12 arabic text-center">
                كشف الدرجات
            </div>
            <div class="col-md-12 arabic text-center">
                المرحلة المتوسطة لكلية الأئمة والحفاظ
            </div>
            <div class="col-md-12 arabic text-center">
                {{ $kelas->desc_ar_dtl }}/الفصل الدراسي {{ $term['desc_ar'] }} لعام {{ $tahun['arab'] }}هـ/{{ $tahun['masehi'] }} م
            </div>
            <div class="col-md-12 arabic text-center">
                معهد شرف الحرمين - بوغور - جاوى الغربية - إندونسيا
            </div>
            <br>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4 arabic text-right">
                        رقم القيد : {{ \App\SmartSystem\General::angka_arab($student->nis) }}
                    </div>
                    <div class="col-md-4 arabic text-right">
                        الصف : {{ $kelas->desc_ar }}/{{ ($kelas->name_ar=='') ? $kelas->name : $kelas->name_ar }}
                    </div>
                    <div class="col-md-4 arabic text-right">
                        اسم الطالب : {{ ($student->name_ar=='') ? $student->name : $student->name_ar }}
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive mt-3">
                    <div>
                        <table class="table arabic" style="text-align:right;" dir="rtl">
                            <thead class="thead-light">
                                <tr>
                                    <th class="align-items-center" style="font-size:20px;">الرقم</th>
                                    <th class="align-items-center" style="font-size:20px;">المواد</th>
                                    <th class="align-items-center" style="font-size:25px;">Subjects</th>
                                    <th class="align-items-center" style="font-size:15px;">المتابعة<br>والحضور</th>
                                    <th class="align-items-center" style="font-size:15px;">الاختبار<br>النصفي</th>
                                    <th class="align-items-center" style="font-size:15px;">الاختبار<br>النهائي</th>
                                    <th class="align-items-center" style="font-size:15px;">مجموعة<br>النتيجة</th>
                                    <th class="align-items-center" style="font-size:15px;">عدد<br>الحصة<br>في الأسبوع</th>
                                    <th class="align-items-center" style="font-size:15px;">النتيجة x <br>عدد<br>الحصة</th>
                                    <th class="align-items-center" style="font-size:15px;">المعدل<br>الصفي</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @php
                                    $no = 1; $j = 0;
                                    $jmlhtot = 0;
                                    $anilaitotal = [];
                                @endphp
                                @foreach ($finaldtl as $key => $val)
                                @php
                                    $jml = 0;
                                    $jmlht = 0;
                                    $formative_val = ($val['formative_val']!='') ? $val['formative_val'] : '0';
                                @endphp
                                    <tr>
                                        <td class="arabic">{{ \App\SmartSystem\General::angka_arab($no) }}</td>
                                        <td class="arabic">{{ $val['name_ar'] }}</td>
                                        <td class="arabic text-left">{{ $val['name_en'] }}</td>
                                        <td class="arabic"  style="text-align: center;">{{ \App\SmartSystem\General::angka_arab(round($formative_val)) }}</td>
                                        <td class="arabic"  style="text-align: center;">{{ \App\SmartSystem\General::angka_arab(round($val['mid_exam'])) }}</td>
                                        <td class="arabic"  style="text-align: center;">{{ \App\SmartSystem\General::angka_arab(round($val['final_exam'])) }}</td>
                                        <td class="arabic"  style="text-align: center;">{{ \App\SmartSystem\General::angka_arab(round($val['final_grade'])) }}</td>
                                        <td class="arabic"  style="text-align: center;">{{ \App\SmartSystem\General::angka_arab($val['lesson_hours']) }}</td>
                                        <td class="arabic"  style="text-align: center;">{{ \App\SmartSystem\General::angka_arab($val['weighted_grade']) }}</td>
                                        <td class="arabic"  style="text-align: center;">{{ \App\SmartSystem\General::angka_arab($val['class_avg']) }}</td>
                                    </tr>
                                @php
                                    $anilaitotal[$j]['id'] = $val['id'];
                                    $anilaitotal[$j]['val'] = $val['final_grade'];
                                    $jmlhtot += $jml;
                                    $no++; $j++;
                                @endphp
                                @endforeach
                            </tbody>
                        </table>
                        <br>
                        <table class="table arabic" style="text-align:right;" dir="rtl">
                            <tbody>
                                <tr>
                                    <td class="align-items-center arabic">إجمالي النتيجة للفصل</td>
                                    <td class="align-items-center arabic">{{ \App\SmartSystem\General::angka_arab(round($final->sum_weighted_grade)) }}</td>
                                    <td class="align-items-center arabic" rowspan="2">النتيجة</td>
                                    <td class="align-items-center arabic" rowspan="2">:</td>
                                    <td class="align-items-center arabic" rowspan="2">{{ \App\SmartSystem\General::hasil_kelulusan($ipk['ipk']) }}</td>
                                    <td class="align-items-center arabic" colspan="2">الملاحظة:</td>
                                    <td class="align-items-center arabic" colspan="2">أيام الغياب:</td>
                                </tr>
                                <tr>
                                    <td class="align-items-center arabic">ساعات الفصل</td>
                                    <td class="align-items-center arabic">{{ \App\SmartSystem\General::angka_arab($final->sum_lesson_hours ?? 0) }}</td>
                                    <td class="align-items-center arabic">السلوك</td>
                                    <td class="align-items-center arabic">{{ $final->behaviour }}</td>
                                    <td class="align-items-center arabic">لمرض</td>
                                    <td class="align-items-center arabic">{{ \App\SmartSystem\General::angka_arab($final->absent_s ?? 0) }}</td>
                                </tr>
                                <tr>
                                    <td class="align-items-center arabic" rowspan="2">المعدل الفصلي {{ 'ل'.preg_replace('/' ."ا". '/', '', $kelas->desc_ar_dtl, 1) }}</td>
                                    <td class="align-items-center arabic" rowspan="2">{{ \App\SmartSystem\General::angka_arab(number_format($final->gpa,2) ?? 0) }}</td>
                                    <td class="align-items-center arabic" rowspan="2">التقدير</td>
                                    <td class="align-items-center arabic" rowspan="2">:</td>
                                    <td class="align-items-center arabic" rowspan="2">{{ \App\SmartSystem\General::predikat($ipk['ipk']) }}</td>
                                    <td class="align-items-center arabic">النظافة</td>
                                    <td class="align-items-center arabic">{{ $final->cleanliness }}</td>
                                    <td class="align-items-center arabic">لاستئذان</td>
                                    <td class="align-items-center arabic">{{ \App\SmartSystem\General::angka_arab($final->absent_i ?? 0) }}</td>
                                </tr>
                                <tr>
                                    <td class="align-items-center arabic">المواظبة</td>
                                    <td class="align-items-center arabic">{{ $final->discipline  }}</td>
                                    <td class="align-items-center arabic">لـآخر</td>
                                    <td class="align-items-center arabic">{{ \App\SmartSystem\General::angka_arab($final->absent_a ?? 0) }}</td>
                                </tr>
                                <tr>
                                    <td class="align-items-center arabic">المعدل التراكمي</td>
                                    <td class="align-items-center arabic">{{ \App\SmartSystem\General::angka_arab(number_format($ipk['ipk'],2) ?? 0) }}</td>
                                    <td class="align-items-center arabic" colspan="7">المواد المحمولة : <div style="inline-size: 500px;overflow-wrap: break-word;">{{ implode(', ',$mahmul) }}</div></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12 arabic text-center">
                تحريرا بمعهد شرف الحرمين:
            </div>
            <div class="col-md-12 arabic text-center">
                بوغور، {{ $tgl_hj_raport }} هـ / {{ $tgl_raport }} م
            </div>
            <div class="col-md-12 arabic text-center">
                <div class="row">
                    <div class="col-md-4">
                        مدير المدرسة
                        <br>
                        <br>
                        <br>
                        {{ $kepalasekolah }}
                    </div>
                    <div class="col-md-4">
                        {{ $walikelasGender }} الفصل
                        <br>
                        <br>
                        <br>
                        {{ $walikelas }}
                    </div>
                    <div class="col-md-4">
                        ولي الأمر
                        <br>
                        <br>
                        <br>
                        ____________________
                    </div>
                </div>
            </div>
        </div>
        @if ($term['id']==2)
        <br>
        <br>
        <hr>
        <br>
        <div id="row" style="background-image:url('/assets/img/adn/logo-msh-emas.png') no-repeat;">
            <div class="col-md-12 arabic text-center">
                بيانات إضافية لمعايير النجاح
            </div>
            <div class="col-md-12 arabic text-center">
                المرحلة المتوسطة لكلية الأئمة والحفاظ
            </div>
            <div class="col-md-12 arabic text-center">
                {{ $kelas->desc_ar_dtl }}/الفصل الدراسي {{ $term['desc_ar'] }} لعام {{ $tahun['arab'] }}هـ/{{ $tahun['masehi'] }} م
            </div>
            <div class="col-md-12 arabic text-center">
                معهد شرف الحرمين - بوغور - جاوى الغربية - إندونسيا
            </div>
            <br>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4 arabic text-right">
                        رقم القيد : {{ \App\SmartSystem\General::angka_arab($student->nis) }}
                    </div>
                    <div class="col-md-4 arabic text-right">
                        الصف : {{ $kelas->desc_ar }}/{{ ($kelas->name_ar=='') ? $kelas->name : $kelas->name_ar }}
                    </div>
                    <div class="col-md-4 arabic text-right">
                        اسم الطالب : {{ ($student->name_ar=='') ? $student->name : $student->name_ar }}
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive mt-3">
                    <div>
                        <table class="table arabic" style="text-align:right;" dir="rtl">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center" style="font-size:20px;">الرقم</th>
                                    <th class="text-center" colspan="2" style="font-size:20px;">معايير النجاح</th>
                                    <th class="text-center" style="font-size:20px;">النتيجة</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                <tr>
                                    <td class="arabic text-center" style="font-size:18px;  padding-right: 10px;">{{ \App\SmartSystem\General::angka_arab(1) }}</td>
                                    <td class="arabic" colspan="2" style="font-size:18px;">نتيجة كشف الدرجات</td>
                                    <td class="arabic text-center" style="font-size:18px;">{{ \App\SmartSystem\General::hasil_kelulusan($ipk['ipk']) }}</td>
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
                                    <td class="arabic text-center" {{ count($tmpgroup)!=0 ? 'rowspan='.count($tmpgroup).'' : '' }} style="font-size:18px; padding-right: 10px; width:5%;">{{ \App\SmartSystem\General::angka_arab(2) }}</td>
                                    <td class="arabic" {{ count($tmpgroup)!=0 ? 'rowspan='.count($tmpgroup).'' : '' }} style="font-size:18px; width:25%;">نتيجة مواد الأساس</td>
                                    @foreach($tmpgroup as $k=>$v)
                                    @php
                                        if($no!=0)
                                        {
                                            echo '</tr><tr>';
                                        }
                                    @endphp
                                    <td class="arabic" style="font-size:18px; padding: padding-right: 10px; width:30%;">{{ $v['group_ar'] }}</td>
                                    <td class="arabic text-center" style="font-size:18px; width:40%;">{{ \App\SmartSystem\General::angka_arab(number_format($v['total'],0,',','')) }}</td>
                                    @php $no++; @endphp
                                    @endforeach
                                    @if ($no==0)
                                    <td class="arabic" style="font-size:18px; padding: padding-right: 10px; width:30%;">&nbsp;</td>
                                    <td class="arabic text-center" style="font-size:18px; width:40%;">&nbsp;</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td class="arabic text-center" style="font-size:18px;">{{ \App\SmartSystem\General::angka_arab(3) }}</td>
                                    <td class="arabic" colspan="2" style="font-size:18px; padding-right: 10px;"> مقرر القرآن (مقرر الحلقة)</td>
                                    <td class="arabic text-center" style="font-size:18px;">{{ $nilaiquranhalaqah }}</td>
                                </tr>
                                <tr>
                                    <td class="arabic text-center" style="font-size:18px;">{{ \App\SmartSystem\General::angka_arab(4) }}</td>
                                    <td class="arabic" colspan="2" style="font-size:18px; padding-right: 10px;">مقرر القرآن (مقرر المستوى)</td>
                                    <td class="arabic text-center" style="font-size:18px;">{{ $nilaiqurantingkat }}</td>
                                </tr>
                                <tr>
                                    <td class="arabic text-center" style="font-size:18px;">{{ \App\SmartSystem\General::angka_arab(5) }}</td>
                                    <td class="arabic" colspan="2" style="font-size:18px; padding-right: 10px;">ملاحظة قسم شؤون الطلاب</td>
                                    <td class="arabic text-center" style="font-size:18px;">{{ ($final->note_from_student_affairs!='') ? \App\SmartSystem\General::pilihan_ar($final->note_from_student_affairs) : '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="arabic text-center" style="font-size:18px;">{{ \App\SmartSystem\General::angka_arab(6) }}</td>
                                    <td class="arabic" colspan="2" style="font-size:18px; padding-right: 10px;">فعاليات ولي الأمر</td>
                                    <td class="arabic text-center" style="font-size:18px;">{{ \App\SmartSystem\General::pilihan_ar($final->activities_parent) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive mt-3">
                    <div>
                        <table class="table arabic" style="text-align:right;" dir="rtl">
                            <tbody class="list">
                                <tr>
                                    <td class="arabic text-center w-50" style="font-size:18px;">النتيجة النهائية</td>
                                    <td class="arabic text-center w-50" style="font-size:18px;">{{ \App\SmartSystem\General::pilihan_ar($final->result) }}</td>
                                </tr>
                                <tr>
                                    <td class="arabic text-center" style="font-size:18px;">رتبة النتيجة في الدفعة</td>
                                    <td class="arabic text-center" style="font-size:18px;">{{ \App\SmartSystem\General::angka_arab($rankinglevel) }}</td>
                                </tr>
                                <tr>
                                    <td class="arabic text-center" style="font-size:18px;">رتبة النتيجة في الصف</td>
                                    <td class="arabic text-center" style="font-size:18px;">{{ \App\SmartSystem\General::angka_arab($rankingkelas) }}</td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12 arabic text-center">
                تحريرا بمعهد شرف الحرمين:
            </div>
            <div class="col-md-12 arabic text-center">
                بوغور، {{ $tgl_hj_raport }} هـ / {{ $tgl_raport }} م
            </div>
            <div class="col-md-12 arabic text-center">
                <div class="row">
                    <div class="col-md-4">
                        مدير المدرسة
                        <br>
                        <br>
                        <br>
                        {{  $kepalasekolah }}
                    </div>
                    <div class="col-md-4">
                        رئيس قسم شؤون الطلاب
                        <br>
                        <br>
                        <br>
                        {{  $kesiswaan }}
                    </div>
                    <div class="col-md-4">
                        رئيسة قسم التعليم
                        <br>
                        <br>
                        <br>
                        {{  $kurikulum }}
                    </div>
                </div>
            </div>
        </div>
        @endif

        @include('layouts.footers.auth')
    </div>
@endsection
