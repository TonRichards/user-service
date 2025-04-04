<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class PermissionData Extends Data
{
    public function __construct(
        public string $name,
        public string $label_en,
    ) {}

    public static function fromArray(array $data = []): array
    {
        return [
            'name' => $data['name'],
            'label_en' => $data['label_en'] ?? null,
            'label_th' => $data['label_th'] ?? null,
            'description_en' => $data['description_en'] ?? null,
            'description_th' => $data['description_th'] ?? null,
        ];
    }
}