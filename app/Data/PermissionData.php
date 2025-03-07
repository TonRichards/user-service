<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class PermissionData Extends Data
{
    public function __construct(
        public string $name,
        public string $display_name,
    ) {}

    public static function fromArray(array $data = []): array
    {
        return [
            'name' => $data['name'],
            'display_name' => $data['display_name'] ?? null,
        ];
    }
}