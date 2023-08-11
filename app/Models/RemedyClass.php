<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RemedyClass extends Model
{
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "ep_remedy_class";
    protected $fillable = [
        'ayid',
        'tid',
        'eid',
        'ayid_remedy',
        'tid_remedy',
        'eid_remedy',
        'course_subject_id',
        'sid',
        'grade_before',
        'grade_after',
        'is_passed',
        'cby',
        'uby',
    ];

    public static function delete_first($siswa,$ayid,$tid)
    {
        $text = ' DELETE FROM ep_remedy_class
            WHERE ayid = '.$ayid.'
            AND tid = '.$tid;
        $text .= (is_array($siswa)) ? ' AND sid IN ('.implode(',',$siswa).')' : ' AND sid = '.$siswa;
        $result = DB::select($text);
        return $result;
    }

    public static function getOne($sid)
    {
        $text = 'SELECT
                    name_ar
                FROM
                    ep_remedy_class
                    INNER JOIN ep_subject ON course_subject_id = ep_subject.id
                    INNER JOIN aa_academic_year ON ayid = aa_academic_year.id
                WHERE
                    (grade_after is null or grade_after = "") AND
                    left(aa_academic_year.name, 4) <= '.substr(config('active_academic_year'),0,4).
                    ' and sid = '.$sid;
		$return = DB::select($text);
		$return = collect($return)->pluck('name_ar');
		$return = json_decode(json_encode($return), true);
		return $return;
    }
    public static function getMahmul($siswa,$subjectid='')
    {
        $text = ' SELECT
                replace(a.name,"/","") as nameay, a.name as ayidname,
                replace(b.name,"/","") as nameay_remedy, b.name as ayidremedy,
                ep_remedy_class.*,
                ep_subject.name as pelajaran, ep_subject.name_ar as pelajaran_ar,
                aa_person.name, aa_person.name_ar
            FROM
                ep_remedy_class
                inner join aa_academic_year a on a.id = ayid
                left outer join aa_academic_year b on b.id = ayid_remedy
                inner join ep_subject on course_subject_id = ep_subject.id
                inner join aa_student on aa_student.id = ep_remedy_class.sid
                inner join aa_person on aa_person.id = aa_student.pid
            WHERE ';
        $text .= is_array($siswa) ? ' sid in ('.implode(',',$siswa).')' : ' sid = '.$siswa;
        $text .= ($subjectid!='') ? ' AND course_subject_id = '.$subjectid : '';
        $hasil = DB::select($text);
        $return = collect($hasil);
        $totalgpa = 0; $gpa = 0; $no = 0; $array = array();
        foreach($hasil as $k=>$v)
        {
            $array[$no] = collect($v)->toArray();
            $no++;
        }
        return $array;
    }
    public static function getAll($student)
    {
        $text = '
        SELECT
            ep_remedy_class.*,
            ep_subject.name as pelajaran,
            ep_subject.name_ar as pelajaran_ar,
            a.name as nameay,
            b.name as nameay_remedy
        FROM
            ep_remedy_class
            INNER JOIN ep_subject ON course_subject_id = ep_subject.id
            INNER JOIN aa_academic_year a ON ayid = a.id
            LEFT OUTER JOIN aa_academic_year b ON ayid_remedy = b.id
        WHERE
            left(aa_academic_year.name, 4) <= '.substr(config('active_academic_year'),0,4).
        ' AND sid IN ('.implode(', ',$student).')';

		$return = DB::select($text);
		$return = json_decode(json_encode($return), true);
		return $return;
    }
    public static function getMahmulforRaportv2($siswa,$all='')
    {
        $text = '
            SELECT c.name as pelajaran, c.name_ar as pelajaran_ar
            FROM ep_remedy_class a
                left outer join aa_academic_year b on ayid = b.id
                left outer join ep_subject c on course_subject_id = c.id
                left outer join aa_student d on a.sid = d.id
                left outer join aa_person e on d.pid = e.id
            WHERE
                ayid = '.config('id_active_academic_year').'
                AND tid = '.config('id_active_term').'
                AND a.sid = '.$siswa.'
        ';
        $hasil = DB::select($text);
        $return = collect($hasil);
        return $return;
    }
    public static function getMahmulforRaport($siswa,$all='')
    {
        $actualayid = (int)str_replace('/','',config('active_academic_year'));
        $actualtid = (int)config('id_active_term');
        $text = ' SELECT
                replace(a.name,"/","") as nameay,
                replace(b.name,"/","") as nameay_remedy,
                ep_remedy_class.*,
                ep_subject.name as pelajaran, ep_subject.name_ar as pelajaran_ar,
                aa_person.name, aa_person.name_ar
            FROM
                ep_remedy_class
                inner join aa_academic_year a on a.id = ayid
                left outer join aa_academic_year b on b.id = ayid_remedy
                inner join ep_subject on course_subject_id = ep_subject.id
                inner join aa_student on aa_student.id = ep_remedy_class.sid
                inner join aa_person on aa_person.id = aa_student.pid
            WHERE ';
        $text .= is_array($siswa) ? ' sid in ('.implode(',',$siswa).')' : ' sid = '.$siswa;
        // $text .= ' AND ( is_passed = 0 OR (is_passed = 1 AND replace(b.name,"/","") < "'.$actualayid.'" '.$whereact.'))';
        $hasil = DB::select($text);
        $return = collect($hasil);
        $totalgpa = 0; $gpa = 0; $no = 0; $array = array();
        foreach($hasil as $k=>$v)
        {
            if($all!='')
            {
                $array[$no] = collect($v)->toArray();
                $no++;
            }
            else
            {
                if($actualayid >= $v->nameay)
                {
                    if($actualayid == $v->nameay)
                    {
                        if($actualtid == $v->tid)
                        {
                            if($v->is_passed == '0')
                            {
                                $array[$no] = collect($v)->toArray();
                                $no++;
                            }
                        }
                        else
                        {
                            // if($actualtid )
                        }
                    }
                    else
                    {
                        if($v->is_passed == '0')
                        {
                            $array[$no] = collect($v)->toArray();
                            $no++;
                        }
                    }
                }
                // if($v->nameay <= $actualayid)
                // {
                //     if($v->nameay == $actualayid)
                //     {
                //         if($v->tid_remedy <= $actualtid)
                //         {
                //             if($v->tid_remedy == $actualtid)
                //             {
                //                 $array[$no] = collect($v)->toArray();
                //                 $no++;
                //             }
                //             else
                //             {
                //                 if($v->is_passed=='0')
                //                 {
                //                     $array[$no] = collect($v)->toArray();
                //                     $no++;
                //                 }
                //             }
                //         }
                //     }
                //     else
                //     {
                //         if($v->is_passed=='0')
                //         {
                //             $array[$no] = collect($v)->toArray();
                //             $no++;
                //         }
                //     }
                // }
            }
        }
        return ($no!='0') ? $array : '0';
    }
    public static function getBefore($ayid='')
    {
        $ayid = ($ayid=='') ? str_replace('/','',config('active_id_academic_year')) : str_replace('/','',$ayid);
        $sql = 'SELECT ayid,ay.name, er.tid, es.name as subject, sid, pid, er.grade_pass,
                course_subject_id as subject_id, is_passed,
                ap.name as person, grade_before, grade_after, er.id as mahmulid
            FROM ep_remedy_class er
            JOIN aa_academic_year AS ay ON ay.id = ayid
            JOIN ep_subject AS es ON es.id = course_subject_id
            JOIN aa_student AS `as` ON as.id = sid
            JOIN aa_person AS ap ON `as`.pid = ap.id ';
        $hasil = DB::select($sql);
        $return = collect($hasil);
        $array = []; $no = 0;
        foreach($return as $k=>$v)
        {
            $array[$no] = collect($v)->toArray();
            $no++;
        }
        return $array;
    }
    // public static function getMahmulforRaport($siswa,$all='')
    // {
    //     $actualayid = (int)str_replace('/','',config('active_academic_year'));
    //     $actualtid = (int)config('id_active_term');
    //     $text = ' SELECT
    //             replace(aa_academic_year.name,"/","") as nameay,
    //             ep_remedy_class.*,
    //             ep_subject.name as pelajaran, ep_subject.name_ar as pelajaran_ar,
    //             aa_person.name, aa_person.name_ar
    //         FROM
    //             ep_remedy_class
    //             inner join aa_academic_year on aa_academic_year.id = ayid_remedy
    //             inner join ep_subject on course_subject_id = ep_subject.id
    //             inner join aa_student on aa_student.id = ep_remedy_class.sid
    //             inner join aa_person on aa_person.id = aa_student.pid
    //         WHERE ';
    //     $text .= is_array($siswa) ? ' sid in ('.implode(',',$siswa).')' : ' sid = '.$siswa;
    //     $hasil = DB::select($text);
    //     $return = collect($hasil);
    //     $totalgpa = 0; $gpa = 0; $no = 0; $array = array();
    //     foreach($hasil as $k=>$v)
    //     {
    //         if($all!='')
    //         {
    //             $array[$no] = collect($v)->toArray();
    //             $no++;
    //         }
    //         else
    //         {
    //             if($v->nameay <= $actualayid)
    //             {
    //                 if($v->nameay == $actualayid)
    //                 {
    //                     if($v->tid_remedy <= $actualtid)
    //                     {
    //                         if($v->tid_remedy == $actualtid)
    //                         {
    //                             $array[$no] = collect($v)->toArray();
    //                             $no++;
    //                         }
    //                         else
    //                         {
    //                             if($v->is_passed=='0')
    //                             {
    //                                 $array[$no] = collect($v)->toArray();
    //                                 $no++;
    //                             }
    //                         }
    //                     }
    //                 }
    //                 else
    //                 {
    //                     if($v->is_passed=='0')
    //                     {
    //                         $array[$no] = collect($v)->toArray();
    //                         $no++;
    //                     }
    //                 }
    //             }
    //         }
    //     }
    //     return ($no!='0') ? $array : '0';
    // }
}
