<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrAttendanceReport extends Model
{
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $primaryKey = 'id';
    protected $table = "aa_person";
    protected $fillable = [
        'pid',
        'att_id',
        'notes',
        'exit_timestamp',
        'duration_manual',
        'is_accepted',
    ];
}
