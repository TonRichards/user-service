<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $table = 'applications';

    protected $fillable  = [
        'name',
        'display_name',
        'description'
    ];
}
