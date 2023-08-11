<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MainDuties extends Model
{
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "aa_main_duties";
    protected $fillable = [
        'id', 'hrpid', 'desc', 'cby', 'uby'
    ];
}
