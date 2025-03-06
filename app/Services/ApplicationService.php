<?php

namespace App\Services;

use App\Models\Application;
use App\Data\ApplicationData;

class ApplicationService
{
    public function model(): Application
    {
        return new Application();
    }

    public function store($data = []): Application
    {
        return $this->model()->create(ApplicationData::fromArray($data));
    }
}