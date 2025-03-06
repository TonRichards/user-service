<?php

namespace App\Services;

use App\Models\Application;
use App\Data\ApplicationData;
use Illuminate\Database\Eloquent\Collection;

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

    public function getApplications(): Collection
    {
        return $this->model()->get();
    }

    public function getApplication($id): Application
    {
        return $this->model()->where('id', $id)->first();
    }
}