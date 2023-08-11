    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Dashboard') }}{{ (isset($judul)) ? ' - '.$judul : '' }}</title>
    <link href="{{ asset('assets') }}/img/adn/edusis.ico" rel="icon" type="image/png">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets') }}/css/app.css" rel="stylesheet">
    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" defer></script>
    <script>
        window.OneSignal = window.OneSignal || [];
        OneSignal.push(function() {
            OneSignal.init({
            appId: "958cae7b-d222-450d-92bf-654269636fa0",
            safari_web_id: "web.onesignal.auto.28be2e0f-48c0-43fd-877a-95cc3c6fc0d9",
            notifyButton: {
                enable: true,
            },
            });
        });
    </script>
    @stack('css')
    @stack('header')
