<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsConfig extends Model
{
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "ms_configs";
    protected $fillable = [
        'id', 'config_name', 'config_value', 'aktif',
    ];
}
