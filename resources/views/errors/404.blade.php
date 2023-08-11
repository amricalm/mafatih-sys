<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Error {{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link type="text/css" href="{{ asset('assets') }}/css/app.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5 pt-5">
        <div class="alert alert-danger text-center">
            <img src="{{ asset('assets/img/adn/logo.png') }}" style="width:200px;" alt="">
            <h2 class="display-3">404</h2>
            <p class="display-5">Halaman yang anda kunjungi <b>tidak ada atau sedang dalam pengembangan</b>.</p>
            <p class="display-5"><a class="btn btn-danger" href="{{ url('home') }}"><i class="fa fa-undo"></i> Kembali</a></p>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/c30c6bc0d1.js" crossorigin="anonymous"></script>
</body>
</html>
