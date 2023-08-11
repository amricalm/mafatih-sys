<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoardingNote extends Model
{
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "ep_boarding_note";
    protected $fillable = [
        'ayid',
        'tid',
        'eid',
        'sid',
        'note',
        'cby',
        'uby',
    ];
}
