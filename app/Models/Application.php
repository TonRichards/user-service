<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Application extends Model
{
    use SoftDeletes, HasUlids, Searchable;

    protected $table = 'applications';

    protected $fillable  = [
        'name',
        'display_name',
    ];

    public function roles(): HasMany
    {
        return $this->hasMany(Role::class);
    }

    public function toSearchableArray()
    {
        return [
            'display_name' => $this->display_name,
        ];
    }
}
