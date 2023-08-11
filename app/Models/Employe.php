<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Employe extends Model
{
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "aa_employe";
    protected $fillable = [
        'id', 'pid', 'nik', 'employe_type', 'position_id', 'npwp', 'npwp_name', 'marital_status', 'coupleid',
        'employment_status','niy','nuptk','ptk_type','decision_number','decision_date','decision_institution','source_salary',
        'is_active',
        'cby', 'uby'
    ];

    public static function HeadMaster()
    {
        $text = "SELECT aa_person.id,aa_person.name,aa_person.name_ar, sex, ms_uploads.url FROM aa_employe
            INNER JOIN hr_position ON hr_position.id = position_id
            INNER JOIN aa_person ON pid = aa_person.id
            LEFT JOIN ms_uploads ON aa_person.id = ms_uploads.pid
            AND ms_uploads.desc = 'Tanda Tangan'
            WHERE hr_position.`id` = 3";
        $return = DB::select($text);
        $return = (count($return)>=1) ? collect($return[0]) : collect($return);
        $return = json_decode(json_encode($return), true);
        return $return;
    }

    public static function Curriculum()
    {
        $text = "SELECT aa_person.id,aa_person.name,aa_person.name_ar, sex, ms_uploads.url FROM aa_employe
            INNER JOIN hr_position ON hr_position.id = position_id
            INNER JOIN aa_person ON pid = aa_person.id
            LEFT JOIN ms_uploads ON aa_person.id = ms_uploads.pid
            AND ms_uploads.desc = 'Tanda Tangan'
            WHERE hr_position.`id` = 5";
        $return = DB::select($text);
        $return = (count($return)>=1) ? collect($return[0]) : collect($return);
        $return = json_decode(json_encode($return), true);
        return $return;
    }

    public static function StudentAffair()
    {
        $text = "SELECT aa_person.id,aa_person.name,aa_person.name_ar, sex, ms_uploads.url FROM aa_employe
            INNER JOIN hr_position ON hr_position.id = position_id
            INNER JOIN aa_person ON pid = aa_person.id
            LEFT JOIN ms_uploads ON aa_person.id = ms_uploads.pid
            AND ms_uploads.desc = 'Tanda Tangan'
            WHERE hr_position.`id` = 4";
        $return = DB::select($text);
        $return = (count($return)>=1) ? collect($return[0]) : collect($return);
        $return = json_decode(json_encode($return), true);
        return $return;
    }

    public static function HouseMaster()
    {
        $text = "SELECT aa_person.id,aa_person.name,aa_person.name_ar, sex, ms_uploads.url FROM aa_employe
            INNER JOIN hr_position ON hr_position.id = position_id
            INNER JOIN aa_person ON pid = aa_person.id
            LEFT JOIN ms_uploads ON aa_person.id = ms_uploads.pid
            AND ms_uploads.desc = 'Tanda Tangan'
            WHERE hr_position.`id` = 13";
        $return = DB::select($text);
        $return = (count($return)>=1) ? collect($return[0]) : collect($return);
        $return = json_decode(json_encode($return), true);
        return $return;
    }

    public static function allAttribut()
    {
        $return = array();
        $return['headMaster'] = Employe::HeadMaster();
        $return['headMasterId'] = isset($headMaster['id']) ? $headMaster['id'] : '';
        $return['curriculum'] = Employe::Curriculum();
        $return['curriculumId'] = isset($curriculum['id']) ? $curriculum['id'] : '';
        $return['studentAffair'] = Employe::StudentAffair();
        $return['studentAffairId'] = isset($studentAffair['id']) ? $studentAffair['id'] : '';
        $return['houseMaster'] = Employe::HouseMaster();
        $return['houseMasterId'] = isset($houseMaster['id']) ? $houseMaster['id'] : '';
        return $return;
    }

}
