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
                            <li class="breadcrumb-item active" aria-current="page">{{ $judul }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-md-12">
            <div class="card-deck">
                @php
                    $arraymenu = [
                        [
                            'name' => 'Kepala Sekolah',
                            'desc' => 'Pengaturan Kepala Sekolah per Tahun Ajar',
                            'url' => 'kepala-sekolah',
                        ],
                        [
                            'name' => 'Wali Kelas',
                            'desc' => 'Pengaturan Wali Kelas per Tahun Ajar',
                            'url' => 'walikelas/daftar',
                        ],
                    ];
                @endphp
                @for ($i=0;$i<count($arraymenu);$i++)
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $arraymenu[$i]['name'] }}</h5>
                        <p class="card-text">{{ $arraymenu[$i]['desc'] }}</p>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted"><a href="{{ url($arraymenu[$i]['url']) }}" class=""><i class="fas fa-share-square"></i> Lihat Detail</a></small>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
@endpush
