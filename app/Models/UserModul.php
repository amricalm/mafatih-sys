<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModul extends Model
{
    public $timestamps = false;
    protected $table = "users_modul";
    protected $fillable = [
        'uid',
        'modul_id',
    ];
}
