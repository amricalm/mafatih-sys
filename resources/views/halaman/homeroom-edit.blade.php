@extends('layouts.app')

@section('content')
<div class="container-fluid pt-7">
    <div class="header">
        <div class="header-body">
            <div class="row">
                <div class="col-lg-6">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('homeroom') }}">Wali Kelas</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $judul }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 text-right">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 mb-5 mb-xl-0">
                            <div class="card shadow">
                                <div class="card-body">
                                    <form action="{{ route('homeroom.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" id="hrid" name="hrid" value="{{ $data[0]->hrid ?? '' }}">
                                        <input type="hidden" id="ccid" name="ccid" value="{{ $getClass->id }}">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group input-group-sm">
                                                    <label class="form-control-label" for="class">Kelas</label>
                                                    <input type="text" class="form-control" autocomplete="off" value="{{ $getClass->name }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group input-group-sm">
                                                    <label class="form-control-label" for="homeroom">Wali Kelas</label>
                                                    <select name="emid" id="emid" class="form-control" required>
                                                        <option value="">- Pilih Wali Kelas -</option>
                                                        @foreach($employes as $employe)
                                                        <option value="{{$employe->id}}" {{($employe->id == ($data[0]->emid ?? '')) ? 'selected="selected"' : ''}}>{{$employe->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group input-group-sm text-right">
                                                    <a href="{{ route('homeroom') }}" class="btn btn-secondary"><i class="fa fa-undo"></i> Kembali</a>
                                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
