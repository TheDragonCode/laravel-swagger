<?php

use App\Http\Middleware\PreventRequestsDuringMaintenance;
use Helldar\LaravelSwagger\Models\Properties\Integer_;
use Helldar\LaravelSwagger\Models\Properties\String_;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

return [
    /*
     * Documentation title.
     */

    'title' => env('APP_NAME', 'Laravel'),

    /*
     * Documentation version.
     */

    'version' => '1.0',

    /*
     * The following are the options for defining routes for generating documentation.
     */

    'routes' => [

        /*
         * Add routes to the documentation starting with the specified path.
         *
         * To add all routes, specify '*'.
         */

        'uri' => 'api/',

        /*
         * Rules for hiding routes from a selection.
         */

        'hide' => [

            /*
             * Hide the following methods when generating documentation.
             */
            'methods' => ['head'],

            /*
             * Hide routes that meet the following conditions:
             */

            'matching' => [
                '#^_debugbar#',
                '#^_ignition#',
                '#^telescope#',
            ],
        ],
    ],

    /*
     * List of server addresses on which API is located.
     */

    'servers' => [
        [
            'url' => env('APP_URL'),

            'description' => env('APP_NAME'),
        ],
    ],

    /*
     * List of security schemes.
     */

    'security' => [
        'schemes' => [
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

        'base' => [
            /*
             * Examples of Security
             */

            /*
            'oauth2_security_example' => [
                'read',
                'write'
            ],
            'passport' => []
            */
        ],
    ],

    /*
     * A list of possible exceptions that occur during the operation of each route.
     */

    'exceptions' => [
        MethodNotAllowedHttpException::class => [
            'code'        => 405,
            'description' => 'Method Not Allowed',
        ],

        PreventRequestsDuringMaintenance::class => [
            'code'        => 503,
            'description' => 'Maintenance Mode',
        ],
    ],

    /*
     * The path to save the generated documentation files.
     */

    'path' => storage_path('app/private'),

    /*
     * The prefix of the file name when generating documentation.
     *
     * The final file name will be "X-Y.Z", where:
     *   X - file name prefix
     *   Y - API version
     *   Z - file extension (json or yaml).
     *
     * For example:
     *   filename = api
     *   version = 1.2
     *   // api.1.2.json
     *   // api.1.2.yaml
     */

    'filename' => 'api',

    'schema' => [
        'properties' => [
            'foo' => String_::class,
            'bar' => Integer_::class,
        ],
    ],
];
