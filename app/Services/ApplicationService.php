<?php

namespace App\Services;

use App\Models\Application;
use Illuminate\Http\Request;
use App\Data\ApplicationData;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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

    public function getApplications(Request $request): LengthAwarePaginator
    {
        $search = $request->get('q', '*');
        $sortBy = $request->get('sort', 'created_at');
        $orderBy = $request->get('order', 'desc');
        $perPage = $request->get('per_page', 10);

        return $this->model()
            ->search($search)
            ->orderBy($sortBy, $orderBy)
            ->paginate($perPage);
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