<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BoardingGroup extends Model
{
    use HasFactory;
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    const DELETED_AT = 'don';
    protected $table = "ep_boarding_group";
    protected $fillable = [
        'name', 'name_ar', 'ayid', 'tid', 'eid', 'sid', 'bagid', 'cby', 'uby'
    ];

    public static function getFromBoarding($siswa,$current='1')
    {
        $text = "SELECT aa_person.id,aa_person.name, aa_person.name_ar,sex
            FROM ep_boarding_group
            LEFT JOIN aa_employe
            ON ep_boarding_group.eid = aa_employe.id
            LEFT JOIN aa_person
            ON aa_person.id = aa_employe.pid
            WHERE sid = ".$siswa;
        $text .= ($current=='1') ? ' AND ayid = '.config('id_active_academic_year') : '';
        $return = DB::select($text);
        $return = (count($return)>=1) ? collect($return[0]) : collect($return);
        $return = json_decode(json_encode($return), true);
        return $return;
    }

    public static function getMsPerAyid($eid="")
    {
        $text = 'SELECT em.id, ps.name
                FROM aa_employe em
                INNER JOIN aa_person ps
                ON em.pid = ps.id
                INNER JOIN ep_boarding_group bg
                ON em.id = bg.eid
                WHERE ayid = '.config('id_active_academic_year');
        if($eid!='') {
            $text .= ' AND pid =  '.$eid;
        }
        $text .= ' GROUP BY bg.eid, ps.name
                   ORDER BY ps.name';
        $return = DB::select($text);
        $return = json_decode(json_encode($return), true);
        return $return;
    }

    public static function getStudentPerMusyrif($eid)
    {
        $return = DB::select('SELECT sid as id, aa_person.name, aa_person.sex
            FROM ep_boarding_group
            inner join aa_student on aa_student.id = sid
            inner join aa_person on aa_person.id = aa_student.pid
            WHERE ayid = '.config('id_active_academic_year').'
            AND eid = '.$eid);
        $return = collect($return);
        $return = json_decode(json_encode($return), true);
        return $return;
    }

    public static function getStudentNonActiveEmploye()
    {
        $text = 'select aa_student.id, nis, aa_person.name from ep_boarding_group
            join (select id from aa_employe where is_active = 0) as aa_employe on eid = aa_employe.id
            join aa_student on aa_student.id = ep_boarding_group.sid
            join aa_person on aa_person.id = aa_student.pid
            where ayid =  '.config('id_active_academic_year');
        $return = DB::select($text);
        $return = collect($return);
        $return = json_decode(json_encode($return), true);
        return $return;
    }
}
