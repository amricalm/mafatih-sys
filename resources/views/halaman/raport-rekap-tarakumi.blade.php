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
                        <a href="{{ url('rekap-tarakumi?pilihkelas='.$req->pilihkelas.'&file=xls') }}" class="btn btn-sm btn-success"><i class="fas fa-file-excel"></i> XlS</a>
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
                    <h3>Rekap Nilai Tarakumi</h3>
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
                                                    $selected = ($v->id==$req->pilihkelas) ? 'selected="selected"' : '';
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
                                    @for($i=0;$i<6;$i++)
                                    <th>
                                        Semester
                                        @php
                                            $j=$i+1;
                                            echo $j;
                                        @endphp
                                    </th>
                                    @endfor
                                    {{-- <th>Total Nilai</th> --}}
                                    {{-- <th>Rata-rata</th> --}}
                                </tr>
                            </thead>
                            <tbody class="list">
                                @if ($req->pilihkelas!='' && $req->pilihkelas!='0')
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($murid as $k=>$v)
                                <tr>
                                    <td>{{ ($i+1) }}</td>
                                    <td>{{ $v->nis }}</td>
                                    <td>{{ $v->name }}</td>
                                    <td class="arabic">{{ $v->name_ar }}</td>
                                    @php $totalgpa = 0; $jmh = 0; @endphp
                                    @for($j=0;$j<6;$j++)
                                    @php
                                        $data = array();
                                        foreach($ipk as $keyitem=>$valitem)
                                        {
                                            if($valitem['sid']==$v->sid)
                                            {
                                                $datas = $valitem['detail'];
                                                $data = isset($datas[$j]) ? $datas[$j] : array('gpa'=>'0');
                                                $jmh = isset($datas[$j]) ? $jmh+1 : $jmh;
                                            }
                                        }
                                        $totalgpa += $data['gpa'];
                                    @endphp
                                    <td style="text-align:right;">{{ (isset($datas[$j])) ? number_format(($totalgpa/$jmh),2,',','.') : '0' }} </td>
                                    @endfor
                                    {{-- <td style="text-align:right;">{{ sprintf('%0.2f',round($totalgpa,2)) }}</td> --}}
                                    {{-- <td style="text-align:right;">{{ ($jmh!=0) ? sprintf('%0.2f',round($totalgpa/$jmh,2)) : '0' }}</td> --}}
                                </tr>
                                @php
                                    $i++;
                                @endphp
                                @endforeach
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
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        e.target // newly activated tab
        e.relatedTarget // previous active tab
        $('#divloading').show();
        id = $(this).attr('id').split('pills-tab-');
        id = id[1];
        $.post('{{ url('raport-rekap-uts') }}',{_token: "{{ csrf_token() }}",'kelas':id},function(data){
            $('#divloading').css('display','none');
            $('#tbody'+id).html(data);
        })
    })
    function detail(sid,name)
    {
        $.post('{{ url('raport-rekap-uts-detail') }}',{_token: "{{ csrf_token() }}",'sid':sid},function(data){
            $('#modalAllLabel').html('Detail '+name);
            $('#modalAllBody').html(data);
            $('#modalAll').modal('show');
        })
    }
</script>
@endpush
