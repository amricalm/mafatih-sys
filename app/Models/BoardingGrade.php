<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoardingGrade extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    const DELETED_AT = 'don';
    protected $table = "ep_boarding_grade";
    protected $fillable = [
        'ayid', 'tid', 'activity_id', 'periode', 'grade', 'group_id', 'cby', 'uby', 'dby'
    ];
}
