<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StudentPassed extends Model
{
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "aa_student_passed";
    protected $fillable = [
        'id','ayid', 'pid', 'nis', 'nisn', 'status', 'school_destination', 'desc','cby', 'uby'
    ];
}
