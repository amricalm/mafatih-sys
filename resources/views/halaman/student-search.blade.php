@extends('layouts.app', ['class' => 'bg-maroon','style'=>'background-image:url(assets/img/adn/bg-msh-miring.png);-webkit-background-size: auto;-moz-background-size: cover;-o-background-size: cover;background-size: cover;background-position: center middle;background-origin: content-box;'])

@push('css')
<style>
    .grecaptcha-badge { opacity:0;}
</style>
@endpush
@section('content')
    @include('layouts.headers.guest')
    <div class="container mt--8 pt-5 pb-5">
        <div class="row justify-content-center pb-2">
            <div class="col-lg-5 col-md-7">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h1 class="arabic" style="text-align: center">أهْلاً وَسَهْلاً</h1>
                                <h6 class="text-center">Selamat datang di <br>halaman khusus <b>orangtua</b></h6>
                                <h6 class="text-center">Tahun Ajaran : {{ config('active_academic_year') }}, Semester {{ config('active_term') }}</h6>
                                <hr>
                            </div>
                            <div class="col-md-12">
                                <form action="" id="frmCari" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="nis">NIS Siswa <small class="arabic">(رقم القيد)</small></label>
                                        <input type="text" class="form-control" id="nis" name="nis" maxlength="10" autocomplete="off" value="{{ $nis }}" >
                                    </div>
                                    <div class="form-group">
                                        <label for="tgllahir">Tanggal Lahir Siswa (contoh <b>2009-02-25</b>)</label>
                                        <div class="input-group input-group-alternative">
                                            <input type="password" class="form-control" id="tgllahir" name="tgllahir" maxlength="10" autocomplete="off" value="{{ $tgl }}">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="bukapassword"><i class="fas fa-eye"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <input type="hidden" name="g-recaptcha-response" id="recaptcha">
                                        </div>
                                    </div>
                                    <button type="submit" id="btncari" class="btn btn-primary btn-block"><i class="fa fa-search"></i> Cari</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($request->post())
        <div class="card" id="divhasil" style="{{ $hasil=='' ? 'display:none;' : '' }}">
            <div class="card-header">Hasil Pencarian</div>
            <div class="card-body">
                @if($hasil!='' && $hasil!='ada' )
                {!! $hasil !!}
                @else
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a href="#pills-tabContent" class="nav-link active" id="pills-profil-tab" data-toggle="pill" data-target="#pills-profil" role="tab" aria-controls="pills-profil" aria-selected="true">Profil</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="#pills-tabContent" class="nav-link" id="pills-nilai-tab" data-toggle="pill" data-target="#pills-nilai" role="tab" aria-controls="pills-nilai" aria-selected="false">Nilai</a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active table-responsive" id="pills-profil" role="tabpanel" aria-labelledby="pills-profil-tab">
                        <table class="table table-striped">
                            <tr>
                                <td class="small">NIS</td>
                                <td class="text-right">{{ $data['profil']['nis'] }}</td>
                            </tr>
                            <tr>
                                <td class="small">Nama Lengkap</td>
                                <td class="text-right">{{ $data['profil']['name'] }}<br>
                                    <div class="arabic">{{ $data['profil']['name_ar'] }}</div></td>
                            </tr>
                            <tr>
                                <td class="small">Kelas</td>
                                <td class="text-right">
                                    {{ $kelas['name'].' / LEVEL '.$kelas['level'] }}<br>
                                    <div class="arabic">{{ $data['profil']['kelas']['namakelas_ar'] }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td class="small">Wali Kelas</td>
                                <td class="text-right">
                                    {{ ($data['profil']['kelas']['sex']=='L') ? 'Ustadz' : 'Ustadzah' }}
                                    {{ $data['profil']['kelas']['namaguru'] }}
                                    <br>
                                    <div class="arabic">
                                    {{ ($data['profil']['kelas']['sex']=='L') ? \App\SmartSystem\General::ustadz('L') : \App\SmartSystem\General::ustadz('P') }}
                                    {{ $data['profil']['kelas']['namaguru_ar'] }}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="small">Pengasuhan</td>
                                <td class="text-right">
                                    {{ ($pengasuhan['sex']=='L') ? 'Ustadz' : 'Ustadzah' }}
                                    {{ $pengasuhan['name'] }}
                                    <br>
                                    <div class="arabic">
                                        {{ ($pengasuhan['sex']=='L') ? \App\SmartSystem\General::ustadz('L') : \App\SmartSystem\General::ustadz('P') }}
                                        {{ $pengasuhan['name_ar'] }}
                                    </div>
                                </td>
                            </tr>
                            @php
                                if(count($bayanat)==0)
                                {
                                    $bayanat = [['teachername'=>'','classname'=>'','level'=>'']];
                                }
                            @endphp
                            <tr>
                                <td class="small">Bayanat Quran</td>
                                <td class="text-right">
                                    {{ ($bayanat[0]['teachersex']=='L') ? 'Ustadz' : 'Ustadzah' }}
                                    {{ $bayanat[0]['teachername'] }}
                                    <br>
                                    <div>
                                        <p style="margin-bottom:0px;"><span class="arabic">{{ $bayanat[0]['classname'] }} / {{ $bayanat[0]['level'] }}</span></p>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="pills-nilai" role="tabpanel" aria-labelledby="pills-nilai-tab">
                        <ul class="nav justify-content-center nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home" type="button" role="tab"
                                        aria-controls="home" aria-selected="true">PTS</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pengasuhan-tab" data-toggle="tab" data-target="#pengasuhan" type="button" role="tab"
                                        aria-controls="pengasuhan" aria-selected="false">Pengasuhan</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pas-tab" data-toggle="tab" data-target="#pas" type="button" role="tab"
                                        aria-controls="pas" aria-selected="false">PAS</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="quran-tab" data-toggle="tab" data-target="#quran" type="button" role="tab"
                                        aria-controls="quran" aria-selected="false">Quran</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                @if($data['profil']['nilaiuts']=='')
                                <div class="alert alert-info text-center" role="alert">
                                    Belum kami publish!
                                </div>
                                @elseif (count($data['profil']['nilaiuts'])==0)
                                <div class="alert alert-info text-center" role="alert">
                                    Belum ada data!
                                </div>
                                @else
                                <table class="table table-striped">
                                    <tr>
                                        <th>Pelajaran</th>
                                        <th>Nilai</th>
                                    </tr>
                                    @php
                                        $totaluts = 0; $jmhuts = 0;
                                    @endphp
                                    @foreach($data['profil']['nilaiuts'] as $kuts=>$vuts)
                                    <tr>
                                        <td>
                                            {{ $vuts['name'] }}
                                            <br><small class="arabic">{{ $vuts['name_ar'] }}</small>
                                            @php
                                                $guru = collect($data['profil']['pelajaran'])->where('subject_id',$vuts['subject_id'])->first();
                                                $guru = (!is_null($guru)) ? $guru->toArray() : ['name'=>''];
                                            @endphp
                                            <br><small>{{ $guru['name'] }}</small>
                                        </td>
                                        <td>{{ $vuts['final_grade'] }}</td>
                                    </tr>
                                    @php
                                        $jmhuts++;
                                        $totaluts += $vuts['final_grade'];
                                    @endphp
                                    @endforeach
                                    <tr>
                                        <td>TOTAL</td>
                                        <td>{{ $totaluts }}</td>
                                    </tr>
                                    <tr>
                                        <td>Rata-rata</td>
                                        <td>{{ round($totaluts/$jmhuts) }}</td>
                                    </tr>
                                </table>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="pengasuhan" role="tabpanel" aria-labelledby="pengasuhan-tab">
                                @if($data['profil']['pengasuhan']=='')
                                <div class="alert alert-info text-center" role="alert">
                                    Belum kami publish!
                                </div>
                                @elseif (count($data['profil']['pengasuhan'])==0)
                                <div class="alert alert-info text-center" role="alert">
                                    Belum ada data!
                                </div>
                                @else
                                <table class="table table-striped">
                                    <tr>
                                        <th>الرقم</th>
                                        <th>Aktivitas</th>
                                        <th>Data</th>
                                        <th>Nilai</th>
                                    </tr>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($data['profil']['groupaktivitas'] as $keyGroup => $valGroup)
                                        <tr>
                                            <td>{{ \App\SmartSystem\General::angka_arab($no) }}</td>
                                            <td>
                                                {{ $valGroup['name'] }}<br>
                                                <small class="arabic">{{ $valGroup['name_ar'] }}</small>
                                            </td>
                                            <td>
                                                <table>
                                                    @foreach ($data['profil']['aktivitas'] as $key => $val)
                                                        @if ($val['group_id'] == $valGroup['id'])
                                                        <tr style="background-color: transparent;">
                                                            <td>{{ $val['name_ar'] }}</td>
                                                        </tr>
                                                        @endif
                                                    @endforeach
                                                </table>
                                            </td>
                                            <td>
                                                <table>
                                                    @foreach ($data['profil']['aktivitas'] as $key => $val)
                                                        @if ($val['group_id'] == $valGroup['id'])
                                                        <tr style="background-color: transparent;">
                                                            @foreach($data['profil']['pengasuhan'] as $k=>$v)
                                                                @if($val['id'] == $v['subject_id'])
                                                                    <td>
                                                                        @if ($val['type'] == "ITEM")
                                                                            {{ $v['letter_grade'] }}
                                                                        @else
                                                                            {{ $v['final_grade'] ?? 0 }}
                                                                        @endif
                                                                    </td>
                                                                @endif
                                                            @endforeach
                                                        </tr>
                                                        @endif
                                                    @endforeach
                                                </table>
                                            </td>
                                        </tr>
                                    @php
                                        $no++;
                                    @endphp
                                    @endforeach
                                </table>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="pas" role="tabpanel" aria-labelledby="pas-tab">
                                @if($data['profil']['nilaiuas']=='')
                                <div class="alert alert-info text-center" role="alert">
                                    Belum kami publish!
                                </div>
                                @elseif (count($data['profil']['nilaiuas'])==0)
                                <div class="alert alert-info text-center" role="alert">
                                    Belum ada data!
                                </div>
                                @else
                                <table class="table table-striped">
                                    <tr>
                                        <th>Pelajaran</th>
                                        <th>Nilai</th>
                                    </tr>
                                    @php
                                        $totaluas = 0; $jmhuas = 0;
                                    @endphp
                                    @foreach($data['profil']['nilaiuas'] as $kuas=>$vuas)
                                    <tr>
                                        <td>
                                            {{ $vuas['name'] }}
                                            <br><small class="arabic">{{ $vuas['name_ar'] }}</small>
                                            @php
                                                $guru = collect($data['profil']['pelajaran'])->where('subject_id',$vuas['subject_id'])->first();
                                                $guru = (!is_null($guru)) ? $guru->toArray() : ['name'=>''];
                                            @endphp
                                            <br><small>{{ $guru['name'] }}</small>
                                        </td>
                                        <td>{{ $vuas['final_grade'] }}</td>
                                    </tr>
                                    @php
                                        $jmhuas++;
                                        $totaluas += $vuas['final_grade'];
                                    @endphp
                                    @endforeach
                                    <tr>
                                        <td>TOTAL</td>
                                        <td>{{ $totaluas }}</td>
                                    </tr>
                                    <tr>
                                        <td>Rata-rata</td>
                                        <td>{{ round($totaluas/$jmhuas) }}</td>
                                    </tr>
                                </table>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="quran" role="tabpanel" aria-labelledby="quran-tab">
                                <table class="table table-striped">
                                <tr>
                                    <th>Penilaian</th>
                                    <th>Nilai</th>
                                </tr>
                                @php
                                    $totaluas = 0; $jmhuas = 0;
                                @endphp
                                @foreach($data['profil']['quran'] as $kuas=>$vuas)
                                <tr>
                                    <td>
                                        {{ $vuas['name'] }}
                                        <br><small class="arabic">{{ $vuas['name_ar'] }}</small>
                                    </td>
                                    <td>{{ $vuas['result_evaluation'] }}</td>
                                </tr>
                                @endforeach
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
    <div id="loadMe" style="display:none;">
        <div class="text-center text-white" role="document">
            <div class="">
                <div class="modal-body text-center">
                    <div class="fa-5x">
                        <i class="fas fa-spinner fa-pulse"></i>
                    </div>
                    <h3>Proses sedang berjalan!</h3>
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


    $('#bukapassword').on('click',function(){
        var kls = $(this).children().attr('class');
        if(kls=='fas fa-eye')
        {
            $('input[name=tgllahir]').attr('type','text');
            $(this).children().attr('class','fas fa-eye-slash');
        }
        else
        {
            $('input[name=tgllahir]').attr('type','password')
            $(this).children().attr('class','fas fa-eye');
        }
    });

    $('#btncari').on('click',function(){
        $(this).attr('disabled')
        nis = $('#nis').val();
        tgl = $('#tgllahir').val();
        gpr = $('#recaptcha').val();
        if(nis!=''&&tgl!='')
        {
            $('#loadMe').show();
            $('#frmCari').trigger('submit');
        }
    })
</script>
@endpush
