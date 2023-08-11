<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsNotif extends Model
{
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "ms_notif";
    protected $fillable = [
        'id',
        'notif_title',
        'notif_message',
        'notif_image',
        'notif_url',
        'notif_datetime',
        'notif_respond',
        'id_respond',
        'notif_hit',
        'cby',
        'uby'
    ];
}
