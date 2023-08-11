<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SignedPosition extends Model
{
    // use HasFactory;
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "ep_signed_position";
    protected $fillable = [
        'ayid',
        'principal',
        'curriculum',
        'studentaffair',
        'housemaster_male',
        'housemaster_female',
        'cby',
        'uby',
    ];

    public static function HeadMaster($ayid='')
    {
        $ayid = ($ayid!='') ? $ayid : config('id_active_academic_year');
        $text = "SELECT aa_person.id,aa_person.name,aa_person.name_ar, sex, ms_uploads.url FROM ep_signed_position
            INNER JOIN aa_employe ON principal = aa_employe.id
            INNER JOIN aa_person ON aa_employe.pid = aa_person.id
            LEFT JOIN ms_uploads ON aa_person.id = ms_uploads.pid
            AND ms_uploads.desc = 'Tanda Tangan'
            WHERE ayid = ".$ayid;
        $return = DB::select($text);
        $return = (count($return)>=1) ? collect($return[0]) : collect($return);
        $return = json_decode(json_encode($return), true);
        return $return;
    }

    public static function Curriculum($ayid='')
    {
        $ayid = ($ayid!='') ? $ayid : config('id_active_academic_year');
        $text = "SELECT aa_person.id,aa_person.name,aa_person.name_ar, sex, ms_uploads.url FROM ep_signed_position
            INNER JOIN aa_employe ON curriculum = aa_employe.id
            INNER JOIN aa_person ON aa_employe.pid = aa_person.id
            LEFT JOIN ms_uploads ON aa_person.id = ms_uploads.pid
            AND ms_uploads.desc = 'Tanda Tangan'
            WHERE ayid = ".$ayid;
        $return = DB::select($text);
        $return = (count($return)>=1) ? collect($return[0]) : collect($return);
        $return = json_decode(json_encode($return), true);
        return $return;
    }

    public static function StudentAffair($ayid='')
    {
        $ayid = ($ayid!='') ? $ayid : config('id_active_academic_year');
        $text = "SELECT aa_person.id,aa_person.name,aa_person.name_ar, sex, ms_uploads.url FROM ep_signed_position
            INNER JOIN aa_employe ON studentaffair = aa_employe.id
            INNER JOIN aa_person ON aa_employe.pid = aa_person.id
            LEFT JOIN ms_uploads ON aa_person.id = ms_uploads.pid
            AND ms_uploads.desc = 'Tanda Tangan'
            WHERE ayid = ".$ayid;
        $return = DB::select($text);
        $return = (count($return)>=1) ? collect($return[0]) : collect($return);
        $return = json_decode(json_encode($return), true);
        return $return;
    }

    public static function HouseMasterMale($ayid='')
    {
        $ayid = ($ayid!='') ? $ayid : config('id_active_academic_year');
        $text = "SELECT aa_person.id,aa_person.name,aa_person.name_ar, sex, ms_uploads.url FROM ep_signed_position
            INNER JOIN aa_employe ON housemaster_male = aa_employe.id
            INNER JOIN aa_person ON aa_employe.pid = aa_person.id
            LEFT JOIN ms_uploads ON aa_person.id = ms_uploads.pid
            AND ms_uploads.desc = 'Tanda Tangan'
            WHERE ayid = ".$ayid;
        $return = DB::select($text);
        $return = (count($return)>=1) ? collect($return[0]) : collect($return);
        $return = json_decode(json_encode($return), true);
        return $return;
    }

    public static function HouseMasterFemale($ayid='')
    {
        $ayid = ($ayid!='') ? $ayid : config('id_active_academic_year');
        $text = "SELECT aa_person.id,aa_person.name,aa_person.name_ar, sex, ms_uploads.url FROM ep_signed_position
            INNER JOIN aa_employe ON housemaster_female = aa_employe.id
            INNER JOIN aa_person ON aa_employe.pid = aa_person.id
            LEFT JOIN ms_uploads ON aa_person.id = ms_uploads.pid
            AND ms_uploads.desc = 'Tanda Tangan'
            WHERE ayid = ".$ayid;
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
