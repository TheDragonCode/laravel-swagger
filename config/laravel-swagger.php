<?php

use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

return [
    'title' => env('APP_NAME'),

    'version' => '1.0',

    'routes' => 'api/',

    'servers' => [
        [
            'url' => env('APP_URL'),

            'description' => env('APP_NAME'),
        ],
    ],

    'security_schemes' => [
        /*
         * Examples of Security schemes
         */

        'api_key_security_example' => [ // Unique name of security
                                        'type'        => 'apiKey', // The type of the security scheme. Valid values are "basic", "apiKey" or "oauth2".
                                        'description' => 'A short description for security scheme',
                                        'name'        => 'api_key', // The name of the header or query parameter to be used.
                                        'in'          => 'header', // The location of the API key. Valid values are "query" or "header".
        ],

        /*
        'oauth2_security_example' => [ // Unique name of security
            'type' => 'oauth2', // The type of the security scheme. Valid values are "basic", "apiKey" or "oauth2".
            'description' => 'A short description for oauth2 security scheme.',
            'flow' => 'implicit', // The flow used by the OAuth2 security scheme. Valid values are "implicit", "password", "application" or "accessCode".
            'authorizationUrl' => 'http://example.com/auth', // The authorization URL to be used for (implicit/accessCode)
            //'tokenUrl' => 'http://example.com/auth' // The authorization URL to be used for (password/application/accessCode)
            'scopes' => [
                'read:projects' => 'read your projects',
                'write:projects' => 'modify projects in your account',
            ]
        ],
        */

        /* Open API 3.0 support
        'passport' => [ // Unique name of security
            'type' => 'oauth2', // The type of the security scheme. Valid values are "basic", "apiKey" or "oauth2".
            'description' => 'Laravel passport oauth2 security.',
            'in' => 'header',
            'scheme' => 'https',
            'flows' => [
                "password" => [
                    "authorizationUrl" => config('app.url') . '/oauth/authorize',
                    "tokenUrl" => config('app.url') . '/oauth/token',
                    "refreshUrl" => config('app.url') . '/token/refresh',
                    "scopes" => []
                ],
            ],
        ],
        */
    ],

    'tags' => [
        [
            'name'        => 'Example',
            'description' => 'Here is the tag description',
        ],
    ],

    'exceptions' => [
        405 => [
            'name'        => MethodNotAllowedHttpException::class,
            'description' => 'Method Not Allowed',
        ],

        503 => [
            'name'        => MaintenanceModeException::class,
            'description' => 'Maintenance Mode',
        ],
    ],

    'path' => storage_path('app/private'),

    'filename' => 'api',
];
