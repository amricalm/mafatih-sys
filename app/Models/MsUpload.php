<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsUpload extends Model
{
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "ms_uploads";
    protected $fillable = [
        'pid','desc', 'url', 'original_file', 'cby', 'uby'
    ];
}
