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
                                <li class="breadcrumb-item active" aria-current="page"><a href="#">Raport PTS</a></li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-lg-6 text-right">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="{{ url('raport/'.$student->id.'/pts/print/pdf') }}" class="btn btn-sm btn-primary"><i class="fa fa-print"></i> Print</a>
                          </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row arabic" >
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div id="watermark">
                            <div id="logo" style="font-size:20px; font-weight:bold; border: solid 2px #000000;">
                                <div align="center" style="margin-top: 10px; margin-bottom: -6px;">
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
                            <br/>
                            <table style="text-align:right; width:100%; font-weight:bold;" dir="rtl">
                                <tr>
                                    <td class="text-align-right" style="width: 45%; font-size:16px;">اسم {{ $studentName }}</td>
                                    <td class="text-align-right" style="width: 40%; font-size:16px;">الصف : {{ $kelas->desc_ar }}/{{ $kelas['name_ar'] ?? '' }}</td>
                                    <td class="text-align-right" style="width: 15%; font-size:16px;">رقم القيد : {{ \App\SmartSystem\General::angka_arab($student->nis) }}</td>
                                </tr>
                            </table>
                            <br>
                            <table style="width:100%; text-align:right; border:solid 2px #000000;" dir="rtl">
                                <thead style="font-weight:bold; text-align:center;">
                                    <tr style="height: 40px;">
                                        <th rowspan="2" style="width: 6%; font-size:18px; border:solid 1px #000000;">الرقم</th>
                                        <th rowspan="2" style="width: 15%; font-size:18px; border:solid 1px #000000; border-left: none;">المواد</th>
                                        <th rowspan="2" style="width: 25%; font-size:18px; border:solid 1px #000000; border-right: none;">Subjects</th>
                                        <th rowspan="2" style="width: 12%; font-size:18px; border:solid 1px #000000;">معايير اكتمال <br/>الحد الأدنى</th>
                                        <th colspan="2" style="width: 35%; font-size:18px; border:solid 1px #000000;">النتيجة</th>
                                        <th rowspan="2" style="width: 10%; font-size:18px; border:solid 1px #000000;">المعدل<br/>الصفي</th>
                                    </tr>
                                    <tr style="height: 40px;">
                                        <th style="width: 8%; font-size:18px; border:solid 1px #000000;">بالرقم</th>
                                        <th style="width: 27%; font-size:18px; border:solid 1px #000000;">بالكتابة</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @php
                                        $no = 1;
                                        $jmlhtot = 0;
                                    @endphp
                                    @foreach ($finaldtl as $key => $val)
                                    @php
                                        $jml = 0;
                                        $jmlht = 0;
                                        $formative_val = ($val['formative_val']!='') ? $val['formative_val'] : '0';
                                        $mid_exam = ($val['mid_exam']!='') ? $val['mid_exam'] : '0';
                                        $grade_pass = ($val['grade_pass']!='') ? $val['grade_pass'] : '0';
                                    @endphp
                                        <tr>
                                            <td class="arabic" style="text-align:center; font-size:18px; border:solid 1px #000000; height: 35px;">{{ \App\SmartSystem\General::angka_arab($no) }}</td>
                                            <td class="arabic" style="font-size:18px; border:solid 1px #000000; border-left: none;">{{ $val['name_ar'] }}</td>
                                            <td style="text-align:left; font-size:18px; border:solid 1px #000000; border-right: none;">{{ $val['name_en'] }}</td>
                                            <td class="arabic" style="text-align:center; border:solid 1px #000000; font-size:18px;">{{ \App\SmartSystem\General::angka_arab($grade_pass) }}</td>
                                            <td class="arabic" style="text-align:center; border:solid 1px #000000; font-size:18px;">{{ \App\SmartSystem\General::angka_arab(number_format($mid_exam,0,'','')) }}</td>
                                            <td class="arabic" style="text-align:center; border:solid 1px #000000; font-size:18px;">{{ App\SmartSystem\General::terbilang_ar(number_format($mid_exam,0,'','')) }}</td>
                                            <td class="arabic" style="text-align:center; border:solid 1px #000000; font-size:18px;">{{ \App\SmartSystem\General::angka_arab($val['class_avg']) }}</td>
                                        </tr>
                                    @php
                                        $jmlhtot += $jml;
                                        $no++;
                                    @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth')
    </div>
@endsection
