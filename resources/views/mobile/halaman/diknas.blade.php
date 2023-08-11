@extends('mobile.template')

@push('header')
<style>
.dropdown-menu {
    border: 1px solid #212529;
    background-color: #ffc107;
}
.dropdown-menu a.dropdown-item {
    color: #212529 !important;
}
.dropdown-menu a.dropdown-item:hover{
    border: 1px solid #212529;
    background-color: #ffc107;
    color: #212529;
}
</style>
@endpush
@section('content')
    <div class="main-container">
        <div class="container mb-4">
            <div class="card border-0 mb-3">

            </div>
        </div>
        <div class="container mb-4">
            <ul class="nav justify-content-center row mb-2">
                @php
                    $no = 1;
                @endphp
                @foreach($thn_ajar as $k=>$v)
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
                @php
                    $no = 1;
                @endphp
                @foreach($thn_ajar as $k=>$v)
                <div class="tab-pane{{ ($no==1) ? ' active' : '' }}" id="thnajar{{ $k }}" role="tabpanel" aria-labelledby="thnajar{{ $k }}-tab">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col align-self-center">
                                    <h6 class="text-center" style="text-transform:uppercase;">Tahun Ajaran {{ $v['name'] }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                            @php
                                $semester = [1,2];
                            @endphp
                            @foreach ($semester as $smstrk=>$smstrv)
                            <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col align-self-center">
                                            <h6>Semester {{ $smstrv }}</h6>
                                        </div>
                                        <div class="col-auto">
                                            <div class="float-right text-right">
                                                @php
                                                    $token = \App\SmartSystem\EasyEncrypt::encrypt($person->dob);
                                                @endphp
                                                {{-- <div class="btn-group btn-sm">
                                                    <button type="button" class="btn btn-sm btn-warning">Download</button>
                                                    <button type="button" class="btn btn-sm btn-warning dropdown-toggle dropdown-toggle-split" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item text-right" href="{{ url('download_raport/diknas-'.$smstrv.'/'.$person->id.'/'.urlencode($token).'?browser=1') }}">Raport</a>
                                                    </div>
                                                </div> --}}
                                                <a href="{{ url('raport/'.$student->id.'/3/print/pdf?token='.urlencode($token).'&tahunajar='.$v['id'].'&semester='.$smstrv.'&browser=1') }}" class="btn btn-sm btn-warning"><i class="material-icons">download</i> Download</a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped text-white">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Mata Pelajaran</th>
                                                <th class="text-right">Nilai</th>
                                                <th class="text-right">Predikat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $total = 0;
                                                $totalmid = 0;
                                                $nilaitotal = collect($nilaidiknas)
                                                    ->where('ayid',$v['id'])
                                                    ->where('tid',$smstrv)
                                                    ->where('format_code','2')
                                                    ->first();
                                                if(!is_null($nilaitotal))
                                                {
                                                    $pelajaran = collect($matapelajarandetail)
                                                        ->where('ayid',$v['id'])
                                                        ->where('tid',$smstrv)
                                                        ->where('level',$nilaitotal['level']);
                                                    $nilaikgn = collect($nilaidiknasdetail)
                                                        ->where('ayid',$v['id'])
                                                        ->where('tid',$smstrv)
                                                        ->where('level',$nilaitotal['level'])
                                                        ->where('letter_grade',3)
                                                        ->whereIn('subject_id',$pelajaran->pluck('subject_diknas_id')->toArray())
                                                        ->toArray();
                                                    $nilaipsk = collect($nilaidiknasdetail)
                                                        ->where('ayid',$v['id'])
                                                        ->where('tid',$smstrv)
                                                        ->where('level',$nilaitotal['level'])
                                                        ->where('letter_grade',4)
                                                        ->whereIn('subject_id',$pelajaran->pluck('subject_diknas_id')->toArray())
                                                        ->toArray();
                                                    @endphp
                                                        <tr>
                                                            <th colspan="4">PENGETAHUAN</th>
                                                        </tr>
                                                    @php
                                                    $i = 1;
                                                    foreach($nilaikgn as $nilaik=>$nilaiv)
                                                    {
                                                        @endphp
                                                            <tr>
                                                                <td>{{ $i }}</td>
                                                                <td>{{ $nilaiv['namapelajaran'] }}</td>
                                                                <td class="text-right">{{ number_format($nilaiv['final_grade'])!=0 ? number_format($nilaiv['final_grade']) : ''; }}</td>
                                                                <td class="text-right">{{ number_format($nilaiv['final_grade'])!=0 ? \App\SmartSystem\General::predikatDiknas(number_format($nilaiv['final_grade'])) : ''; }}</td>
                                                            </tr>
                                                        @php
                                                        $i++;
                                                    }
                                                    @endphp
                                                        <tr>
                                                            <th colspan="4">KETERAMPILAN</th>
                                                        </tr>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Mata Pelajaran</th>
                                                            <th class="text-right">Nilai</th>
                                                            <th class="text-right">Predikat</th>
                                                        </tr>
                                                    @php
                                                    $j = 1;
                                                    foreach($nilaipsk as $nilaik=>$nilaiv)
                                                    {
                                                        @endphp
                                                            <tr>
                                                                <td>{{ $j }}</td>
                                                                <td>{{ $nilaiv['namapelajaran'] }}</td>
                                                                <td class="text-right">{{ number_format($nilaiv['final_grade'])!=0 ? number_format($nilaiv['final_grade']) : ''; }}</td>
                                                                <td class="text-right">{{ number_format($nilaiv['final_grade'])!=0 ? \App\SmartSystem\General::predikatDiknas(number_format($nilaiv['final_grade'])) : ''; }}</td>
                                                            </tr>
                                                        @php
                                                        $j++;
                                                    }
                                                }
                                            @endphp
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    </div>
                </div>
                @php
                    $no++;
                @endphp
                @endforeach
            </div>
        </div>
    </div>
@endsection
