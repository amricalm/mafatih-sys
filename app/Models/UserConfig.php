<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserConfig extends Model
{
    public $timestamps = false;
    protected $table = "users_config";
    protected $fillable = [
        'uid',
        'ayid',
        'tid',
        'date_change',
    ];
}
