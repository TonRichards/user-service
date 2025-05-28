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
        'application_id',
        'organization_id',
    ];

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'permission_roles');
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function toSearchableArray()
    {
        return [
            'display_name' => $this->display_name,
            'application_id' => $this->application_id,
            'organization_id' => $this->organization_id,
        ];
    }
}
