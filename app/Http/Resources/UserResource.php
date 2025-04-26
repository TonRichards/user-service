<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string $id
 * @property string $name
 * @property string $email
 */
class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'organizations'  => $this->organizations->map(fn($org) => [ // @phpstan-ignore-line
                'organization_id' => $org->id,
                'role'            => $org->pivot->role_id,
            ]),
        ];
    }
}
