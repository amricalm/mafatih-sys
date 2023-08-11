@extends('mobile.template')

@section('content')
    <div class="main-container">
        <div class="container mb-4">
            <div class="row text-center mt-3">
                @php
                    $array = [
                        [
                            'icon'=>'<i class="material-icons vm md-36 text-template">edit</i>',
                            'h' => 'Edit',
                            'p' => 'Profil',
                            'link' => url('/').'/mobile/profil',
                        ],
                        [
                            'icon'=>'<i class="material-icons vm md-36 text-template">subscriptions</i>',
                            'h' => 'Lihat',
                            'p' => 'Nilai Akademik',
                            'link' => url('/').'/mobile/nilai-akademik',
                        ],
                        [
                            'icon'=>'<i class="material-icons vm md-36 text-template">local_florist</i>',
                            'h' => 'Lihat',
                            'p' => 'Nilai Pengasuhan',
                            'link' => url('/').'/mobile/nilai-pengasuhan',
                        ],
                        [
                            'icon'=>'<i class="material-icons vm md-36 text-template">location_city</i>',
                            'h' => 'Lihat',
                            'p' => 'Pencapaian diri',
                            'link' => url('/').'/mobile/pencapaian-diri',
                        ],
                    ];
                @endphp
                @foreach ($array as $k=>$v)
                <div class="col-6 col-md-3">
                    <div class="card border-0 mb-4">
                        <div class="card-body" onclick="location.href='{{ $v['link'] }}'" style="cursor: pointer;">
                            <div class="avatar avatar-60 bg-default-light rounded-circle text-default">{!! $v['icon'] !!}</div>
                            <h3 class="mt-3 mb-0 font-weight-normal">{{ $v['h'] }}</h3>
                            <p class="text-secondary small">{{ $v['p'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            {{-- <div class="card">
                <div class="card-body text-center ">
                    <div class="row justify-content-equal no-gutters">
                        <div class="col-4 col-md-2 mb-3">
                            <a href="send_money.html" class="icon icon-50 rounded-circle mb-1 bg-default-light text-default"><span class="material-icons">edit</span></a>
                            <p class="text-secondary"><small>Edit Profil</small></p>
                        </div>
                        <div class="col-4 col-md-2 mb-3">
                            <a href="transfer.html" class="icon icon-50 rounded-circle mb-1 bg-default-light text-default"><span class="material-icons">bookmark_add</span></a>
                            <p class="text-secondary"><small>Nilai</small></p>
                        </div>
                        <div class="col-4 col-md-2 mb-3">
                            <a href="recharge.html" class="icon icon-50 rounded-circle mb-1 bg-default-light text-default"><span class="material-icons">health_and_safety</span></a>
                            <p class="text-secondary"><small>Kesehatan</small></p>
                        </div>
                        <div class="col-4 col-md-2 mb-3">
                            <a href="send_money.html" class="icon icon-50 rounded-circle mb-1 bg-default-light text-default"><span class="material-icons">account_circle</span></a>
                            <p class="text-secondary"><small>Prestasi</small></p>
                        </div>
                        <div class="col-4 col-md-2 mb-3">
                            <div class="icon icon-50 rounded-circle mb-1 bg-default-light text-default"><span class="material-icons">mark_chat_read</span></div>
                            <p class="text-secondary"><small>Konseling</small></p>
                        </div>
                        <div class="col-4 col-md-2 mb-3">
                            <div class="icon icon-50 rounded-circle mb-1 bg-default-light text-default"><span class="material-icons">wb_incandescent</span></div>
                            <p class="text-secondary"><small>Electricity</small></p>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
        {{-- <div class="container">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Menu Lainnya</h6>
                </div>
                <div class="card-body px-0 pt-0">
                    <div class="list-group list-group-flush border-top border-color">
                        <a href="language.html" class="list-group-item list-group-item-action border-color">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="avatar avatar-50 bg-default-light text-default rounded">
                                        <span class="material-icons">language</span>
                                    </div>
                                </div>
                                <div class="col align-self-center pl-0">
                                    <h6 class="mb-1">Language</h6>
                                    <p class="text-secondary">Choose preffered language</p>
                                </div>
                            </div>
                        </a>
                        <a href="security_settings.html" class="list-group-item list-group-item-action border-color">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="avatar avatar-50 bg-default-light text-default rounded">
                                        <span class="material-icons">lock_open</span>
                                    </div>
                                </div>
                                <div class="col align-self-center pl-0">
                                    <h6 class="mb-1">Security Settings</h6>
                                    <p class="text-secondary">App lock, Password</p>
                                </div>
                            </div>
                        </a>
                        <a href="notification_settings.html" class="list-group-item list-group-item-action border-color">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="avatar avatar-50 bg-default-light text-default rounded">
                                        <span class="material-icons">notifications</span>
                                    </div>
                                </div>
                                <div class="col align-self-center pl-0">
                                    <h6 class="mb-1">Notification Settings</h6>
                                    <p class="text-secondary">Customize notification receiving</p>
                                </div>
                            </div>
                        </a>
                        <a href="my_cards.html" class="list-group-item list-group-item-action border-color">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="avatar avatar-50 bg-default-light text-default rounded">
                                        <span class="material-icons">credit_card</span>
                                    </div>
                                </div>
                                <div class="col align-self-center pl-0">
                                    <h6 class="mb-1">My Cards</h6>
                                    <p class="text-secondary">Add, update, delete Credit Cards</p>
                                </div>
                            </div>
                        </a>
                        <a href="my_address.html" class="list-group-item list-group-item-action border-color">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="avatar avatar-50 bg-default-light text-default rounded">
                                        <span class="material-icons">location_city</span>
                                    </div>
                                </div>
                                <div class="col align-self-center pl-0">
                                    <h6 class="mb-1">My Address</h6>
                                    <p class="text-secondary">Add, update, delete address</p>
                                </div>
                            </div>
                        </a>
                        <a href="login.html" class="list-group-item list-group-item-action border-color">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="avatar avatar-50 bg-danger-light text-danger rounded">
                                        <span class="material-icons">power_settings_new</span>
                                    </div>
                                </div>
                                <div class="col align-self-center pl-0">
                                    <h6 class="mb-1">Logout</h6>
                                    <p class="text-secondary">Logout from the application</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="main-container">
            <div class="container">
                <h4>Artikel Terakhir</h4>
                @php
                    $feed = collect($feed)->take(8)->toArray();
                @endphp
                <div class="row">
                    @for($i=0;$i<count($feed);$i++)
                    @php
                        $image = ($feed[$i]->featured_media!='0') ? collect(\App\SmartSystem\WpLibrary::getFeatureImage($feed[$i]->featured_media))->toArray() : array('source_url'=>'');
                        $judulartikel = $feed[$i]->title;
                        $link = $feed[$i]->link;
                    @endphp
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card border-0 mb-4 overflow-hidden">
                            <div class="card-body h-150 position-relative">
                                @if ($i==0)
                                <div class="bottom-left m-2">
                                    <button class="btn btn-sm btn-default rounded">Baru</button>
                                </div>
                                @endif
                                <a href="product.html" class="background" style="background-image: url('{{ $image->source_url }}');">
                                    <img src="{{ $image->source_url }}" alt="" style="display: none;">
                                </a>
                            </div>
                            <div class="card-body ">
                                {{-- <p class="mb-0"><a class="text-secondary">lebih lanjut</a></p> --}}
                                <a href="{{ $link }}" target="_blank">
                                    <p class="mb-0">{{ $judulartikel->rendered }}</p>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>
                <div class="row text-center">
                    <div class="col-6 col-md-4 col-lg-3 mx-auto">
                        <button class="btn btn-sm btn-outline-secondary rounded" onclick="window.open('https://mahadsyarafulharamain.sch.id/informasi/')">Lihat lebih lengkap</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
