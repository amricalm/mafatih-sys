<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ppdb extends Model
{
    // use HasFactory;
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "aa_ppdb";
    protected $fillable = [
        'registration_id',
        'nisn',
        'pid',
        'school_id',
        'academic_year_id',
        'process',
        'is_notif_regis',
        'is_notif_complete', 'cby', 'uby'
    ];
}
