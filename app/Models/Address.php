<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    // use HasFactory;
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "aa_address";
    protected $fillable = [
        'pid',
        'type',
        'address',
        'province',
        'city',
        'district',
        'village',
        'post_code',
        'latitude',
        'longitude',
        'cby',
        'uby',
    ];

    // public function Person()
    // {
    // 	return $this->belongsTo(Person::class,'pid');
    // }
}
