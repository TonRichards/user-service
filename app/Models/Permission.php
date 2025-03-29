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
        'label_en',
        'label_th',
        'description_en',
        'description_th',
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'permission_roles');
    }

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'label_en' => $this->label_en,
            'label_th' => $this->label_th,
            'description_en' => $this->description_en,
            'description_th' => $this->description_th,
        ];
    }
}
