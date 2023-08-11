<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpdbSet extends Model
{
    // use HasFactory;
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "aa_ppdb_set";
    protected $fillable = [
        'url',
        'ayid',
        'name',
        'desc',
        'start_date',
        'end_date',
        'thumbnail',
        'header',
        'body',
        'footer',
        'hit',
        'cby',
        'uby',
    ];
}
