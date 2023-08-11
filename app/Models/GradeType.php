<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeType extends Model
{
    protected $table = "rf_grade_type";
    protected $fillable = [
        'seq', 'code','desc', 'desc_ar',
    ];
}
