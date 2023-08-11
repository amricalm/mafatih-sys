<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuRole extends Model
{
    public $timestamps = false;
    protected $table = "menu_role";
    protected $fillable = [
        'menu_id','role_id'
    ];
}
