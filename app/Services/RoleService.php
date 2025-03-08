<?php

namespace App\Services;

use App\Models\Role;
use App\Data\RoleData;
use Illuminate\Pagination\LengthAwarePaginator;

class RoleService
{
    public function model(): Role
    {
        return new Role();
    }

    public function getById(string $id): Role
    {
        return $this->model()->findOrFail($id);
    }

    public function store(array $data = []): Role
    {
        return $this->model()->create(RoleData::fromArray($data));
    }

    public function getRoles(): LengthAwarePaginator
    {
        return $this->model()
            ->where('application_id', request()->get('application_id'))
            ->paginate(request()->get('per_page', 10));
    }

    public function update(array $data = [], string $id): Role
    {
        $role = $this->getById($id);

        $role->update(RoleData::fromArray($data));

        $role->fresh();

        return $role;
    }

    public function delete(string $id): void
    {
        $role = $this->getById($id);

        $role->delete();
    }
}