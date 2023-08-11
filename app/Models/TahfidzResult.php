<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TahfidzResult extends Model
{
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "ep_tahfidz_result";
    protected $fillable = [
        'id', 'ccid', 'ayid', 'tid', 'date', 'page', 'line', 'cby', 'uby'
    ];
}
