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
    @include('layouts.navbars.sidebar')
    @endauth
    <div class="main-content">
        @include('layouts.navbars.navbar')
        @yield('content')
    </div>
    @guest()
        @include('layouts.footers.guest')
    @endguest
    @include('layouts.footers.footer')
    @php
    $route = Request()->getHttpHost();
    if($route=='dev.mahadsyarafulharamain.sch.id')
    {
        echo '<!-- Global site tag (gtag.js) - Google Analytics -->';
        echo '<script async src="https://www.googletagmanager.com/gtag/js?id=G-QX6WSSGQ8V"></script>';
        echo '<script>';
        echo 'window.dataLayer = window.dataLayer || [];';
        echo 'function gtag(){dataLayer.push(arguments);}';
        echo "gtag('js', new Date());";
        echo "gtag('config', 'G-QX6WSSGQ8V')";
        echo '</script>';
    }
    else
    {

        // echo '<script src="https://unpkg.com/typebot-js@2.2"></script>
        //     <script>
        //     var typebotCommands = Typebot.initBubble({
        //         url: "https://viewer.typebot.io/cs-edusis-uy769nr",
        //         button: { color: "#0042DA" },
        //     });
        //     </script>';
    }
    @endphp
</body>
</html>
