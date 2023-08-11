<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FinalGrade extends Model
{
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "ep_final_grade";
    protected $fillable = [
        'format_code',
        'reg_no',
        'qr_code',
        'published',
        'ayid',
        'tid',
        'sid',
        'ccid',
        'class_avg',
        'weight_grade',
        'class_avg',
        'sum_weighted_grade',
        'sum_lesson_hours',
        'ips',
        'gpa_prev',
        'gpa',
        'result',
        'letter_grade',
        'subject_remedy',
        'cleanliness',
        'discipline',
        'behaviour',
        'absent_a',
        'absent_i',
        'absent_s',
        'memorizing_quran',
        'activities_parent',
        'note_from_student_affairs',
        'note_boarding',
        'form_teacher',
        'principal',
        'curriculum',
        'studentaffair',
        'housemaster',
        'houseleader',
        'date_legalization',
        'hijri_date_legalization',
        'cby',
        'uby'
    ];

    public static function getDateRaport($ayid,$tid)
    {
        $text = "SELECT date_legalization, hijri_date_legalization
            FROM ep_final_grade
            WHERE date_legalization !=''
            AND hijri_date_legalization !=''
            AND ayid = ".$ayid."
            AND tid = ".$tid;
        $return = DB::select($text);
        $return = (count($return)>=1) ? collect($return[0]) : collect($return);
        $return = json_decode(json_encode($return), true);
        return $return;
    }

    public static function getStudentFinalGrade($siswa,$formatcode=0,$ayid,$tid)
    {
        $text = "SELECT ep_final_grade.*, student.nis,
            person.name AS student_name, person.name_ar AS student_name_ar, person.sex AS student_sex,
            principal.name AS principal_name, principal.name_ar AS principal_name_ar,
            principal.sex AS principal_sex, ttdprincipal.url AS principal_url,
            curriculum.name AS curriculum_name, curriculum.name_ar AS curriculum_name_ar,
            curriculum.sex AS curriculum_sex, ttdcurriculum.url AS curriculum_url,
            studentaffair.NAME AS studentaffair_name, studentaffair.name_ar AS studentaffair_name_ar,
            studentaffair.sex AS studentaffair_sex, ttdstudentaffair.url AS studentaffair_url,
            formteacher.NAME AS formteacher_name, formteacher.name_ar AS formteacher_name_ar,
            formteacher.sex AS formteacher_sex, ttdformteacher.url AS formteacher_url,
            housemaster.NAME AS housemaster_name, housemaster.name_ar AS housemaster_name_ar,
            housemaster.sex AS housemaster_sex, ttdhousemaster.url AS housemaster_url,
            houseleader.NAME AS houseleader_name, houseleader.name_ar AS houseleader_name_ar,
            houseleader.sex AS houseleader_sex, ttdhouseleader.url AS houseleader_url

            FROM ep_final_grade

            LEFT JOIN aa_student AS student
            ON ep_final_grade.sid = student.id
            LEFT JOIN aa_person AS person
            ON student.pid = person.id

            LEFT JOIN (
                SELECT aa_employe.id, aa_employe.pid, name, name_ar, sex
                FROM aa_person
                INNER JOIN aa_employe
                ON aa_person.id = aa_employe.pid
            ) AS principal
            ON ep_final_grade.principal = principal.id
            LEFT JOIN ms_uploads AS ttdprincipal
            ON principal.pid = ttdprincipal.pid
            AND ttdprincipal.desc = 'Tanda Tangan'

            LEFT JOIN (
                SELECT aa_employe.id, aa_employe.pid, name, name_ar, sex
                FROM aa_person
                INNER JOIN aa_employe
                ON aa_person.id = aa_employe.pid
            ) AS curriculum
            ON ep_final_grade.curriculum = curriculum.id
            LEFT JOIN ms_uploads AS ttdcurriculum
            ON curriculum.pid = ttdcurriculum.pid
            AND ttdcurriculum.desc = 'Tanda Tangan'

            LEFT JOIN (
                SELECT aa_employe.id, aa_employe.pid, name, name_ar, sex
                FROM aa_person
                INNER JOIN aa_employe
                ON aa_person.id = aa_employe.pid
            ) AS studentaffair
            ON ep_final_grade.studentaffair = studentaffair.id
            LEFT JOIN ms_uploads AS ttdstudentaffair
            ON studentaffair.pid = ttdstudentaffair.pid
            AND ttdstudentaffair.desc = 'Tanda Tangan'

            LEFT JOIN aa_person AS formteacher
            ON ep_final_grade.form_teacher = formteacher.id
            LEFT JOIN ms_uploads AS ttdformteacher
            ON formteacher.id = ttdformteacher.pid
            AND ttdformteacher.desc = 'Tanda Tangan'

            LEFT JOIN (
                SELECT aa_employe.id, aa_employe.pid, name, name_ar, sex
                FROM aa_person
                INNER JOIN aa_employe
                ON aa_person.id = aa_employe.pid
            ) AS housemaster
            ON ep_final_grade.housemaster = housemaster.id
            LEFT JOIN ms_uploads AS ttdhousemaster
            ON housemaster.pid = ttdhousemaster.pid
            AND ttdhousemaster.desc = 'Tanda Tangan'

            LEFT JOIN aa_employe AS emp_houseleader
            ON ep_final_grade.houseleader = emp_houseleader.id
            LEFT JOIN aa_person AS houseleader
            ON emp_houseleader.pid = houseleader.id
            LEFT JOIN ms_uploads AS ttdhouseleader
            ON emp_houseleader.id = ttdhouseleader.pid
            AND ttdhouseleader.desc = 'Tanda Tangan'

            WHERE ep_final_grade.sid = ".$siswa."
            AND ep_final_grade.format_code = ".$formatcode."
            AND ep_final_grade.ayid = ".$ayid."
            AND ep_final_grade.tid = ".$tid;
            
        $return = DB::select($text);
        $return = (count($return)>=1) ? collect($return[0]) : collect($return);
        $return = json_decode(json_encode($return), true);
        return $return;
    }
    public static function getOnePerson($siswa, $ayid='', $tid='',$format_code='0')
    {
        $ayid = ($ayid!='') ? $ayid : config('id_active_academic_year');
        $tid = ($tid!='') ? $tid : config('id_active_term');
        $text = ' select
                *
            from
                ep_final_grade
            where
                ayid = '.$ayid.'
                and tid = '.$tid.'
                and sid = '.$siswa .'
                and format_code = '.$format_code;
        $result = DB::select($text);
        return $result;
    }
    public static function getIPK($siswa,$all=array())
    {
        $text = 'select * from ep_final_grade
            WHERE format_code = 0 ';
        $text .= (is_array($siswa)) ? ' AND sid IN ('.implode(',',$siswa).')' : ' AND sid = '.$siswa;
        $text .= (empty($all)) ? '' : ' and tid = '.$all['tid'].' and ayid = '.$all['ayid'];

        $return = DB::select($text);
        if(!empty($return))
        {
            if(is_array($siswa))
            {
                $return = collect($return)->groupby('sid')->toArray();
                $data = array();
                $no = 0;
                foreach($return as $k=>$v)
                {
                    $i = 0;
                    $gpa = array(); $thnajar = array(); $semester = array();
                    foreach($v as $kk=>$vv)
                    {
                        $thnajar[$i] = $v[$i]->ayid;
                        $semester[$i] = $v[$i]->tid;
                        $gpa[$i] = $v[$i]->gpa;
                        $i++;
                    }
                    $gpatot = array_sum($gpa)/count($gpa);
                    $data[$no] = array('sid'=>$k,'gpa'=>round($gpatot),'gpadetail'=>$gpa,'thndetail'=>$thnajar,'semester'=>$semester);
                    $no++;
                }
                return $data;
            }
            else
            {
                $return = (empty($all)) ? collect($return)->pluck('gpa')->toArray() : $return[0]->gpa;
                return (empty($all)) ? (array_sum($return)/count($return)) : $return;
            }
        }
        else
        {
            return '0';
        }
    }
    public static function delete_first($ayid,$tid,$format_code,$sid)
    {
        $text = '
            DELETE FROM ep_final_grade
            WHERE ayid = '.$ayid.'
            AND tid = '.$tid.'
            AND format_code = '.$format_code.'
        ';
        $text .= (is_array($sid)) ? ' AND sid IN ('.implode(',',$sid).')' : ' AND sid = '.$sid;
        $return  = DB::select($text);
        return $return;
    }
}
