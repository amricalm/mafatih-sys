<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
<head>
    @include('mobile.header')
</head>
<body class="body-scroll d-flex flex-column h-100 menu-overlay darkmode" data-page="">
    @include('mobile.screen-loader')
    @if(Auth::check())
    @include('mobile.menu-sidebar')
    @endif
    <main class="flex-shrink-0 main has-footer">
        @if(Auth::check())
        @include('mobile.menu-header')
        <div class="container-fluid px-0">
            <div class="card overflow-hidden">
                <div class="card-body p-0 h-150">
                    <div class="background">
                        <img src="{{ asset('assets') }}/img/adn/bg.png" alt="" style="display: none;">
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid top-70 text-center mb-4">
            <a href="#" id="fotoprofil">
            <div class="avatar avatar-140 rounded-circle mx-auto shadow">
                <div class="background">
                    <img src="{{ $foto }}" alt="Foto Profil">
                </div>
            </div>
            </a>
        </div>
        <div class="container mb-4 text-center text-white">
            <h6 class="mb-2">{{ $person->name }}</h6>
            <p class="arabic">{{ $person->name_ar }}</p>
        </div>
        @endif
        @yield('content')
    </main>
    @if (isset($menufooter)&&$menufooter=='1')
    @include('mobile.menu-footer')
    @endif
    @include('mobile.footer')
    @stack('js')
</body>
</html>
