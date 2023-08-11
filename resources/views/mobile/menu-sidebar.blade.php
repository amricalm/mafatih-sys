<!-- menu main -->
<div class="main-menu">
    <div class="row mb-4 no-gutters" style="cursor:pointer;" onclick="ganti()">
        <div class="col-auto"><button class="btn btn-link btn-40 btn-close text-white"><span
                    class="material-icons">chevron_left</span></button></div>
        <div class="col-auto">
            <div class="avatar avatar-40 rounded-circle position-relative">
                <figure class="background">
                    <img src="{{ $foto }}" alt="Foto Profil">
                </figure>
            </div>
        </div>
        <div class="col pl-3 text-left align-self-center">
            <h6 class="mb-1" style="text-decoration: underline;">{{ auth()->user()->name }}</h6>
        </div>
    </div>
    <div class="menu-container">
        @php
        $array = [
            [
                'icon'=>'account_balance',
                'h' => 'Dashboard',
                'p' => 'Lengkapi Profil Anda.',
                'link' => url('/').'/mobile/home',
            ],
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
                'h' => 'Pencapaian Diri',
                'p' => 'Lihat Prestasi, Hukuman, Konseling dll',
                'link' => url('/').'/mobile/pencapaian-diri',
            ],
            [
                'icon'=>'web',
                'h' => 'Website Mahad',
                'p' => 'Lihat informasi tentang mahad',
                'link' => 'https://www.mahadsyarafulharamain.sch.id?browser=1',
            ],
        ];
        @endphp
        <ul class="nav nav-pills flex-column ">
            @foreach ($array as $k=>$v)
            <li class="nav-item">
                <a class="nav-link" href="{{ $v['link'] }}">
                    <div>
                        <span class="material-icons icon">{{ $v['icon'] }}</span>
                        {{ $v['h'] }}
                    </div>
                    <span class="arrow material-icons">chevron_right</span>
                </a>
            </li>
            @endforeach
        </ul>
        <div class="text-center">
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" id="btnlogout" class="btn btn-danger text-white rounded my-3 mx-auto"><i class="fas fa-sign-out-alt"></i> Keluar</button>
            </form>
        </div>
    </div>
</div>
<div class="backdrop"></div>
<div class="modal fade" id="exampleModal" tabindex="-1" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pilih Siswa</h5>
                {{-- <button type="button" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i></button> --}}
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="swiper-slide swiper-slide-active" style="margin-right: 30px;">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-auto">
                                                <div class="avatar avatar-60 rounded mb-1">
                                                    <div class="background" style="background-image: url(&quot;img/user1.png&quot;);"><img src="img/user1.png" alt="" style="display: none;"></div>
                                                </div>
                                            </div>
                                            <div class="col pl-0">
                                                <p class="text-secondary mb-0"><small>Errica</small></p>
                                                <p class="mb-1">$1500 <small class="text-success">28% <span class="material-icons small">call_made</span></small></p>
                                                <p class="text-secondary small">25-06-2020 08:00pm</p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="swiper-slide swiper-slide-next" style="margin-right: 30px;">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-auto">
                                                <div class="avatar avatar-60 rounded mb-1">
                                                    <div class="background" style="background-image: url(&quot;img/user2.png&quot;);"><img src="img/user2.png" alt="" style="display: none;"></div>
                                                </div>
                                            </div>
                                            <div class="col pl-0">
                                                <p class="text-secondary mb-0"><small>Alisia</small></p>
                                                <p class="mb-1">$1500 <small class="text-danger">10% <span class="material-icons small">call_received</span></small></p>
                                                <p class="text-secondary small">25-06-2020 08:00pm</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-target="#carouselExampleControls" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-target="#carouselExampleControls" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </button>
                </div> --}}
                <form action="">
                    <div class="form-group">
                        <select name="" id="" class="form-control">

                        </select>
                    </div>
                    <div class="text-center">
                        <a href="#">Tambah Siswa</a>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
            </div>
        </div>
    </div>
</div>

