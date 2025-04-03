<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string $id
 * @property string $name
 * @property string $display_name
 */
class PermissionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'label_en' => $this->label_en,
            'label_th' => $this->label_th,
            'description_en' => $this->description_en,
            'description_th' => $this->description_th,
            'roles' => RoleResource::collection($this->roles), // @phpstan-ignore-line
        ];
    }
}
