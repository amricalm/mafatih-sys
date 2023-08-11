<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardingGradeDtl extends Model
{
    use HasFactory;
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "ep_boarding_grade_dtl";
    protected $fillable = [
        'bgid', 'sid', 'ayid', 'tid', 'score', 'remission','cby', 'uby'
    ];
}
