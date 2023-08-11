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
                            <li class="breadcrumb-item active" aria-current="page"><a href="#">{{ __('Formulir') }}</a>
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 text-right">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 mb-5 mb-xl-0">
                        <div class="container-fluid d-flex align-items-center">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <h1 class="display-2 ">Ahlan Wasahlan!</h1>
                                    <p class="mt-0 mb-5">
                                        Pilih sekolah dan tahun ajaran yang dituju! Isilah data dasar dibawah, tab
                                        lain seperti Profil Keluarga dan lain-lain akan aktif setelahnya. Isi
                                        selengkap-lengkapnya, lalu jangan lupa <b>Simpan</b>. Sistem akan
                                        mengakumulasi prosesnya. Jika sudah lengkap 100%, Anda akan terima email
                                        kembali. Klik <a href="#konfirmasikelengkapan" style="cursor:pointer;"><span class="badge badge-danger">Konfirmasi Kelengkapan</span></a>, jika sudah lengkap.</p>
                                </div>
                                <div class="col-md-12">
                                    <div class="row form-group">
                                        <label class="col-md-4 col-form-label" for="sekolah">Pilih Sekolah {{--
                                            <spanclass="text-red">*)</span> --}}</label>
                                        <div class="col-md-8">
                                            <select name="sekolah" id="sekolah" class="form-control" required>
                                                @foreach($sekolah as $key => $value)
                                                <option value="{{ $value['id'] }}" {!! (($ppdb->
                                                    school_id==$value['id'])?'selected="selected"':'') !!}>{{
                                                    $value['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row form-group">
                                        <label class="col-md-4 col-form-label" for="tahun_ajar">Pilih Tahun Ajaran
                                            {{-- <spanclass="text-red">*)</span> --}}</label>
                                        <div class="col-md-8">
                                            <select name="tahunajar" id="tahunajar" class="form-control"
                                                onchange="gantitahunajaran()" required>
                                                @foreach($tahunajar as $key => $value)
                                                <option value="{{ $value['id'] }}" {!! (($ppdb->
                                                    academic_year_id==$value['id'])?'selected="selected"':'') !!}>{{
                                                    $value['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="nav-wrapper">
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
                                <li class="nav-item">
                                    <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-4-tab" data-toggle="tab"
                                        href="#tabs-icons-text-4" role="tab" aria-controls="tabs-icons-text-4"
                                        aria-selected="false">Kondisi Ekonomi</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-5-tab" data-toggle="tab"
                                        href="#tabs-icons-text-5" role="tab" aria-controls="tabs-icons-text-5"
                                        aria-selected="false">Upload</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel"
                                        aria-labelledby="tabs-icons-text-1-tab">
                                        <form id="formstep1">
                                            <input type="hidden" name="ppdb_id" value="{{ $ppdb->id }}">
                                            <input type="hidden" name="academic_year_id" class="academic_year_id"
                                                value="{{ $ppdb->academic_year_id }}">
                                            <input type="hidden" name="school_id" class="school_id"
                                                value="{{ $ppdb->school_id }}">
                                            <input type="hidden" name="pid" value="{{ $person->id }}">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="nisn">NISN</label>
                                                        <input type="text" name="nisn" id="nisn"
                                                            class="form-control" autocomplete="off"
                                                            placeholder="Nomor Induk Siswa Nasional"
                                                            value="{{ $ppdb->nisn }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="name">Nama
                                                            Lengkap</label>
                                                        <input type="text" name="name" id="name"
                                                            class="form-control" autocomplete="off"
                                                            placeholder="Nama Lengkap" required
                                                            value="{{ $person->name }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="nickname">Nama
                                                            Panggilan</label>
                                                        <input type="text" name="nickname" id="nickname"
                                                            class="form-control" autocomplete="off"
                                                            placeholder="Nama Panggilan"
                                                            value="{{ $person->nickname }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="name_ar">Nama Lengkap
                                                            Dalam Huruf Arab</label>
                                                        <input type="text" class="form-control arabic"
                                                            name="name_ar" id="name_ar" autocomplete="off" dir="rtl"
                                                            placeholder="بالعربية" required
                                                            value="{{ $person->name_ar }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="nik">NIK di KK</label>
                                                        <input type="text" class="form-control" name="nik" autocomplete="off" required placeholder="NIK yang tertera di KK" value="{{ $person->nik }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="kk">Nomor Kartu Keluarga</label>
                                                        <input type="text" class="form-control" name="kk" autocomplete="off" required placeholder="Nomor Kartu Keluarga" value="{{ $person->kk }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="aktalahir">Nomor Akta Lahir</label>
                                                        <input type="text" class="form-control" name="aktalahir" autocomplete="off" required placeholder="Nomor Akta Lahir" value="{{ $person->aktalahir }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="pob">Tempat
                                                            Lahir</label>
                                                        <input type="text" class="form-control" name="pob"
                                                            autocomplete="off" required placeholder="Tempat Lahir"
                                                            value="{{ $person->pob }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="dob">Tanggal
                                                            Lahir</label>
                                                        <input type="text" class="form-control datepicker"
                                                            name="dob" autocomplete="off" required
                                                            placeholder="1999-09-19" value="{{ $person->dob }}">
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
                                                            value="'.$key.'"'.(($person->sex==$key)?'
                                                            checked="checked"':'').'> <label for="sex'.$i.'"
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
                                                            id="son_order" autocomplete="off"
                                                            value="{{ $person->son_order }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="siblings">Jml Saudara
                                                            Kandung</label>
                                                        <input type="number" class="form-control" name="siblings"
                                                            id="siblings" autocomplete="off"
                                                            value="{{ $person->siblings }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="stepbros">Jml Saudara
                                                            Tiri</label>
                                                        <input type="number" class="form-control" autocomplete="off"
                                                            name="stepbros" id="stepbros"
                                                            value="{{ $person->stepbros }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="adoptives">Jml
                                                            Saudara Angkat</label>
                                                        <input type="number" class="form-control" name="adoptives"
                                                            id="adoptives" autocomplete="off"
                                                            value="{{ $person->adoptives }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label"
                                                            for="citizen">Kewarganegaraan</label>
                                                        <input type="text" class="form-control" autocomplete="off"
                                                            name="citizen" id="citizen"
                                                            value="{{ $person->citizen }}">
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
                                                                value="'.$key.'"'.(($person->religion==$key)?'
                                                                selected="selected"':'').'>'.$val.'</option>';
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
                                                            id="languages" autocomplete="off"
                                                            value="{{ $person->languages }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="alamat">Alamat
                                                            Rumah</label>
                                                        <textarea class="form-control" id="alamat" name="alamat"
                                                            rows="18">{{ $alamat->address }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label"
                                                            for="provinsi">Provinsi</label>
                                                        <select class="form-control" name="provinsi" id="provinsi"
                                                            required>
                                                            <option> - Pilih Salah Satu - </option>
                                                            @foreach ($provinces as $item)
                                                            <option value="{{ $item->id ?? '' }}" {!!
                                                                ($alamat['province']==$item->id) ? '
                                                                selected="selected"' : '' !!}>{{ $item->name ?? ''
                                                                }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="kota">Kota</label>
                                                        <select class="form-control" name="kota" id="kota" required>
                                                            <option> - Pilih Salah Satu - </option>
                                                            @php
                                                            $kota = (count($city)>0) ? $city : array();
                                                            @endphp
                                                            @foreach($kota as $key => $value)
                                                            <option value="{{ $key }}" {!! ($alamat['city']==$key)
                                                                ? 'selected="selected"' : '' !!}>{{ $value }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label"
                                                            for="kecamatan">Kecamatan</label>
                                                        <select class="form-control" name="kecamatan" id="kecamatan"
                                                            required>
                                                            <option> - Pilih Salah Satu - </option>
                                                            @php
                                                            $kec = (count($district)>0) ? $district : array();
                                                            @endphp
                                                            @foreach($kec as $key => $value)
                                                            <option value="{{ $key }}" {!!
                                                                ($alamat['district']==$key) ? 'selected="selected"'
                                                                : '' !!}>{{ $value }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="desa">Desa</label>
                                                        <select class="form-control" name="desa" id="desa" required>
                                                            <option> - Pilih Salah Satu - </option>
                                                            @php
                                                            $desa = (count($village)>0) ? $village : array();
                                                            @endphp
                                                            @foreach($desa as $key => $value)
                                                            <option value="{{ $key }}" {!!
                                                                ($alamat['village']==$key) ? 'selected="selected"'
                                                                : '' !!}>{{ $value }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="post">Kode
                                                            POS</label>
                                                        <input type="text" class="form-control" name="post"
                                                            id="post" autocomplete="off"
                                                            value="{{ $alamat->post_code }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group input-group-sm text-right">
                                                        <button type="button" class="btn btn-secondary"><i
                                                                class="fa fa-undo"></i> Kembali</button>
                                                        <button type="button" class="btn btn-primary"
                                                            id="btnStep1"><i class="fa fa-save"></i> Simpan</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel"
                                        aria-labelledby="tabs-icons-text-2-tab">
                                        <form id="formstep2">
                                            <input type="hidden" name="ppdb_id" value="{{ $ppdb->id }}">
                                            <input type="hidden" name="academic_year_id" class="academic_year_id"
                                                value="{{ $ppdb->academic_year_id }}">
                                            <input type="hidden" name="school_id" class="school_id"
                                                value="{{ $ppdb->school_id }}">
                                            <input type="hidden" name="pid" value="{{ $person->id }}">
                                            <div class="row">
                                                <div class="col-md-12 p-3 text-center">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input"
                                                            name="stay_with_parent" id="stay_with_parent" value="1"
                                                            {{ ($person->stay_with_parent=='1') ?
                                                        'checked="checked"' : '' }}>
                                                        <label class="custom-control-label"
                                                            for="stay_with_parent">Tinggal dengan Orang tua</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="ayah_nama">Nama
                                                            Ayah</label>
                                                        <input type="text" name="ayah_nama" id="ayah_nama"
                                                            class="form-control" autocomplete="off" required
                                                            value="{{ ($person->ayah_id!='0'&&$person->ayah_id!='') ? $ayah->name : '' }}">
                                                    </div>
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="ayah_age">Umur
                                                            Ayah</label>
                                                        <input type="number" class="form-control" id="ayah_age"
                                                            name="ayah_age" autocomplete="off" required
                                                            value="{{ ($person->ayah_id!='0'&&$person->ayah_id!='') ? $ayah->age : '' }}">
                                                    </div>
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label"
                                                            for="ayah_last_education">Pendidikan Terakhir
                                                            Ayah</label>
                                                        <input type="text" class="form-control"
                                                            id="ayah_last_education" name="ayah_last_education"
                                                            autocomplete="off" required
                                                            value="{{ ($person->ayah_id!='0'&&$person->ayah_id!='') ? $ayah->last_education : '' }}">
                                                    </div>
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="ayah_job">Pekerjaan
                                                            Ayah</label>
                                                        <select name="ayah_job" id="ayah_job" class="form-control">
                                                            @php
                                                            foreach($jobs as $key=>$val)
                                                            {
                                                            $ayahjob = '';
                                                            if($person->ayah_id!='0'&&$person->ayah_id!='')
                                                            {
                                                            $ayahjob = $ayah->job;
                                                            }
                                                            echo '<option
                                                                value="'.$val->id.'"'.(($val->id==$ayahjob)?'
                                                                selected="selected"':'').'>'.$val->name.'</option>';
                                                            }
                                                            @endphp
                                                        </select>
                                                    </div>
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label"
                                                            for="ayah_income">Penghasilan Perbulan Ayah</label>
                                                        <input type="number" class="form-control" name="ayah_income"
                                                            id="ayah_income" required
                                                            value="{{ ($person->ayah_id!='0'&&$person->ayah_id!='') ? $ayah->income : '' }}">
                                                    </div>
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label"
                                                            for="ayah_languages">Bahasa Dirumah</label>
                                                        <input type="text" class="form-control"
                                                            name="ayah_languages" id="ayah_languages"
                                                            autocomplete="off"
                                                            value="{{ ($person->ayah_id!='0'&&$person->ayah_id!='') ? $ayah->languages : 'Bahasa Indonesia' }}">
                                                    </div>
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label"
                                                            for="ayah_citizen">Kewarganegaraan Ayah</label>
                                                        <input type="text" class="form-control" autocomplete="off"
                                                            name="ayah_citizen" id="ayah_citizen"
                                                            value="{{ ($person->ayah_id!='0'&&$person->ayah_id!='') ? $ayah->citizen : 'WNI' }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="ibu_nama">Nama
                                                            Ibu</label>
                                                        <input type="text" name="ibu_nama" id="ibu_nama"
                                                            class="form-control" autocomplete="off" required
                                                            value="{{ ($person->ibu_id!='0'&&$person->ibu_id!='') ? $ibu->name : '' }}">
                                                    </div>
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="ibu_age">Umur
                                                            Ibu</label>
                                                        <input type="number" class="form-control" name="ibu_age"
                                                            id="ibu_age" autocomplete="off" required
                                                            value="{{ ($person->ibu_id!='0'&&$person->ibu_id!='') ? $ibu->age : '' }}">
                                                    </div>
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label"
                                                            for="ibu_last_education">Pendidikan Terakhir Ibu</label>
                                                        <input type="text" class="form-control"
                                                            id="ibu_last_education" name="ibu_last_education"
                                                            autocomplete="off" required
                                                            value="{{ ($person->ibu_id!='0'&&$person->ibu_id!='') ? $ibu->last_education : '' }}">
                                                    </div>
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="ibu_job">Pekerjaan
                                                            Ibu</label>
                                                        <select name="ibu_job" id="ibu_job" class="form-control">
                                                            @php
                                                            foreach($jobs as $key=>$val)
                                                            {
                                                            $ibujob = '';
                                                            if($person->ibu_id!='0'&&$person->ibu_id!='')
                                                            {
                                                            $ibujob = $ibu->job;
                                                            }
                                                            echo '<option
                                                                value="'.$val->id.'"'.(($val->id==$ibujob)?'
                                                                selected="selected"':'').'>'.$val->name.'</option>';
                                                            }
                                                            @endphp
                                                        </select>
                                                    </div>
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label"
                                                            for="ibu_income">Penghasilan Perbulan Ibu</label>
                                                        <input type="text" class="form-control" id="ibu_income"
                                                            name="ibu_income" required
                                                            value="{{ ($person->ibu_id!='0'&&$person->ibu_id!='') ? $ibu->income : '' }}">
                                                    </div>
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="ibu_languages">Bahasa
                                                            Dirumah</label>
                                                        <input type="text" class="form-control" name="ibu_languages"
                                                            id="ibu_languages" autocomplete="off"
                                                            value="{{ ($person->ibu_id!='0'&&$person->ibu_id!='') ? $ibu->languages : 'Bahasa Indonesia' }}">
                                                    </div>
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label"
                                                            for="ibu_citizen">Kewarganegaraan Ibu</label>
                                                        <input type="text" class="form-control" autocomplete="off"
                                                            name="ibu_citizen" id="ibu_citizen"
                                                            value="{{ ($person->ibu_id!='0'&&$person->ibu_id!='') ? $ibu->citizen : 'WNI' }}">
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
                                                            rows="18">{{ (!empty($alamat_ayah)) ? $alamat_ayah->address : '' }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label"
                                                            for="ayah_provinsi">Provinsi</label>
                                                        <select class="form-control" name="ayah_provinsi"
                                                            id="ayah_provinsi" required>
                                                            <option> - Pilih Salah Satu - </option>
                                                            @foreach ($provinces as $item)
                                                            <option value="{{ $item->id ?? '' }}">{{ $item->name ??
                                                                '' }}</option>
                                                            @endforeach
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
                                                    <input type="hidden" name="pid" value="{{ $person->id }}">
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
                                                                        @php
                                                                        foreach($jobs as $key=>$val)
                                                                        {
                                                                            echo '<option value="'.$val->id.'">'.$val->name.'</option>';
                                                                        }
                                                                        @endphp
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
                                    <div class="tab-pane fade" id="tabs-icons-text-3" role="tabpanel"
                                        aria-labelledby="tabs-icons-text-3-tab">
                                        <form id="formstep3">
                                            <input type="hidden" name="ppdb_id" value="{{ $ppdb->id }}">
                                            <input type="hidden" name="academic_year_id" class="academic_year_id"
                                                value="{{ $ppdb->academic_year_id }}">
                                            <input type="hidden" name="school_id" class="school_id"
                                                value="{{ $ppdb->school_id }}">
                                            <input type="hidden" name="pid" value="{{ $person->id }}">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="height">Tinggi
                                                            Badan</label>
                                                        <input type="number" class="form-control" id="height"
                                                            name="height" placeholder="Tinggi Badan" value="{{ $person->height }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="weight">Berat
                                                            Badan</label>
                                                        <input type="number" class="form-control" id="weight"
                                                            name="weight" placeholder="Berat Badan" value="{{ $person->weight }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group" style="margin-top:25px;">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input"
                                                                name="is_glasses" id="is_glasses" value="1" {{ ($person->is_glasses=='1')?'checked="checked"':'' }}>
                                                            <label class="custom-control-label"
                                                                for="is_glasses">Berkacamata</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-control-label"
                                                            for="character">Karakter/Watak</label>
                                                        <input type="text" class="form-control" id="character"
                                                            name="character" placeholder="Periang dll" value="{{ $person->character }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="hobbies">Hobi</label>
                                                        <input type="text" class="form-control" id="hobbies"
                                                            name="hobbies" placeholder="Hobi" value="{{ $person->hobbies }}">
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
                                                        <input type="hidden" name="pid" value="{{ $person->id }}">
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
                                                                <div class="form-group">
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
                                                                        Nama Prestasi</th>
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
                                                        <input type="hidden" name="pid" value="{{ $person->id }}">
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
                                                                <div class="form-group">
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
                                    <div class="tab-pane fade" id="tabs-icons-text-4" role="tabpanel"
                                        aria-labelledby="tabs-icons-text-4-tab">
                                        <form id="formstep4">
                                            <input type="hidden" name="ppdb_id" value="{{ $ppdb->id }}">
                                            <input type="hidden" name="academic_year_id" class="academic_year_id"
                                                value="{{ $ppdb->academic_year_id }}">
                                            <input type="hidden" name="school_id" class="school_id"
                                                value="{{ $ppdb->school_id }}">
                                            <input type="hidden" name="pid" value="{{ $person->id }}">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="building_status">Kepemilikan
                                                            Rumah</label>
                                                        <input type="text" name="building_status" id="building_status" class="form-control"
                                                            autocomplete="off" value="{{ ($person->ayah_id!=''&&$person->ayah_id!='0') ? $ayah->building_status : ''}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="building_area">Luas Rumah</label>
                                                        <input type="number" name="building_area" id="building_area" class="form-control"
                                                            autocomplete="off" value="{{ ($person->ayah_id!=''&&$person->ayah_id!='0') ? $ayah->building_area : '' }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="surface_area">Luas Tanah</label>
                                                        <input type="number" name="surface_area" id="surface_area" class="form-control"
                                                            autocomplete="off" value="{{ ($person->ayah_id!=''&&$person->ayah_id!='0') ? $ayah->surface_area : '' }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="electricity_bills">Tagihan Listrik
                                                            Bulanan</label>
                                                        <input type="text" name="electricity_bills" id="electricity_bills" class="form-control"
                                                            autocomplete="off" value="{{ ($person->ayah_id!=''&&$person->ayah_id!='0') ? $ayah->electricity_bills : '' }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="water_bills">Tagihan Air PDAM
                                                            Bulanan</label>
                                                        <input type="text" name="water_bills" id="water_bills" class="form-control"
                                                            autocomplete="off" value="{{ ($person->ayah_id!=''&&$person->ayah_id!='0') ? $ayah->water_bills : '' }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group input-group-sm">
                                                        <label class="form-control-label" for="telecommunication_bills">Tagihan Telkom
                                                            Bulanan</label>
                                                        <input type="text" name="telecommunication_bills" id="telecommunication_bills" class="form-control"
                                                            autocomplete="off" value="{{ ($person->ayah_id!=''&&$person->ayah_id!='0') ? $ayah->telecommunication_bills : '' }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="electronic">Alat Elektronik</label>
                                                        <textarea type="text" name="electronic" id="electronic" class="form-control"
                                                            autocomplete="off">{{ ($person->ayah_id!=''&&$person->ayah_id!='0') ? $ayah->electronic : '' }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="vehicle">Kendaraan</label>
                                                        <textarea type="text" name="vehicle" id="vehicle" class="form-control"
                                                            autocomplete="off">{{ ($person->ayah_id!=''&&$person->ayah_id!='0') ? $ayah->vehicle : '' }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="assets">Asset</label>
                                                        <textarea type="text" name="assets" id="assets" class="form-control"
                                                            autocomplete="off">{{ ($person->ayah_id!=''&&$person->ayah_id!='0') ? $ayah->assets : '' }}</textarea>
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
                                        <h2>Profil Siswa</h2>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
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
                                                        <input type="hidden" id="foto_pid" name="foto_id" value="{{ $person->id }}">
                                                        <input type="hidden" id="foto_desc" name="foto_id" value="Foto Personal">
                                                        <input type="file" name="foto_file" id="foto_file" class="form-control" autocomplete="off" onchange="upload('foto')">
                                                        @endif
                                                    </form>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-control-label" for="nis">Kartu
                                                        Keluarga</label>
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
                                                            <input type="hidden" id="kk_pid" name="kk_pid" value="{{ $person->id }}">
                                                            <input type="hidden" id="kk_desc" name="kk_desc" value="Kartu Keluarga">
                                                            <input type="file" name="kk_file" id="kk_file" class="form-control" autocomplete="off" onchange="upload('kk')">
                                                        @endif
                                                    </form>
                                                </div>
                                                <div class="form-group">
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
                                                                    @php $adaal=''; @endphp
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                        @if($adaal=='')
                                                        <input type="hidden" id="al_pid" name="al_pid" value="{{ $person->id }}">
                                                        <input type="hidden" id="al_desc" name="al_desc" value="Akta Kelahiran">
                                                        <input type="file" name="al_file" id="al_file" class="form-control" autocomplete="off" onchange="upload('al')">
                                                        @endif
                                                    </form>
                                                </div>
                                                <div class="form-group">
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
                                                        <input type="hidden" id="ks_pid" name="ks_pid" value="{{ $person->id }}">
                                                        <input type="hidden" id="ks_desc" name="ks_desc" value="Surat Keterangan Sehat">
                                                        <input type="file" name="ks_file" id="ks_file" class="form-control" autocomplete="off" onchange="upload('ks')">
                                                        @endif
                                                    </form>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-control-label" for="nis">Surat Keterangan
                                                        Baik</label>
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
                                                        <input type="hidden" id="kb_pid" name="kb_pid" value="{{ $person->id }}">
                                                        <input type="hidden" id="kb_desc" name="kb_desc" value="Surat Keterangan Baik">
                                                        <input type="file" name="kb_file" id="kb_file" class="form-control" autocomplete="off" onchange="upload('kb')">
                                                        @endif
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <h2>Orang Tua</h2>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
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
                                                <div class="form-group">
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
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12" id="konfirmasikelengkapan">
                                                <a href="{{ url('ppdb/'.$person->id.'/pembayaran') }}" class="btn btn-block bg-maroon text-white"> Konfirmasi kelengkapan</a>
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
<script src="{{ asset('argon/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    loadTableSaudara();
    loadTablePrestasi();
    loadTableKesehatan();
    {{ ($person->stay_with_parent=='1') ? 'enabledalamat(true);' : '' }}
    $('#stay_with_parent').on('change', function() {
        if ($(this).prop('checked') == true) {
            enabledalamat(true);
        } else {
            enabledalamat(false);
        }
    })
    function enabledalamat(tipe)
    {
        if(tipe==true)
        {
            $(".ortu input").each(function() {
                $(this).attr('disabled', 'disabled');
            });
            $('.ortu select').each(function() {
                $(this).attr('disabled', 'disabled');
            });
            $('.ortu textarea').each(function() {
                $(this).attr('disabled', 'disabled');
            });
        }
        else
        {
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
    }
    $('.datepicker').datepicker({
        'setDate': new Date(),
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayHighlight: true,
        zIndexOffset: 999
    });

    function gantitahunajaran() {
    // $('#tahunajar').
    }
    $('#btnStep1').click(function(e) {
        $('#formstep1').submit();
    });
    $('#formstep1').on('submit',function(e) {
        e.preventDefault();
        forms = $(this).serialize();
        $.post('{{ route('ppdb.update',['step'=>1]) }}',{"_token": "{{ csrf_token() }}","data":forms},function(datas){
            if(datas=='Berhasil'){
                msgSukses('Profil Santri/Calon Santri berhasil disimpan!');
            }
            else{
                msgError(datas);
            }
        })
    });
    $('#btnStep2').click(function(e) {
        $('#formstep2').submit();
    });
    $('#formstep2').submit(function(e) {
        e.preventDefault();
        forms = $(this).serialize();
        $.post('{{ route('ppdb.update',['step'=>2]) }}',{"_token": "{{ csrf_token() }}","data":forms},function(datas){
            if(datas=='Berhasil'){
                msgSukses('Data keluarga berhasil disimpan!');
            }
            else{
                msgError(datas);
            }
        });
    });
    $('#btnStep3').click(function(e){
        $('#formstep3').submit();
    });
    $('#formstep3').submit(function(e){
        e.preventDefault();
        forms = $(this).serialize();
        $.post('{{ route('ppdb.update',['step'=>4]) }}',{"_token": "{{ csrf_token() }}","data":forms},function(datas){
            if(datas=='Berhasil'){
                msgSukses('Data lainnya berhasil disimpan!');
            }
            else{
                msgError(datas);
            }
        });
    });
    $('#btnStep4').click(function(e){
        $('#formstep4').submit();
    });
    $('#formstep4').submit(function(e){
        e.preventDefault();
        forms = $(this).serialize();
        $.post('{{ route('ppdb.update',['step'=>7]) }}',{"_token": "{{ csrf_token() }}","data":forms},function(datas){
            if(datas=='Berhasil'){
                msgSukses('Data ekonomi berhasil disimpan!');
            }
            else{
                msgError(datas);
            }
        });
    });

    $('#btnSimpanSaudara').click(function(e){
        $('#frmSaudara').submit();
    });
    $('#frmSaudara').submit(function(e){
        e.preventDefault();
        forms = $(this).serialize();
        $.post('{{ route('ppdb.update',['step'=>3]) }}',{"_token": "{{ csrf_token() }}","data":forms},function(datas){
            if(datas=='Berhasil'){
                msgSukses('Data saudara berhasil disimpan!');
                loadTableSaudara();
            }
            else{
                msgError(datas);
            }
        });
    });
    $('#btnSimpanPrestasi').click(function(e){
        name = $('#prestasi_name').val();
        year = $('#prestasi_year').val();
        if(name!=''&&year!='')
        {
            $('#frmPrestasi').submit();
        }
        else
        {
            alert('Lengkapi form prestasi!');
        }
    });
    $('#frmPrestasi').submit(function(e){
        e.preventDefault();
        forms = $(this).serialize();
        $.post('{{ route('ppdb.update',['step'=>5]) }}',{"_token": "{{ csrf_token() }}","data":forms},function(datas){
            if(datas=='Berhasil'){
                msgSukses('Data prestasi berhasil disimpan!');
                loadTablePrestasi();
            }
            else{
                msgError(datas);
            }
        });
    });
    $('#btnSimpanSakit').click(function(e){
        name = $('#sakit_name').val();
        year = $('#sakit_year').val();
        if(name!=''&&year!='')
        {
            $('#frmSakit').submit();
        }
        else
        {
            alert('Lengkapi form sakit yang pernah diderita!');
        }
    });
    $('#frmSakit').submit(function(e){
        e.preventDefault();
        forms = $(this).serialize();
        $.post('{{ route('ppdb.update',['step'=>6]) }}',{"_token": "{{ csrf_token() }}","data":forms},function(datas){
            if(datas=='Berhasil'){
                msgSukses('Data medis sakit berhasil disimpan!');
                loadTableKesehatan();
            }
            else{
                msgError(datas);
            }
        });
    });
    function loadTableSaudara()
    {
        $.post('{{ route('ppdb.getdata','sibling') }}',{"_token": "{{ csrf_token() }}",'pid':'{{ $person->id }}'},function(data){
            $('#listsibling').html(data);
        });
    }
    function loadTablePrestasi()
    {
        $.post('{{ route('ppdb.getdata','achievement') }}',{"_token": "{{ csrf_token() }}",'pid':'{{ $person->id }}'},function(data){
            $('#listprestasi').html(data);
        });
    }
    function loadTableKesehatan()
    {
        $.post('{{ route('ppdb.getdata','medicalrecord') }}',{"_token": "{{ csrf_token() }}",'pid':'{{ $person->id }}'},function(data){
            $('#listkesehatan').html(data);
        });
    }
    function hapussibling(idsibling)
    {
        if(confirm('Yakin dihapus?'))
        {
            $.get('{{ url('ppdb') }}/'+idsibling+'/hapus/sibling',function(data){
                if(data=='Berhasil')
                {
                    msgSukses('Saudara berhasil dihapus!');
                }
                else
                {
                    msgError(data);
                }
                loadTableSaudara();
            });
        }
    }
    function hapusprestasi(idprestasi)
    {
        if(confirm('Yakin dihapus?'))
        {
            $.get('{{ url('ppdb') }}/'+idprestasi+'/hapus/prestasi',function(data){
                if(data=='Berhasil')
                {
                    msgSukses('Prestasi berhasil dihapus!');
                }
                else
                {
                    msgError(data);
                }
                loadTablePrestasi();
            });
        }
    }
    function hapussakit(idsakit)
    {
        if(confirm('Yakin dihapus?'))
        {
            $.get('{{ url('ppdb') }}/'+idsakit+'/hapus/sakit',function(data){
                if(data=='Berhasil')
                {
                    msgSukses('Medis berhasil dihapus!');
                }
                else
                {
                    msgError(data);
                }
                loadTableKesehatan();
            });
        }
    }
    $('#btnTambahElektronik').click(function(){
        $('#elektronik').append('')
    });
    function hapusfile(tipe)
    {
        desc = $('#'+tipe+'_desc').val();
        if(confirm('Yakin akan hapus '+desc+'?'))
        {
            $.get('{{ url('ppdb') }}/{{ $person->id }}/hapusfile/'+desc,function(data){
                if(data=='Berhasil')
                {
                    $('#'+tipe+'_gambar').alert('close');
                    text = '<input type="hidden" id="'+tipe+'_pid" name="'+tipe+'_pid" value="{{ $person->id }}"><input type="hidden" id="'+tipe+'_desc" name="'+tipe+'_desc" value="'+desc+'"><input type="file" name="'+tipe+'_file" id="'+tipe+'_file" class="form-control" autocomplete="off" onchange="upload('+"'"+tipe+"'"+')">';
                    $('#frmUpload'+tipe).html(text);
                    msgSukses(desc+' berhasil dihapus!');
                }
                else
                {
                    msgError(data);
                }
            });
        }
    }
    function upload(tipe)
    {
        var file_data = $('#'+tipe+'_file').prop('files')[0];
        var file_desc = $('#'+tipe+'_desc').val();
        var form_data = new FormData();
        form_data.append('file', file_data);
        form_data.append('pid',$('#'+tipe+'_pid').val());
        form_data.append('desc',file_desc);
        form_data.append("_token","{{ csrf_token() }}");
        $.ajax({
            url: '{{ route('upload') }}', // <-- point to server-side PHP script
            dataType: 'text',  // <-- what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(data){
                datas = data.split('|');
                if(datas[0]=='Berhasil')
                {
                    if(datas[1]=='jpg'||datas[1]=='gif'||datas[1]=='png'||datas[1]=='jpeg')
                    {
                        text = '<div class="alert alert-light alert-dismissible fade show" role="alert" id="foto_gambar"><input type="hidden" id="foto_desc" value="{{ $val['desc'] }}"><a href="{{ url('/') }}/'+datas[2]+'" target="_blank"><img src="{{ url('/') }}/'+datas[2]+'" alt="Foto Personal" height="200px"></a><button type="button" class="close" aria-label="Close" onclick="hapusfile('+"'"+tipe+"'"+')"><span aria-hidden="true">&times;</span></button></div>';
                        $('#frmUpload'+tipe).html(text);
                    }
                    msgSukses(file_desc+' berhasil diupload');
                }
                else
                {
                    msgError(data);
                }
            }
        });
    }
</script>
@endpush
