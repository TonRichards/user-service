<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $current_organization_id
 */
class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'current_organization_id' => $this->current_organization_id,
            'organizations'  => $this->organizations($this->organizations),
        ];
    }

    private function organizations($organizations): array
    {
        return $organizations->map(function ($organization) {
            return [
                'organization_id' => $organization->id,
                'name' => $organization->name,
                'role' => $organization->pivot->role_id,
            ];
        })->toArray();
    }
}
