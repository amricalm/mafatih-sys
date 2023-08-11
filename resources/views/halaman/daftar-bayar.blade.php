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
                            <li class="breadcrumb-item active" aria-current="page"><a href="#">{{ __('Pembayaran') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 mb-5 mb-xl-0">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="table-responsive py-4">
                                    <div class="container">
                                        <table class="table data-table" id="tablesiswa">
                                            <thead>
                                                <tr>
                                                    <th>Nama Santri yang terdaftar</th>
                                                    <th>Sekolah</th>
                                                    <th>Tahun Ajaran</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        {{ $person->name }}
                                                    </td>
                                                    <td>
                                                        @php
                                                        $ppdb = \App\Models\Ppdb::where('pid',$person->id)->first();
                                                        $sekolah = \App\Models\School::where('id',$ppdb['school_id'])->first();
                                                        $aayear = \App\Models\AcademicYear::where('id',$ppdb['academic_year_id'])->first();
                                                        $arrayproses = array('1'=>'Lengkapi','2'=>'Lengkapi','3'=>'Lengkapi','4'=>'Lengkapi','5'=>'sudah bayar');
                                                        @endphp
                                                        {{ $sekolah['name'] }}
                                                    </td>
                                                    <td>
                                                        {{ $aayear['name'] }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5">
                            @for($i=0;$i<count($bills);$i++)
                            <div class="col-md-6">
                                <div class="card">
                                    <img src="{{ asset('uploads/mahad.png') }}" class="card-img-top" alt="Mahad">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $bills[($i+1)]['name'] }}</h5>
                                        <p class="card-title">
                                            {{ $bills[($i+1)]['desc'] }}
                                        </p>
                                        <p class="card-text">
                                            Rp. {{ number_format($bills[($i+1)]['amount'],0,',','.') }},-
                                        </p>
                                    </div>
                                    <div class="card-footer">
                                        <a href="{{ url('ppdb/'.$person->id.'/prosesbayar/'.($i+1)) }}" class="btn btn-block btn-default"><i class="fa fa-tags" aria-hidden="true"></i> Bayar sekarang</a>
                                    </div>
                                </div>
                            </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')

@endpush
