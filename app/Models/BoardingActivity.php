<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoardingActivity extends Model
{
    use HasFactory;
    use SoftDeletes;

    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    const DELETED_AT = 'don';
    protected $table = "ep_boarding_activity";
    protected $fillable = [
        'group_id', 'name', 'name_ar', 'type','point', 'cby', 'uby'
    ];
}
