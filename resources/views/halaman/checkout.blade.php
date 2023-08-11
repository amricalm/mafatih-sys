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
                        @foreach($channels as $channel)
                        @if($channel->active)
                        <div class="col-md-4">
                            <div class="card">
                                <blockquote class="blockquote mb-0 p-5 text-center card-img-top bg-maroon">
                                    <h1 class="text-white">{{$channel->name}}</h1>
                                </blockquote>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
