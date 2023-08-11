<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>404 Custom Error Page Example</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5 pt-5">
        <div class="alert alert-danger text-center">
            <img src="{{ asset('assets/img/adn/logo.png') }}" style="width:200px;" alt="">
            <h2 class="display-3">403</h2>
            <p class="display-5">Anda tidak diperkenankan mengunjungi halaman ini.</p>
            <p class="display-5"><button class="btn btn-danger" onclick="window.location.href='{{ url('home') }}'"><i class="fa fa-undo"></i> Kembali</button></p>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/c30c6bc0d1.js" crossorigin="anonymous"></script>
</body>
</html>
