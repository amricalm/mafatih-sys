@extends('layouts.app')
@include('komponen.daerah')

@section('content')
<div class="container-fluid pt-7">
    <div class="header">
        <div class="header-body">
            <div class="row">
                <div class="col-lg-6">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('sekolah') }}">{{ $judul }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 mb-5 mb-xl-0">
                        <form action="{{ route('sekolah.simpan') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" id="id" value="{{ config('id_active_school') }}">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="nss">NSS</label>
                                        <input type="text" class="form-control" name="nss" id="nss" autocomplete="off" placeholder="Nomor Statistik Sekolah" value="{{ $sekolah['nss'] }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="name">Nama Sekolah</label>
                                        <input type="text" class="form-control" name="name" id="name" autocomplete="off" placeholder="Nama Sekolah" value="{{ $sekolah['name'] }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="phone">Telpon</label>
                                        <input type="text" class="form-control" name="phone" id="phone" autocomplete="off" value="{{ $sekolah['phone'] }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="email">Email</label>
                                        <input type="email" class="form-control" name="email" id="email" autocomplete="off" value="{{ $sekolah['email'] }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="year">Tahun Berdiri</label>
                                        <input type="number" class="form-control" name="year" id="year" autocomplete="off" placeholder="Tahun berdiri" value="{{ $sekolah['year'] }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="school_type_id">Tingkat</label>
                                        <select class="form-control" name="school_type_id" id="school_type_id">
                                            @foreach($type as $key => $value)
                                            <option value="{{ $value['id'] }}" {!! ($sekolah['school_type_id']==$value['id']) ? 'selected="selected"' : '' !!}>{{ $value['desc'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="accreditation">Status Akreditasi</label>
                                        <input type="text" class="form-control" name="accreditation" id="accreditation" autocomplete="off" value="{{ $sekolah['accreditation'] }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="surface_area">Luas Tanah</label>
                                        <input type="number" class="form-control" name="surface_area" id="surface_area" autocomplete="off" value="{{ $sekolah['surface_area'] }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="building_area">Luas Bangunan</label>
                                        <input type="number" class="form-control" name="building_area" id="building_area" autocomplete="off" value="{{ $sekolah['building_area'] }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="land_status">Status Tanah</label>
                                        <input type="text" class="form-control" name="land_status" id="land_status" autocomplete="off" value="{{ $sekolah['land_status'] }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="alamat">Alamat</label>
                                        <textarea name="alamat" id="alamat" class="form-control" rows="5">{{ $alamat['address'] }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="provinsi">Provinsi</label>
                                        @php
                                        $provinces = new App\Http\Controllers\WilayahController;
                                        $provinces= $provinces->provinces();
                                        @endphp
                                        <select class="form-control" name="provinsi" id="provinsi" required>
                                            <option value=""> - Pilih Salah Satu - </option>
                                            @foreach ($provinces as $item)
                                            <option value="{{ $item->id ?? '' }}" {!! ($alamat['province']==$item->id) ? ' selected="selected"' : '' !!}>{{ $item->name ?? '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="kota">Kota</label>
                                        <select class="form-control" name="kota" id="kota" required>
                                            <option value=""> - Pilih Salah Satu - </option>
                                            @php
                                            $kota = (count($city)>0) ? $city : array();
                                            @endphp
                                            @foreach($kota as $key => $value)
                                            <option value="{{ $key }}" {!! ($alamat['city']==$key) ? 'selected="selected"' : '' !!}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="kecamatan">Kecamatan</label>
                                        <select class="form-control" name="kecamatan" id="kecamatan" required>
                                            <option value=""> - Pilih Salah Satu - </option>
                                            @php
                                            $kec = (count($district)>0) ? $district : array();
                                            @endphp
                                            @foreach($kec as $key => $value)
                                            <option value="{{ $key }}" {!! ($alamat['district']==$key) ? 'selected="selected"' : '' !!}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="desa">Desa</label>
                                        <select class="form-control" name="desa" id="desa" required>
                                            <option value=""> - Pilih Salah Satu - </option>
                                            @php
                                            $desa = (count($village)>0) ? $village : array();
                                            @endphp
                                            @foreach($desa as $key => $value)
                                            <option value="{{ $key }}" {!! ($alamat['village']==$key) ? 'selected="selected"' : '' !!}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="post_code">Kode POS</label>
                                        <input type="text" class="form-control" name="post_code" id="post_code" autocomplete="off" value="{{ $alamat['post_code'] }}">
                                    </div>
                                </div>
                                <hr>
                                <div class="col-md-12 text-right">
                                    <button class="btn btn-secondray" onclick="history.back()"><i class="fa fa-undo"></i> Kembali</button>
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
@endpush
