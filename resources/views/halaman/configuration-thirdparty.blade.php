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
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Tripay</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Google Recaptcha</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-onesignal-tab" data-toggle="pill" href="#pills-onesignal" role="tab" aria-controls="pills-onesignal" aria-selected="false">One Signal</a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="POST" id="frmTripay">
                                <input type="hidden" id="type" name="type" value="tripay">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_prod" id="is_prod1" value="production" {{ (config('tripay_is_prod')=='production') ? 'checked="checked"' : '' }}>
                                        <label class="form-check-label" for="is_prod1">
                                            Production
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_prod" id="is_prod2" value="sandbox" {{ (config('tripay_is_prod')=='sandbox') ? 'checked="checked"' : '' }}>
                                        <label class="form-check-label" for="is_prod2">
                                            Sandbox
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="merchant">Nomor Merchant</label>
                                    <input type="text" class="form-control" id="merchant" name="merchant" value="{{ config('tripay_merchant') }}"  >
                                </div>
                                <div class="form-group">
                                    <label for="merchant">Nomor Merchant Secondary</label>
                                    <input type="text" class="form-control" id="sandbox_merchant" name="sandbox_merchant" value="{{ config('tripay_sandbox_merchant') }}"  >
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h2>Production</h2>
                                        <div class="form-group">
                                            <label for="apikey">API Key</label>
                                            <input type="text" autocomplete="off" class="form-control" name="apikey" id="apikey" value="{{ config('tripay_apikey') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="privatekey">Private Key</label>
                                            <input type="text" autocomplete="off" class="form-control" id="privatekey" name="privatekey" value="{{ config('tripay_privatekey') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="url_payment_channel">URL Channel Pembayaran</label>
                                            <input type="text" autocomplete="off" class="form-control" id="url_payment_channel" name="url_payment_channel" value="{{ config('tripay_url_payment_channel') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="url_detail">URL Lihat Detail Transaksi</label>
                                            <input type="text" autocomplete="off" class="form-control" id="url_detail" name="url_detail" value="{{ config('tripay_url_detail') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="url_create">URL Meminta Transaksi</label>
                                            <input type="text" autocomplete="off" class="form-control" id="url_create" name="url_create" value="{{ config('tripay_url_create') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h2>Sandbox</h2>
                                        <div class="form-group">
                                            <label for="sandbox_apikey">API Key</label>
                                            <input type="text" autocomplete="off" class="form-control" name="sandbox_apikey" id="sandbox_apikey" value="{{ config('tripay_sandbox_apikey') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="sandbox_privatekey">Private Key</label>
                                            <input type="text" autocomplete="off" class="form-control" id="sandbox_privatekey" name="sandbox_privatekey" value="{{ config('tripay_sandbox_privatekey') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="sandbox_url_payment_channel">URL Channel Pembayaran</label>
                                            <input type="text" autocomplete="off" class="form-control" id="sandbox_url_payment_channel" name="sandbox_url_payment_channel" value="{{ config('tripay_sandbox_url_payment_channel') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="sandbox_url_detail">URL Lihat Detail Transaksi</label>
                                            <input type="text" autocomplete="off" class="form-control" id="sandbox_url_detail" name="sandbox_url_detail" value="{{ config('tripay_sandbox_url_detail') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="sandbox_url_create">URL Meminta Transaksi</label>
                                            <input type="text" autocomplete="off" class="form-control" id="sandbox_url_create" name="sandbox_url_create" value="{{ config('tripay_sandbox_url_create') }}">
                                        </div>
                                    </div>
                                </div>
                                <button type="button" id="saveTripay" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="POST" id="frmGR">
                                <input type="hidden" id="type" name="type" value="recaptcha">
                                <div class="form-group">
                                    <label for="apikey">Site Key</label>
                                    <input type="text" autocomplete="off" class="form-control" name="sitekey" id="sitekey" value="{{ config('recaptcha_sitekey') }}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Secret Key</label>
                                    <input type="text" autocomplete="off" class="form-control" id="secretkey" name="secretkey" value="{{ config('recaptcha_secretkey') }}">
                                </div>
                                <button type="button" id="saveRecaptcha" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-onesignal" role="tabpanel" aria-labelledby="pills-onesignal-tab">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="POST" id="frmOS">
                                <input type="hidden" id="type" name="type" value="onesignal">
                                <div class="form-group">
                                    <label for="appid">APP ID</label>
                                    <input type="text" autocomplete="off" class="form-control" name="appid" id="appid" value="{{ config('onesignal_appid') }}">
                                </div>
                                <div class="form-group">
                                    <label for="apikey">REST API KEY</label>
                                    <input type="text" autocomplete="off" class="form-control" name="sitekey" id="sitekey" value="{{ config('onesignal_apikey') }}">
                                </div>
                                <button type="button" id="saveOneSignal" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
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
        $('#saveOneSignal').on('click',function(){
            data = $('#frmOS').serialize();
            $.post('{{ url('konfigurasi') }}',{"_token": "{{ csrf_token() }}", data:data},function(data){
                if(data=='Berhasil')
                {
                    msgSukses('Berhasil disimpan');
                }
            })
        })
    </script>
@endpush
