<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardingActivityNonActive extends Model
{
    use HasFactory;

    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';

    protected $table = "ep_boarding_activity_nonactive";
    protected $fillable = [
        'ayid', 'tid', 'activity_id', 'desc', 'cby', 'uby'
    ];
}
