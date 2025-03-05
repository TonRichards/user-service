<?php

namespace App\Data;

use App\Models\User;
use Spatie\LaravelData\Data;

class RoleData extends Data
{
    public function __construct(
        public string $name,
        public string $description,
        public integer $application_id,
    ) {}

    public static function fromArray(array $data): array
    {
        return [
            'name' => $data['name'],
            'description' => $data['description'],
            'application_id' => $data['application_id'],
        ];
    }
}