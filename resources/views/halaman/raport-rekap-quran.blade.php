@extends('layouts.app')
@include('komponen.tabledata')
@include('komponen.datepicker')

@section('content')
<div class="container-fluid pt-7">
    <div class="header">
        <div class="header-body">
            <div class="row">
                <div class="col-lg-6">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url($aktif) }}">Rekap Raport Alquran</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 text-right">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        @if ($req->pilihkelas)
                        <a href="{{ url()->current().'?'.http_build_query($req->query()).'&file=xls' }}" target="_blank" class="btn btn-sm btn-success"><i class="fas fa-file-excel"></i> XlS</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Rekap Nilai Alquran</h3>
                    <form action="" method="GET" style="padding-bottom: 10px;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label for="staticLembaga" class="sr-only">Kelas</label>
                                            <select name="pilihkelas" id="pilihkelas" class="form-control">
                                                <option value="0"> - Pilih Salah Satu - </option>
                                                @foreach ($kelas as $k=>$v)
                                                @php
                                                    $selected = ($v->id==$pilihkelas) ? 'selected="selected"' : '';
                                                @endphp
                                                <option value="{{ $v->id }}" {{ $selected }}>{{ $v->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-right">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="submit" name="filter" value="yes" class="btn btn-primary"><i class="fa fa-check"></i> Filter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped align-items-center datatables">
                            <thead class="thead-light">
                                <tr>
                                    <th rowspan="2">No</th>
                                    <th rowspan="2">Nomor Induk</th>
                                    <th rowspan="2">Nama Lengkap</th>
                                    <th rowspan="2">Nama Dalam Arabic</th>
                                    <th rowspan="2">Kelas</th>
                                    <th rowspan="2">L/P</th>
                                    <th rowspan="2" class="arabic" style="font-size:12px !important; text-align:center !important;">مشرف الحلقة</th>
                                    <th rowspan="2" class="arabic" style="font-size:12px !important; text-align:center !important;">الحلقة</th>
                                    <th rowspan="2" class="arabic" style="font-size:12px !important; text-align:center !important;">الجرء الذي تم تسميعه</th>
                                    <th rowspan="2" class="arabic" style="font-size:12px !important; text-align:center !important;">الجزء المقرر</th>
                                    <th colspan="4" class="arabic" style="font-size:12px !important; text-align:center !important;"> مقرر القرآن</th>
                                    @php $no=0; @endphp
                                    @foreach ($weight as $v=>$k)
                                        <th rowspan="2" class="arabic" style="font-size:12px !important; text-align:center !important;">{{ $k->name_ar }}</th>
                                        @php $no++; @endphp
                                    @endforeach
                                    <th rowspan="2" class="arabic" style="font-size:12px !important; text-align:center !important;">مجموعة النتيجة</th>
                                    <th rowspan="2" class="arabic" style="font-size:12px !important; text-align:center !important;">ملاحظة المشرف</th>
                                </tr>
                                <tr>
                                    <th class="arabic" style="font-size:12px !important; text-align:center !important;">(نتيجة مقرر الحلقة)</th>
                                    <th class="arabic" style="font-size:12px !important; text-align:center !important;">(التقدير)</th>
                                    <th colspan="2" class="arabic" style="font-size:12px !important; text-align:center !important;">(مقرر المستوى)</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @php $i=0; $nlTotal=0; $nlRataKls=0; @endphp
                                @foreach ($siswa as $k=>$v)
                                <tr>
                                    <td>{{ ($i+1) }}</td>
                                    <td>{{ $v->nis }}</td>
                                    <td><a href="{{ url('siswa/'.$v->pid.'/edit') }}">{{ $v->name }}</a></td>
                                    <td class="arabic">{{ $v->name_ar }}</td>
                                    <td class="arabic">{{ $v->desc_ar }}/{{ $v->class_name_ar }}</td>
                                    <td>{{ $v->sex }}</td>
                                    @php
                                        $app['result'] = \App\Models\BayanatResultDtl::getResultDtl($v->pid,config('id_active_academic_year'),config('id_active_term'));
                                        $halaqahnamear = (count($app['result'])>0) ? $app['result'][0]['name_ar'] : '-';
                                        $teachernamear = (count($app['result'])>0) ? $app['result'][0]['teachernamear'] : '-';
                                        $teachersex = (count($app['result'])>0) ? $app['result'][0]['teachersex'] : '-';
                                        $juz_has_tasmik = (count($app['result'])>0) ? $app['result'][0]['juz_has_tasmik'] : '';
                                        $juz_is_study = (count($app['result'])>0) ? $app['result'][0]['juz_is_study'] : '-';
                                        $result_decision_set = (count($app['result'])>0) ? $app['result'][0]['result_decision_set'] : '-';
                                        $result_set = (count($app['result'])>0) ? $app['result'][0]['result_set'] : '';
                                        $result_appreciation = (count($app['result'])>0) ? $app['result'][0]['result_appreciation'] : '-';
                                        $result_notes = (count($app['result'])>0) ? $app['result'][0]['result_notes'] : '-';
                                        $mustawa = \App\Models\Student::mustawa($v->sid,config('id_active_academic_year'),config('id_active_term'));
                                        $app['muqorrormustawa'] = \App\Models\BayanatLevel::where('level',$mustawa)->first();
                                        $juz_tasmik = '0'; $hasil = ''; $app['result_decision_level'] = 'Tidak Sempurna';
                                        if($juz_has_tasmik!='')
                                        {
                                            $juz_tasmik = !empty($juz_has_tasmik) ? (int)$juz_has_tasmik : 0;
                                            $juz_tasmik = (is_numeric($juz_tasmik)) ? $juz_tasmik : '0';
                                        }
                                        $nilaiqurantingkat = '-';
                                        if(count($app['result'])>0)
                                        {
                                            $nilaiqurantingkat = ($app['result'][0]['mm']!='')
                                                ? (int)$app['result'][0]['juz_has_tasmik'] >= (int)$app['result'][0]['level']
                                                : false;
                                            $nilaiqurantingkat = (int)$app['result'][0]['juz_has_tasmik'] >= (int)$mustawa;
                                            $nilaiquranhalaqah = ($app['result'][0]['level']!='')
                                                ? (int)$app['result'][0]['juz_has_tasmik'] >= (int)$app['result'][0]['mm']
                                                : false;

                                            $nilaiqurantingkat = ($nilaiqurantingkat) ? 'تم' : 'لم يتم';
                                        }
                                        $app['nilaiqurantingkat'] = (count($app['result'])>0) ? collect($app['result'])->first()['result_decision_level'] : '-';
                                        $nilaiquranhalaqah = (count($app['result'])>0) ? collect($app['result'])->first()['result_decision_set'] : '-';
                                        $app['nilaiquranhalaqah'] = '-';
                                        if($nilaiquranhalaqah!='-')
                                        {
                                            $app['nilaiquranhalaqah'] = ($nilaiquranhalaqah=='ناجح') ? 'تم' : 'لم يتم';
                                        }

                                    @endphp
                                    <td class="arabic text-center">{{ \App\SmartSystem\General::ustadz($teachersex).' '.$teachernamear }}</td>
                                    <td class="arabic text-center">{{ str_replace('(بنات)','',str_replace('(بنين)','',$halaqahnamear)) }}</td>
                                    <td class="arabic text-center">{{ Lang::get('juz_has_tasmik.'.$juz_tasmik,[],'ar') }}</td>
                                    <td class="arabic text-center">{{ $juz_is_study }}</td>
                                    <td class="arabic text-center">{{ $result_decision_set }}</td>
                                    <td class="arabic text-center">{{ $result_appreciation }}</td>
                                    <td class="arabic text-center">{{ Lang::get('juz_has_tasmik.'.$mustawa,[],'ar') }}</td>
                                    <td class="arabic text-center">{{ $nilaiqurantingkat }}</td>
                                    @foreach($weight as $v=>$k)
                                        @php $result_evaluation = isset($app['result'][$v]['result_evaluation']) ? $app['result'][$v]['result_evaluation'] : 0; @endphp
                                        <td class="arabic text-center">{{ (count($app['result'])>0) ? \App\SmartSystem\General::angka_arab(number_format($result_evaluation)) : '-';}}</td>
                                    @endforeach
                                    <td class="arabic text-center">{{ ($result_set!='') ? \App\SmartSystem\General::angka_arab(number_format($result_set,2,'.',',')) : '-' }}</td>
                                    <td>{{ $result_notes }}</td>
                                </tr>
                                @php $i++; @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalAll" tabindex="-1" aria-labelledby="modalAllLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAllLabel">Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalAllBody">
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $(document).ready(function() {
        var table = $('#datatables').DataTable( {
            "paging": true,
            "pageLength": {{ config('paging') }},
            "language": {
                "paginate": {
                    "previous": "&lt;",
                    "next": "&gt;"
                },
                "search": "Cari :",
            },
            "searching": true,
            "ordering": false,
            "info": false,
            scrollY: "300px",
            scrollX: true,
            scrollCollapse: true,
            fixedColumns: {
                left: 5, right:2
            }
        } );
    } );
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        e.target // newly activated tab
        e.relatedTarget // previous active tab
        $('#divloading').show();
        id = $(this).attr('id').split('pills-tab-');
        id = id[1];
        $.post('{{ url('raport-rekap-total') }}',{_token: "{{ csrf_token() }}",'kelas':id},function(data){
            $('#divloading').css('display','none');
            $('#tbody'+id).html(data);
        })
    })
    function detail(sid,name)
    {
        $.post('{{ url('raport-rekap-uas-detail') }}',{_token: "{{ csrf_token() }}",'sid':sid},function(data){
            $('#modalAllLabel').html('Detail '+name);
            $('#modalAllBody').html(data);
            $('#modalAll').modal('show');
        })
    }
</script>
@endpush
