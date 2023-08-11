<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AcademicYear extends Model
{
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "aa_academic_year";
    protected $fillable = [
        'id', 'name', 'desc', 'cby', 'uby'
    ];

    public static function getPrevAcademicYear($ayid) {
        $prev = $ayid - 1;
        $return = DB::select('SELECT id,name FROM aa_academic_year WHERE id = '.$prev);
        return $return;
    }
}
