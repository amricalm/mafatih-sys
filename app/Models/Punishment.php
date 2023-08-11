<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Punishment extends Model
{
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "ep_punishment";
    protected $fillable = [
        'pid',
        'name',
        'year',
        'level',
        'desc',
        'cby',
        'uby',
    ];

    public function getFromPerson($id)
    {
        $text = " SELECT id, pid, name, ep_punishment.year,  ep_punishment.level, ep_punishment.date, ep_punishment.desc, cby, uby, uby, uon
            FROM ep_punishment ";
        if(is_array($id))
        {
            $text .= " WHERE pid IN (".implode($id).")";
        }
        else
        {
            $text .= " WHERE pid = ".$id;
        }
        $text .= ' ORDER BY uon DESC';
        return collect(DB::select($text));
    }
}
