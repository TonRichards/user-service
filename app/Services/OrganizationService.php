<?php

namespace App\Services;

use App\Models\Organization;

class OrganizationService
{
    public function upsert(array $data): Organization
    {
        return Organization::updateOrCreate([
            'name' => $data['name'],
        ], [
            'name' => $data['name'],
        ]);
    }
}