<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsJobs extends Model
{
    protected $table = "ms_jobs";
    protected $fillable = [
        'name', 'desc',
    ];
}
