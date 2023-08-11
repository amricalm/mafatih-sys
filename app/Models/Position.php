<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "hr_position";
    protected $fillable = [
        'id', 'name', 'name_ar', 'cby', 'uby'
    ];
}
