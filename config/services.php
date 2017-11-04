<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => 'sandboxbb8e413a88e146bb86305c080843c716.mailgun.org',
        // 'domain' => env('MAILGUN_DOMAIN'),
        'secret' => 'key-08da69511e32339b2300b77870130ccd',
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('7583b96350921758c202e77b9ad1a6bff3215ca3'),
        // 'secret' => env('MAIL_PASSWORD', '7583b96350921758c202e77b9ad1a6bff3215ca3'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

];
