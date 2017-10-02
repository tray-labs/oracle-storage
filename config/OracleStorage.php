<?php

return [
    'user' => [
        'username' => getenv('ORACLE_STORAGE_USERNAME'),
        'password' => getenv('ORACLE_STORAGE_PASSWORD')
    ],
    'account' => [
        'identifier' => getenv('ORACLE_STORAGE_IDENTIFIER'),
        'auth_uri' => getenv('ORACLE_STORAGE_AUTH_URI')
    ],
    'storage' => [
        'container' => getenv('ORACLE_STORAGE_CONTAINER'),
        'local_path' => getenv('ORACLE_STORAGE_LOCAL_PATH')
    ]
];