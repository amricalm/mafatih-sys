<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseClass extends Model
{
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "ep_course_class";
    protected $fillable = [
        'ayid', 'name', 'name_ar', 'name_en', 'level', 'active', 'cby', 'uby'
    ];
}
