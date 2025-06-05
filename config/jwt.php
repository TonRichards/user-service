<?php

return [
    'secret' => env('JWT_SECRET'),
    'issuer' => env('JWT_ISSUER', 'user_service'),
    'ttl' => env('JWT_TTL', 3600),
];