@extends('layouts.app')
@include('komponen.tabledata')

@section('content')
<div class="container-fluid pt-7">
    <div class="header">
        <div class="header-body">
            <div class="row">
                <div class="col-lg-12">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('') }}">Dashboard</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="table-responsive py-4">
                    <div class="container">
                        <table class="table datatables">
                            <thead>
                                <tr>
                                    <th>Waktu</th>
                                    <th>Nama File</th>
                                    <th>Keterangan</th>
                                    <th>Download</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($get as $k=>$v)
                                @php
                                    $namafile = Str::substr($v->url, 11, Str::length($v->url));
                                @endphp
                                <tr>
                                    <td>{{ $v->con }}</td>
                                    <td>{{ $namafile }}</td>
                                    <td>{{ $v->desc }}</td>
                                    {{-- <td><a href="{{ url('download/'.$v->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-file-download"></i></a></td> --}}
                                    <td><a href="{{ asset($v->original_file) }}" class="btn btn-primary btn-sm" download><i class="fas fa-file-download"></i></a></td>
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
