@extends('mobile.template')
@include('komponen.tabledata')

@push('header')
<style>
    .btn-circle.btn-xl {
        width: 70px;
        height: 70px;
        padding: 10px 16px;
        border-radius: 35px;
        font-size: 24px;
        line-height: 1.33;
    }

    .btn-circle {
        width: 30px;
        height: 30px;
        padding: 6px 0px;
        border-radius: 15px;
        text-align: center;
        font-size: 12px;
        line-height: 1.42857;
        border:1px solid white;
    }

</style>
@endpush

@section('content')
    <div class="main-container">
        <div class="main-container">
            <div class="container mb-4">
                <ul class="nav justify-content-center row mb-2">
                    @php
                        $no = 1;
                    @endphp
                    @foreach($pencapaian as $k=>$v)
                    <li class="col-6 nav-item mb-2">
                        <button class="btn btn-outline-default px-2 btn-block rounded" id="thnajar{{ $k }}-tab" data-toggle="tab" href="#thnajar{{ $k }}" role="tab"  aria-controls="thnajar{{ $k }}" aria-selected="{{ ($no==1) ? ' true' : 'false' }}"><span class="material-icons mr-1">badge</span> {{ $v['name'] }}</button>
                    </li>
                    @php
                        $no++;
                    @endphp
                    @endforeach
                </ul>
            </div>
            <div class="container">
                <div class="tab-content">
                    <div class="tab-pane active" id="thnajar0" role="tabpanel" aria-labelledby="thnajar0-tab">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col align-self-center">
                                        <h6 class="text-center" style="text-transform:uppercase;">PRESTASI ANANDA</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="list-group list-group-flush">
                                    @if ($prestasi->count()==0)
                                        🙏belum ada data
                                    @else
                                        @foreach ($prestasi as $k=>$v)
                                                <div class="row p-2">
                                                    <div class="col-auto align-self">
                                                        <i class="material-icons text-default">check_circle</i>
                                                    </div>
                                                    <div class="col pl-0">
                                                        <div class="row mb-1">
                                                            <div class="col">
                                                                <p class="mb-0"><b>{{ strtoupper($v->name) }}</b></p>
                                                            </div>
                                                            <div class="col-auto pl-0">
                                                                <p class="small text-secondary">{{ $v->date }}</p>
                                                            </div>
                                                        </div>
                                                        <p class="small">{!! $v->desc !!}</p>
                                                        @if($v->file!='')
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item">
                                                                <a href="{{ url($v->file) }}?browser=1" style="font-size:10px;"><i class="fas fa-arrow-circle-down"></i> download</a>
                                                            </li>
                                                        </ul>
                                                        @endif
                                                    </div>
                                                </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="thnajar1" role="tabpanel" aria-labelledby="thnajar1-tab">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col align-self-center">
                                        <h6 class="text-center" style="text-transform:uppercase;">PELANGGARAN ANANDA</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="list-group list-group-flush">
                                    @if ($pelanggaran->count()==0)
                                        🙏belum ada data
                                    @else
                                        @foreach ($pelanggaran as $k=>$v)
                                        <div class="row p-2">
                                            <div class="col-auto align-self">
                                                <a class="btn btn-circle text-white" style="background-color:#{{ $levelpelanggaran[($v->level)-1] }}"><i class="fas fa-flag"></i></a>
                                            </div>
                                            <div class="col pl-0">
                                                <div class="row mb-1">
                                                    <div class="col">
                                                        <p class="mb-0"><b>{{ strtoupper($v->name) }}</b> ( Level {{ $v->level }} )</p>
                                                    </div>
                                                    <div class="col-auto pl-0">
                                                        <p class="small text-secondary">{{ $v->date }}</p>
                                                    </div>
                                                </div>
                                                <p class="small text-secondary">{!! $v->desc !!}</p>
                                            </div>
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="thnajar2" role="tabpanel" aria-labelledby="thnajar2-tab">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col align-self-center">
                                        <h6 class="text-center" style="text-transform:uppercase;">RIWAYAT KESEHATAN ANANDA</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="list-group list-group-flush">
                                    @if ($kesehatan->count()==0)
                                        🙏belum ada data
                                    @else
                                        @foreach ($kesehatan as $k=>$v)
                                        <div class="row p-2">
                                            <div class="col-auto align-self">
                                                @if ($v->is_finish!='1')
                                                <a href="#" class="btn btn-circle text-white"><i class="fas fa-file-medical-alt"></i></a>
                                                @else
                                                <a href="#" class="btn btn-circle text-white"><i class="fas fa-hand-holding-medical"></i></a>
                                                @endif
                                            </div>
                                            <div class="col pl-0">
                                                <div class="row mb-1">
                                                    <div class="col">
                                                        <p class="mb-0"><b>{{ strtoupper($v->name) }}</b> <small style="font-size:10px;">( {{ $v->is_finish!='1'?'BELUM ':'SUDAH ' }} DITANGANI )</small></p>
                                                    </div>
                                                    <div class="col-auto pl-0">
                                                        <p class="small text-secondary">{{ $v->date }}</p>
                                                    </div>
                                                </div>
                                                <p class="small">{!! $v->desc !!}</p>
                                                <p class="small text-secondary"><b>Penanganan</b> : {!! $v->handle !!} <b>oleh</b> {{ ($v->sex=='L')?'Ustadz ':'Ustadzah ' }}{{ $v->handlebyname }}</p>
                                            </div>
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="thnajar3" role="tabpanel" aria-labelledby="thnajar3-tab">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col align-self-center">
                                        <h6 class="text-center" style="text-transform:uppercase;">BIMBINGAN KONSELING ANANDA</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="list-group list-group-flush">
                                    @if ($konseling->count()==0)
                                        🙏belum ada data
                                    @else
                                        @foreach ($konseling as $k=>$v)
                                        <div class="row p-2">
                                            <div class="col-auto align-self">
                                                {{-- <i class="material-icons text-default">check_circle</i> --}}
                                                <i class="fas fa-grin-hearts"></i>
                                            </div>
                                            <div class="col pl-0">
                                                <div class="row mb-1">
                                                    <div class="col">
                                                        <p class="mb-0"><b>{{ strtoupper($v->name) }}</b></p>
                                                    </div>
                                                    <div class="col-auto pl-0">
                                                        <p class="small text-secondary">{{ $v->date }}</p>
                                                    </div>
                                                </div>
                                                <p class="small text-secondary">{!! $v->desc !!}</p>
                                            </div>
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
