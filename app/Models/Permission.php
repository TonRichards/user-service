<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    use SoftDeletes, Searchable;

    protected $table = 'permissions';

    protected $fillable = [
        'name',
        'display_name',
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'permission_roles');
    }

    public function toSearchableArray()
    {
        return [
            'display_name' => $this->display_name,
        ];
    }
}
