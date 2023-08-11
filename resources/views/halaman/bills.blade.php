@extends('layouts.app')
@include('komponen.dataTables')

@section('content')
<div class="container-fluid pt-7">
    <div class="header">
        <div class="header-body">
            <div class="row">
                <div class="col-lg-6">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('tahunajaran') }}">{{ $judul }}</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 text-right">

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="table-responsive py-4">
                    <div class="container">
                        <table class="table data-table" id="tablesiswa">
                            <thead>
                                <tr>
                                    <th>No Invoice</th>
                                    <th>Nama Santri/Calon Santri</th>
                                    <th>Nama Tagihan</th>
                                    <th>Jumlah Total</th>
                                    <th>Status</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $key=>$value)
                                @php
                                $method = ($value['method']=='') ? 'QRIS' : $value['method'];
                                @endphp
                                <tr>
                                    <td>{{ $value['invoice_id'] }}</td>
                                    <td>{{ $value['name'] }}</td>
                                    <td>{{ $value['bill'] }}</td>
                                    <td>{{ $value['amount'] }}</td>
                                    <td><span class="badge badge-primary">{{ $value['status'] }}</span></td>
                                    <td class="text-right">
                                        <div class="btn-group text-white" role="group" aria-label="Basic example">
                                            <a href="{{ url('ppdb/'.$value['invoice_id'].'/prosesdetail'."/".$method) }}" type="button" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Lihat</a>
                                        </div>
                                    </td>
                                </tr>
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
@push('js')
@endpush
