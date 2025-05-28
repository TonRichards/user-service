<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class RoleData extends Data
{
    public function __construct(
        public string $name,
        public string $display_name,
        public string $application_id,
        public string $organization_id,
    ) {}

    public static function fromArray(array $data): array
    {
        return [
            'name' => $data['name'],
            'display_name' => $data['display_name'],
            'application_id' => $data['application_id'],
            'organization_id' => $data['organization_id'],
        ];
    }
}