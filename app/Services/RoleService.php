<?php

namespace App\Services;

use App\Models\Role;
use App\Data\RoleData;

class RoleService
{
    public function model(): Role
    {
        return new Role();
    }

    public function store($data = []): Role
    {
        return $this->model()->create(RoleData::fromArray($data));
    }
}