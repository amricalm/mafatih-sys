<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrComponentPosition extends Model
{
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "hr_component_position";
    protected $fillable = [
        'component_id',
        'position_id',
        'duration_min',
        'score',
        'is_mandatory',
        'is_overtime',
        'cby',
        'uby',
    ];

}
