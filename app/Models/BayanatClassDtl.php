<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BayanatClassDtl extends Model
{
    // use HasFactory;
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "ep_bayanat_class_dtl";
    protected $fillable = [
        'ccid',
        'sid',
        'ayid',
        'tid',
        'cby',
        'uby',
    ];
}
