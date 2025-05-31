<?php

return [

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'usuarios'),
    ],

    // === GUARDS ===
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'usuarios',
        ],

        'usuarios' => [ // <-- Guard adicionado aqui
            'driver' => 'session',
            'provider' => 'usuarios',
        ],

        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],

        'fornecedor' => [
            'driver' => 'session',
            'provider' => 'fornecedores',
        ],
    ],

    // === PROVIDERS ===
    'providers' => [
        'usuarios' => [
            'driver' => 'eloquent',
            'model' => App\Models\Usuario::class,
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Administrador::class,
        ],

        'fornecedores' => [
            'driver' => 'eloquent',
            'model' => App\Models\Fornecedor::class,
        ],
    ],

    // === PASSWORD RESET ===
    'passwords' => [
        'usuarios' => [
            'provider' => 'usuarios',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        'admins' => [
            'provider' => 'admins',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        'fornecedores' => [
            'provider' => 'fornecedores',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
