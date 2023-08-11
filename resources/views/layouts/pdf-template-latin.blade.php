<!DOCTYPE html>
<html>

<head>
    {{-- <meta charset="utf-8" /> --}}
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" media="screen,projection" type="text/css" href="{{ url('/asset/css/cetak.css') }}" />
    <link rel="stylesheet" media="screen,projection" type="text/css" href="{{ url('/asset/css/print.css') }}" />

    <title>{{ $judul }}</title>
    <style>
        body {
            font-family: 'sakkalmajalla', sans-serif;
        }

        .arabic{
            font-size:24px !important;
            direction: rtl;
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
            background-size: 170px 223px;
            margin-left: 10px;
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
        <table cellpadding="0" cellspacing="0" {!! (isset($styleheader)) ? $styleheader : '' !!}>
            <tr class="top">
                <td colspan="2">
                    @yield('header')
                </td>
            </tr>
        </table>
        @yield('isi')
    </div>
</body>

</html>
