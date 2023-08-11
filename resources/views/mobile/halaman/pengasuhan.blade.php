@extends('mobile.template')

@section('content')
    <div class="main-container">
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
                                    <h6 class="float-left">Tahun Ajaran {{ $v['name'] }}</h6>
                                </div>
                                <div class="col-6">
                                    <div class=" float-right">
                                        {{-- <a href="{{ url('raport/'.$detail->pid.'/1/print/pdf') }}" class="btn btn-outline-default btn-block rounded" >
                                            <span class="material-icons mr-1">download_for_offline</span> PDF
                                        </a> --}}
                                    </div>
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
                                                            $adadata = $finalboardingdtl
                                                                ->where('ayid',$v['id'])
                                                                ->where('tid',$smstrv)
                                                                ->isEmpty();
                                                        @endphp
                                                        @if (!$adadata)
                                                        @php
                                                            $token = \App\SmartSystem\EasyEncrypt::encrypt($person->dob);
                                                        @endphp
                                                        <a href="{{ url('raport/'.$student->id.'/2/print/pdf?token='.urlencode($token).'&tahunajar='.$v['id'].'&semester='.$smstrv.'&browser=1') }}" class="btn btn-sm btn-warning"><i class="material-icons">download</i> Download</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-striped text-white">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Penilaian Pengasuhan</th>
                                                        <th class="text-right">Nilai</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $total = 0;
                                                        $data = collect($data)->sortBy('seq');
                                                        $i = 1;
                                                    @endphp
                                                    @foreach($data as $dk=>$dv)
                                                    @php
                                                        $nilai = $finalboardingdtl
                                                            ->where('ayid',$v['id'])
                                                            ->where('tid',$smstrv)
                                                            ->where('subject_id',$dv->id);
                                                        $nilais = (count($nilai->toArray())==0) ? ['final_grade'=>'','letter_grade'=>''] : $nilai->first();
                                                    @endphp
                                                        <tr>
                                                            <td>{{ $i++ }}</td>
                                                            <td>{{ $dv->name }}</td>
                                                            <td class="text-right">{{ ($nilais['letter_grade']!='-') ? $nilais['letter_grade'] : number_format($nilais['final_grade'],0,',','.') }}</td>
                                                        </tr>
                                                    @endforeach
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
