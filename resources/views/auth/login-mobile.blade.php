@extends('mobile.template')

@section('content')
<div class="container h-100 text-white">
    <div class="row h-100">
        <div class="col-12 align-self-center mb-4">
            <div class="row justify-content-center">
                <form role="form" id="frmlogin" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="col-11 col-sm-7 col-md-6 col-lg-5 col-xl-4">
                        <h2 class="font-weight-normal mb-3 text-white">
                            <img src="{{ asset('assets/img/adn/logo.png') }}" style="width: 75%;" />
                        </h2>
                        <p class="mb-5">Silahkan masukkan username &amp; Password</p>
                        @if ($errors->has('password'))
                        <span class="invalid-feedback" style="display: block;" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                        @if ($errors->has('email'))
                        <span class="invalid-feedback" style="display: block;" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                        <div class="form-group float-label active">
                            <input class="form-control text-white" type="email" name="email" id="email" value="{{ old('email') }}" value="" required autofocus="autofocus" autocomplete="off">
                            <label class="form-control-label text-white">Username</label>
                        </div>
                        <div class="form-group float-label position-relative">
                            <input type="password" class="form-control text-white" name="password" value="" required>
                            <label class="form-control-label text-white">Password</label>
                        </div>
                        <div class="form-group float-label position-relative">
                            <button type="button" id="bukapassword" class="btn btn-sm text-white"><i class="fas fa-eye"></i> Lihat Password</button>
                        </div>
                        <p class="text-right"><button type="button" id="btnsubmit" class="btn btn-maroon btn-block rounded my-4" ><i class="fas fa-sign-in-alt"></i> {{ __('Masuk') }}</button></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $('#bukapassword').on('click',function(){
        var kls = $(this).children().attr('class');
        if(kls=='fas fa-eye')
        {
            $('input[name=password]').attr('type','text');
            $(this).html('<i class="fas fa-eye-slash"></i> Sembunyi Password');
        }
        else
        {
            $('input[name=password]').attr('type','password');
            $(this).html('<i class="fas fa-eye"></i> Lihat Password');
        }
    });
    $('#btnsubmit').on('click',function(){
        $(this).html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Proses...');
        $('#frmlogin').submit();
    });
</script>
@endpush
