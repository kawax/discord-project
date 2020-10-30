<?php

use CharlotteDunois\Yasmin\WebSocket\WSManager;

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
        'domain'   => env('MAILGUN_DOMAIN'),
        'secret'   => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model'   => App\Model\User::class,
        'key'     => env('STRIPE_KEY'),
        'secret'  => env('STRIPE_SECRET'),
        'webhook' => [
            'secret'    => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],

    'discord' => [
        'token'           => env('DISCORD_BOT_TOKEN'),
        'channel'         => env('DISCORD_CHANNEL'),
        'guild'           => (int) env('DISCORD_GUILD'),
        'bot'             => (int) env('DISCORD_BOT_ID'),
        'admin'           => (int) env('DISCORD_ADMIN_ID'),
        'private'         => (int) env('DISCORD_PRIVATE'),
        'role'            => (int) env('DISCORD_ROLE'),
        'laravel_channel' => (int) env('DISCORD_LARAVEL_CHANNEL'),

        'prefix'    => '/',
        'not_found' => 'Command Not Found!',
        'path'      => [
            'commands' => app_path('Discord/Commands'),
            'directs'  => app_path('Discord/Directs'),
        ],
        'yasmin'    => [
            'ws.disabledEvents' => [
                'TYPING_START',
            ],
            'intents'           => WSManager::GATEWAY_INTENTS['GUILD_MESSAGES'] + WSManager::GATEWAY_INTENTS['GUILD_MESSAGE_REACTIONS'] + WSManager::GATEWAY_INTENTS['DIRECT_MESSAGES'] + WSManager::GATEWAY_INTENTS['DIRECT_MESSAGE_REACTIONS'],
        ],
    ],

];
