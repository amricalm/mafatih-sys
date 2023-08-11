<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CourseClassDtl extends Model
{
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "ep_course_class_dtl";
    protected $fillable = [
        'ccid','ayid', 'sid', 'cby', 'uby'
    ];

    public static function getStudentPerClass($ccid)
    {
        $text = 'SELECT sid as id, pid, aa_person.name
            FROM ep_course_class_dtl
            inner join aa_student on aa_student.id = sid
            inner join aa_person on aa_person.id = aa_student.pid
            WHERE ayid = '.config('id_active_academic_year').'
            AND ccid = '.$ccid;
        $return = DB::select($text);
        $return = collect($return);
        $return = json_decode(json_encode($return), true);
        return $return;
    }
    public static function getClassFromStudent($pid,$current='1')
    {
        $text = 'SELECT ccid, level, name, name_ar FROM ep_course_class_dtl
            inner join ep_course_class on ccid = ep_course_class.id
            inner join aa_student on sid = aa_student.id
            where pid = '.$pid;
        $text .= ($current=='1') ? ' and ayid = '.config('id_active_academic_year') : '';
        $return = DB::select($text);
        $return = collect($return);
        $return = json_decode(json_encode($return), true);
        return $return;
    }
}
