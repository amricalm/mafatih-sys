<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Counselling extends Model
{
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "ep_counselling";
    protected $fillable = [
        'id',
        'pid',
        'name',
        'year',
        'desc',
        'cby',
        'uby',
    ];

    public function getFromPerson($id)
    {
        $text = " SELECT id, pid, name, ep_counselling.year,  ep_counselling.date, ep_counselling.desc, cby, uby, uby, uon
            FROM ep_counselling ";
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
