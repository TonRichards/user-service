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
                'label_en' => $permission->label_en,
                'label_th' => $permission->label_th,
                'description_en' => $permission->description_en,
                'description_th' => $permission->description_th,
                'roles' => RoleResource::collection($permission->roles),
            ];
        });
    }
}
