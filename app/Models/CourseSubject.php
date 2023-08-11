<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CourseSubject extends Model
{
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "ep_course_subject";
    protected $fillable = [
        'ayid',
        'tid',
        'seq',
        'level',
        'subject_id',
        'eid',
        'grade_pass',
        'week_duration',
        'cby',
        'uby',
    ];

    public static function getFromClass($where)
    {
        $text = ' SELECT ep_subject.id,ep_subject.name FROM ep_course_subject
            LEFT JOIN ep_course_class ON ep_course_class.level = ep_course_subject.level
            LEFT JOIN ep_subject ON subject_id = ep_subject.`id`
            WHERE ep_course_class.id = '.$where['id'].'
            AND ayid = '.config('id_active_academic_year').'
            AND tid = '.config('id_active_term').'
            ORDER BY ep_subject.name ';
        $return = DB::select($text);
        $return = json_decode(json_encode($return), true);
        return $return;
    }

    public static function getFromLevel($level,$ayid,$tid)
    {
        $text = ' SELECT id, subject_id, week_duration, grade_pass, seq, level
                FROM ep_course_subject
                WHERE ayid = '.$ayid.'
                AND tid = '.$tid;
        $text .= is_array($level) ? ' AND level IN ('.implode(',',$level).') ' : ' AND level = '.$level;
        $return  = DB::select($text);
        return collect($return);
    }
}
