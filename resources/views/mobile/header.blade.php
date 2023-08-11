<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
<meta name="description" content="Dashboard Guru">
<meta name="author" content="Andhana Web And Software Developer">
<meta name="generator" content="EDUSIS - Andhana">
<title>{{ config('app.name', 'Dashboard') }}{{ (isset($judul)) ? ' - '.$judul : '' }}</title>
<meta name="apple-mobile-web-app-capable" content="yes">
<link rel="manifest" href="manifest.json" />
<link rel="apple-touch-icon" href="{{ asset('assets/img/edusis.ico') }}" sizes="180x180">
<link rel="icon" href="{{ asset('assets/img/adn/edusis.ico') }}" sizes="32x32" type="image/png">
<link rel="icon" href="{{ asset('assets/img/adn/edusis.ico') }}" sizes="16x16" type="image/png">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
<link href="{{ asset('mobile') }}/vendor/swiper/css/swiper.min.css" rel="stylesheet">
<link href="{{ asset('mobile') }}/css/style.css" rel="stylesheet" id="style">
<link href="{{ asset('mobile') }}/css/style-purple.css" rel="stylesheet" id="style">
<link href="{{ asset('mobile') }}/css/style-custom.css" rel="stylesheet" id="style">
<link type="text/css" href="{{ asset('assets') }}/css/app.css" rel="stylesheet">
@stack('header')
