<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-dark bg-maroon" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" app-toggle="collapse" app-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""><i class=" fas fa-bars emas"></i></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0" href="{{ route('home') }}">
            <img src="{{ asset('assets') }}/img/adn/logo-msh-versi-com-invert.png" class="navbar-brand-img" alt="...">
        </a>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" app-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                            <img alt="Image placeholder" src="{{ asset('argon') }}/img/theme/team-1-800x800.jpg">
                        </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Selamat datang!') }}</h6>
                    </div>
                    {{-- <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>{{ __('My profile') }}</span>
                    </a> --}}
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </div>
            </li>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('assets/img/adn/logo.png') }}">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" app-toggle="collapse" app-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <ul class="navbar-nav">
                @php
                $menu = [
                    [
                        'nama' => 'Dashboard',
                        'url' => 'home',
                        'icon' => 'ni ni-tv-2',
                        'warna' => '',
                    ],
                    [
                        'nama' => 'Halaman Pendaftaran',
                        'url' => 'ppdb',
                        'icon' => 'ni ni-single-02',
                        'warna' => '',
                    ],
                    [
                        'nama' => 'Prestasi',
                        'url' => 'prestasi',
                        'icon' => 'ni ni-check-bold',
                        'warna' => '',
                    ],
                    [
                        'nama' => 'Biaya Pendidikan',
                        'url' => 'biaya-pendidikan',
                        'icon' => 'ni ni-folder-17',
                        'warna' => '',
                    ],
                    [
                        'nama' => 'Setting',
                        'url' => 'setting',
                        'icon' => 'ni ni-settings-gear-65',
                        'warna' => '',
                    ],
                ];
                for($i=0;$i<count($menu);$i++) {
                    echo '<li class="nav-item">' ;
                    echo '<a class="nav-link '.((isset($aktif)&&$aktif==$menu[$i]['url']) ? ' active' : '' ).'" href="'.url($menu[$i]['url']).'" role="button" aria-expanded="false">';
                    echo '<i class="'.$menu[$i]['icon'].' '.$menu[$i]['warna'].'"></i>';
                    echo '<span class="nav-link-text '.$menu[$i]['warna'].'">'.$menu[$i]['nama'].'</span>';
                    echo '</a>';
                    echo '</li>';
                    }
                    @endphp
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out"></i>
                            <span>{{ __('Logout') }}</span>
                        </a>
                    </li>
            </ul>
        </div>
    </div>
</nav>
