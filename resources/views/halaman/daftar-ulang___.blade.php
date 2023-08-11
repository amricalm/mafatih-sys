@extends('layouts.app', ['class' => 'bg-maroon','style'=>'background-image:url(assets/img/adn/bg-msh-miring.png); -webkit-background-size: auto;-moz-background-size: cover;-o-background-size: cover;background-size: cover;background-position: center middle;background-origin: content-box;'])

@section('content')
@include('layouts.headers.guest')
<div class="container mt--8 pb-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card bg-emas shadow border-0">
                <div class="card-body px-lg-5 py-lg-5">
                    <div class="text-center">
                        <a style="margin:0 auto;padding-top:30px;" href="{{ route('home') }}">
                            <img src="{{ asset('assets/img/adn/logo.png') }}" style="width: 50%;" />
                        </a>
                    </div>
                </div>
                <div class="text-center maroon">
                    {{ __('Silahkan daftar terlebih dahulu!') }}
                </div>
                <div class="card-body px-lg-5 py-lg-5">
                    <form role="form" method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                            <div class="input-group input-group-alternative mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                                </div>
                                <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Nama Anda') }}" type="text" name="name" value="{{ old('name') }}" required autofocus>
                            </div>
                            @if ($errors->has('name'))
                            <span class="invalid-feedback" style="display: block;" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                            <div class="input-group input-group-alternative mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                </div>
                                <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" type="email" name="email" value="{{ old('email') }}" required>
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
                                <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Password') }}" type="password" name="password" id="password" required>
                            </div>
                            @if ($errors->has('password'))
                            <span class="invalid-feedback" style="display: block;" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                </div>
                                <input class="form-control" placeholder="{{ __('Confirm Password') }}" type="password" name="password_confirmation" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <input type="hidden" name="g-recaptcha-response" id="recaptcha">
                            </div>
                        </div>
                        <div class="text-center">
                            <button {{-- href="route('registrasi')" --}} type="submit" class="btn btn-default mt-4"><i class="fas fa-user-plus"></i> {{ __('Daftar Akun') }}</button>
                            <a href="{{ route('login') }}" type="submit" class="btn mt-4"><i class="fas fa-sign-in-alt"></i> {{ __('Login') }}</a>
                        </div>
                    </form>
                </div>
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

</script>
@endpush
