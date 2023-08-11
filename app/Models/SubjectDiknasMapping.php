<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SubjectDiknasMapping extends Model
{
    use HasFactory;
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "ep_subject_diknas_mapping";
    protected $fillable = [
        'ayid', 'tid', 'level', 'subject_diknas_id', 'name', 'group', 'seq', 'is_mulok', 'cby', 'uby'
    ];

    public static function getFromLevel($level,$ayid,$tid)
    {
        $text = ' SELECT ep_subject_diknas_mapping.*, ep_subject_diknas.short_name, ep_subject_diknas.name
                FROM ep_subject_diknas_mapping
                left join ep_subject_diknas
                on ep_subject_diknas_mapping.subject_diknas_id = ep_subject_diknas.id
                WHERE ayid = '.$ayid.'
                AND tid = '.$tid;
        $text .= is_array($level) ? ' AND level IN ('.implode(',',$level).') ' : ' AND level = '.$level;
        $text .= ' ORDER BY seq';
        $return  = DB::select($text);
        return collect($return);
    }

    public static function getNilai($siswa,$letter_grade)
    {
        $format_code_diknas = 2;
        $actualayid = config('id_active_academic_year');
        $actualtid = config('id_active_term');
        $text = ' SELECT ep_final_grade_dtl.sid, ep_final_grade_dtl.letter_grade, subject_id, subject_seq_no, final_grade, ep_subject_diknas.name as nameay
            FROM
                ep_final_grade_dtl
                INNER JOIN aa_academic_year
                ON aa_academic_year.id = ayid
                INNER JOIN ep_subject_diknas
                ON ep_subject_diknas.id = subject_id
            WHERE format_code = '.$format_code_diknas.'
            AND ayid = '.$actualayid.'
            AND tid = '.$actualtid.'
            AND letter_grade = '.$letter_grade.'
            AND ';
        $text .= ((array)$siswa===$siswa) ? ' sid in ('.implode(',',$siswa).')' : ' sid = '.$siswa;
        $hasil = DB::select($text);
        $return = collect($hasil);
        if((array)$siswa===$siswa)
        {
            $arraytotal = array(); $nototal = 0;
            foreach($siswa as $kk=>$vv)
            {
                $no = 0; $array = array();
                $hasil = $return->where('sid',$vv)->sortBy('subject_seq_no');
                foreach($hasil as $k=>$v)
                {
                    $array[$no] = collect($v)->toArray();
                    $no++;
                }
                $arraytotal[$nototal]['sid']    = $vv;
                $arraytotal[$nototal]['detail'] = $array;
                $nototal++;
            }
            return $arraytotal;
        }
    }

    public static function getNilaiDiknas($siswa,$letter_grade)
    {
        $mapping = new SubjectDiknasMapping;
        $nilai = $mapping->getNilai($siswa,$letter_grade);
        return $nilai;
    }


}
