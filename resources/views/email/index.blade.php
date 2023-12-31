<!doctype html>
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.80.0">
    <title>{{ config('app.name', 'Dashboard') }}{{ (isset($judul)) ? ' - '.$judul : '' }}</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.6/examples/sticky-footer/">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <!-- Favicons -->
    <link rel="apple-touch-icon" href="/docs/4.6/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="/docs/4.6/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="/docs/4.6/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="manifest" href="/docs/4.6/assets/img/favicons/manifest.json">
    <link rel="mask-icon" href="/docs/4.6/assets/img/favicons/safari-pinned-tab.svg" color="#563d7c">
    <link rel="icon" href="/docs/4.6/assets/img/favicons/favicon.ico">
    <meta name="msapplication-config" content="/docs/4.6/assets/img/favicons/browserconfig.xml">
    <meta name="theme-color" content="#563d7c">
    <style>
        .container {
            width: auto;
            max-width: 680px;
            padding: 0 15px;
        }

        .footer {
            background-color: #f5f5f5;
        }

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
    <!-- Custom styles for this template -->
    <link href="sticky-footer.css" rel="stylesheet">
</head>
<body class="d-flex flex-column h-100">
    <!-- Begin page content -->
    <main role="main" class="flex-shrink-0">
        <div class="container">
            <div class="row">
                <div class="col-md-12 pt-3">
                    <img src="https://s3.amazonaws.com/unroll-images-production/projects%2F0%2F1633405145176-logo.png" alt="logo msh" width="300px">
                </div>
            </div>
            <hr>
            @yield('body')
            <div class="row">
                <div class="col-md-12">
                    @php
                    $text = 'Untuk Informasi dan kendala bisa <b>kontak/wa Admin EDUSIS</b> <a href="http://wa.me/6281213922553">(+62 812-1392-2553)</a>., atau <br>
                            ke <b>email kami</b> di <a href="mailto:info@mahadsyarafulharamain.com">info@mahadsyarafulharamain.com</a>.<br>
                            Terima kasih atas perhatian dan kerjasama dari Abah dan Ummah, semoga Allah selalu memberikan kebaikan buat kita semua. <br>
                            Untuk <b>prosedur pendaftaran dan agenda selanjutnya</b> nantikan email dari kami atau cek link berikut
                            <a href="https://ppdb.mahadsyarafulharamain.sch.id/prosedur" target="_blank">https://ppdb.mahadsyarafulharamain.sch.id/prosedur</a>
                            <br><br><b>Admin PPDB</b>';
                    @endphp
                    <p>
                        {!! (!empty($footeremail)) ? $footeremail : $text !!}
                    </p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
