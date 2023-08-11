<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYearDetail extends Model
{
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "aa_academic_year_detail";
    protected $fillable = [
        'id', 'ayid','tid','mid_exam_date','hijri_mid_exam_date','publish_mid_exam','final_exam_date','hijri_final_exam_date','publish_final_exam', 'cby', 'uby'
    ];
}
