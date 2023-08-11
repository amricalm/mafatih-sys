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
                <div class="card-header">
                    <ul class="nav nav-pills" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Profil Aktif</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Nama Sekolah Diknas</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <h3>Profil Aktif</h3>
                            <form action="" method="POST" id="frmTripay">
                                <input type="hidden" id="type" name="type" value="global">
                                <div class="form-group">
                                    <label for="active_school">Sekolah Aktif</label>
                                    <select name="active_school" id="active_school" class="form-control">
                                        @foreach ($school as $key=>$val)
                                            @php
                                                $selected = ($val['id']==config('id_active_school')) ? 'selected="selected"' : '';
                                            @endphp
                                            <option value="{{ $val['id'] }}" {{ $selected }}>{{ $val['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="active_academic_year">Tahun Ajaran Aktif</label>
                                    <select name="active_academic_year" id="active_academic_year" class="form-control">
                                        @php
                                            $ayid = collect($config)->where('config_name','active_academic_year')->toArray();
                                            $ayid = reset($ayid);
                                            $tid = collect($config)->where('config_name','active_term')->toArray();
                                            $tid = reset($tid);
                                        @endphp
                                        @foreach ($ac_year as $key=>$val)
                                            @php
                                                $selected = ($val['id']==$ayid['config_value']) ? 'selected="selected"' : '';
                                            @endphp
                                            <option value="{{ $val['id'] }}" {{ $selected }}>{{ $val['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="active_term">Semester Aktif</label>
                                    <select name="active_term" id="active_term" class="form-control">
                                        @php $term = [['id'=>'1','desc'=>'Semester 1'],['id'=>'2','desc'=>'Semester 2']]; @endphp
                                        @foreach ($term as $key=>$val)
                                            @php
                                                $selected = ($val['id']==$tid['config_value']) ? 'selected="selected"' : '';
                                            @endphp
                                            <option value="{{ $val['id'] }}" {{ $selected }}>{{ $val['desc'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="nama_lembaga">Nama Lembaga</label>
                                    <input type="text" autocomplete="off" class="form-control" name="nama_lembaga" id="nama_lembaga" value="{{ config('nama_lembaga') }}">
                                </div>
                                <div class="form-group">
                                    <label for="telpon_lembaga">No. Telpon Lembaga</label>
                                    <input type="text" autocomplete="off" class="form-control" name="telpon_lembaga" id="telpon_lembaga" value="{{ config('telpon_lembaga') }}">
                                </div>
                                <div class="form-group">
                                    <label for="email_lembaga">Email Lembaga</label>
                                    <input type="email" autocomplete="off" class="form-control" name="email_lembaga" id="email_lembaga" value="{{ config('email_lembaga') }}">
                                </div>
                                <button type="button" id="save" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <h3>Nama Sekolah untuk Raport Diknas</h3>
                            <form method="POST" id="frmOther">
                                <input type="hidden" id="type" name="type" value="diknas">
                                @foreach($school_type as $k=>$v)
                                    <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-2 col-form-label">Nama {{ $v->desc }}</label>
                                        <div class="col-sm-10">
                                            <input type="text" autocomplete="off" class="form-control" name="id[{{ $v->id }}]" id="id[{{ $v->id }}]" value="{{ $v->name }}">
                                        </div>
                                    </div>
                                @endforeach
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <button type="button" id="save_other" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
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
@endsection
@push('js')
    <script>
        $('#save').on('click',function(){
            data = $('#frmTripay').serialize();
            $.post('{{ url('konfigurasi') }}',{"_token": "{{ csrf_token() }}", data:data},function(data){
                if(data=='Berhasil')
                {
                    msgSukses('Berhasil disimpan');
                    location.reload();
                }
            })
        });

        $('#save_other').on('click',function(){
            data = $('#frmOther').serialize();
            $.post('{{ url('konfigurasi') }}',{"_token": "{{ csrf_token() }}", data:data},function(data){
                if(data=='Berhasil')
                {
                    msgSukses('Berhasil disimpan');
                    location.reload();
                }
            })
        })
    </script>
@endpush
