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
                        {{-- <a href="{{ route('siswa.baru') }}" id="createNew" class="btn btn-sm btn-neutral"><i class="fa fa-plus"></i> Tambah</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
   <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ url('konfigurasi/savelogo') }}" method="POST" id="frmTripay" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="type" name="type" value="logo">
                        @if (config('logo_lembaga')!='')
                        <div class="form-group">
                            <label for="active_term">Logo (max 899x207)</label>
                            <div class="card">
                                <div class="card-body">
                                    <img src="{{ asset('uploads/'.config('logo_lembaga')) }}"  alt="Logo" style="-webkit-filter: drop-shadow(5px 5px 5px #222); filter: drop-shadow(5px 5px 5px #222);">
                                </div>
                            </div>
                        </div>
                        <button type="submit" id="save" class="btn btn-primary"><i class="fa fa-trash-alt"></i> Hapus</button>
                        @else
                        <div class="form-group">
                            <label for="active_term">Logo (max 899x207)</label>
                            <input type="file" name="logo" id="logo" class="form-control" autocomplete="off">
                        </div>
                        <button type="submit" id="save" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
    {{-- <script>
        $('#save').on('click',function(){
            data = $('#frmTripay').serialize();
            $.post('{{ url('konfigurasi') }}',{"_token": "{{ csrf_token() }}", data:data},function(data){
                if(data=='Berhasil')
                {
                    msgSukses('Berhasil disimpan');
                }
            })
        })
    </script> --}}
@endpush
