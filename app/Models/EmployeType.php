<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeType extends Model
{
    protected $table = "rf_employe_type";
    protected $fillable = [
        'code', 'desc'
    ];
}
