<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Organization extends Model
{
    use HasUlids;

    protected $table = 'organizations';

    protected $fillable  = [
        'name',
        'email',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_organizations')
            ->withPivot('role_id')
            ->withTimestamps();
    }

    public function roles(): HasMany
    {
        return $this->hasMany(Role::class, 'organization_id');
    }
}
