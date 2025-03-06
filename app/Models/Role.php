<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Role extends Model
{
    use SoftDeletes;

    protected $table = 'roles';

    protected $fillable = [
        'name',
        'description',
        'application_id',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
