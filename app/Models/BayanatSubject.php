<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BayanatSubject extends Model
{
    // use HasFactory;
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "ep_bayanat_subject";
    protected $fillable = [
        'id',
        'name',
        'name_ar',
        'name_en',
        'weight',
        'is_deleted',
        'cby',
        'uby',
    ];
}
