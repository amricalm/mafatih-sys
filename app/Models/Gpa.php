<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\FinalGrade;
use App\Models\FinalGradeDtl;
use App\Models\Student;

class Gpa extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $incrementing = false;
    protected $table = "ep_gpa";
    // protected $primaryKey = ['ayid','tid','sid'];
    protected $primaryKey = false;
    protected $fillable = [
        'ayid', 'tid', 'sid', 'gpa',
    ];
    public static function getRankingClass($ccid)
    {
        $app['murid'] = Student::join('ep_course_class_dtl','sid','=','aa_student.id')
                ->join('ep_course_class','ccid','=','ep_course_class.id')
                ->join('aa_person','aa_person.id','=','aa_student.pid')
                ->where('ayid',config('id_active_academic_year'))
                ->where('ccid',$ccid)
                ->select('nis','aa_person.name','aa_person.name_ar','ccid','ep_course_class.name as classname','sid','sex');
        $app['murid'] = $app['murid']->get();
        $murid = collect($app['murid'])->pluck('sid')->toArray();
        $ipk = Gpa::getIPK($murid,config('id_active_academic_year'),config('id_active_term'));
        $app['ipk'] = collect($ipk)->sortByDesc('ipk')->values()->all();
        $namakelas = collect($app['murid'])->pluck('classname','ccid')->toArray();
        $app['namakelas'] = collect(array_unique($namakelas));
        return $app['ipk'];
    }
    public static function getRankingLevel($level,$jkl='')
    {
        $app['murid'] = Student::join('ep_course_class_dtl','sid','=','aa_student.id')
                ->join('ep_course_class','ccid','=','ep_course_class.id')
                ->join('aa_person','aa_person.id','=','aa_student.pid')
                ->where('ayid',config('id_active_academic_year'))
                ->where('level',$level)
                ->select('nis','aa_person.name','aa_person.name_ar','ccid','ep_course_class.name as classname','sid','sex');
        $app['murid'] = ($jkl!='') ? $app['murid']->where('sex',$jkl) : $app['murid'];
        $app['murid'] = $app['murid']->get();
        $murid = collect($app['murid'])->pluck('sid')->toArray();
        $ipk = Gpa::getIPK($murid,config('id_active_academic_year'),config('id_active_term'));
        $app['ipk'] = collect($ipk)->sortByDesc('ipk')->values()->all();
        $namakelas = collect($app['murid'])->pluck('classname','ccid')->toArray();
        $app['namakelas'] = collect(array_unique($namakelas));
        return $app['ipk'];
    }
    public static function getIPK($siswa,$ayid,$tid)
    {
        $getacademicyear = AcademicYear::where('id',$ayid)->first();
        $actualayid = (int)str_replace('/','',$getacademicyear->name);
        $actualtid = (int)$tid;
        // $text = ' SELECT
        //         replace(aa_academic_year.name,"/","") as nameay,
        //         ep_gpa.*
        //     FROM
        //         ep_gpa
        //         inner join aa_academic_year on aa_academic_year.id = ayid
        //     WHERE ';



        $text = 'SELECT
            REPLACE(aa_academic_year.name,"/","") AS nameay, ep_course_class.level,school_type,
            ep_gpa.*
        FROM
            ep_gpa
            INNER JOIN aa_academic_year ON aa_academic_year.id = ayid
            INNER JOIN ep_course_class_dtl
            ON ep_gpa.sid = ep_course_class_dtl.sid
            AND ep_gpa.ayid = ep_course_class_dtl.ayid
             JOIN ep_course_class
            ON ccid = ep_course_class.id
            INNER JOIN rf_level_class
            ON ep_course_class.level = rf_level_class.level
            WHERE ';

        $text .= ((array)$siswa===$siswa) ? ' ep_gpa.sid in ('.implode(',',$siswa).')' : ' ep_gpa.sid = '.$siswa;
        $hasil = DB::select($text);
        $return = collect($hasil);

        $actuallevel = 'SELECT sid, ep_course_class.level, school_type, ayid
                FROM ep_course_class_dtl
                INNER JOIN ep_course_class
                ON ccid = ep_course_class.id
                INNER JOIN rf_level_class
                ON ep_course_class.level = rf_level_class.level
                WHERE ayid = '.$ayid.'
                AND ';
        $actuallevel .= ((array)$siswa===$siswa) ? ' sid in ('.implode(',',$siswa).')' : ' sid = '.$siswa;
        $hasillevel = DB::select($actuallevel);
        $returnlevel = collect($hasillevel);
        if((array)$siswa===$siswa)
        {
            $arraytotal = array(); $nototal = 0;
            foreach($siswa as $kk=>$vv)
            {
                $totalgpa = 0; $gpa = 0; $array = array();
                $hasil = $return->where('sid',$vv)->sortBy('nameay');
                foreach($hasil as $k=>$v)
                {
                    if($v->nameay <= $actualayid)
                    {
                        if($v->nameay == $actualayid)
                        {
                            if($v->tid <= $actualtid)
                            {
                                $hasillevel = $returnlevel->where('sid',$vv)->where('ayid',$v->ayid);
                                if($v->school_type == $hasillevel[0]->school_type) //memisahkan IPK SMP & SMA
                                {
                                    $array[] = collect($v)->toArray();
                                    $totalgpa += $v->gpa;
                                }
                            }
                        }
                        else
                        {
                            if($v->school_type == $returnlevel[0]->school_type) //memisahkan IPK SMP & SMA
                            {
                                $array[] = collect($v)->toArray();
                                $totalgpa += $v->gpa;
                            }
                        }
                    }
                }
                $no = count($array);
                $arraytotal[$nototal]['sid'] = $vv;
                $arraytotal[$nototal]['ipk'] = ($no!='0') ? round($totalgpa/$no,2) : '0';
                $arraytotal[$nototal]['detail'] = $array;
                $nototal++;
            }
            return $arraytotal;
        }
        else
        {
            $totalgpa = 0; $gpa = 0; $no = 0; $array = array();
            foreach($hasil as $k=>$v)
            {
                if($v->nameay <= $actualayid)
                {
                    if($v->nameay == $actualayid)
                    {
                        if($v->tid <= $actualtid)
                        {
                            if($v->school_type == $hasillevel[0]->school_type) //memisahkan IPK SMP & SMA
                            {
                                $array[$no] = collect($v)->toArray();
                                $totalgpa += $v->gpa;
                                $no++;
                            }
                        }
                    }
                    else
                    {
                        if($v->school_type == $hasillevel[0]->school_type) //memisahkan IPK SMP & SMA
                        {
                            $array[$no] = collect($v)->toArray();
                            $totalgpa += $v->gpa;
                            $no++;
                        }
                    }
                }
            }
            return ($no!='0') ? array('ipk'=>round($totalgpa/$no,2),'detail'=>$array) : '0';
        }
    }
    public static function getIPKSemester($siswa,$ayid,$tid)
    {
        $gpa = new Gpa;
        $gpa = $gpa->getIPK($siswa,$ayid,$tid);
        return $gpa;
    }
    public static function updateIPK($siswa,$ayid,$tid)
    {
        if(is_array($siswa))
        {
            foreach($siswa as $k=>$v)
            {
                Gpa::updateOneIPK($v,$ayid,$tid);
            }
        }
        else
        {
            Gpa::updateOneIPK($siswa,$ayid,$tid);
        }
    }
    public static function updateOneIPK($siswa,$ayid,$tid,$subjectid='')
    {

    }
}
