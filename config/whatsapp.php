<?php

return [
    /*
    |--------------------------------------------------------------------------
    | WhatsApp Gateway Configuration
    |--------------------------------------------------------------------------
    |
    | Konfigurasi untuk WhatsApp Gateway yang digunakan untuk mengirim
    | notifikasi otomatis kepada alumni yang mengisi kuesioner.
    |
    */

    'default' => env('WHATSAPP_DRIVER', 'gowa'),

    'drivers' => [
        'fonnte' => [
            'gateway_url' => env('FONNTE_GATEWAY_URL', 'https://api.fonnte.com/send'),
            'api_key' => env('FONNTE_API_KEY', ''),
            'device_id' => env('FONNTE_DEVICE_ID', ''),
        ],

        'wablas' => [
            'gateway_url' => env('WABLAS_GATEWAY_URL', 'https://domain.wablas.com/api/send-message'),
            'api_key' => env('WABLAS_API_KEY', ''),
        ],

        'waweb' => [
            'gateway_url' => env('WAWEB_GATEWAY_URL', 'https://api.waweb.com/send'),
            'api_key' => env('WAWEB_API_KEY', ''),
            'instance_id' => env('WAWEB_INSTANCE_ID', ''),
        ],

        'gowa' => [
            'gateway_url' => env('GOWA_API_URL', 'https://blast.withmangg.web.id/send/message'),
            'username' => env('GOWA_USERNAME', 'user1'),
            'password' => env('GOWA_PASSWORD', 'pass1'),
            'method' => 'POST',
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ],

        'custom' => [
            'gateway_url' => env('WHATSAPP_GATEWAY_URL', ''),
            'api_key' => env('WHATSAPP_API_KEY', ''),
            'additional_headers' => [
                'Authorization' => 'Bearer ' . env('WHATSAPP_ACCESS_TOKEN', ''),
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Message Template
    |--------------------------------------------------------------------------
    |
    | Template pesan default yang akan dikirim melalui WhatsApp
    |
    */

    'message_template' => [
        'greeting' => 'Halo {nama}! 👋',
        'thank_you' => 'Terima kasih telah mengisi kuesioner Tracer Study Politeknik Harapan Bersama. 📋',
        'confirmation' => 'Data Anda telah berhasil disimpan dan akan digunakan untuk pengembangan kampus.',
        'details' => "Detail pengisian:\n• Nama: {nama}\n• Perusahaan: {perusahaan}\n• Tanggal: {tanggal}",
        'footer' => "Salam,\nTim Tracer Study\nPoliteknik Harapan Bersama 📚",
    ],

    /*
    |--------------------------------------------------------------------------
    | Retry Configuration
    |--------------------------------------------------------------------------
    |
    | Konfigurasi untuk retry jika pengiriman gagal
    |
    */

    'retry' => [
        'attempts' => env('WHATSAPP_RETRY_ATTEMPTS', 3),
        'delay' => env('WHATSAPP_RETRY_DELAY', 5), // dalam detik
    ],

    /*
    |--------------------------------------------------------------------------
    | Timeout Configuration
    |--------------------------------------------------------------------------
    |
    | Konfigurasi timeout untuk request ke gateway
    |
    */

    'timeout' => [
        'request' => env('WHATSAPP_REQUEST_TIMEOUT', 30), // dalam detik
        'response' => env('WHATSAPP_RESPONSE_TIMEOUT', 10), // dalam detik
    ],
];
