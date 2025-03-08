<?php

namespace App\Services;

use App\Models\Application;
use App\Data\ApplicationData;
use Illuminate\Pagination\LengthAwarePaginator;

class ApplicationService
{
    public function model(): Application
    {
        return new Application();
    }

    public function store(array $data = []): Application
    {
        return $this->model()->create(ApplicationData::fromArray($data));
    }

    public function getApplications(): LengthAwarePaginator
    {
        return $this->model()->paginate(request()->query('per_page', 10));
    }

    public function getById(string $id): Application
    {
        return $this->model()->where('id', $id)->firstOrFail();
    }

    public function update(array $data, string $id): Application
    {
        $application = $this->getById($id);

        $application->update(ApplicationData::fromArray($data));

        $application->fresh();

        return $application;
    }

    public function delete(string $id): void
    {
        $application = $this->getById($id);

        $application->roles()->delete();

        $application->delete();
    }
}