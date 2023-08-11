<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FinalGradeDtl extends Model
{
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "ep_final_grade_dtl";
    protected $fillable = [
        'format_code',
        'reg_no',
        'qr_code',
        'published',
        'ayid',
        'tid',
        'subject_id',
        'subject_seq_no',
        'ccid',
        'sid',
        'formative_val',
        'mid_exam',
        'final_exam',
        'final_grade',
        'lesson_hours',
        'weighted_grade',
        'class_avg',
        'sum_weighted_grade',
        'sum_lesson_hours',
        'ips',
        'gpa_prev',
        'gpa',
        'result',
        'letter_grade',
        'knowledge_desc',
        'skill_desc',
        'cby',
        'uby'
    ];

    public static function getBoardingFinalGradeDtl($sid)
    {
        $format_code = 1;
        $text = DB::select('SELECT ep_boarding_activity.id, ep_boarding_activity.name, ep_boarding_activity.name_ar,
                            IFNULL(NULL, grade.final_grade) AS final_grade, IFNULL(NULL, grade.letter_grade) AS letter_grade, ep_boarding_activity.type, IFNULL(NULL, grade.note) AS note
                            FROM ep_boarding_activity
                            LEFT JOIN ep_boarding_activity_nonactive non
                            ON ep_boarding_activity.id = non.activity_id
                            AND ayid = '.config('id_active_academic_year').'
                            AND tid = '.config('id_active_term').'
                            AND non.desc = "ACTIVITY"
                            LEFT JOIN (
                                SELECT ep_final_grade_dtl.ayid, ep_final_grade_dtl.tid, ep_final_grade_dtl.sid, subject_seq_no, subject_id, final_grade, ep_final_grade_dtl.letter_grade, note
                                FROM ep_final_grade_dtl
                                LEFT JOIN ep_final_grade
                                ON ep_final_grade_dtl.sid = ep_final_grade.sid
                                AND ep_final_grade_dtl.ayid = ep_final_grade.ayid
                                AND ep_final_grade_dtl.tid = ep_final_grade.tid
                                AND ep_final_grade_dtl.format_code = ep_final_grade.format_code
                                LEFT JOIN ep_boarding_note
                                ON ep_final_grade_dtl.sid = ep_boarding_note.sid
                                AND ep_final_grade_dtl.ayid = ep_boarding_note.ayid
                                AND ep_final_grade_dtl.tid = ep_boarding_note.tid
                                WHERE ep_final_grade_dtl.sid = '.$sid.'
                                AND ep_final_grade_dtl.ayid = '.config('id_active_academic_year').'
                                AND ep_final_grade_dtl.tid = '.config('id_active_term').'
                                AND ep_final_grade_dtl.format_code = '.$format_code.'
                            ) AS grade
                            ON ep_boarding_activity.id = grade.subject_id
                            WHERE non.activity_id IS NULL
                            AND ep_boarding_activity.don IS NULL
                            AND grade.ayid = '.config('id_active_academic_year').'
                            AND grade.tid = '.config('id_active_term').'
                            ORDER BY seq ASC');
        $return = collect($text);
        $return = json_decode(json_encode($return), true);
        return $return;
    }

    public static function delete_first($ayid,$tid,$siswa,$formatcode)
    {
        try {
            $text = ' DELETE FROM ep_final_grade_dtl
                WHERE ayid = '.$ayid.'
                AND tid = '.$tid.'
                AND format_code = '.$formatcode;
            $text .= (is_array($siswa)) ? ' AND sid IN ('.implode(',',$siswa).')' : ' AND sid = '.$siswa;
            $result = DB::select($text);
            return 'Berhasil';
        } catch (\Throwable $th) {
            return $th;
        }
    }
    public static function getOnePerson($siswa,$ayid='',$tid='')
    {
        $ayid = ($ayid!='') ? $ayid : config('id_active_academic_year');
        $tid = ($tid!='') ? $tid : config('id_active_term');
        $text = ' select
                *
            from
                ep_final_grade_dtl
            where
                format_code = 0
                and ayid = '.$ayid.'
                and tid = '.$tid.'
                and sid = '.$siswa;
        $result = DB::select($text);
        return $result;
    }
}
