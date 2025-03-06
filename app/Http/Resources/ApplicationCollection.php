<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ApplicationCollection extends ResourceCollection
{
    public function toArray(Request $request): Collection
    {
        return $this->collection->map(function ($application) {
            return [
                'id' => $application->id,
                'name' => $application->name,
                'display_name' => $application->display_name,
                'description' => $application->description,
                'roles' => $application->roles()->count(),
            ];
        });
    }
}
