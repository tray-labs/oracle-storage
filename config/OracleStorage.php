<?php

return [
    'user' => [
        'username' => env('ORACLE_STORAGE_USERNAME'),
        'password' => env('ORACLE_STORAGE_PASSWORD')
    ],
    'account' => [
        'identifier' => env('ORACLE_STORAGE_IDENTIFIER'),
        'auth_uri' => env('ORACLE_STORAGE_AUTH_URI')
    ],
    'storage' => [
        'container' => env('ORACLE_STORAGE_CONTAINER'),
        'local_path' => env('ORACLE_STORAGE_LOCAL_PATH')
    ]
];