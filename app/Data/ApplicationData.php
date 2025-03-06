<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class ApplicationData extends Data
{
    public function __construct(
        public string $name,
        public string $display_name,
        public string $description,
    ) {}

    public static function fromArray(array $data): array
    {
        return [
            'name' => $data['name'],
            'display_name' => $data['display_name'] ?? null,
            'description' => $data['description'] ?? null,
        ];
    }
}