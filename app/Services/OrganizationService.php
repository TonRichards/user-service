<?php

namespace App\Services;

use App\Models\Organization;

class OrganizationService
{
    public function getById(string $id): ?Organization
    {
        return Organization::findOrFail($id);
    }

    public function upsert(array $data): Organization
    {
        return Organization::updateOrCreate([
            'name' => $data['name'],
        ], [
            'name' => $data['name'],
        ]);
    }

    public function store(array $data): Organization
    {
        return Organization::create(['name' => $data['name']]);
    }

    public function update(string $id, array $data): Organization
    {
        $organization = $this->getById($id);

        $organization->update($data);

        return $organization->fresh();
    }

    public function destroy(string $id): void
    {
        $organization = $this->getById($id);

        $organization->users()->detach();

        $organization->roles()->delete();

        $organization->delete();
    }
}