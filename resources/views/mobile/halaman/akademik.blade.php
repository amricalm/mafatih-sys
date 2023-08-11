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
                @php
                    $arraygpa = collect($gpa)->pluck('gpa')->toArray();
                    $arraythn = collect($gpa)->sortBy(['name','tid'])->pluck('name')->toArray();
                    $arraysms = collect($gpa)->sortBy(['name','tid'])->pluck('tid')->toArray();
                    $textchart = '';
                    $indexgpa = 0;
                    $totalgpa = 0;
                    $totalgpaindex = 0;
                    foreach($gpa as $kgpa=>$vgpa)
                    {
                        $totalgpa += $vgpa->gpa;
                        $indexgpa++;
                        $totalgpaindex = $totalgpa/$indexgpa;
                    }
                    for($i=0;$i<count($arraythn);$i++)
                    {
                        $textchart .= ($i==0) ? '' : ', ';
                        $textchart .= '"'.$arraythn[$i].' S'.$arraysms[$i].'"';
                    }
                @endphp
                <div class="card-body">
                    <h1 class=" text-center mb-0 display-4">{{ number_format($totalgpaindex,2,",",".") }}</h1>
                    <p class="text-center text-secondary mb-4">IPK</p>
                </div>
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
                                            <h6>
                                                @php
                                                $gpas = collect($gpa)->where('ayid',$v['id'])->where('tid',$smstrv)->first();
                                                if(!is_null($gpas))
                                                {
                                                    // $totalgpa
                                                    echo 'IP : '.$gpas->gpa;
                                                }
                                                @endphp
                                            </h6>
                                        </div>
                                        <div class="col-auto">
                                            <div class="float-right text-right">
                                                @if (!is_null($gpas))
                                                @php
                                                    $token = \App\SmartSystem\EasyEncrypt::encrypt($person->dob);
                                                @endphp
                                                <div class="btn-group btn-sm">
                                                    <button type="button" class="btn btn-sm btn-warning">Download</button>
                                                    <button type="button" class="btn btn-sm btn-warning dropdown-toggle dropdown-toggle-split" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item text-right" href="{{ url('raport/'.$student->id.'/pts/print/pdf?token='.urlencode($token).'&tahunajar='.$v['id'].'&semester='.$smstrv.'&browser=1') }}">UTS</a>
                                                        <a class="dropdown-item text-right" href="{{ url('raport/'.$student->id.'/1/print/pdf?token='.urlencode($token).'&tahunajar='.$v['id'].'&semester='.$smstrv.'&browser=1') }}">Raport</a>
                                                    </div>
                                                </div>
                                                {{-- <a href="{{ url('download/raport/akademik-'.$smstrv.'/'.$person->id.'/'.$token.'?browser=1') }}" class="btn btn-sm btn-warning"><i class="material-icons">download</i> Download</a> --}}
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
                                                <th>Mata Pelajaran</th>
                                                <th class="text-right">UTS</th>
                                                <th class="text-right">FRM</th>
                                                <th class="text-right">UAS</th>
                                                <th class="text-right">NA</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $total = 0;
                                                $totalmid = 0;
                                                $totalform = 0;
                                                $totalfinal = 0;
                                                $nilaitotal = collect($nilaiakademik)
                                                    ->where('ayid',$v['id'])
                                                    ->where('tid',$smstrv)
                                                    ->where('format_code','0')
                                                    ->first();
                                                if(!is_null($nilaitotal))
                                                {
                                                    $pelajaran = collect($matapelajarandetail)
                                                        ->where('ayid',$v['id'])
                                                        ->where('tid',$smstrv)
                                                        ->where('level',$nilaitotal['level']);
                                                    $nilai = collect($nilaiakademikdetail)
                                                        ->where('ayid',$v['id'])
                                                        ->where('tid',$smstrv)
                                                        ->where('level',$nilaitotal['level'])
                                                        ->whereIn('subject_id',$pelajaran->pluck('subject_id')->toArray())
                                                        ->toArray();

                                                    $i = 1;
                                                    foreach($nilai as $nilaik=>$nilaiv)
                                                    {
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $i }}</td>
                                                            <td>{{ $nilaiv['namapelajaran'] }} <!--({{ $nilaiv['lesson_hours'] }})--></td>
                                                            <td class="text-right">{{ $nilaiv['mid_exam'] }}</td>
                                                            <td class="text-right">{{ $nilaiv['formative_val'] }}</td>
                                                            <td class="text-right">{{ $nilaiv['final_exam'] }}</td>
                                                            <td class="text-right">{{ $nilaiv['final_grade'] }}</td>
                                                        </tr>
                                                        @php
                                                        $totalmid += $nilaiv['mid_exam'];
                                                        $totalform += $nilaiv['formative_val'];
                                                        $totalfinal += $nilaiv['final_exam'];
                                                        $total += $nilaiv['final_grade'];
                                                        $i++;
                                                    }
                                                }
                                            @endphp
                                            <tr>
                                                <td colspan="2">TOTAL</td>
                                                <td class="text-right">{{ $totalmid }}</td>
                                                <td class="text-right">{{ $totalform }}</td>
                                                <td class="text-right">{{ $totalfinal }}</td>
                                                <td class="text-right">{{ $total }}</td>
                                            </tr>
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
@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('mixedchartjs');
    Chart.defaults.color = "#ffffff";
    let chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [{!! $textchart !!}],
            datasets: [{
                label: 'Nilai ',
                data: [{{ implode(',',$arraygpa) }}],
                borderWidth: 1,
                borderColor: '#ffffff',
                backgroundColor: '#ffffff',
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: false
                }
            }
        }
    });
</script>
@endpush
