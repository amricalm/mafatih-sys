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
                            <li class="breadcrumb-item active" aria-current="page"><a href="#">Halaman Pendaftaran</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 text-right">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 pt-3 pb-3 card card-profile shadow">
                <div class="list-group" id="list-tab" role="tablist">
                    <a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">Form Pendaftaran</a>
                    <a class="list-group-item list-group-item-action disabled" id="list-profile-list" data-toggle="list" href="#" role="tab" aria-controls="profile" disabled="disabled">Jadwal</a>
                    <a class="list-group-item list-group-item-action disabled" id="list-messages-list" data-toggle="list" href="#" role="tab" aria-controls="messages" aria-disabled="true">Ujian</a>
                    {{-- <a class="list-group-item list-group-item-action disabled" id="list-settings-list" data-toggle="list" href="#" role="tab" aria-controls="settings" aria-disabled="true">Kotak Pesan</a> --}}
                </div>
            </div>
            <div class="col-xl-8 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                                    <form action="{{ route('ppdb.simpan') }}" method="POST" autocomplete="off">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row form-group">
                                                    <label class="col-md-4 col-form-label" for="sekolah">Pilih Sekolah</label>
                                                    <div class="col-md-8">
                                                        <select name="sekolah" id="sekolah" class="form-control">
                                                            @foreach($sekolah as $key => $value)
                                                            <option value="{{ $value['institution_id'] }}">{{ $value['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row form-group">
                                                    <label class="col-md-4 col-form-label" for="tahun_ajar">Pilih Tahun Ajaran</label>
                                                    <div class="col-md-8">
                                                        <select name="tahunajar" id="tahunajar" class="form-control">
                                                            @foreach($tahunajar as $key => $value)
                                                            <option value="{{ $value['id'] }}">{{ $value['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <h6 class="heading-small text-muted mb-4">{{ __('Formulir Pendaftaran') }}</h6>
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link active" id="tab01-tab" data-toggle="tab" href="#tab01" type="button" role="tab" aria-controls="tab01" aria-selected="true">[1]</a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="tab02-tab" data-toggle="tab" href="#tab02" type="button" role="tab" aria-controls="tab02" aria-selected="false">[2]</a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="tab03-tab" data-toggle="tab" href="#tab03" type="button" role="tab" aria-controls="tab03" aria-selected="false">[3]</a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="upload-tab" data-toggle="tab" href="#upload" type="button" role="tab" aria-controls="upload" aria-selected="false">Upload</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active" id="tab01" role="tabpanel" aria-labelledby="tab01-tab">
                                                @csrf
                                                <div class="row mt-3">
                                                    <div class="col-md-12">
                                                        <div class="form-group input-group-sm">
                                                            <label class="form-control-label" for="nisn">NISN</label>
                                                            <input type="text" name="nisn" id="nisn" class="form-control" autocomplete="off" value="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group input-group-sm">
                                                            <label class="form-control-label" for="name">Nama Lengkap</label>
                                                            <input type="text" name="name" id="name" class="form-control" autocomplete="off" required value="{{ $person['name'] }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group input-group-sm">
                                                            <label class="form-control-label" for="nickname">Nama Panggilan</label>
                                                            <input type="text" name="nickname" id="nickname" class="form-control" autocomplete="off" value="{{ $person['nickname'] }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group input-group-sm">
                                                            <label class="form-control-label" for="name_ar">Nama Lengkap Dalam Huruf Arab</label>
                                                            <input type="text" class="form-control arabic" name="name_ar" id="name_ar" autocomplete="off" dir="rtl" required value="{{ $person['name_ar'] }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group input-group-sm">
                                                            <label class="form-control-label" for="pob">Tempat Lahir</label>
                                                            <input type="text" class="form-control" name="pob" autocomplete="off" required value="{{ $person['pob'] }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group input-group-sm">
                                                            <label class="form-control-label" for="dob">Tanggal Lahir</label>
                                                            <input type="text" class="form-control datepicker" name="dob" autocomplete="off" required value="{{ $person['dob'] }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group input-group-sm">
                                                            <label class="form-control-label" for="">Jenis Kelamin</label>
                                                            <br>
                                                            @php
                                                            $array = ['L'=>'Laki-laki','P'=>'Perempuan'];
                                                            $i = 0;
                                                            foreach($array as $key=>$val) {
                                                            $i++;
                                                            $selected = ($person['sex']==$key) ? 'selected="selected"' : '';
                                                            echo '<input type="radio" name="sex" id="sex'.$i.'" value="'.$key.'" '.$selected.'> <label for="sex'.$i.'">'.$val.'</label>&nbsp;&nbsp;';
                                                            }
                                                            @endphp
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group input-group-sm">
                                                            <label class="form-control-label" for="son_order">Anak ke-</label>
                                                            <input type="text" class="form-control" name="son_order" id="son_order" autocomplete="off" required value="{{ $person['son_order'] }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group input-group-sm">
                                                            <label class="form-control-label" for="siblings">Jml Saudara Kandung</label>
                                                            <input type="text" class="form-control" name="siblings" id="siblings" autocomplete="off" value="{{ $person['siblings'] }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group input-group-sm">
                                                            <label class="form-control-label" for="stepbros">Jml Saudara Tiri</label>
                                                            <input type="text" class="form-control" autocomplete="off" name="stepbros" id="stepbros" value="{{ $person['stepbros'] }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group input-group-sm">
                                                            <label class="form-control-label" for="adoptives">Jml Saudara Angkat</label>
                                                            <input type="text" class="form-control" name="adoptives" id="adoptives" autocomplete="off" value="{{ $person['adoptives'] }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group input-group-sm">
                                                            <label class="form-control-label" for="citizen">Kewarganegaraan</label>
                                                            <input type="text" class="form-control" autocomplete="off" name="citizen" id="citizen" value="{{ $person['citizen'] }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group input-group-sm">
                                                            <label class="form-control-label" for="religion">Agama</label>
                                                            <select name="religion" id="religion" class="form-control">
                                                                @php
                                                                $arrayr = ['islam'=>'Islam','lainnya'=>'lainnya'];
                                                                foreach($arrayr as $key=>$val)
                                                                {
                                                                $selected = ($person['religion']==$key) ? 'selected="selected"' : '';
                                                                echo '<option value="'.$key.'" '.$selected.'>'.$val.'</option>';
                                                                }
                                                                @endphp
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group input-group-sm">
                                                            <label class="form-control-label" for="languages">Bahasa Dirumah</label>
                                                            <input type="text" class="form-control" name="languages" id="languages" autocomplete="off" value="{{ $person['languages'] }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-control-label" for="address">Alamat Rumah</label>
                                                            <textarea class="form-control" id="alamat" name="alamat" rows="18">{{ $alamat->address }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group input-group-sm">
                                                            <label class="form-control-label" for="provinsi">Provinsi</label>
                                                            <select class="form-control" name="provinsi" id="provinsi" required>
                                                                <option> - Pilih Salah Satu - </option>
                                                                @foreach ($provinces as $item)
                                                                @php $selected = ($alamat->province == $item->id) ? 'selected="selected"' : ''; @endphp
                                                                <option value="{{ $item->id ?? '' }}" {{ $selected }}>{{ $item->name ?? '' }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group input-group-sm">
                                                            <label class="form-control-label" for="kota">Kota</label>
                                                            <select class="form-control" name="kota" id="kota" required>
                                                                <option> - Pilih Salah Satu - </option>
                                                                @foreach($city as $key => $value)
                                                                <option value="{{ $key }}" {!! ($key==$alamat->city) ? 'selected="selected"' : '' !!}>{{ $value }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group input-group-sm">
                                                            <label class="form-control-label" for="kecamatan">Kecamatan</label>
                                                            <select class="form-control" name="kecamatan" id="kecamatan" required>
                                                                <option> - Pilih Salah Satu - </option>
                                                                @foreach($district as $key => $value)
                                                                <option value="{{ $key }}" {!! ($key==$alamat->district) ? 'selected="selected"' : '' !!}>{{ $value }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group input-group-sm">
                                                            <label class="form-control-label" for="desa">Desa</label>
                                                            <select class="form-control" name="desa" id="desa" required>
                                                                <option> - Pilih Salah Satu - </option>
                                                                @foreach($village as $key => $value)
                                                                <option value="{{ $key }}" {!! ($key==$alamat->village) ? 'selected="selected"' : '' !!}>{{ $value }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group input-group-sm">
                                                            <label class="form-control-label" for="post">Kode POS</label>
                                                            <input type="text" class="form-control" name="post" id="post" autocomplete="off" value="{{ $alamat->post_code }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <button class="btn btn-secondary">Batal</button>
                                                            </div>
                                                            <div class="col-md-6 text-right">
                                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                    </form>
                                </div>
                            </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">PROFIL</div>
                        <div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">PESAN</div>
                        <div class="tab-pane fade" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">SETTING</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@include('layouts.footers.auth')
@endsection

@push('js')
<script src="{{ asset('argon/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    $('.datepicker').datepicker({
        'setDate': new Date()
        , autoclose: true
        , format: 'yyyy-mm-dd'
        , todayHighlight: true
        , zIndexOffset: 999
    });

</script>
@endpush
