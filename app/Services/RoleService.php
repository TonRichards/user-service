<?php

namespace App\Services;

use App\Models\Role;
use App\Data\RoleData;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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

    public function getRoles(Request $request): LengthAwarePaginator
    {
        $search = $request->get('q', '*');
        $orderBy = $request->get('order');
        $perPage = $request->get('per_page', 10);
        $sortBy = $request->get('sort', 'created_at');
        $applicationId = $request->get('application_id');

        $query = $this->model()
            ->search($search)
            ->orderBy($sortBy, $orderBy);

        if ($applicationId) {
            $query = $query->where('application_id', $applicationId);
        }

        return $query->paginate($perPage);
    }

    public function update(string $id, array $data = []): Role
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