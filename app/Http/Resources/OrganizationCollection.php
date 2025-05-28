<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrganizationCollection extends ResourceCollection
{
    public function toArray(Request $request): Collection
    {
        return $this->collection->map(function($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
            ];
        });
    }
}
