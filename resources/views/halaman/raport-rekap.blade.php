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
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url($aktif) }}">{{ $judul }}</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 text-right">
                    <div class="btn-group" role="group" aria-label="Basic example">
                    </div>
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
                            'name' => 'Remedial UTS',
                            'desc' => 'Download Data Remedial UTS semua Kelas.',
                            'url' => 'remedial/UTS',
                        ],
                        [
                            'name' => 'Remedial UAS',
                            'desc' => 'Download Data Remedial UAS semua Kelas.',
                            'url' => 'remedial/UAS',
                        ],
                        [
                            'name' => 'Rekap UTS',
                            'desc' => 'Lihat Rekap UTS semua Kelas.',
                            'url' => 'raport-rekap-uts',
                        ],
                        [
                            'name' => 'Rekap UAS',
                            'desc' => 'Lihat Rekap UAS semua Kelas.',
                            'url' => 'raport-rekap-uas',
                        ],
                        [
                            'name' => 'Rekap Nilai Total',
                            'desc' => 'Lihat Rekap Nilai Total semua kelas.',
                            'url' => 'raport-rekap-total',
                        ],
                        [
                            'name' => 'Rekap Bayanat Idhafiyah',
                            'desc' => 'Lihat Rekap Bayanat Idhafiyah semua Kelas.',
                            'url' => 'rekap-idhafiyah',
                        ],
                        [
                            'name' => 'Lihat Mahmul',
                            'desc' => 'Lihat Mahmul',
                            'url' => 'rekap-mahmul',
                        ],
                        [
                            'name' => 'Rekap Tarakumi',
                            'desc' => 'Rekap Tarakumi per Semester',
                            'url' => 'rekap-tarakumi',
                        ],
                        [
                            'name' => 'Rekap Angkatan',
                            'desc' => 'Rekap Rangking per Angkatan',
                            'url' => 'rekap-rangking',
                        ],
                        [
                            'name' => 'Rekap Nilai Alquran',
                            'desc' => 'Rekap Nilai Raport',
                            'url' => 'rekap-alquran',
                        ],
                        [
                            'name' => 'Rekap Pengasuhan',
                            'desc' => 'Lihat Rekap Pengasuhan semua Musyrif Sakan.',
                            'url' => 'raport-rekap-pengasuhan',
                        ],
                        [
                            'name' => 'Rekap Diknas',
                            'desc' => 'Rekap Raport Diknas',
                            'url' => 'rekap-diknas',
                        ],
                    ];
                @endphp
                @for ($i=0;$i<count($arraymenu);$i++)
                <div class="card mb-4">
                    <div class="card-body pb-0">
                        <h5 class="card-title mb-2">{{ $arraymenu[$i]['name'] }}</h5>
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
<script>
</script>
@endpush
