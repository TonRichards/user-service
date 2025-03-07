<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PermissionCollection extends ResourceCollection
{
    public function toArray(Request $request): Collection
    {
        return $this->collection->map(function($permission) {
            return [
                'id' => $permission->id,
                'name' => $permission->name,
                'display_name' => $permission->display_name,
                'roles' => RoleResource::collection($permission->roles),
            ];
        });
    }
}
