<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sibling extends Model
{
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "aa_sibling";
    protected $fillable = [
        'pid',
        'sid',
        'cby',
        'uby',
    ];
    public function Person()
    {
        return $this->belongsTo(Person::class,'pid')->withDefault;
    }
}
