@extends('layouts.app')
@include('komponen.tabledata')
@include('komponen.emojipicker')

@push('css')
<style>
    div.kecil{
        max-width: 300px;
        word-break: break-all;
        white-space: normal;
    }
</style>
@endpush
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
                <div class="py-4">
                    <div class="container">
                        @foreach ($notif as $ky=>$vl)
                        @php
                            $url = ($vl->notif_url!='') ? $vl->notif_url.'" target="_blank' : '#';
                        @endphp
                        <a href="{!! $url !!}">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-1">{{ $vl->notif_title }}</h5>
                                    <p><small class="text-muted mb-3">{{ $vl->notif_datetime }}</small></p>
                                    <p class="card-text"><small>{!! $vl->notif_message !!}</small></p>
                                    {{-- <p class="card-text"><small class="text-muted">{{ $vl->notif_datetime }}</small></p> --}}
                                </div>
                            </div>
                        </a>
                        @endforeach
                        <div class="card align-center">
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-12 float-right">
                                        {{ $notif->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth')
</div>
@endsection
