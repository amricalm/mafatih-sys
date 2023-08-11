<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardingGradePredicate extends Model
{
    use HasFactory;
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "ep_boarding_grade_predicate";
    protected $fillable = [
        'bgid', 'sid', 'ayid', 'tid', 'activity_id', 'predicate','cby', 'uby'
    ];
}
