<?php

namespace App\Data;

use App\Models\User;
use Spatie\LaravelData\Data;

class UserData extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public string $application_id,
        public ?string $password = null,
    ) {}

    public static function fromArray(array $data): array
    {
        return [
            'name' => $data['name'],
            'email' => $data['email'],
            'application_id' => $data['application_id'],
            'password' => isset($data['password']) ? bcrypt($data['password']) : null,
        ];
    }
}
