<?php

return [
    'secret' => env('JWT_SECRET'),
    'issuer' => env('JWT_ISSUER', 'user_service'),
    'ttl' => env('JWT_TTL', 3600),

    'public_key' => file_get_contents(base_path(env('JWT_PUBLIC_KEY_PATH'))),
    'private_key' => file_get_contents(base_path(env('JWT_PRIVATE_KEY_PATH'))),
    'algorithm' => env('JWT_ALGO', 'RS256')
];