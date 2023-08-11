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
                                <h1>Pembayaran telah dibuat.</h1>
                                @php
                                $ppdb = \App\Models\Ppdb::where('pid',$person->id)->first();
                                $aayear = \App\Models\AcademicYear::where('id',$ppdb['academic_year_id'])->first();
                                $sekolah = \App\Models\School::where('id',$ppdb['school_id'])->first();
                                @endphp
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        No. Invoice : <br><b>{{ $cek->invoice_id }}</b>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        No. Registrasi : <br><b>{{ $ppdb['registration_id'] }}</b>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Nama calon siswa : <br><b>{{ $person->name }}</b>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Sekolah dituju : <br><b>{{ $sekolah->name }}</b>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Tahun Ajaran : <br><b>{{ $aayear->name }}</b>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Email : <br><b>{{ auth()->user()->email }}</b>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        No. Handphone : <br><b>{{ '0'.auth()->user()->handphone }}</b>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-md-12">
                                <div class="card mb-3">
                                    <div class="row no-gutters">
                                        <div class="col-md-4">
                                            <img src="{{ asset('uploads/mahad.png') }}" class="card-img-top" alt="Mahad">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body text-right">
                                                <h5 class="card-title">{{ $bills[$cek['bill_id']]['name'] }}</h5>
                                                <p class="card-text">{{ $bills[$cek['bill_id']]['desc'] }}</p>
                                                <h1>Rp. {{ number_format($bills[$cek['bill_id']]['amount'],0,",",".") }}</h1>
                                                @if(!empty($transaksi))
                                                <p>+ biaya admin Rp.{{ (is_array($transaksi['total_fee'])) ? $transaksi['total_fee']['flat'] : $transaksi['total_fee'] }}.<br> Total Rp. {{ number_format($transaksi['amount'],0,',','.') }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(empty($transaksi))
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="list-group">
                                    @foreach($payment_channel as $item)
                                    @if($item->code=='QRIS')
                                        @php continue; @endphp
                                    @endif
                                    @if($item->active==true)
                                    @php
                                    $total = $bills[$request->idbiaya]['amount'] + $item->total_fee->flat;
                                    $bank = explode(' ',$item->name);
                                    $bank = strtolower($bank[0]);
                                    @endphp
                                    <form action="{{ url('ppdb/'.$request->id.'/prosesdetail/'.$request->idbiaya).'/'.$item->code }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="invoice" id="invoice" value="{{ $cek->invoice_id }}" >
                                    <input type="hidden" name="amount" id="amount" value="{{ $total }}" >
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="row" style="width:100%">
                                            <div class="col-md-6 col-sm-12 text-center-sm">
                                                <img src="{{ asset('assets/img/bank/'.$bank.'.png') }}" alt="{{ $item->name }}" style="height:20px">
                                            </div>
                                            {{-- <div class="col-md-5 col-sm-12 p-1 text-center">
                                                <small>Biaya admin Rp. {{ number_format($item->total_fee->flat,0,',','.') }}</small><br> Total <b style="font-size:21px;">Rp. {{ number_format($total,0,',','.') }}</b>
                                                <input type="hidden" id="{{ $item->code }}_amount" value="{{ $bills[$request->idbiaya]['amount'] }}">
                                            </div> --}}
                                            <div class="col-md-6 col-sm-12">
                                                {{-- <button type="submit" onclick="return confirm('Yakin akan melakukan pembayaran dengan {{ $item->name }} ?')" class="btn btn-primary btn-sm btn-block">Bayar via {{ $item->name }}</button> --}}
                                                <a href="{{ url('ppdb/'.$cek->invoice_id.'/prosesdetail/'.$item->code) }}" class="btn btn-primary btn-sm btn-block" onclick="return confirm('Yakin akan melakukan pembayaran dengan {{ $item->name }} ?')">Bayar via {{ $item->name }}</a>
                                            </div>
                                        </div>
                                    </li>
                                    </form>
                                    @endif
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            @if(!empty($transaksi['qr_url']))
                            <div class="col-md-12">
                                <img src="{{ $transaksi['qr_url'] }}" alt="{{ $transaksi['qr_string'] }}" style="width:250px">
                            </div>
                            @endif
                            @if(!empty($transaksi))
                            <div class="col-md-12">
                                <div class="nav-wrapper">
                                    <ul class="nav nav-pills flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                                    @for($i=0;$i<count($transaksi['instructions']);$i++)
                                    <li class="nav-item">
                                        <a class="nav-link mb-sm-3 mb-md-0 {{ ($i==0)?'active':'' }}" id="tabs-icons-text-{{ __($i+1) }}-tab" data-toggle="tab" href="#tabs-icons-text-{{ __($i+1) }}" role="tab" aria-controls="tabs-icons-text-{{ __($i+1) }}" aria-selected="true"><i class="ni ni-cloud-upload-96 mr-2"></i> {{ $transaksi['instructions'][$i]['title'] }}</a>
                                    </li>
                                    @endfor
                                    </ul>
                                </div>
                                <div class="card shadow">
                                    <div class="card-body">
                                        <div class="tab-content" id="myTabContent">
                                            @for($i=0;$i<count($transaksi['instructions']);$i++)
                                            <div class="tab-pane fade show {{ ($i==0)?'active':'' }}" id="tabs-icons-text-{{ __($i+1) }}" role="tabpanel" aria-labelledby="tabs-icons-text-{{ __($i+1) }}-tab">
                                                <ol>
                                                    @for($j=0;$j<count($transaksi['instructions'][$i]['steps']); $j++)
                                                    <li>{{ $transaksi['instructions'][$i]['steps'][$j] }}</li>
                                                    @endfor
                                                </ol>
                                            </div>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
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
