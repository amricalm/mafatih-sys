@extends('layouts.app', ['class' => 'bg-maroon','style'=>'background-image:url(assets/img/adn/pola-01.png);
-webkit-background-size: auto;-moz-background-size: auto;-o-background-size: auto;background-size: auto;'])

@section('content')
    @include('layouts.headers.guest')
    <div class="container mt--8 pb-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card bg-emas shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <img src="{{ asset('assets/img/adn/logo.png') }}" style="width: 250px;" />
                            </div>
                            <div class="col-md-6">
                                <h1>PENDAFTARAN PESERTA DIDIK BARU</h1>
                            </div>
                            <div class="col-md-12 pt-2">
                                <h2>Data Calon Santri</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">NISN</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nama Ayah</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nama Lengkap</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nama Ibu</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                            id="inlineRadio1" value="option1">
                                        <label class="form-check-label" for="inlineRadio1">Laki-laki</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                            id="inlineRadio2" value="option2">
                                        <label class="form-check-label" for="inlineRadio2">Perempuan</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tempat Lahir</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tanggal Lahir</label>
                                    <input type="email" class="form-control datepicker" id="exampleInputEmail1"
                                        aria-describedby="emailHelp">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Asal Sekolah</label>
                                    <input type="email" class="form-control datepicker" id="exampleInputEmail1"
                                        aria-describedby="emailHelp">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Alamat</label>
                                    <textarea name="" id="" class="form-control" rows="3" style="height:93px;"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">No. HP</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <a href="{{ route('pembayaran') }}" type="button" class="btn btn-default btn-lg">Simpan</a>
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
        $('.datepicker').datepicker({
            'setDate': new Date(),
            autoclose: true,
            format: 'yyyy-mm-dd',
            todayHighlight: true,
            zIndexOffset: 999
        });
    </script>
@endpush
