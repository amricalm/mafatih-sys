@extends('mobile.template')

@section('content')
    <div class="container mb-4">
        <div class="card">
            <div class="card-body text-left text-md-center">
                <p style="text-align:center;">
                    <button class="btn btn-danger btn-sm text-white" type="button" data-toggle="collapse" data-target="#collapseWidthExample" aria-expanded="false" aria-controls="collapseWidthExample">Lihat Ayat Quran (Acak) <i class="fas fa-angle-down"></i></button>
                </p>
                <div>
                    <div class="collapse width" id="collapseWidthExample">
                        {!! \App\SmartSystem\General::random_quran('','jumbotron') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main-container">
        <div class="container mb-4">
            <div class="row">
                @php
                    $arraydetail = [
                        'kelas' => [
                            'icon' => '<button class="btn btn-40 bg-default-light text-default rounded-circle"><i class="material-icons">subscriptions</i></button>',
                            'name' => config('kelas.name').' / Level '.config('kelas.level'),
                            'name_ar' => config('kelas')['name_ar'],
                        ],
                        'walikelas' => [
                            'icon' => '<div class="avatar avatar-50 rounded-circle mx-auto shadow"><div class="background" style="background-image: url(\''.config('walikelas.foto').'\');"><img src="'.config('walikelas.foto').'" alt="Foto Profil" style="display: none;"/></div></div>',
                            'name' => ((config('walikelas.sex')=='L')?'Ustadz ':'Ustadzah ').config('walikelas.name'),
                            'name_ar' => \App\SmartSystem\General::ustadz(config('walikelas.sex')).' '.config('walikelas.name_ar')
                        ],
                        'pengasuhan' => [
                            'icon' => '<div class="avatar avatar-50 rounded-circle mx-auto shadow"><div class="background" style="background-image: url(\''.config('pengasuhan.foto').'\');"><img src="'.config('pengasuhan.foto').'" alt="Foto Profil" style="display: none;"/></div></div>',
                            'name' => ((config('pengasuhan.sex')=='L')?'Ustadz ':'Ustadzah ').config('pengasuhan.name'),
                            'name_ar' => \App\SmartSystem\General::ustadz(config('pengasuhan.sex')).' '.config('pengasuhan.name_ar')
                        ],
                        'guru Al-quran' => [
                            'icon' => '<div class="avatar avatar-50 rounded-circle mx-auto shadow"><div class="background" style="background-image: url(\''.config('bayanat.foto').'\');"><img src="'.config('bayanat.foto').'" alt="Foto Profil" style="display: none;"/></div></div>',
                            'name' => (null !== (config('bayanat.teachername'))) ? config('bayanat.teachername') : '&nbsp;',
                            'name_ar' => (null !== (config('bayanat.classname'))) ? config('bayanat.classname') : '&nbsp;'
                        ]
                    ];
                @endphp
                @foreach ($arraydetail as $k=>$v)
                <div class="col-12 col-md-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="mb-1">{!! $v['name'] !!} <br> <span class="arabic">{!! $v['name_ar'] !!}</span></h5>
                                    <p class="text-secondary">{{ ucfirst($k) }}</p>

                                </div>
                                <div class="col-auto pl-0">
                                    {!! $v['icon'] !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="container mb-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">MENU</h6>
                </div>
                <div class="card-body px-0 pt-0">
                    @php
                    $array = [
                        [
                            'icon'=>'edit',
                            'h' => 'Edit Profil',
                            'p' => 'Lengkapi Profil Anda.',
                            'link' => url('/').'/mobile/profil',
                        ],
                        [
                            'icon'=>'subscriptions',
                            'h' => 'Raport Akademik',
                            'p' => 'Lihat Detail Raport Akademik',
                            'link' => url('/').'/mobile/nilai-akademik',
                        ],
                        [
                            'icon'=>'local_florist',
                            'h' => 'Raport Pengasuhan',
                            'p' => 'Lihat Detail Raport Pengasuhan',
                            'link' => url('/').'/mobile/nilai-pengasuhan',
                        ],
                        [
                            'icon'=>'history_edu',
                            'h' => 'Raport Al-Quran',
                            'p' => 'Lihat Raport Al-Quran',
                            'link' => url('/').'/mobile/nilai-alquran',
                        ],
                        [
                            'icon'=>'auto_stories',
                            'h' => 'Raport Diknas',
                            'p' => 'Lihat Raport Diknas',
                            'link' => url('/').'/mobile/nilai-diknas',
                        ],
                        [
                            'icon'=>'location_city',
                            'h' => 'Lihat Pencapaian Diri',
                            'p' => 'Lihat Prestasi, Hukuman, Konseling dll',
                            'link' => url('/').'/mobile/pencapaian-diri',
                        ],
                        [
                            'icon'=>'power_settings_new',
                            'h' => 'Logout',
                            'p' => 'Keluar dari aplikasi',
                            'link' => 'javascript:void(0);" onclick="logout();',
                        ],
                    ];
                    @endphp
                    <div class="row">
                        <div class="col-md-12">
                            <div class="list-group list-group-flush border-top border-color">
                            @php
                                $no = 0;
                            @endphp
                            @foreach ($array as $k=>$v)
                                @if ($no==3)
                                </div></div><div class="col-md-6"><div class="list-group list-group-flush border-top border-color">
                                @endif
                                <a href="{!! $v['link'] !!}" class="list-group-item list-group-item-action border-color">
                                    <div class="row">
                                        <div class="col-auto">
                                            <div class="avatar avatar-50 {{ ($v['h']=='Logout') ? 'bg-danger-light text-danger' : 'bg-default-light text-default' }} rounded">
                                                <span class="material-icons">{{ $v['icon'] }}</span>
                                            </div>
                                        </div>
                                        <div class="col align-self-center pl-0">
                                            <h6 class="mb-1">{{ $v['h'] }}</h6>
                                            <p class="text-secondary">{{ $v['p'] }}</p>
                                        </div>
                                    </div>
                                </a>
                                @php $no++; @endphp
                            @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- @include('mobile.news') --}}
    </div>
@endsection
@push('js')
<script>
    function logout()
    {
        $('#logout-form').submit();
    }
</script>
@endpush
