<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SchoolOrigin extends Model
{
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "aa_school_origin";
    protected $fillable = [
        'pid', 'nis', 'school_origin', 'school_origin_name', 'diploma_number', 'diploma_year', 'exam_number', 'skhu', 'study_year', 'school_origin_tf', 'move_date', 'from_class', 'in_class', 'received_date', 'cby', 'uby'
    ];
}
