<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Homeroom extends Model
{
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "aa_homeroom";
    protected $fillable = [
        'id', 'ayid', 'ccid', 'emid', 'cby', 'uby'
    ];


    public static function getFromClass($kelas,$current='1')
    {
        $text = "SELECT aa_person.id,aa_person.name, aa_person.name_ar,sex, ms_uploads.url FROM aa_homeroom
            JOIN aa_employe ON aa_employe.id = emid
            JOIN aa_person ON aa_person.id = pid
            LEFT JOIN ms_uploads ON aa_person.id = ms_uploads.pid
            AND ms_uploads.desc = 'Tanda Tangan'
            WHERE ccid = $kelas";
        $text .= ($current=='1') ? " AND ayid = ".config('id_active_academic_year') : '';
        $return = DB::select($text);
        $return = (count($return)>=1) ? collect($return[0]) : collect($return);
        $return = json_decode(json_encode($return), true);
        return $return;
    }
}
