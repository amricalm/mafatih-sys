<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RfModul extends Model
{
    public $timestamps = false;
    protected $table = "rf_modul";
    protected $fillable = [
        'name',
        'desc',
        'is_publish',
    ];
}
