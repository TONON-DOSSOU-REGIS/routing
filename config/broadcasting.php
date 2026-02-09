<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Broadcaster
    |--------------------------------------------------------------------------
    */
    'default' => env('BROADCAST_CONNECTION', 'log'),

    /*
    |--------------------------------------------------------------------------
    | Broadcast Connections
    |--------------------------------------------------------------------------
    */
    'connections' => [
        'pusher' => [
            'driver' => 'pusher',
            'key' => env('PUSHER_APP_KEY'),
            'secret' => env('PUSHER_APP_SECRET'),
            'app_id' => env('PUSHER_APP_ID'),
            'options' => (function () {
                $options = [
                    'cluster' => env('PUSHER_APP_CLUSTER', 'mt1'),
                    'useTLS' => env('PUSHER_SCHEME', 'https') === 'https',
                    'encrypted' => true,
                ];

                $host = env('PUSHER_HOST');
                if (!empty($host)) {
                    $options['host'] = $host;
                }

                $port = env('PUSHER_PORT');
                if (!empty($port)) {
                    $options['port'] = $port;
                }

                $scheme = env('PUSHER_SCHEME');
                if (!empty($scheme)) {
                    $options['scheme'] = $scheme;
                }

                return $options;
            })(),
        ],

        'log' => [
            'driver' => 'log',
        ],

        'null' => [
            'driver' => 'null',
        ],
    ],

];
