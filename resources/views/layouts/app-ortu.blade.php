<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.headers.header')
</head>

<body class="{{ $class ?? '' }}" style="{{ $style ?? '' }}">
    @auth()
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    @if (\Auth::user()->role=='2')
    @include('layouts.navbars.sidebar-ortu')
    @else
    @include('layouts.navbars.sidebar')
    @endif
    @endauth
    <div class="main-content">
        @include('layouts.navbars.navbar')
        @yield('content')
    </div>
    @guest()
    @include('layouts.footers.guest')
    @endguest
    @include('layouts.footers.footer')
</body>

</html>
