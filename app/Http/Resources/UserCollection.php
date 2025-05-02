<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    public function toArray(Request $request): Collection
    {
        return $this->collection->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'organizations' => $this->organizations($user->organizations),
            ];
        });
    }

    private function organizations($organizations): array
    {
        return $organizations->map(function ($organization) {
            return [
                'id' => $organization->id,
                'name' => $organization->name,
            ];
        })->toArray();
    }
}
