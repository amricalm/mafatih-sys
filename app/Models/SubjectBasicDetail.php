<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectBasicDetail extends Model
{
    use HasFactory;
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "ep_subject_basic_dtl";
    protected $fillable = [
        'subject_basic_id', 'subject_id', 'cby', 'uby'
    ];
}
