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
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url($aktif) }}">{{ $judul
                                    }}</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 text-right">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        {{-- <a href="{{ route('siswa.baru') }}" id="createNew" class="btn btn-sm btn-neutral"><i
                                class="fa fa-plus"></i> Tambah</a> --}}
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
                            'name' => 'Aplikasi',
                            'desc' => 'Profil Sekolah/Yayasan',
                            'url' => 'konfigurasi/yayasan',
                        ],
                        [
                            'name' => 'Data',
                            'desc' => 'Berkaitan dengan data',
                            'url' => 'konfigurasi/data',
                        ],
                        [
                            'name' => 'Pihak Ketiga',
                            'desc' => 'Semua API Pihak Ketiga',
                            'url' => 'konfigurasi/pihakketiga',
                        ],
                        [
                            'name' => 'Logo',
                            'desc' => 'Logo disertakan dalam aplikasi',
                            'url' => 'konfigurasi/logo',
                        ],
                        [
                            'name' => 'Menu',
                            'desc' => 'Macam-macam menu',
                            'url' => 'konfigurasi/menu',
                        ],
                        [
                            'name' => 'Peran',
                            'desc' => 'Macam-macam peran',
                            'url' => 'konfigurasi/peran',
                        ],
                        [
                            'name' => 'Modul',
                            'desc' => 'Macam-macam modul',
                            'url' => 'konfigurasi/modul',
                        ],
                        [
                            'name' => 'Notifikasi Android',
                            'desc' => 'Notifikasi Android',
                            'url' => 'konfigurasi/notif-android',
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
<script>
    $('#saveTripay').on('click',function(){
            data = $('#frmTripay').serialize();
            $.post('{{ url('konfigurasi') }}',{"_token": "{{ csrf_token() }}", data:data},function(data){
                if(data=='Berhasil')
                {
                    msgSukses('Berhasil disimpan');
                }
            })
        })
        $('#saveRecaptcha').on('click',function(){
            data = $('#frmGR').serialize();
            $.post('{{ url('konfigurasi') }}',{"_token": "{{ csrf_token() }}", data:data},function(data){
                if(data=='Berhasil')
                {
                    msgSukses('Berhasil disimpan');
                }
            })
        })
</script>
@endpush
