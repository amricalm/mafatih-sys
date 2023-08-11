<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MenuModul extends Model
{
    // use HasFactory;
    public $timestamps = false;
    protected $primaryKey = null;
    protected $table = "menu_modul";
    protected $fillable = [
        'menu_id',
        'modul_id',
        'seq',
    ];
}
