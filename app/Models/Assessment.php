<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Assessment extends Model
{
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "ep_assessment";
    protected $fillable = [
        'ayid', 'tid', 'subject_id', 'sid', 'grade_type', 'val', 'cby', 'uby'
    ];

    public static function getAssessmentStudent($ayid,$tid,$subid,$typeid,$sid)
    {
        $text = 'SELECT * FROM ep_assessment
            WHERE tid = '.$tid.'
            AND ayid = '.$ayid.'
            AND subject_id = '.$subid.'
            AND sid = '.$sid;
        $text .= is_array($typeid) ? ' AND grade_type IN ("'.implode('","',$typeid).'")' : ' AND grade_type = "'.$typeid.'"';
        $return = DB::select($text);
        $return = (count($return)>=1) ? collect($return[0])->where('val','!=','0') : collect($return);
        $return = json_decode(json_encode($return), true);
        if(count($return)==0)
        {
            $return = ['id'=>'','ayid'=>$ayid,'tid'=>$tid,'subject_id'=>$subid,'grade_type'=>$typeid,'sid'=>$sid,'val'=>0];
        }
        return $return;
    }

    public static function getBoardingAssessmentStudent($ayid,$tid,$sid,$activityid)
    {
        $text = 'SELECT sid, SUM(score) AS tscore, SUM(remission) AS tremission
            FROM ep_boarding_grade_dtl gdtl
            INNER JOIN ep_boarding_grade g
            ON gdtl.bgid = g.id
            AND gdtl.ayid = g.ayid
            AND gdtl.tid = g.tid
            WHERE gdtl.tid = '.$tid.'
            AND gdtl.ayid = '.$ayid.'
            AND sid = '.$sid.'
            AND activity_id = '.$activityid.'
            AND g.don IS NULL';
        $return = DB::select($text);
        $return = (count($return)>=1) ? collect($return[0]) : collect($return);
        $return = json_decode(json_encode($return), true);
        if(count($return)==0)
        {
            $return = ['tscore'=>0,'tremission'=>0];
        }
        return $return;
    }

    public static function getBoardingAssessmentStudentTarget($ayid,$tid,$activityid)
    {
        $text = 'SELECT SUM(score_total) AS tscoretarget
            FROM ep_boarding_grade
            WHERE tid = '.$tid.'
            AND ayid = '.$ayid.'
            AND activity_id = '.$activityid.'
            AND periode IS NOT NULL
            AND don IS NULL';
        $return = DB::select($text);
        $return = (count($return)>=1) ? collect($return[0]) : collect($return);
        $return = json_decode(json_encode($return), true);
        if(count($return)==0)
        {
            $return = ['tscoretarget'=>0];
        }
        return $return;
    }

    public static function getBoardingAssessmentPredicateStudent($ayid,$tid,$sid,$activityid)
    {
        $text = 'SELECT predicate FROM ep_boarding_grade_predicate
            WHERE tid = '.$tid.'
            AND ayid = '.$ayid.'
            AND sid = '.$sid.'
            AND activity_id = '.$activityid.'
            ORDER BY id DESC
            LIMIT 1';
        $return = DB::select($text);
        $return = (count($return)>=1) ? collect($return[0]) : collect($return);
        $return = json_decode(json_encode($return), true);
        if(count($return)==0)
        {
            $return = ['predicate'=>''];
        }
        return $return;
    }

    public static function getAcademicFinalGrade($ayid, $tid, $ccid, $sid)
    {
        $return = DB::select('SELECT dik.id AS subject_id, ROUND(AVG(grade_pass)) AS grade_pass, ROUND(AVG(final_grade)) AS final_grade
            FROM ep_subject_diknas_mapping AS dik
            JOIN ep_subject AS sub
            ON dik.id = sub.subject_id_diknas
            JOIN ep_final_grade_dtl AS gdtl
            ON gdtl.subject_id = sub.id
            JOIN ep_course_class cc
            ON gdtl.ccid = cc.id
            JOIN ep_course_subject csub
            ON (sub.id = csub.subject_id AND cc.level = csub.level AND gdtl.tid = csub.tid)
            WHERE format_code = 0
            AND gdtl.ayid = '.$ayid.'
            AND gdtl.tid = '.$tid.'
            AND ccid = '.$ccid.'
            AND sid = '.$sid.'
            GROUP BY dik.id
            ORDER BY dik.id');
        $return = collect($return);
        $return = json_decode(json_encode($return), true);
        return $return;
    }

    public static function getRemedial($ayid,$tid,$type)
    {
        $text = 'select tbl.name as namakelas,  aa_person.name, ep_subject.name as namamapel, val from ep_assessment
            inner join aa_student on ep_assessment.sid = aa_student.id
            inner join aa_person on pid = aa_person.id
            inner join ep_subject on ep_subject.id = subject_id
            inner join (
                select ccid,name,sid from ep_course_class_dtl
				inner join ep_course_class on ccid = ep_course_class.id
				where ayid = '.$ayid.'
            ) tbl on tbl.sid = ep_assessment.sid
            where ayid = "'.$ayid.'"
            and tid = "'.$tid.'"
            and grade_type="'.$type.'"
            and val < 60
            order by tbl.name, aa_person.name, ep_subject.name';
        $return = DB::select($text);
        $return = collect($return);
        $return = json_decode(json_encode($return), true);
        return $return;
    }
}
