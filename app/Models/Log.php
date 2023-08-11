<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    public $timestamps = false;
    protected $table = "log";
    protected $fillable = [
        'ip','country_code','country_name','region_code','region_name','city','time_zone','latitude','longitude','org','timestamp','nama_login','role_id','detail',
    ];
}
