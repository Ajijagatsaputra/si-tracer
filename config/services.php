<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'whatsapp' => [
        'gateway_url' => env('WHATSAPP_GATEWAY_URL', 'https://api.whatsapp.com/send'),
        'api_key' => env('WHATSAPP_API_KEY', ''),
        'instance_id' => env('WHATSAPP_INSTANCE_ID', ''),
        'access_token' => env('WHATSAPP_ACCESS_TOKEN', ''),
    ],

    'gowa' => [
        'api_url' => env('GOWA_API_URL', 'https://blast.withmangg.web.id/send/message'),
        'username' => env('GOWA_USERNAME', 'user1'),
        'password' => env('GOWA_PASSWORD', 'pass1'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

];
