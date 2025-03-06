<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Application extends Model
{
    protected $table = 'applications';

    protected $fillable  = [
        'name',
        'display_name',
        'description'
    ];

    public function roles(): HasMany
    {
        return $this->hasMany(Role::class);
    }
}
