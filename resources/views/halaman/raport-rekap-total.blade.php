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
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url($aktif) }}">Raport Rekap</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 text-right">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        @if ($req->pilihkelas)
                        <a href="{{ url('raport-rekap-total/'.$req->pilihkelas.'/export') }}" target="_blank" class="btn btn-sm btn-success"><i class="fas fa-file-excel"></i> XlS</a>
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
                    <h3>Rekap Nilai Total</h3>
                    <form action="" method="POST" style="padding-bottom: 10px;">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label for="staticLembaga" class="sr-only">Kelas</label>
                                            <select name="pilihkelas" id="pilihkelas" class="form-control" required>
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
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Filter</button>
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
                                    <th>No</th>
                                    <th>Nomor Induk</th>
                                    <th>Nama Lengkap</th>
                                    <th>Nama Dalam Arabic</th>
                                    <th>Kelas</th>
                                    <th>L/P</th>
                                    @php $no=0; @endphp
                                    @foreach ($mapel as $v=>$k )
                                        <th style="text-align:right;">{{ $k->name }}</th>
                                        {{-- <th >Durasi</th> --}}
                                        @php $no++; @endphp
                                    @endforeach
                                    <th>Total Nilai</th>
                                    <th>Rata-rata</th>
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
                                    $tampil = 0;
                                    $total = 0;
                                    $totaldurasi = 0;
                                    $jmhMapel = 0;
                                    $test = $nilai->where('sid',$v->sid);
                                    @endphp
                                    @foreach($mapel as $a=>$b)
                                        @php
                                            $tampil = 0; $durasi = 0;
                                            foreach($test as $t=>$u)
                                            {
                                                if($u->subject_id == $b->subject_id)
                                                {
                                                    $tampil = $u->final_grade;
                                                    $durasi = $b->week_duration;
                                                    $totaldurasi += $b->week_duration;
                                                    $total += ($u->final_grade*$b->week_duration);
                                                    break;
                                                }
                                            }
                                        $jmhMapel++;
                                        @endphp
                                    <td style="text-align:right;">{{ number_format($tampil,0,',','.') }}</td>
                                    {{-- <td>{{ $durasi }}</td> --}}
                                    @endforeach
                                    @php
                                        $nlRata = ($total!=0 && $jmhMapel!=0) ? round($total/$totaldurasi) : 0;
                                        $nlTotal += $total;
                                        $nlRataKls += $nlRata;
                                    @endphp
                                    <td style="text-align:right;">{{ number_format($total,0,',','.') }}</td>
                                    <td style="text-align: right;">{{ $nlRata }}</td>
                                </tr>
                                @php $i++; @endphp
                                @endforeach
                                @if ($i!=0)
                                <tr>
                                    <th colspan="6"><b>RATA-RATA PER MATA PELAJARAN</b></th>
                                    @php
                                    $nlRtMp = 0;
                                    $test = $nilai->where('sid',$v->sid);
                                    @endphp
                                    @foreach($mapel as $a=>$b)
                                        @php
                                            $nlRtMp = 0;
                                            foreach($test as $t=>$u)
                                            {
                                                if($u->subject_id == $b->subject_id)
                                                {
                                                    $nlRtMp = $u->class_avg;
                                                    break;
                                                }
                                            }
                                        @endphp
                                    <th style="text-align:right;">{{ $nlRtMp }}</th>
                                    @endforeach
                                    @php
                                        $nlRtTotal = ($nlTotal!=0 && $i!=0) ? round($nlTotal/$i) : 0;
                                        $nlRata = ($nlRataKls!=0 && $i!=0) ? round($nlRataKls/$i) : 0;
                                    @endphp
                                    <th style="text-align:right;">{{ $nlRtTotal }}</th>
                                    <th style="text-align: right;">{{ $nlRata }}</th>
                                </tr>
                                @endif
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
