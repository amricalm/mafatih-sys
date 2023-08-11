<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectDiknas extends Model
{
    use HasFactory;
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "ep_subject_diknas";
    protected $fillable = [
        'short_name','name', 'cby', 'uby'
    ];
}
