<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Dashboard') }}</title>
    <link href="{{ asset('assets') }}/img/adn/edusis.ico" rel="icon" type="image/png">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
    <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets') }}/css/app.css" rel="stylesheet">
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

    </style>
</head>
<body>
    <header>
        <div class="collapse bg-light bg-emas" id="navbarHeader">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8 col-md-7 py-4">
                        <h4 class="maroon">Halaman ini</h4>
                        <p class="maroon">Halaman ini berisi tentang proses pendaftaran untuk menjadi Santri
                            Ma'had Syaraful Haramain. Jika ada masalah dalam pendaftaran, mohon segera menghubungi kami.
                            Bisa ke WA kami, atau ke media  kami yang lain.
                        </p>
                    </div>
                    <div class="col-sm-4 offset-md-1 py-4">
                        <h4 class="text-white">Kontak Kami</h4>
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-white">Follow on Twitter</a></li>
                            <li><a href="#" class="text-white">Like on Facebook</a></li>
                            <li><a href="#" class="text-white">Email me</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar navbar-dark bg-maroon shadow-sm">
            <div class="container d-flex justify-content-between">
                <a href="#" class="navbar-brand d-flex align-items-center">
                    <img src="{{ asset('assets/img/adn/logo-msh-versi-com-invert.png') }}" style="width: 25%;" />
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader"
                    aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </div>
    </header>

    <main role="main">

        <section class="jumbotron text-center">
            <div class="container">
                <h1>Prosesnya mudah.</h1>
                <p class="lead text-muted">Jika anda baru akan mendaftar, silahkan klik tombol untuk Pendaftaran. Sudah
                    pernah daftar, langsung klik Login.</p>
                <p>
                    <a href="{{ route('login') }}" class="btn btn-maroon my-2"><i class="fas fa-sign-in-alt"></i> Login</a>
                    <a href="{{ route('register') }}" class="btn btn-default my-2"><i class="fas fa-user-plus"></i> Daftar</a>
                </p>
            </div>
        </section>
        <div class="container">
        </div>
        </div>
        <footer style="width: 100%; height: 50px; position: absolute; bottom: 0;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center mt-2">
                        <p style="font-size: 12px;">&copy; {{ now()->year }} <a href="https://andhana.com" class="font-weight-bold"
                                target="_blank">mahadsyarafulharamain.sch.id</a></p>
                    </div>
                </div>
                {{-- <p class="float-right">
      <a href="#">Back to top</a>
    </p> --}}
                {{-- <p>Album example is &copy; Bootstrap, but please download and customize it for yourself!</p>
    <p>New to Bootstrap? <a href="/">Visit the homepage</a> or read our <a href="/docs/4.6/getting-started/introduction/">getting started guide</a>.</p> --}}
            </div>
        </footer>
        <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
        <script src="https://kit.fontawesome.com/c30c6bc0d1.js" crossorigin="anonymous"></script>
        <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>
</body>

</html>
