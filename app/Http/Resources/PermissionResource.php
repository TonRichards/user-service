<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string $id
 * @property string $name
 * @property string $label_en
 * @property string $label_th
 * @property string $description_en
 * @property string $description_th
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
