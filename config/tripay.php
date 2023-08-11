<?php

return [
    'sandbox_url_payment_channel' => env('TRIPAY_URL_PAYMENT_CHANNEL'),
    'sandbox_url_create_payment' => env('TRIPAY_CREATE'),
    'sandbox_url_detail_payment' => env('TRIPAY_DETAIL'),
    'sandbox_api_key' => env('TRIPAY_API_KEY'),
    'sandbox_private_key' => env('TRIPAY_PRIVATE_KEY'),

    // 'sandbox_url_payment_channel' => env('TRIPAY_SANDBOX_URL_PAYMENT_CHANNEL'),
    // 'sandbox_url_create_payment' => env('TRIPAY_SANDBOX_CREATE'),
    // 'sandbox_url_detail_payment' => env('TRIPAY_SANDBOX_DETAIL'),
    // 'sandbox_api_key' => env('TRIPAY_SANDBOX_API_KEY'),
    // 'sandbox_private_key' => env('TRIPAY_SANDBOX_PRIVATE_KEY'),
];
