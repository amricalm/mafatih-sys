<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseSubjectTeacher extends Model
{
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "ep_course_subject_teacher";
    protected $fillable = [
        'level',
        'subject_id',
        'ayid',
        'tid',
        'ccid',
        'eid',
        'cby',
        'uby',
    ];
}
