<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ppdb extends Model
{
    // use HasFactory;
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "aa_ppdb";
    protected $fillable = [
        'id_ppdb',
        'registration_id',
        'nisn',
        'pid',
        'school_id',
        'academic_year_id',
        'process',
        'previous_school',
        'address_previous_school',
        'information_from',
        'father_temp',
        'mother_temp',
        'father_job_temp',
        'mother_job_temp',
        'whatsapp',
        'email',
        'is_boarding',
        'is_granted',
        'is_notif_regis',
        'is_notif_complete', 'cby', 'uby'
    ];

    public static function getbills()
    {
        $querys = "SELECT * FROM aa_ppdb_set
            LEFT OUTER JOIN aa_ppdb_cost ON ppdb_id = aa_ppdb_set.id
            LEFT OUTER JOIN fin_cost ON cost_id = fin_cost.id
            WHERE is_publish = '1'
            /* WHERE start_date <= CURRENT_DATE()
            AND end_date >= CURRENT_DATE() */";
        // $query = DB::select('call getbills');
        $query = DB::select($querys);
        return $query;
    }

    public static function getall($id)
    {
        $text = "SELECT aa_ppdb.id, aa_ppdb.pid, p.name, s.name AS school_name, ay.name AS ayname,
            ay.name as ayname, user_id, previous_school,
            school_id, st.desc, registration_id AS regid, aa_ppdb.con,
            pob,dob, aa_ppdb.is_granted, sd.nis, sd.nisn, is_accepted, role, invoice_id
            FROM aa_ppdb
            LEFT JOIN aa_person AS p ON p.id = aa_ppdb.pid
            LEFT JOIN aa_school AS s ON s.id = school_id
            LEFT JOIN aa_academic_year AS ay ON ay.id = academic_year_id
            LEFT JOIN rf_school_type AS st ON s.school_type_id = st.id
            LEFT JOIN aa_student AS sd ON aa_ppdb.pid = sd.pid
            LEFT JOIN users AS us ON us.id = p.user_id
            LEFT JOIN (SELECT * FROM aa_ppdb_payment WHERE status='LUNAS') AS pp ON pp.ppdb_id = aa_ppdb.id
            WHERE
            /* academic_year_id = ".config('id_active_academic_year')." AND */
            id_ppdb = $id
            ORDER BY aa_ppdb.con desc";
        $query = DB::select($text);
        $resultArray = json_decode(json_encode($query), true);
        return $resultArray;
    }

    // public static function getCount($ayid,$ids)
    // {
    //     $text = '';
    // }
}
