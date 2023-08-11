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
                            <li class="breadcrumb-item active" aria-current="page"><a href="#">{{ __('Formulir') }}</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 text-right">
                </div>
            </div>
        </div>
        <div class="row">
            {{-- <div class="col"> --}}
            <div class="card">
                <div class="card-body">
                    <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 mb-5 mb-xl-0">
                        <div class="container-fluid d-flex align-items-center">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <h1 class="display-2 ">Ahlan Wasahlan!</h1>
                                    <p class="mt-0 mb-5">
                                        Panduan dalam registrasi</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- </div> --}}
        </div>
    </div>
</div>
@endsection
@push('js')
@endpush
