<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectBasic extends Model
{
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "ep_subject_basic";
    protected $fillable = [
        'ayid', 'level', 'name_group', 'name_group_ar', 'cby', 'uby'
    ];
}
