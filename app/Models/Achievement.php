<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Achievement extends Model
{
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "aa_achievement";
    protected $fillable = [
        'pid',
        'name',
        'year',
        'desc',
        'date',
        'file',
        'cby',
        'uby',
    ];

    public function getFromPerson($id)
    {
        $text = " SELECT id, pid, aa_achievement.name, aa_achievement.year, aa_achievement.desc,
            file, aa_achievement.date, cby, con, uby, uon
            FROM aa_achievement ";
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
