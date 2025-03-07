<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RoleCollection extends ResourceCollection
{
    public function toArray(Request $request): Collection
    {
        return $this->collection->map(function ($role) {
            return [
                'name' => $role->name,
                'display_name' => $role->display_name,
            ];
        });
    }
}
