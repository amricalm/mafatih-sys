@if (isset($nomenu))

@else
<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-dark bg-maroon" id="sidenav-main">
    <div class="container-fluid" id="sidetray">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main"
            aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""><i class=" fas fa-bars emas"></i></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0" href="{{ route('home') }}">
            <img src="{{ asset('assets') }}/img/adn/logo.png" class="navbar-brand-img" alt="...">
        </a>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item">
                <a href="{{ url('notifikasi') }}" class="nav-link" >
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle bg-maroon">
                            <i class="far fa-bell"></i>
                        </span>
                    </div>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                            <img alt="Image placeholder" src="{{ asset('argon') }}/img/theme/team-1-800x800.jpg">
                        </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    @if (auth()->user()->role!='2')
                    <a href="{{ url('lihat-file') }}" class="dropdown-item">
                        <i class="far fa-folder-open"></i>
                        <span>Lihat File</span>
                    </a>
                    @endif
                    <a href="{{ url('profil') }}" class="dropdown-item">
                        <i class="ni ni-circle-08"></i>
                        <span>Profil</span>
                    </a>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
                            <img src="{{ asset('assets') }}/img/adn/logo.png">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse"
                            data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false"
                            aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="btn-block">
                <a href="#" style="text-align:center;margin-bottom:5px;" onclick="ubahSemesterAktif()" class="btn btn-sm btn-secondary">TA AKTIF {{ config('active_academic_year') }}</a>
                <a href="#" style="text-align:center;margin-bottom:5px;" onclick="ubahSemesterAktif()" class="btn btn-sm btn-secondary">{{ config('active_term') }}</a>
            </div>
            {{-- <div class="input-group input-group-sm mb-3" style="margin-bottom:5px;" onclick="showabsenmodal()">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Absen</span>
                </div>
                <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="jammenu" readonly>
            </div>
            <div class="btn-group btn-block" role="group" aria-label="">
                {{-- <button type="button" class="btn btn-sm btn-secondary" id="jammenu"></button>
                <button type="button" class="btn btn-sm btn-secondary"><i class="fa fa-user-clock"></i> Absen</button>
            </div> --}}
            <ul class="navbar-nav">
                @php
                $menu = \App\SmartSystem\General::menu_sidebar();
                @endphp
                <li class="nav-item">
                    <a class="nav-link {{ (!isset($aktif)) ? 'active' : '' }}" href="{{ url('/') }}/home">
                        <i class="ni ni-tv-2"></i> Dashboard
                    </a>
                </li>
                @foreach ($menu as $k=>$v)
                    @php
                        $dropdown = \App\SmartSystem\General::menu_dropdown($v->id);
                        $is_collapse = 'collapse';
                        $is_expanded = 'false';
                        $is_active = '';
                        foreach($dropdown as $key=>$val)
                        {
                            if(isset($aktif))
                            {
                                if($aktif==$val->slug)
                                {
                                    $is_collapse = 'expanded';
                                    $is_expanded = 'true';
                                }
                            }
                        }
                        $dropdownhtml = 'class="nav-link" href="'.url($v->slug).'"';
                        if(count($dropdown)>0)
                        {
                            $dropdownhtml = 'class="nav-link collapsed" href="#menus'.$v->id.'" data-toggle="collapse" role="button" aria-expanded="'.$is_expanded.'" aria-controls="menus'.$v->id.'"';
                        }
                    @endphp
                <li class="nav-item ">
                    <a {!! $dropdownhtml !!}>
                        <i class="{{  $v->menu_icon  }}"></i>
                        <span class="nav-link-text">{{ $v->menu }}</span>
                    </a>
                    @if (count($dropdown)>0)
                        <div class="{{ $is_collapse }}" id="menus{{ $v->id }}">
                            <ul class="nav nav-sm flex-column">
                                @foreach($dropdown as $key => $value)
                                <li class="nav-item ">
                                    @php
                                    $is_active = (isset($aktif)&&$aktif==$value->slug) ? 'active' : '';
                                    @endphp
                                    <a class="nav-link {{ $is_active }}" href="{{ url('/'.$value->slug) }}" style="font-size:12px">
                                        <i class="{{  $value->menu_icon }}"></i> {{ $value->menu  }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </li>
                @endforeach
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
@endif
