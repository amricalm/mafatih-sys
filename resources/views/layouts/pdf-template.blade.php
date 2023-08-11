<!DOCTYPE html>
<html>

<head>
    {{-- <meta charset="utf-8" /> --}}
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $judul }}</title>
    <style>
        /*
        * Font Majalla
        */
        @font-face {
            font-family: 'sakkala';
            src: url('/assets/fonts/Sakkal-Majalla-Regular.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        body {
            font-family: 'sakkala', sans-serif;
        }

        .arabic{
            font-size:20px !important;
            direction: rtl;
        }

        table, th, td {
            border: 1px solid;
            border-collapse: collapse;
        }

        table .sub-table {
            border: 2px solid white;
            width: 100%;
            margin: -3.3px;
        }
        table .sub-table td {
            border: 1px solid black;
        }

        .text-align-left
        {
            text-align: left;
        }
        .text-align-center
        {
            text-align: center;
        }

        .text-align-right
        {
            text-align: right;
        }

        #logo {
            position: absolute;
            background-image: url('/assets/img/adn/logo-msh-emas.png');
            background-repeat: no-repeat;
            background-size: 290px 290px;
            top: 10px;
        }

        #watermark {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: url('/assets/img/adn/logo-msh-watermark.png');
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            z-index: -1;
            background-size: 1180px 1180px;
        }

        #ttdkepsek {
            position: absolute;
            background-image: url('/assets/img/adn/logo-msh-emas.png');
            background-repeat: no-repeat;
            background-size: 290px 290px;
            top: 10px;
        }

        #stempel {
            background-image: url('/assets/img/adn/logo-msh-emas.png');
            background-repeat: no-repeat;
            background-size: 170px 223px;
            background-origin: content-box;
            z-index: 999;
        }

        .ttd{
            position: absolute;
            left: 0px;
            top: 0px;
            z-index: 1;
        }
    </style>
</head>
<body>
    <div>
        @yield('isi')
    </div>
</body>

</html>
