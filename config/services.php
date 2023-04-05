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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'google' => [
        'client_id' => '791547908121-las95s3oms97d2oi1umks72l3vk6fg4v.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'http://127.0.0.1:8000/callback/google',
    ],

    'facebook' => [
        'client_id' => '957150998804351',
        'client_secret' => '9112fe027e119c8eece0bf78a7048fd0',
        'redirect' => 'http://127.0.0.1:8000/callback/facebook',
    ],
];
