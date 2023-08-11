<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RfSchoolType extends Model
{
    public $timestamps = false;
    protected $table = "rf_school_type";
    protected $fillable = [
        'desc',
        'name',
    ];
}
