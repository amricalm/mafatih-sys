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
                            <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="#">{{ __('Tambah Karyawan') }}</a></li>
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
                            <div class="nav-wrapper">
                                <ul class="nav nav-pills flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab" data-toggle="tab" href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">Profil Karyawan</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link mb-sm-3 mb-md-0 disabled" id="tabs-icons-text-25-tab" data-toggle="tab"
                                            href="#tabs-icons-text-25" role="tab" aria-controls="tabs-icons-text-2"
                                            aria-selected="false">Profil Pekerjaan</a>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a class="nav-link mb-sm-3 mb-md-0 disabled" id="tabs-icons-text-2-tab" data-toggle="tab" href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" disabled="disabled" aria-selected="false">Profil Keluarga</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link mb-sm-3 mb-md-0 disabled" id="tabs-icons-text-3-tab" data-toggle="tab" href="#tabs-icons-text-3" role="tab" aria-controls="tabs-icons-text-3" disabled="disabled" aria-selected="false">Profil Lain</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link mb-sm-3 mb-md-0 disabled" id="tabs-icons-text-4-tab" data-toggle="tab" href="#tabs-icons-text-4" role="tab" aria-controls="tabs-icons-text-4" disabled="disabled" aria-selected="false">Kondisi Ekonomi</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link mb-sm-3 mb-md-0 disabled" id="tabs-icons-text-5-tab" data-toggle="tab" href="#tabs-icons-text-5" role="tab" aria-controls="tabs-icons-text-5" disabled="disabled" aria-selected="false">Upload</a>
                                    </li> --}}
                                </ul>
                            </div>
                            <div class="card shadow">
                                <div class="card-body">
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                                            <form action="{{ url('karyawan/simpan') }}" method="POST">
                                                @csrf
                                                @include('halaman.dalam.person-karyawan')
                                            </form>
                                        </div>
                                        <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                                            <div class="row">
                                                <div class="col-md-12 p-3 text-center">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" name="stay_with_parent" id="stay_with_parent">
                                                        <label class="custom-control-label" for="stay_with_parent">Tinggal dengan Orang tua</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="ayah_nama">Nama Ayah</label>
                                                        <input type="text" name="ayah_nama" id="ayah_nama" class="form-control" autocomplete="off" required>
                                                    </div>
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="ayah_age">Umur Ayah</label>
                                                        <input type="number" class="form-control" id="ayah_age" name="ayah_age" autocomplete="off" required>
                                                    </div>
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="ayah_last_education">Pendidikan Terakhir Ayah</label>
                                                        <input type="text" class="form-control" id="ayah_last_education" name="ayah_last_education" autocomplete="off" required>
                                                    </div>
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="ayah_job">Pekerjaan Ayah</label>
                                                        <select name="ayah_job" id="ayah_job" class="form-control">
                                                            @php
                                                            foreach($jobs as $key=>$val)
                                                            {
                                                            echo '<option value="'.$val->id.'">'.$val->name.'</option>';
                                                            }
                                                            @endphp
                                                        </select>
                                                    </div>
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="ayah_job">Penghasilan Perbulan Ayah</label>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="ayah_language">Bahasa Dirumah</label>
                                                        <input type="text" class="form-control" name="ayah_language" id="ayah_language" autocomplete="off">
                                                    </div>
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="ayah_citizen">Kewarganegaraan Ayah</label>
                                                        <input type="text" class="form-control" autocomplete="off" name="ayah_citizen" id="ayah_citizen">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="ibu_nama">Nama Ibu</label>
                                                        <input type="text" name="ibu_nama" id="ibu_nama" class="form-control" autocomplete="off">
                                                    </div>
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="ibu_age">Umur Ibu</label>
                                                        <input type="number" class="form-control datepicker" name="ibu_age" id="ibu_age" autocomplete="off" required>
                                                    </div>
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="ibu_last_education">Pendidikan Terakhir Ibu</label>
                                                        <input type="text" class="form-control" id="ibu_last_education" name="ibu_last_education" autocomplete="off" required>
                                                    </div>
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="ibuh_job">Pekerjaan Ibu</label>
                                                        <select name="ibu_jobs" id="ibu_jobs" class="form-control">
                                                            @php
                                                            foreach($jobs as $key=>$val)
                                                            {
                                                            echo '<option value="'.$val->id.'">'.$val->name.'</option>';
                                                            }
                                                            @endphp
                                                        </select>
                                                    </div>
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="ayah_job">Penghasilan Perbulan Ibu</label>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="languages_ibu">Bahasa Dirumah</label>
                                                        <input type="text" class="form-control" name="languages_ibu" id="languages_ibu" autocomplete="off">
                                                    </div>
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="ibu_citizen">Kewarganegaraan Ibu</label>
                                                        <input type="text" class="form-control" autocomplete="off" name="ibu_citizen" id="ibu_citizen">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ortu row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="address">Alamat Rumah</label>
                                                        <textarea class="form-control" id="alamat_ayah" name="alamat" rows="18"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="provinsi">Provinsi</label>
                                                        <select class="form-control" name="provinsi" id="provinsi" required>
                                                            <option> - Pilih Salah Satu - </option>
                                                            @foreach ($provinces as $item)
                                                            <option value="{{ $item->id ?? '' }}">{{ $item->name ?? '' }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="kota">Kota</label>
                                                        <select class="form-control" name="kota" id="kota" required>
                                                            <option> - Pilih Salah Satu - </option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="kecamatan">Kecamatan</label>
                                                        <select class="form-control" name="kecamatan" id="kecamatan" required>
                                                            <option> - Pilih Salah Satu - </option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="desa">Desa</label>
                                                        <select class="form-control" name="desa" id="desa" required>
                                                            <option> - Pilih Salah Satu - </option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="post">Kode POS</label>
                                                        <input type="text" class="form-control" name="post" id="post" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h3>Saudara</h3>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="table-responsive">
                                                        <div>
                                                            <table class="table align-items-center">
                                                                <thead class="thead-light">
                                                                    <tr>
                                                                        <th style="width:10%;">No</th>
                                                                        <th style="width:90%;">Detail</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="list-prestasi">
                                                                    <tr>
                                                                        <td>1</td>
                                                                        <td>
                                                                            <p>Nama <br>Umur <br>Jkl <br>Pendidikan <br>Pekerjaan</p>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12" style="border:1px solid black;border-radius:5px;padding:5px;">
                                                    <h4>Form Tambah Saudara</h4>
                                                    <div class="row card-body">
                                                        <div class="col-md-6">
                                                            <div class="form-group input-group-sm">
                                                                <label class="form-control-label" for="post">Nama Saudara</label>
                                                                <input type="text" class="form-control" name="post" id="post" autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group input-group-sm">
                                                                <label class="form-control-label" for="post">Umur</label>
                                                                <input type="text" class="form-control" name="post" id="post" autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group input-group-sm">
                                                                <label class="form-control-label" for="">Jenis Kelamin</label>
                                                                <br>
                                                                <input type="radio" name="sex" id="sex1" value="L"> <label for="sex1">Laki-laki</label>&nbsp;&nbsp;
                                                                <input type="radio" name="sex" id="sex2" value="P"> <label for="sex2">Perempuan</label>&nbsp;&nbsp;
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group input-group-sm">
                                                                <label class="form-control-label" for="post">Pendidikan</label>
                                                                <input type="text" class="form-control" name="post" id="post" autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group input-group-sm">
                                                                <label class="form-control-label" for="post">Pekerjaan</label>
                                                                <input type="text" class="form-control" name="post" id="post" autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 text-right">
                                                            <button class="btn btn-sm btn-primary">Tambah</button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="tabs-icons-text-3" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="height">Tinggi Badan</label>
                                                        <input type="number" class="form-control" id="height" name="height" placeholder="Tinggi Badan">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="weight">Berat Badan</label>
                                                        <input type="number" class="form-control" id="weight" name="weight" placeholder="Berat Badan">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group" style="margin-top:25px;">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="is_glasses" id="is_glasses">
                                                            <label class="custom-control-label" for="is_glasses">Berkacamata</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="character">Karakter/Watak</label>
                                                        <input type="text" class="form-control" id="character" name="character" placeholder="Periang dll">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="hobbies">Hobi</label>
                                                        <input type="text" class="form-control" id="hobbis" name="hobbies" placeholder="Hobi">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h3>Prestasi</h3>
                                                    <div class="table-responsive">
                                                        <div>
                                                            <table class="table align-items-center">
                                                                <thead class="thead-light">
                                                                    <tr>
                                                                        <th scope="col" class="sort" data-sort="name">Nama Prestasi</th>
                                                                        <th scope="col" class="sort" data-sort="budget">Tahun</th>
                                                                        <th scope="col" class="sort" data-sort="status">Deskripsi</th>
                                                                        <th scope="col"></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="list-prestasi">
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th scope="col" class="sort" data-sort="name">
                                                                            <input type="text" name="name-prestasi" id="name-prestasi" class="form-control form-control-sm form-block">
                                                                        </th>
                                                                        <th scope="col" class="sort" data-sort="year">
                                                                            <input type="number" name="year-prestasi" id="year-prestasi" class="form-control form-block form-control-sm">
                                                                        </th>
                                                                        <th scope="col" class="sort" data-sort="desc">
                                                                            <input type="text" name="desc-prestasi" id="des-prestasi" class="form-control form-block form-control-sm">
                                                                        </th>
                                                                        <th scope="col">
                                                                            <input type="button" class="btn btn-primary btn-sm" value="Tambah">
                                                                        </th>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h3>Kesehatan</h3>
                                                    <div class="table-responsive">
                                                        <div>
                                                            <table class="table align-items-center">
                                                                <thead class="thead-light">
                                                                    <tr>
                                                                        <th scope="col" class="sort" data-sort="name">Nama Prestasi</th>
                                                                        <th scope="col" class="sort" data-sort="budget">Tahun</th>
                                                                        <th scope="col" class="sort" data-sort="status">Deskripsi</th>
                                                                        <th scope="col"></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="list-prestasi">
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th scope="col" class="sort" data-sort="name">
                                                                            <input type="text" name="name-prestasi" id="name-prestasi" class="form-control form-control-sm form-block">
                                                                        </th>
                                                                        <th scope="col" class="sort" data-sort="year">
                                                                            <input type="number" name="year-prestasi" id="year-prestasi" class="form-control form-block form-control-sm">
                                                                        </th>
                                                                        <th scope="col" class="sort" data-sort="desc">
                                                                            <input type="text" name="desc-prestasi" id="des-prestasi" class="form-control form-block form-control-sm">
                                                                        </th>
                                                                        <th scope="col">
                                                                            <input type="button" class="btn btn-primary btn-sm" value="Tambah">
                                                                        </th>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="tabs-icons-text-4" role="tabpanel" aria-labelledby="tabs-icons-text-4-tab">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="nis">Kepemilikan Rumah</label>
                                                        <input type="text" name="nisn" id="nisn" class="form-control" autocomplete="off" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="nis">Luas Rumah</label>
                                                        <input type="number" name="nisn" id="nisn" class="form-control" autocomplete="off" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="nis">Luas Tanah</label>
                                                        <input type="number" name="nisn" id="nisn" class="form-control" autocomplete="off" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="nis">Tagihan Listrik Bulanan</label>
                                                        <input type="text" name="nisn" id="nisn" class="form-control" autocomplete="off" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="nis">Tagihan Air PDAM Bulanan</label>
                                                        <input type="text" name="nisn" id="nisn" class="form-control" autocomplete="off" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="nis">Tagihan Telkom Bulanan</label>
                                                        <input type="text" name="nisn" id="nisn" class="form-control" autocomplete="off" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <h3>Alat Elektronik</h3>
                                                    <div class="table-responsive">
                                                        <div>
                                                            <table class="table align-items-center">
                                                                <thead class="thead-light">
                                                                    <tr>
                                                                        <th scope="col">Nama</th>
                                                                        <th scope="col"></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="list-prestasi">
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th scope="col" class="sort" data-sort="desc">
                                                                            <input type="text" name="desc-prestasi" id="des-prestasi" class="form-control form-block form-control-sm">
                                                                        </th>
                                                                        <th scope="col">
                                                                            <input type="button" class="btn btn-primary btn-sm" value="Tambah">
                                                                        </th>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <h3>Kendaraan</h3>
                                                    <div class="table-responsive">
                                                        <div>
                                                            <table class="table align-items-center">
                                                                <thead class="thead-light">
                                                                    <tr>
                                                                        <th scope="col" class="sort" data-sort="name">Jenis</th>
                                                                        <th scope="col" class="sort" data-sort="budget">Jumlah</th>
                                                                        <th scope="col" class="sort" data-sort="status">Keterangan</th>
                                                                        <th scope="col"></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="list-prestasi">
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th scope="col" class="sort" data-sort="name">
                                                                            <input type="text" name="name-prestasi" id="name-prestasi" class="form-control form-control-sm form-block">
                                                                        </th>
                                                                        <th scope="col" class="sort" data-sort="year">
                                                                            <input type="number" name="year-prestasi" id="year-prestasi" class="form-control form-block form-control-sm">
                                                                        </th>
                                                                        <th scope="col" class="sort" data-sort="desc">
                                                                            <input type="text" name="desc-prestasi" id="des-prestasi" class="form-control form-block form-control-sm">
                                                                        </th>
                                                                        <th scope="col">
                                                                            <input type="button" class="btn btn-primary btn-sm" value="Tambah">
                                                                        </th>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <h3>Asset</h3>
                                                    <div class="table-responsive">
                                                        <div>
                                                            <table class="table align-items-center">
                                                                <thead class="thead-light">
                                                                    <tr>
                                                                        <th scope="col" class="sort" data-sort="name">Jenis</th>
                                                                        <th scope="col" class="sort" data-sort="budget">Jumlah</th>
                                                                        <th scope="col" class="sort" data-sort="status">Keterangan</th>
                                                                        <th scope="col"></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="list-prestasi">
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th scope="col" class="sort" data-sort="name">
                                                                            <input type="text" name="name-prestasi" id="name-prestasi" class="form-control form-control-sm form-block">
                                                                        </th>
                                                                        <th scope="col" class="sort" data-sort="year">
                                                                            <input type="number" name="year-prestasi" id="year-prestasi" class="form-control form-block form-control-sm">
                                                                        </th>
                                                                        <th scope="col" class="sort" data-sort="desc">
                                                                            <input type="text" name="desc-prestasi" id="des-prestasi" class="form-control form-block form-control-sm">
                                                                        </th>
                                                                        <th scope="col">
                                                                            <input type="button" class="btn btn-primary btn-sm" value="Tambah">
                                                                        </th>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="tabs-icons-text-5" role="tabpanel" aria-labelledby="tabs-icons-text-5-tab">
                                            <h2>Profil Karyawan</h2>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="nis">Foto Karyawan</label>
                                                        <input type="file" name="nisn" id="nisn" class="form-control" autocomplete="off" value="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="nis">Kartu Keluarga</label>
                                                        <input type="file" name="nisn" id="nisn" class="form-control" autocomplete="off" value="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="nis">Akta Lahir</label>
                                                        <input type="file" name="nisn" id="nisn" class="form-control" autocomplete="off" value="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="nis">Surat Keterangan Sehat</label>
                                                        <input type="file" name="nisn" id="nisn" class="form-control" autocomplete="off" value="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="nis">Surat Keterangan Baik</label>
                                                        <input type="file" name="nisn" id="nisn" class="form-control" autocomplete="off" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <h2>Orang Tua</h2>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="nis">Foto Rumah</label>
                                                        <input type="file" name="nisn" id="nisn" class="form-control" autocomplete="off" value="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="nis">Foto Rekening Listrik</label>
                                                        <input type="file" name="nisn" id="nisn" class="form-control" autocomplete="off" value="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
@push('js')
<script>
    $('#stay_with_parent').on('change', function() {
        if ($(this).prop('checked') == true) {
            $(".ortu input").each(function() {
                $(this).attr('disabled', 'disabled');
            });
            $('.ortu select').each(function() {
                $(this).attr('disabled', 'disabled');
            });
            $('.ortu textarea').each(function() {
                $(this).attr('disabled', 'disabled');
            });
        } else {
            $(".ortu input").each(function() {
                $(this).removeAttr('disabled');
            });
            $('.ortu select').each(function() {
                $(this).removeAttr('disabled');
            });
            $('.ortu textarea').each(function() {
                $(this).removeAttr('disabled');
            });
        }
    })
</script>
<script src="{{ asset('argon/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    $('.datepicker').datepicker({
        'setDate': new Date(),
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayHighlight: true,
        zIndexOffset: 999
    });
</script>
@endpush
