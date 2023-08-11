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
                        <div class="col-md-6 text-right">
                            <h1>PEMBAYARAN PENDAFTARAN PPDB</h1>
                            <small>Ikuti petunjuk pembayaran melalui link berikut : <a href="#" class="badge badge-primary"><i class="fa fa-external-link-alt"></i> Link</a></small>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-4">
                            <div class="card">
                                <blockquote class="blockquote mb-0 p-5 text-center card-img-top bg-maroon">
                                    <h3 class="text-white">Invoice No.</h3>
                                    <h1 class="text-white">ABC12348</h1>
                                </blockquote>
                                <div class="card-body">
                                    <h5 class="card-title">Pendaftaran</h5>
                                    <p class="card-text">
                                        Rp. 400.000,-
                                    </p>
                                    <a href="" class="btn btn-block btn-primary"><i class="fa fa-check-circle"></i> Sudah bayar</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <blockquote class="blockquote mb-0 p-5 text-center card-img-top bg-maroon">
                                    <h3 class="text-white">Invoice No.</h3>
                                    <h1 class="text-white">ABC12349</h1>
                                </blockquote>
                                <div class="card-body">
                                    <h5 class="card-title">Wakaf</h5>
                                    <p class="card-text">
                                        Rp. 10.000.000,-
                                    </p>
                                    <a href="{{ url('pembayaran/2/periksa') }}" class="btn btn-block btn-default"><i class="fa fa-tags"></i> Bayar sekarang</a>
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
