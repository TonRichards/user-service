<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use SoftDeletes, Searchable;

    protected $table = 'roles';

    protected $fillable = [
        'name',
        'display_name',
    ];

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'permission_roles');
    }

    public function toSearchableArray()
    {
        return [
            'display_name' => $this->display_name,
        ];
    }
}
