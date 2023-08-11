@extends('layouts.app', ['class' => 'bg-maroon','style'=>'background-image:url('.asset("assets/img/adn/bg-msh-miring.png").');-webkit-background-size: auto;-moz-background-size: cover;-o-background-size: cover;background-size: cover;background-position: center middle;background-origin: content-box;'])

@push('css')
<style>
    .grecaptcha-badge { opacity:0;}
</style>
@endpush
@section('content')
    @include('layouts.headers.guest')
    <div class="container mt--8 pt-5 pb-5">
        <div class="row justify-content-center pb-2">
            <div class="col-lg-5 col-md-7">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h1 class="arabic" style="text-align: center">أهْلاً وَسَهْلاً</h1>
                                <h6 class="text-center">Selamat datang di <br>halaman khusus <b>orangtua</b></h6>
                                <h1 class="text-center">Form Daftar Ulang</h1>
                                <hr>
                            </div>
                            <div class="col-md-12">
                                <form action="" id="frmCari" method="GET">
                                    {{-- @csrf --}}
                                    <div class="form-group">
                                        <label for="noreg">Nomor Registrasi</label>
                                        <input type="text" class="form-control" id="noreg" name="nored" maxlength="10" autocomplete="off" value="{{ $noreg }}" >
                                    </div>
                                    {{-- <div class="form-group">
                                        <div class="col-md-6">
                                            <input type="hidden" name="g-recaptcha-response" id="recaptcha">
                                        </div>
                                    </div> --}}
                                    <button type="submit" id="btncari" class="btn btn-primary btn-block"><i class="fa fa-search"></i> Cari</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($request->post())
        <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="card shadow">
                    <ul class="nav nav-pills flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab"
                                data-toggle="tab" href="#tabs-icons-text-1" role="tab"
                                aria-controls="tabs-icons-text-1" aria-selected="true">Profil Siswa</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab"
                                href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2"
                                aria-selected="false">Profil Keluarga</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-3-tab" data-toggle="tab"
                                href="#tabs-icons-text-3" role="tab" aria-controls="tabs-icons-text-3"
                                aria-selected="false">Profil Lain</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-4-tab" data-toggle="tab"
                                href="#tabs-icons-text-4" role="tab" aria-controls="tabs-icons-text-4"
                                aria-selected="false">Kondisi Ekonomi</a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-6-tab" data-toggle="tab"
                                href="#tabs-icons-text-6" role="tab" aria-controls="tabs-icons-text-6"
                                aria-selected="false">Profil Sekolah Asal</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-5-tab" data-toggle="tab"
                                href="#tabs-icons-text-5" role="tab" aria-controls="tabs-icons-text-5"
                                aria-selected="false">Upload</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                                <form id="formstep1">
                                    {{-- <input type="hidden" name="student_id" value="{{ $student->id }}">
                                    <input type="hidden" name="pid" value="{{ $person->id }}"> --}}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="nis">NIS</label>
                                                <input type="text" name="nis" id="nis"
                                                    class="form-control" autocomplete="off"
                                                    placeholder="Nomor Induk Sekolah" >
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="nisn">NISN</label>
                                                <input type="text" name="nisn" id="nisn"
                                                    class="form-control" autocomplete="off"
                                                    placeholder="Nomor Induk Siswa Nasional" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="name">Nama
                                                    Lengkap</label>
                                                <input type="text" name="name" id="name"
                                                    class="form-control" autocomplete="off"
                                                    placeholder="Nama Lengkap" required >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="nickname">Nama
                                                    Panggilan</label>
                                                <input type="text" name="nickname" id="nickname"
                                                    class="form-control" autocomplete="off"
                                                    placeholder="Nama Panggilan" >
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="name_ar">Nama Lengkap
                                                    Dalam Huruf Arab</label>
                                                <input type="text" class="form-control arabic"
                                                    name="name_ar" id="name_ar" autocomplete="off" dir="rtl"
                                                    placeholder="بالعربية" required >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="nik">NIK di KK</label>
                                                <input type="text" class="form-control" name="nik" autocomplete="off" required placeholder="NIK yang tertera di KK" >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="kk">Nomor Kartu Keluarga</label>
                                                <input type="text" class="form-control" name="kk" autocomplete="off" required placeholder="Nomor Kartu Keluarga" >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="aktalahir">Nomor Akta Lahir</label>
                                                <input type="text" class="form-control" name="aktalahir" autocomplete="off" required placeholder="Nomor Akta Lahir" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="pob">Tempat
                                                    Lahir</label>
                                                <input type="text" class="form-control" name="pob"
                                                    autocomplete="off" required placeholder="Tempat Lahir"
                                                    >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="dob">Tanggal
                                                    Lahir</label>
                                                <input type="text" class="form-control datepicker"
                                                    name="dob" autocomplete="off" required
                                                    placeholder="1999-09-19" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="">Jenis
                                                    Kelamin</label>
                                                <br>
                                                @php
                                                $array = ['L'=>'Laki-laki','P'=>'Perempuan'];
                                                $i = 0;
                                                foreach($array as $key=>$val) {
                                                $i++;
                                                echo '<input type="radio" name="sex" id="sex'.$i.'"
                                                    value="'.$key.'"> <label for="sex'.$i.'"
                                                    required>'.$val.'</label>&nbsp;&nbsp;';
                                                }
                                                @endphp
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="son_order">Anak
                                                    ke-</label>
                                                <input type="number" class="form-control" name="son_order"
                                                    id="son_order" autocomplete="off" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="siblings">Jml Saudara
                                                    Kandung</label>
                                                <input type="number" class="form-control" name="siblings"
                                                    id="siblings" autocomplete="off" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="stepbros">Jml Saudara
                                                    Tiri</label>
                                                <input type="number" class="form-control" autocomplete="off"
                                                    name="stepbros" id="stepbros" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="adoptives">Jml
                                                    Saudara Angkat</label>
                                                <input type="number" class="form-control" name="adoptives"
                                                    id="adoptives" autocomplete="off" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label"
                                                    for="citizen">Kewarganegaraan</label>
                                                <input type="text" class="form-control" autocomplete="off"
                                                    name="citizen" id="citizen" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label"
                                                    for="religion">Agama</label>
                                                <select name="religion" id="religion" class="form-control">
                                                    @php
                                                    $arrayr = ['islam'=>'Islam','lainnya'=>'lainnya'];
                                                    foreach($arrayr as $key=>$val)
                                                    {
                                                    echo '<option
                                                        value="'.$key.'">'.$val.'</option>';
                                                    }
                                                    @endphp
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="languages">Bahasa
                                                    Dirumah</label>
                                                <input type="text" class="form-control" name="languages"
                                                    id="languages" autocomplete="off" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="alamat">Alamat Rumah</label>
                                                <textarea class="form-control" id="alamat" name="alamat" rows="18"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label"
                                                    for="provinsi">Provinsi</label>
                                                <select class="form-control" name="provinsi" id="provinsi"
                                                    required>
                                                    <option value="0"> - Pilih Salah Satu - </option>
                                                </select>
                                            </div>
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="kota">Kota</label>
                                                <select class="form-control" name="kota" id="kota" required>
                                                    <option value="0"> - Pilih Salah Satu - </option>
                                                </select>
                                            </div>
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label"
                                                    for="kecamatan">Kecamatan</label>
                                                <select class="form-control" name="kecamatan" id="kecamatan"
                                                    required>
                                                    <option value="0"> - Pilih Salah Satu - </option>
                                                </select>
                                            </div>
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="desa">Desa</label>
                                                <select class="form-control" name="desa" id="desa" required>
                                                    <option value="0"> - Pilih Salah Satu - </option>
                                                </select>
                                            </div>
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="post">Kode
                                                    POS</label>
                                                <input type="text" class="form-control" name="post"
                                                    id="post" autocomplete="off" >
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group input-group-sm text-right">
                                                <a type="button" class="btn btn-secondary" href="{{ url()->previous() }}"><i class="fa fa-undo"></i> Kembali</a>
                                                <button type="button" class="btn btn-primary"
                                                    id="btnStep1"><i class="fa fa-save"></i> Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                                <form id="formstep2">
                                    @csrf
                                    {{-- <input type="hidden" name="pid" value="{{ $person->id }}"> --}}
                                    {{-- <input type="hidden" name="student_id" value="{{ $student->id }}"> --}}
                                    <div class="row">
                                        <div class="col-md-12 p-3 text-center">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input"
                                                    name="stay_with_parent" id="stay_with_parent" value="1" >
                                                <label class="custom-control-label"
                                                    for="stay_with_parent">Tinggal dengan Orang tua</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="ayah_nik">NIK
                                                    Ayah</label>
                                                <input type="text" name="ayah_nik" id="ayah_nik"
                                                    class="form-control" autocomplete="off" >
                                            </div>
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="ayah_nama">Nama
                                                    Ayah</label>
                                                <input type="text" name="ayah_nama" id="ayah_nama"
                                                    class="form-control" autocomplete="off" required >
                                            </div>
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="ayah_pob">Tempat Lahir Ayah</label>
                                                <input type="text" name="ayah_pob" id="ayah_pob"
                                                    class="form-control" autocomplete="off" required >
                                            </div>
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="ayah_dob">Tanggal
                                                    Lahir Ayah</label>
                                                <input type="text" class="form-control datepicker"
                                                    name="ayah_dob" id="ayah_dob" autocomplete="off"
                                                    placeholder="1999-09-19"   required>
                                            </div>
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label"
                                                    for="ayah_last_education">Pendidikan Terakhir
                                                    Ayah</label>
                                                <input type="text" class="form-control"
                                                    id="ayah_last_education" name="ayah_last_education"
                                                    autocomplete="off" required >
                                            </div>
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="ayah_job">Pekerjaan
                                                    Ayah</label>
                                                <select name="ayah_job" id="ayah_job" class="form-control">
                                                </select>
                                            </div>
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label"
                                                    for="ayah_income">Penghasilan Perbulan Ayah</label>
                                                <input type="number" class="form-control" name="ayah_income"
                                                    id="ayah_income" required >
                                            </div>
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label"
                                                    for="ayah_languages">Bahasa Dirumah</label>
                                                <input type="text" class="form-control"
                                                    name="ayah_languages" id="ayah_languages"
                                                    autocomplete="off" >
                                            </div>
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label"
                                                    for="ayah_citizen">Kewarganegaraan Ayah</label>
                                                <input type="text" class="form-control" autocomplete="off"
                                                    name="ayah_citizen" id="ayah_citizen" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="ibu_nik">NIK
                                                    Ibu</label>
                                                <input type="text" name="ibu_nik" id="ibu_nik"
                                                    class="form-control" autocomplete="off" required >
                                            </div>
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="ibu_nama">Nama
                                                    Ibu</label>
                                                <input type="text" name="ibu_nama" id="ibu_nama"
                                                    class="form-control" autocomplete="off" required >
                                            </div>
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="ibu_pob">Tempat Lahir Ibu</label>
                                                <input type="text" name="ibu_pob" id="ibu_pob"
                                                    class="form-control" autocomplete="off" required >
                                            </div>
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="ibu_dob">Tanggal
                                                    Lahir Ibu</label>
                                                <input type="text" class="form-control datepicker"
                                                    name="ibu_dob" id="ibu_dob" autocomplete="off" required
                                                    placeholder="1999-09-19" >
                                            </div>
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label"
                                                    for="ibu_last_education">Pendidikan Terakhir Ibu</label>
                                                <input type="text" class="form-control"
                                                    id="ibu_last_education" name="ibu_last_education"
                                                    autocomplete="off" required >
                                            </div>
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="ibu_job">Pekerjaan
                                                    Ibu</label>
                                                <select name="ibu_job" id="ibu_job" class="form-control">
                                                </select>
                                            </div>
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label"
                                                    for="ibu_income">Penghasilan Perbulan Ibu</label>
                                                <input type="text" class="form-control" id="ibu_income"
                                                    name="ibu_income" required >
                                            </div>
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="ibu_languages">Bahasa
                                                    Dirumah</label>
                                                <input type="text" class="form-control" name="ibu_languages"
                                                    id="ibu_languages" autocomplete="off" >
                                            </div>
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label"
                                                    for="ibu_citizen">Kewarganegaraan Ibu</label>
                                                <input type="text" class="form-control" autocomplete="off"
                                                    name="ibu_citizen" id="ibu_citizen" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ortu row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="ayah_alamat">Alamat
                                                    Rumah</label>
                                                <textarea class="form-control" id="ayah_alamat"
                                                    name="ayah_alamat"
                                                    rows="18"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label"
                                                    for="ayah_provinsi">Provinsi</label>
                                                <select class="form-control" name="ayah_provinsi"
                                                    id="ayah_provinsi" required>
                                                    <option> - Pilih Salah Satu - </option>
                                                </select>
                                            </div>
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label"
                                                    for="ayah_kota">Kota</label>
                                                <select class="form-control" name="ayah_kota" id="ayah_kota"
                                                    required>
                                                    <option> - Pilih Salah Satu - </option>
                                                </select>
                                            </div>
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label"
                                                    for="ayah_kecamatan">Kecamatan</label>
                                                <select class="form-control" name="ayah_kecamatan"
                                                    id="ayah_kecamatan" required>
                                                    <option> - Pilih Salah Satu - </option>
                                                </select>
                                            </div>
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label"
                                                    for="ayah_desa">Desa</label>
                                                <select class="form-control" name="ayah_desa" id="ayah_desa"
                                                    required>
                                                    <option> - Pilih Salah Satu - </option>
                                                </select>
                                            </div>
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="ayah_post">Kode
                                                    POS</label>
                                                <input type="text" class="form-control" name="ayah_post"
                                                    id="ayah_post" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 p-3 text-center">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="stay_with_wali" id="stay_with_wali" >
                                            <label class="custom-control-label" for="stay_with_wali">Isi Data Wali</label>
                                        </div>
                                    </div>
                                    <div class="wali row">
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="wali_nik">NIK
                                                    Wali</label>
                                                <input type="text" name="wali_nik" id="wali_nik"
                                                    class="form-control" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="wali_nama">Nama
                                                    Wali</label>
                                                <input type="text" name="wali_nama" id="wali_nama"
                                                    class="form-control" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="wali_pob">Tempat Lahir Wali</label>
                                                <input type="text" name="wali_pob" id="wali_pob"
                                                    class="form-control" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="wali_dob">Tanggal
                                                    Lahir Wali</label>
                                                <input type="text" class="form-control datepicker"
                                                    name="wali_dob" id="wali_dob" autocomplete="off"
                                                    placeholder="1999-09-19">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label"
                                                    for="wali_last_education">Pendidikan Terakhir
                                                    Wali</label>
                                                <input type="text" class="form-control"
                                                    id="wali_last_education" name="wali_last_education"
                                                    autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="wali_job">Pekerjaan
                                                    Wali</label>
                                                <select name="wali_job" id="wali_job" class="form-control">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label"
                                                    for="wali_income">Penghasilan Perbulan Wali</label>
                                                <input type="number" class="form-control" name="wali_income"
                                                    id="wali_income">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label"
                                                    for="wali_languages">Bahasa Dirumah</label>
                                                <input type="text" class="form-control"
                                                    name="wali_languages" id="wali_languages"
                                                    autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label"
                                                    for="wali_citizen">Kewarganegaraan Wali</label>
                                                <input type="text" class="form-control" autocomplete="off"
                                                    name="wali_citizen" id="wali_citizen">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label"
                                                    for="wali_relation">Hubungan Wali Terhadap Santri</label>
                                                <input type="text" class="form-control" autocomplete="off"
                                                    name="wali_relation" id="wali_relation">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group input-group-sm text-right">
                                                <button type="button" class="btn btn-primary"
                                                    id="btnStep2"><i class="fa fa-save"></i> Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
                                                    <tbody id="listsibling">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="border:1px solid black;border-radius:5px;padding:5px;">
                                        <h4 style="text-align:center;font-weight:bold;">Form Tambah Saudara</h4>
                                        <form id="frmSaudara">
                                            {{-- <input type="hidden" name="pid" value="{{ $person->id }}"> --}}
                                            <div class="row card-body">
                                                <div class="col-md-12">
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="saudara_nama">Nama
                                                            Saudara</label>
                                                        <input type="text" class="form-control" name="saudara_nama"
                                                            id="saudara_nama" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label"
                                                            for="saudara_age">Umur</label>
                                                        <input type="number" class="form-control" name="saudara_age"
                                                            id="saudara_age" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="">Jenis
                                                            Kelamin</label>
                                                        <br>
                                                        <input type="radio" name="saudara_sex" id="sasex1" value="L">
                                                        <label for="sasex1">Laki-laki</label>&nbsp;&nbsp;
                                                        <input type="radio" name="saudara_sex" id="sasex2" value="P">
                                                        <label for="sasex2">Perempuan</label>&nbsp;&nbsp;
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="saudara_last_education">Pendidikan</label>
                                                        <input type="text" class="form-control" name="saudara_last_education" id="saudara_last_education" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label"
                                                            for="saudara_job">Pekerjaan</label>
                                                            <select name="saudara_job" id="saudara_job" class="form-control">
                                                            </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 text-right">
                                                    <button type="button" id="btnSimpanSaudara" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tabs-icons-text-3" role="tabpanel"  aria-labelledby="tabs-icons-text-3-tab">
                                <form id="formstep3">
                                    {{-- <input type="hidden" name="pid" value="{{ $person->id }}">
                                    <input type="hidden" name="student_id" value="{{ $student->id }}"> --}}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="phone">Nomor Telephone</label>
                                                <input type="text" class="form-control" id="phone"
                                                    name="phone" placeholder="081234567890" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="email">E-Mail</label>
                                                <input type="email" class="form-control" id="email"
                                                    name="email" placeholder="example@gmail.com">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="height">Tinggi Badan</label>
                                                <input type="number" class="form-control" id="height"
                                                    name="height" placeholder="Tinggi Badan">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="weight">Berat Badan</label>
                                                <input type="number" class="form-control" id="weight"
                                                    name="weight" placeholder="Berat Badan">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label"
                                                    for="blood">Golongan Darah</label>
                                                <input type="text" class="form-control" id="blood"
                                                    name="blood" placeholder="AB" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label"
                                                    for="character">Karakter/Watak</label>
                                                <input type="text" class="form-control" id="character"
                                                    name="character" placeholder="Periang dll" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm" style="margin-top:25px;">
                                                <div class="custom-control custom-checkbox align-middle">
                                                    <input type="checkbox" class="custom-control-input"
                                                        name="is_glasses" id="is_glasses" value="1" >
                                                    <label class="custom-control-label"
                                                        for="is_glasses">Berkacamata</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="hobbies">Hobi</label>
                                                <input type="text" class="form-control" id="hobbies"
                                                    name="hobbies" placeholder="Hobi" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="traumatic">Pernah Mengalami Trauma</label>
                                                <input type="text" class="form-control" id="traumatic"
                                                    name="traumatic" placeholder="Trauma" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="disability">Berkebutuhan Khusus</label>
                                                <select name="disability" id="disability" class="form-control">
                                                    @php
                                                    $arrayr = ['Tidak'=>'Tidak','Ya'=>'Ya'];
                                                    foreach($arrayr as $key=>$val)
                                                    {
                                                        echo '<option
                                                        value="'.$key.'">'.$val.'</option>';
                                                    }
                                                    @endphp
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="received_date">Tanggal Diterima di Sekolah Ini</label>
                                                <input type="text" class="form-control datepicker" id="received_date" name="received_date" placeholder="1999-09-19" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="disability_type">Jenis Berkebutuhan Khusus</label>
                                                <input type="text" class="form-control" id="disability_type"
                                                    name="disability_type" placeholder="Jenis Berkebutuhan Khusus" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group input-group-sm text-right">
                                                <button type="button" class="btn btn-primary"
                                                    id="btnStep3"><i class="fa fa-save"></i> Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3>Prestasi</h3>
                                        <div class="table-responsive">
                                            <div>
                                                <table class="table align-items-center">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th scope="col" class="sort" data-sort="name">
                                                                Nama Prestasi</th>
                                                            <th scope="col" class="sort" data-sort="budget">
                                                                Tahun</th>
                                                            <th scope="col" class="sort" data-sort="status">
                                                                Deskripsi</th>
                                                            <th scope="col"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="listprestasi">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="border:1px solid black;border-radius:5px;padding:5px;">
                                            <h4 style="text-align:center;font-weight:bold;">Form Tambah Prestasi</h4>
                                            <form id="frmPrestasi">
                                                {{-- <input type="hidden" name="pid" value="{{ $person->id }}"> --}}
                                                <div class="row card-body">
                                                    <div class="col-md-6">
                                                        <div class="form-group input-group-sm">
                                                            <label class="form-control-label" for="prestasi_name">Nama Prestasi</label>
                                                            <input type="text" class="form-control" name="prestasi_name"
                                                                id="prestasi_name" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group input-group-sm">
                                                            <label class="form-control-label"
                                                                for="prestasi_year">Tahun</label>
                                                            <input type="number" class="form-control" name="prestasi_year"
                                                                id="prestasi_year" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group input-group-sm">
                                                            <label class="form-control-label" for="prestasi_desc">Keterangan</label>
                                                            <textarea name="prestasi_desc" id="prestasi_desc" rows="2" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 text-right">
                                                        <button type="button" id="btnSimpanPrestasi" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah</button>
                                                    </div>
                                                </div>
                                            </form>
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
                                                            <th scope="col" class="sort" data-sort="name">
                                                                Sakit</th>
                                                            <th scope="col" class="sort" data-sort="budget">
                                                                Tahun</th>
                                                            <th scope="col" class="sort" data-sort="status">
                                                                Deskripsi</th>
                                                            <th scope="col"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="listkesehatan">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="border:1px solid black;border-radius:5px;padding:5px;">
                                            <h4 style="text-align:center;font-weight:bold;">Form Tambah Medical Record</h4>
                                            <form id="frmSakit">
                                                {{-- <input type="hidden" name="pid" value="{{ $person->id }}"> --}}
                                                <div class="row card-body">
                                                    <div class="col-md-6">
                                                        <div class="form-group input-group-sm">
                                                            <label class="form-control-label" for="sakit_name">Sakit</label>
                                                            <input type="text" class="form-control" name="sakit_name"
                                                                id="sakit_name" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group input-group-sm">
                                                            <label class="form-control-label"
                                                                for="sakit_year">Tahun</label>
                                                            <input type="number" class="form-control" name="sakit_year"
                                                                id="sakit_year" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group input-group-sm">
                                                            <label class="form-control-label" for="sakit_desc">Keterangan</label>
                                                            <textarea name="sakit_desc" id="sakit_desc" rows="2" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 text-right">
                                                        <button type="button" id="btnSimpanSakit" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tabs-icons-text-4" role="tabpanel" aria-labelledby="tabs-icons-text-4-tab">
                                <form id="formstep4">
                                    {{-- <input type="hidden" name="pid" value="{{ $person->id }}"> --}}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="building_status">Kepemilikan
                                                    Rumah</label>
                                                <input type="text" name="building_status" id="building_status" class="form-control"
                                                    autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="building_area">Luas Rumah</label>
                                                <input type="number" name="building_area" id="building_area" class="form-control"
                                                    autocomplete="off" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="surface_area">Luas Tanah</label>
                                                <input type="number" name="surface_area" id="surface_area" class="form-control"
                                                    autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="electricity_bills">Tagihan Listrik
                                                    Bulanan</label>
                                                <input type="text" name="electricity_bills" id="electricity_bills" class="form-control"
                                                    autocomplete="off" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="water_bills">Tagihan Air PDAM
                                                    Bulanan</label>
                                                <input type="text" name="water_bills" id="water_bills" class="form-control"
                                                    autocomplete="off" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="telecommunication_bills">Tagihan Telkom
                                                    Bulanan</label>
                                                <input type="text" name="telecommunication_bills" id="telecommunication_bills" class="form-control"
                                                    autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="electronic">Alat Elektronik</label>
                                                <textarea type="text" name="electronic" id="electronic" class="form-control"
                                                    autocomplete="off"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="vehicle">Kendaraan</label>
                                                <textarea type="text" name="vehicle" id="vehicle" class="form-control"
                                                    autocomplete="off"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="assets">Asset</label>
                                                <textarea type="text" name="assets" id="assets" class="form-control"
                                                    autocomplete="off"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group input-group-sm text-right">
                                                <button type="button" class="btn btn-primary" id="btnStep4"><i class="fa fa-save"></i> Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="tabs-icons-text-5" role="tabpanel"
                                aria-labelledby="tabs-icons-text-5-tab">
                                <form action="">
                                <h2>Profil Siswa</h2>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group input-group-xl">
                                            <label class="form-control-label" for="nis">Foto Siswa</label>
                                            <form id="frmUploadfoto">
                                                @php $adafoto=''; @endphp
                                                @if(!empty($files))
                                                    @foreach($files as $key=>$val)
                                                        @if($val['desc']=='Foto Personal')
                                                            <div class="alert alert-light alert-dismissible fade show" role="alert" id="foto_gambar">
                                                                <input type="hidden" id="foto_desc" value="{{ $val['desc'] }}">
                                                                <a href="{{ asset('uploads/'.$val['url']); }}" target="_blank"><img src="{{ asset('uploads/'.$val['url']); }}" alt="Foto Personal" height="200px"></a>
                                                                <button type="button" class="close" aria-label="Close" onclick="hapusfile('foto')">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            @php $adafoto='ada'; @endphp
                                                        @endif
                                                    @endforeach
                                                @endif
                                                @if($adafoto=='')
                                                    {{-- <input type="hidden" id="foto_pid" name="foto_id" value="{{ $person->id }}"> --}}
                                                    <input type="hidden" id="foto_desc" name="foto_id" value="Foto Personal">
                                                    <input type="file" name="foto_file" id="foto_file" class="form-control" autocomplete="off" onchange="upload('foto')">
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group input-group-xl">
                                            <label class="form-control-label" for="nis">Kartu Keluarga</label>
                                            <form id="frmUploadkk">
                                                @php $adakk=''; @endphp
                                                @if(!empty($files))
                                                    @foreach($files as $key=>$val)
                                                        @if($val['desc']=='Kartu Keluarga')
                                                            <div class="alert alert-light alert-dismissible fade show" role="alert" id="kk_gambar">
                                                                <input type="hidden" id="kk_desc" value="{{ $val['desc'] }}">
                                                                <a href="{{ asset('uploads/'.$val['url']); }}" target="_blank"><img src="{{ asset('uploads/'.$val['url']); }}" alt="Kartu Keluarga" height="200px"></a>
                                                                <button type="button" class="close" aria-label="Close" onclick="hapusfile('kk')">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            @php $adakk='ada'; @endphp
                                                        @endif
                                                    @endforeach
                                                @endif
                                                @if($adakk=='')
                                                    {{-- <input type="hidden" id="kk_pid" name="kk_pid" value="{{ $person->id }}"> --}}
                                                    <input type="hidden" id="kk_desc" name="kk_desc" value="Kartu Keluarga">
                                                    <input type="file" name="kk_file" id="kk_file" class="form-control" autocomplete="off" onchange="upload('kk')" width="100%">
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group input-group-xl">
                                            <label class="form-control-label" for="nis">Akta Lahir</label>
                                            <form id="frmUploadal">
                                                @php $adaal=''; @endphp
                                                @if(!empty($files))
                                                    @foreach($files as $key=>$val)
                                                        @if($val['desc']=='Akta Kelahiran')
                                                            <div class="alert alert-light alert-dismissible fade show" role="alert" id="al_gambar">
                                                                <input type="hidden" id="al_desc" value="{{ $val['desc'] }}">
                                                                <a href="{{ asset('uploads/'.$val['url']); }}" target="_blank"><img src="{{ asset('uploads/'.$val['url']); }}" alt="Akta Kelahiran" height="200px"></a>
                                                                <button type="button" class="close" aria-label="Close" onclick="hapusfile('al')">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            @php $adaal='ada'; @endphp
                                                        @endif
                                                    @endforeach
                                                @endif
                                                @if($adaal=='')
                                                    {{-- <input type="hidden" id="al_pid" name="al_pid" value="{{ $person->id }}"> --}}
                                                    <input type="hidden" id="al_desc" name="al_desc" value="Akta Kelahiran">
                                                    <input type="file" name="al_file" id="al_file" class="form-control" autocomplete="off" onchange="upload('al')">
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group input-group-xl">
                                            <label class="form-control-label" for="nis">Scan Ijazah Depan</label>
                                            <form id="frmUploadsid">
                                                @php $adasid=''; @endphp
                                                @if(!empty($files))
                                                    @foreach($files as $key=>$val)
                                                        @if($val['desc']=='Ijazah Depan')
                                                            <div class="alert alert-light alert-dismissible fade show" role="alert" id="sid_gambar">
                                                                <input type="hidden" id="sid_desc" value="{{ $val['desc'] }}">
                                                                <a href="{{ asset('uploads/'.$val['url']); }}" target="_blank"><img src="{{ asset('uploads/'.$val['url']); }}" alt="Ijazah Depan" height="200px"></a>
                                                                <button type="button" class="close" aria-label="Close" onclick="hapusfile('sid')">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            @php $adasid='ada'; @endphp
                                                        @endif
                                                    @endforeach
                                                @endif
                                                @if($adasid=='')
                                                {{-- <input type="hidden" id="sid_pid" name="sid_pid" value="{{ $person->id }}"> --}}
                                                <input type="hidden" id="sid_desc" name="sid_desc" value="Ijazah Depan">
                                                <input type="file" name="sid_file" id="sid_file" class="form-control" autocomplete="off" onchange="upload('sid')">
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group input-group-xl">
                                            <label class="form-control-label" for="nis">Scan Ijazah Belakang</label>
                                            <form id="frmUploadsib">
                                                @php $adasib=''; @endphp
                                                @if(!empty($files))
                                                    @foreach($files as $key=>$val)
                                                        @if($val['desc']=='Ijazah Belakang')
                                                            <div class="alert alert-light alert-dismissible fade show" role="alert" id="sib_gambar">
                                                                <input type="hidden" id="sib_desc" value="{{ $val['desc'] }}">
                                                                <a href="{{ asset('uploads/'.$val['url']); }}" target="_blank"><img src="{{ asset('uploads/'.$val['url']); }}" alt="Ijazah Belakang" height="200px"></a>
                                                                <button type="button" class="close" aria-label="Close" onclick="hapusfile('sib')">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            @php $adasib='ada'; @endphp
                                                        @endif
                                                    @endforeach
                                                @endif
                                                @if($adasib=='')
                                                {{-- <input type="hidden" id="sib_pid" name="sib_pid" value="{{ $person->id }}"> --}}
                                                <input type="hidden" id="sib_desc" name="sib_desc" value="Ijazah Belakang">
                                                <input type="file" name="sib_file" id="sib_file" class="form-control" autocomplete="off" onchange="upload('sib')">
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group input-group-xl">
                                            <label class="form-control-label" for="nis">Scan Surat Keterangan Hasil Ujian (SKHU)</label>
                                            <form id="frmUploadskhu">
                                                @php $adaskhu=''; @endphp
                                                @if(!empty($files))
                                                    @foreach($files as $key=>$val)
                                                        @if($val['desc']=='SKHU')
                                                            <div class="alert alert-light alert-dismissible fade show" role="alert" id="skhu_gambar">
                                                                <input type="hidden" id="skhu_desc" value="{{ $val['desc'] }}">
                                                                <a href="{{ asset('uploads/'.$val['url']); }}" target="_blank"><img src="{{ asset('uploads/'.$val['url']); }}" alt="SKHU" height="200px"></a>
                                                                <button type="button" class="close" aria-label="Close" onclick="hapusfile('skhu')">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            @php $adaskhu='ada'; @endphp
                                                        @endif
                                                    @endforeach
                                                @endif
                                                @if($adaskhu=='')
                                                {{-- <input type="hidden" id="skhu_pid" name="skhu_pid" value="{{ $person->id }}"> --}}
                                                <input type="hidden" id="skhu_desc" name="skhu_desc" value="SKHU">
                                                <input type="file" name="skhu_file" id="skhu_file" class="form-control" autocomplete="off" onchange="upload('skhu')">
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group input-group-xl">
                                            <label class="form-control-label" for="nis">Surat Keterangan
                                                Sehat</label>
                                            <form id="frmUploadks">
                                                @php $adaks=''; @endphp
                                                @if(!empty($files))
                                                    @foreach($files as $key=>$val)
                                                        @if($val['desc']=='Surat Keterangan Sehat')
                                                            <div class="alert alert-light alert-dismissible fade show" role="alert" id="ks_gambar">
                                                                <input type="hidden" id="ks_desc" value="{{ $val['desc'] }}">
                                                                <a href="{{ asset('uploads/'.$val['url']); }}" target="_blank"><img src="{{ asset('uploads/'.$val['url']); }}" alt="Surat Keterangan Sehat" height="200px"></a>
                                                                <button type="button" class="close" aria-label="Close" onclick="hapusfile('ks')">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            @php $adaks='ada'; @endphp
                                                        @endif
                                                    @endforeach
                                                @endif
                                                @if($adaks=='')
                                                {{-- <input type="hidden" id="ks_pid" name="ks_pid" value="{{ $person->id }}"> --}}
                                                <input type="hidden" id="ks_desc" name="ks_desc" value="Surat Keterangan Sehat">
                                                <input type="file" name="ks_file" id="ks_file" class="form-control" autocomplete="off" onchange="upload('ks')">
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group input-group-xl">
                                            <label class="form-control-label" for="nis">Surat Keterangan Baik</label>
                                            <form id="frmUploadkb">
                                                @php $adakb = ''; @endphp
                                                @if(!empty($files))
                                                    @foreach($files as $key=>$val)
                                                        @if($val['desc']=='Surat Keterangan Baik')
                                                            <div class="alert alert-light alert-dismissible fade show" role="alert" id="kb_gambar">
                                                                <input type="hidden" id="kb_desc" value="{{ $val['desc'] }}">
                                                                <a href="{{ asset('uploads/'.$val['url']); }}" target="_blank"><img src="{{ asset('uploads/'.$val['url']); }}" alt="Surat Keterangan Baik" height="200px"></a>
                                                                <button type="button" class="close" aria-label="Close" onclick="hapusfile('kb')">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            @php $adakb = 'ada'; @endphp
                                                        @endif
                                                    @endforeach
                                                @endif
                                                @if($adakb=='')
                                                {{-- <input type="hidden" id="kb_pid" name="kb_pid" value="{{ $person->id }}"> --}}
                                                <input type="hidden" id="kb_desc" name="kb_desc" value="Surat Keterangan Baik">
                                                <input type="file" name="kb_file" id="kb_file" class="form-control" autocomplete="off" onchange="upload('kb')">
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group input-group-xl">
                                            <label class="form-control-label" for="nis">Fakta Integritas</label>
                                            <form id="frmUploadpi">
                                                @php $adapi = ''; @endphp
                                                @if(!empty($files))
                                                    @foreach($files as $key=>$val)
                                                        @if($val['desc']=='Fakta Integritas')
                                                            <div class="alert alert-light alert-dismissible fade show" role="alert" id="pi_gambar">
                                                                <input type="hidden" id="pi_desc" value="{{ $val['desc'] }}">
                                                                <a href="{{ asset('uploads/'.$val['url']); }}" target="_blank"><img src="{{ asset('uploads/'.$val['url']); }}" alt="Fakta Integritas" height="200px"></a>
                                                                <button type="button" class="close" aria-label="Close" onclick="hapusfile('pi')">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            @php $adapi = 'ada'; @endphp
                                                        @endif
                                                    @endforeach
                                                @endif
                                                @if($adapi=='')
                                                {{-- <input type="hidden" id="pi_pid" name="pi_pid" value="{{ $person->id }}"> --}}
                                                <input type="hidden" id="pi_desc" name="pi_desc" value="Fakta Integritas">
                                                <input type="file" name="pi_file" id="pi_file" class="form-control" autocomplete="off" onchange="upload('pi')">
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group input-group-xl">
                                            <label class="form-control-label" for="nis">SKBN (Surat Keterangan Bebas Narkoba)</label>
                                            <form id="frmUploadskbn">
                                                @php $adaskbn = ''; @endphp
                                                @if(!empty($files))
                                                    @foreach($files as $key=>$val)
                                                        @if($val['desc']=='SKBN')
                                                            <div class="alert alert-light alert-dismissible fade show" role="alert" id="skbn_gambar">
                                                                <input type="hidden" id="skbn_desc" value="{{ $val['desc'] }}">
                                                                <a href="{{ asset('uploads/'.$val['url']); }}" target="_blank"><img src="{{ asset('uploads/'.$val['url']); }}" alt="SKBN" height="200px"></a>
                                                                <button type="button" class="close" aria-label="Close" onclick="hapusfile('skbn')">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            @php $adaskbn = 'ada'; @endphp
                                                        @endif
                                                    @endforeach
                                                @endif
                                                @if($adaskbn=='')
                                                {{-- <input type="hidden" id="skbn_pid" name="skbn_pid" value="{{ $person->id }}"> --}}
                                                <input type="hidden" id="skbn_desc" name="skbn_desc" value="SKBN">
                                                <input type="file" name="skbn_file" id="skbn_file" class="form-control" autocomplete="off" onchange="upload('skbn')">
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <h2>Orang Tua</h2>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group input-group-xl">
                                            <label class="form-control-label" for="nis">KTP Ayah</label>
                                            <form id="frmUploadktpa">
                                                @php $adaktpa = ''; @endphp
                                                @if(!empty($files))
                                                    @foreach($files as $key=>$val)
                                                        @if($val['desc']=='KTP Ayah')
                                                            <div class="alert alert-light alert-dismissible fade show" role="alert" id="ktpa_gambar">
                                                                <input type="hidden" id="ktpa_desc" value="{{ $val['desc'] }}">
                                                                <a href="{{ asset('uploads/'.$val['url']); }}" target="_blank"><img src="{{ asset('uploads/'.$val['url']); }}" alt="KTP Ayah" height="200px"></a>
                                                                <button type="button" class="close" aria-label="Close" onclick="hapusfile('ktpa')">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            @php $adaktpa = 'ada'; @endphp
                                                        @endif
                                                    @endforeach
                                                @endif
                                                @if($adaktpa=='')
                                                {{-- <input type="hidden" id="ktpa_pid" name="ktpa_pid" value="{{ $person->id }}"> --}}
                                                <input type="hidden" id="ktpa_desc" name="ktpa_desc" value="KTP Ayah">
                                                <input type="file" name="ktpa_file" id="ktpa_file" class="form-control" autocomplete="off" onchange="upload('ktpa')">
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group input-group-xl">
                                            <label class="form-control-label" for="nis">KTP Ibu</label>
                                            <form id="frmUploadktpi">
                                                @php $adaktpi = ''; @endphp
                                                @if(!empty($files))
                                                    @foreach($files as $key=>$val)
                                                        @if($val['desc']=='KTP Ibu')
                                                            <div class="alert alert-light alert-dismissible fade show" role="alert" id="ktpi_gambar">
                                                                <input type="hidden" id="ktpi_desc" value="{{ $val['desc'] }}">
                                                                <a href="{{ asset('uploads/'.$val['url']); }}" target="_blank"><img src="{{ asset('uploads/'.$val['url']); }}" alt="KTP Ibu" height="200px"></a>
                                                                <button type="button" class="close" aria-label="Close" onclick="hapusfile('ktpi')">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            @php $adaktpi = 'ada'; @endphp
                                                        @endif
                                                    @endforeach
                                                @endif
                                                @if($adaktpi=='')
                                                {{-- <input type="hidden" id="ktpi_pid" name="ktpi_pid" value="{{ $person->id }}"> --}}
                                                <input type="hidden" id="ktpi_desc" name="ktpi_desc" value="KTP Ibu">
                                                <input type="file" name="ktpi_file" id="ktpi_file" class="form-control" autocomplete="off" onchange="upload('ktpi')">
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group input-group-xl">
                                            <label class="form-control-label" for="nis">KTP Wali</label>
                                            <form id="frmUploadktpw">
                                                @php $adaktpw = ''; @endphp
                                                @if(!empty($files))
                                                    @foreach($files as $key=>$val)
                                                        @if($val['desc']=='KTP Wali')
                                                            <div class="alert alert-light alert-dismissible fade show" role="alert" id="ktpw_gambar">
                                                                <input type="hidden" id="ktpw_desc" value="{{ $val['desc'] }}">
                                                                <a href="{{ asset('uploads/'.$val['url']); }}" target="_blank"><img src="{{ asset('uploads/'.$val['url']); }}" alt="KTP Wali" height="200px"></a>
                                                                <button type="button" class="close" aria-label="Close" onclick="hapusfile('ktpw')">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            @php $adaktpw = 'ada'; @endphp
                                                        @endif
                                                    @endforeach
                                                @endif
                                                @if($adaktpw=='')
                                                {{-- <input type="hidden" id="ktpw_pid" name="ktpw_pid" value="{{ $person->id }}"> --}}
                                                <input type="hidden" id="ktpw_desc" name="ktpw_desc" value="KTP Wali">
                                                <input type="file" name="ktpw_file" id="ktpw_file" class="form-control" autocomplete="off" onchange="upload('ktpw')">
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-6">
                                        <div class="form-group input-group-xl">
                                            <label class="form-control-label" for="nis">Foto Rumah</label>
                                            <form id="frmUploadfr">
                                                @php $adafr = ''; @endphp
                                                @if(!empty($files))
                                                    @foreach($files as $key=>$val)
                                                        @if($val['desc']=='Foto Rumah')
                                                            <div class="alert alert-light alert-dismissible fade show" role="alert" id="fr_gambar">
                                                                <input type="hidden" id="fr_desc" value="{{ $val['desc'] }}">
                                                                <a href="{{ asset('uploads/'.$val['url']); }}" target="_blank"><img src="{{ asset('uploads/'.$val['url']); }}" alt="Foto Rumah" height="200px"></a>
                                                                <button type="button" class="close" aria-label="Close" onclick="hapusfile('fr')">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            @php $adafr = 'ada'; @endphp
                                                        @endif
                                                    @endforeach
                                                @endif
                                                @if($adafr=='')
                                                <input type="hidden" id="fr_pid" name="fr_pid" value="{{ $person->id }}">
                                                <input type="hidden" id="fr_desc" name="fr_desc" value="Foto Rumah">
                                                <input type="file" name="fr_file" id="fr_file" class="form-control" autocomplete="off" onchange="upload('fr')">
                                                @endif
                                            </form>
                                        </div>
                                    </div> --}}
                                    {{-- <div class="col-md-6">
                                        <div class="form-group input-group-xl">
                                            <label class="form-control-label" for="nis">Foto Rekening
                                                Listrik</label>
                                            <form id="frmUploadfre">
                                                @php $adafre = ''; @endphp
                                                @if(!empty($files))
                                                    @foreach($files as $key=>$val)
                                                        @if($val['desc']=='Foto Rekening')
                                                            <div class="alert alert-light alert-dismissible fade show" role="alert" id="fre_gambar">
                                                                <input type="hidden" id="fre_desc" value="{{ $val['desc'] }}">
                                                                <a href="{{ asset('uploads/'.$val['url']); }}" target="_blank"><img src="{{ asset('uploads/'.$val['url']); }}" alt="Foto Rekening" height="200px"></a>
                                                                <button type="button" class="close" aria-label="Close" onclick="hapusfile('fre')">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            @php $adafre = 'ada'; @endphp
                                                        @endif
                                                    @endforeach
                                                @endif
                                                @if($adafre=='')
                                                <input type="hidden" id="fre_pid" name="fre_pid" value="{{ $person->id }}">
                                                <input type="hidden" id="fre_desc" name="fre_desc" value="Foto Rekening">
                                                <input type="file" name="fre_file" id="fre_file" class="form-control" autocomplete="off" onchange="upload('fre')">
                                                @endif
                                            </form>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tabs-icons-text-6" role="tabpanel"  aria-labelledby="tabs-icons-text-6-tab">
                                <form id="formstep6">
                                    {{-- <input type="hidden" name="pid" value="{{ $person->id }}"> --}}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="school_origin">Asal Sekolah</label>
                                                <select name="school_origin" id="school_origin" class="form-control">
                                                    @php
                                                    $arrayr = ['SD'=>'SD','MI'=>'MI','PAKET A'=>'PAKET A'];
                                                    foreach($arrayr as $key=>$val)
                                                    {
                                                        echo '<option value="'.$key.'"'.((($origin->school_origin ?? '')==$key)?'selected="selected"':'').'>'.$val.'</option>';
                                                    }
                                                    @endphp
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="school_origin_name">Nama SD/MI/Paket A (jika Paket A sebutkan Nama Sekolah Induk)</label>
                                                <input type="text" class="form-control" id="school_origin_name" name="school_origin_name" placeholder="Nama Sekolah Asal" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="diploma_number">Nomor Ijazah</label>
                                                <input type="text" class="form-control" id="diploma_number" name="diploma_number" placeholder="DN-09/D-SD/99/0119999" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="diploma_year">Tahun Ijazah</label>
                                                <input type="text" class="form-control datepicker" id="diploma_year" name="diploma_year" placeholder="1999-09-19" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="exam_number">Nomor Peserta Ujian SD/MI/Paket A</label>
                                                <input type="text" class="form-control" id="exam_number" name="exam_number" placeholder="99-9999-0099-9" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="skhu">Nomor & Tahun Surat Keterangan Hasil Ujian (SKHU)</label>
                                                <input type="text" class="form-control" id="skhu" name="skhu" placeholder="DN-PA 0099999 Tahun 2019" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="study_year">Lama Belajar (diisi angka dalam tahun)</label>
                                                <div class="input-group input-group-sm">
                                                    <input type="number" class="form-control" id="study_year" name="study_year" >
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">Tahun</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <hr/>
                                            <p>Khusus untuk santri pindahan</p>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="school_origin_tf">Pindahan dari (Nama Sekolah Asal)</label>
                                                <input type="text" class="form-control" id="school_origin_tf" name="school_origin_tf" placeholder="" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="move_date">Tanggal Pindah (pada surat keterangan pindah)</label>
                                                <input type="text" class="form-control datepicker" id="move_date" name="move_date" placeholder="1999-09-19" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="from_class">Dari Kelas (pindahan)</label>
                                                <input type="number" class="form-control" id="from_class" name="from_class" placeholder=""  >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label class="form-control-label" for="in_class">Di Kelas (pindahan)</label>
                                                <input type="number" class="form-control" id="in_class" name="in_class" placeholder=""  >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group input-group-sm text-right">
                                                <button type="button" class="btn btn-primary" id="btnStep6"><i class="fa fa-save"></i> Simpan</button>
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
        @endif
    </div>
    <div id="loadMe" style="display:none;">
        <div class="text-center text-white" role="document">
            <div class="">
                <div class="modal-body text-center">
                    <div class="fa-5x">
                        <i class="fas fa-spinner fa-pulse"></i>
                    </div>
                    <h3>Proses sedang berjalan!</h3>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
{!! RecaptchaV3::initJs() !!}
<script>
    grecaptcha.ready(function() {
        grecaptcha.execute('{{ env('RECAPTCHAV3_SITEKEY') }}', {
                action: 'register'
            }).then(function(token) {
            if (token) {
                document.getElementById('recaptcha').value = token;
            }
        });
    });

    $('#btncari').on('click',function(){
        $(this).attr('disabled')
        nis = $('#nis').val();
        tgl = $('#tgllahir').val();
        gpr = $('#recaptcha').val();
        if(nis!=''&&tgl!='')
        {
            $('#loadMe').show();
            $('#frmCari').trigger('submit');
        }
    })
</script>
@endpush
