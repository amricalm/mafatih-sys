<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HrComponent extends Model
{
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "hr_component";
    protected $fillable = [
        'code',
        'name',
        'desc',
        'score',
        'duration_min',
        'is_mandatory',
        'is_overtime',
        'is_active',
        'cby',
        'uby',
    ];

    public static function getPerPerson($id)
    {
        $text = "SELECT hc.* FROM hr_component hc
            INNER JOIN hr_component_position hcp ON component_id = hc.id
            INNER JOIN aa_employe ae ON hcp.position_id = ae.position_id
            WHERE pid = ".$id;
        $query = DB::select($text);
        $resultArray = json_decode(json_encode($query), true);
        return $resultArray;
    }
}
