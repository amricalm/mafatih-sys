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
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url($aktif) }}">Rekap Raport Bayanat Idhafiyah</a></li>
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
                    <h3>Rekap Nilai Bayanat Idhafiyah</h3>
                    <form action="" method="GET" style="padding-bottom: 10px;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label for="staticLembaga" class="sr-only">Kelas</label>
                                            <select name="pilihkelas" id="pilihkelas" class="form-control">
                                                <option value="0"> - Pilih Salah Satu - </option>
                                                @foreach ($kelass as $k=>$v)
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
                                    <th rowspan="2" class="arabic" style="font-size:12px !important; text-align:center !important;">نتيجة كشف الدرجات</th>
                                    @php
                                        $mpGroup = collect($mudalfashl);
                                        $tmpgroup = array();
                                        $imp = 0;
                                        foreach($mpGroup as $kmpg=>$vmpg)
                                        {
                                            $mp = collect($mf)->get($vmpg['id']);
                                            $nilaimp = 0;
                                            $tmpgroup[$imp]['group_ar'] = $vmpg['name_group_ar'];
                                            $imp++;
                                        }
                                    @endphp
                                    <th class="text-center" {{ count($tmpgroup)!=0 ? 'colspan='.count($tmpgroup).'' : '' }}>نتيجة مواد الأساس</th>
                                    <th rowspan="2" class="arabic" style="font-size:12px !important; text-align:center !important;">مقرر القرآن (مقرر الحلقة)</th>
                                    <th rowspan="2" class="arabic" style="font-size:12px !important; text-align:center !important;">مقرر القرآن (مقرر المستوى)</th>
                                    <th rowspan="2" class="arabic" style="font-size:12px !important; text-align:center !important;">ملاحظة قسم شؤون الطلاب</th>
                                    <th rowspan="2" class="arabic" style="font-size:12px !important; text-align:center !important;">فعاليات ولي الأمر</th>
                                    <th rowspan="2" class="arabic" style="font-size:12px !important; text-align:center !important;">النتيجة النهائية</th>
                                    <th rowspan="2" class="arabic" style="font-size:12px !important; text-align:center !important;">رتبة النتيجة في الدفعة</th>
                                    <th rowspan="2" class="arabic" style="font-size:12px !important; text-align:center !important;">رتبة النتيجة في الصف</th>
                                </tr>
                                <tr>
                                    @foreach($tmpgroup as $k=>$v)
                                    <th class="arabic" style="font-size:12px !important; text-align:center !important;">{{ $v['group_ar'] }}</th>
                                    @endforeach
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
                                        $ayid           = config('id_active_academic_year');
                                        $tid            = config('id_active_term');
                                        $getipk         = \App\Models\Gpa::getIPK($v->sid,$ayid,$tid);
                                        $nlipk          = number_format($getipk['ipk']);
                                        $ipk            = \App\SmartSystem\General::hasil_kelulusan($nlipk);
                                        $final          = \App\Models\FinalGrade::select('note_from_student_affairs','activities_parent','result')
                                                            ->where('format_code','0')
                                                            ->where('ayid',$ayid)
                                                            ->where('tid',$tid)
                                                            ->where('sid',$v->sid)
                                                            ->first();
                                        $finaldtl       = \App\Models\FinalGradeDtl::select(['ep_subject.id','formative_val','final_grade'])
                                                            ->join('ep_subject','ep_subject.id','=','subject_id')
                                                            ->where('format_code','0')
                                                            ->where('ayid',$ayid)
                                                            ->where('tid',$tid)
                                                            ->where('sid',$v->sid)
                                                            ->get();
                                        $getBayanatResultDtl = \App\Models\BayanatResultDtl::getResultDtl($v->pid,$ayid,$tid);
                                        $mustawa        = \App\Models\Student::mustawa($v->sid,$ayid,$tid);
                                        $rankinglevel   = key(collect(\App\Models\Gpa::getRankingLevel($v->level,$v->sex))->where('sid',$v->sid)->toArray())+1;
                                        $rankingkelas   = key(collect(\App\Models\Gpa::getRankingClass($v->class_id))->where('sid',$v->sid)->toArray())+1;
                                        $nilaiquranhalaqah = '-';
                                        $nilaiqurantingkat = '-';
                                        if(count($getBayanatResultDtl)>0)
                                        {
                                            $nilaiqurantingkat = ($getBayanatResultDtl[0]['mm']!='')
                                                ? (int)$getBayanatResultDtl[0]['juz_has_tasmik'] >= (int)$getBayanatResultDtl[0]['level']
                                                : false;
                                            $nilaiqurantingkat = (int)$getBayanatResultDtl[0]['juz_has_tasmik'] >= (int)$mustawa;
                                            $nilaiquranhalaqah = ($getBayanatResultDtl[0]['level']!='')
                                                ? (int)$getBayanatResultDtl[0]['juz_has_tasmik'] >= (int)$getBayanatResultDtl[0]['mm']
                                                : false;

                                            $nilaiqurantingkat = ($nilaiqurantingkat) ? 'تم' : 'لم يتم';
                                            $nilaiquranhalaqah = ($nilaiquranhalaqah) ? 'تم' : 'لم يتم';
                                        }
                                        $no = 1; $j = 0;
                                        $jmlhtot = 0;
                                        $anilaitotal = [];
                                    @endphp
                                    @foreach ($finaldtl as $key => $val)
                                    @php
                                        $jml = 0;
                                        $jmlht = 0;
                                        $formative_val = ($val->formative_val!='') ? $val->formative_val : '0';
                                        $anilaitotal[$j]['id'] = $val->id;
                                        $anilaitotal[$j]['val'] = $val->final_grade;
                                        $jmlhtot += $jml;
                                        $no++; $j++;
                                    @endphp
                                    @endforeach
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
                                    <td class="arabic text-center">{{ $ipk }}</td>
                                    @foreach($tmpgroup as $k=>$v)
                                        <td class="arabic text-center">{{ \App\SmartSystem\General::angka_arab(number_format($v['total'],0,',','')) }}</td>
                                    @php $no++; @endphp
                                    @endforeach
                                    <td class="arabic text-center">{{ $nilaiquranhalaqah }}</td>
                                    <td class="arabic text-center">{{ $nilaiqurantingkat }}</td>
                                    <td class="arabic text-center">{{ ($final->note_from_student_affairs!='') ? \App\SmartSystem\General::pilihan_ar($final->note_from_student_affairs) : '-' }}</td>
                                    <td class="arabic text-center">{{ ($final->activities_parent!='') ? \App\SmartSystem\General::pilihan_ar($final->activities_parent) : '-' }}</td>
                                    <td class="arabic text-center">{{ \App\SmartSystem\General::pilihan_ar($final->result) }}</td>
                                    <td class="arabic text-center">{{ \App\SmartSystem\General::angka_arab($rankinglevel) }}</td>
                                    <td class="arabic text-center">{{ \App\SmartSystem\General::angka_arab($rankingkelas) }}</td>
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
