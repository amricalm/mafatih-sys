<?php

return [
    'mode'                     => '',
    'format'                   => 'A4',
    'default_font_size'        => '12',
    'default_font'             => 'sans-serif',
    'margin_left'              => 18,
    'margin_right'             => 18,
    'margin_top'               => 18,
    'margin_bottom'            => 18,
    'margin_header'            => 0,
    'margin_footer'            => 0,
    'orientation'              => 'P',
    'title'                    => 'Laravel mPDF',
    'subject'                  => '',
    'author'                   => '',
    'watermark'                => '',
    'show_watermark'           => false,
    'show_watermark_image'     => false,
    'watermark_font'           => 'sans-serif',
    'display_mode'             => 'default',
    'watermark_text_alpha'     => 0.1,
    'watermark_image_path'     => '/assets/img/adn/logo-msh-emas.png',
    'watermark_image_alpha'    => 0.2,
    'watermark_image_size'     => 'D',
    'watermark_image_position' => 'P',
    'custom_font_dir'          => base_path('public/assets/fonts/'), // don't forget the trailing slash!
    'custom_font_data'         => [
                                    'sakkalmajalla' => [
                                        'R'  => 'Sakkal-Majalla-Regular.ttf',    // regular font
                                        'B'  => 'majallab.ttf',    // bold font
                                        'useOTL' => 0xFF,
                                        'useKashida' => 75,
                                    ]
                                  ],
    'auto_language_detection'  => false,
    'temp_dir'                 => rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR),
    'pdfa'                     => false,
    'pdfaauto'                 => false,
    'use_active_forms'         => false,

];
