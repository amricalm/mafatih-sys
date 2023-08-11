@extends('layouts.app', ['class' => 'bg-maroon','style'=>'background-image:url(assets/img/adn/bg-msh-miring.png);-webkit-background-size: auto;-moz-background-size: cover;-o-background-size: cover;background-size: cover;background-position: center middle;background-origin: content-box;'])

@section('content')
    @include('layouts.headers.guest')
    <div class="container mt--8 pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card bg-emas shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="text-center pb-4">
                            <a style="margin:0 auto;padding-top:30px;" href="{{ route('home') }}">
                                <img src="{{ asset('assets/img/adn/logo.png') }}" style="width: 75%;" />
                            </a>
                        </div>
                        <div class="text-center maroon mb-4">
                            {{ __('Silahkan masukkan email dan password') }}
                        </div>
                        <form role="form" method="POST" id="frmlogin" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }} mb-3">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                    </div>
                                    <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" type="email" name="email" id="email" value="{{ old('email') }}" value="" required autofocus="autofocus" autocomplete="off">
                                </div>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ __('Password') }}" type="password" value="" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="bukapassword"><i class="fas fa-eye"></i></span>
                                    </div>
                                </div>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-default my-4" id="btnsubmit"><i class="fas fa-sign-in-alt"></i> {{ __('Masuk') }}</button>
                                {{-- @php
                                    if (strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false)
                                    {
                                        echo '<a href="'.url('daftar-ulang').'" class="btn my-4"><i class="fas fa-user-plus"></i> Daftar</a>';
                                    }
                                @endphp --}}
                                {{-- <a href="{{ route('register') }}" class="btn my-4"><i class="fas fa-user-plus"></i> {{ __('Daftar') }}</a> --}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
<script src="https://kit.fontawesome.com/5c10d44513.js" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){
            $('#email').focus();
        });
        $('#bukapassword').on('click',function(){
            var kls = $(this).children().attr('class');
            if(kls=='fas fa-eye')
            {
                $('input[name=password]').attr('type','text');
                $(this).children().attr('class','fas fa-eye-slash');
            }
            else
            {
                $('input[name=password]').attr('type','password')
                $(this).children().attr('class','fas fa-eye');
            }
        });
        $('#btnsubmit').on('click',function(){
            $(this).html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Proses...');
        });
    </script>
@endpush
