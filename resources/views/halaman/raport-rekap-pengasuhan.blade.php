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
                        @if ($req->pilih)
                        <a href="{{ url('raport-rekap-pengasuhan/'.$req->pilih.'/export') }}" target="_blank" class="btn btn-sm btn-success"><i class="fas fa-file-excel"></i> XlS</a>
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
                    <h3>Rekap Nilai Pengasuhan</h3>
                    <form action="" method="POST" style="padding-bottom: 10px;">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label for="staticLembaga" class="sr-only">Kelas</label>
                                            <select name="pilih" id="pilih" class="form-control" required>
                                                <option value="0"> - Pilih Salah Satu - </option>
                                                @foreach ($employe as $k=>$v)
                                                @php
                                                    $selected = ($v['id']==$pilih) ? 'selected="selected"' : '';
                                                @endphp
                                                <option value="{{ $v['id'] }}" {{ $selected }}>{{ $v['name'] }}</option>
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
                                    <th class="text-center">No</th>
                                    <th class="text-center">NIS</th>
                                    <th class="text-center">Nama Lengkap</th>
                                    <th class="text-center">Nama Dalam Arabic</th>
                                    <th class="text-center">Kelas</th>
                                    @foreach ($finalboardingdtl as $rows)
                                    @foreach ($rows['nilai'] as $nilai)
                                        <th class="text-center">{{ $nilai['name_ar'] }}</th>
                                    @endforeach
                                    @break
                                    @endforeach
                                    <th class="text-left">Komentar MS</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @php $i=0; @endphp
                                @foreach ($finalboardingdtl as $rows)
                                <tr>
                                    <td class="text-center">{{ ($i+1) }}</td>
                                    <td class="text-center">{{ \App\SmartSystem\General::angka_arab($rows['nis']) }}</td>
                                    <td>{{ $rows['name'] }}</td>
                                    <td class="text-right">{{ $rows['name_ar'] }}</td>
                                    <td class="text-right">{{ $rows['class'] }}</td>
                                    @php $note = "";  @endphp
                                    @foreach ($rows['nilai'] as $nilai)
                                        @if ($nilai['type']=='ITEM')
                                            <td class="text-center">{{ $nilai['letter_grade'] }}</td>
                                        @else
                                            <td class="text-center">{{ number_format($nilai['final_grade']) }}</td>
                                        @endif
                                        @php $note = $nilai['note'];  @endphp
                                    @endforeach
                                    <td class="text-left">{{ $note }}</td>
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
