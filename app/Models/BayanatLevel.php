<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BayanatLevel extends Model
{
    // use HasFactory;
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "ep_bayanat_level";
    protected $fillable = [
        'id',
        'code',
        'name',
        'name_ar',
        'name_en',
        'level',
        'is_deleted',
        'cby',
        'uby',
    ];
}
