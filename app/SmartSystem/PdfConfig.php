<?php

namespace App\SmartSystem;

use Illuminate\Database\Eloquent\Model;

class PdfConfig extends Model
{
    public static function config()
    {
        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];
        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];
        $mpdfconf = [
            'fontDir' => array_merge($fontDirs, [
                public_path() . '/assets/fonts',
            ]),
            'fontdata' => $fontData + [
                'sakkala' => [
                    'R' => 'Sakkal-Majalla-Regular.ttf',
                    'B' => 'majallab.ttf',
                    'useOTL' => 0xFF,
                    'useKashida' => 75,
                ]
            ],
            'default_font' => 'sakkala'
        ];

        return $mpdfconf;
    }
}
