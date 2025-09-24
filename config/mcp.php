<?php

return [
    /*
    |--------------------------------------------------------------------------
    | MCP Servers
    |--------------------------------------------------------------------------
    |
    | Here you can define the MCP servers that should be available for your
    | application. Each server should have a unique handle and reference
    | the server class that implements the MCP server functionality.
    |
    */

    'servers' => [
        'onboarding' => [
            'class' => \App\Mcp\Servers\OnboardingServer::class,
            'name' => 'Pilates Studio Onboarding Server',
            'description' => 'Provides access to onboarding functionality and testing tools for the Pilates Studio Management System.',
            'version' => '1.0.0',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Server
    |--------------------------------------------------------------------------
    |
    | The default MCP server to use when no specific server is requested.
    |
    */

    'default' => 'onboarding',

    /*
    |--------------------------------------------------------------------------
    | Server Settings
    |--------------------------------------------------------------------------
    |
    | Global settings for MCP servers.
    |
    */

    'settings' => [
        'timeout' => 30,
        'max_connections' => 10,
        'debug' => env('MCP_DEBUG', false),
    ],
];
