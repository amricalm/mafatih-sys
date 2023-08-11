<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BayanatWeight extends Model
{
    // use HasFactory;
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "ep_bayanat_weight";
    protected $fillable = [
        'id',
        'name',
        'name_ar',
        'name_en',
        'weight',
        'is_group',
        'is_deleted',
        'cby',
        'uby',
    ];
}
