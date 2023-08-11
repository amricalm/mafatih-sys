<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BayanatAssessment extends Model
{
    // use HasFactory;
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    public $incrementing = false;
    public $primaryKey = null;
    protected $table = "ep_bayanat_assessment";
    protected $fillable = [
        'pid',
        'ayid',
        'tid',
        'sub',
        'grade',
        'cby',
        'uby',
    ];

    public static function getAssessmentToProcess($arrayid)
    {
        $text = 'select ap.name, ap.id as eid
            , epbl.id as juzid, epbl.name as level, epbl.name_ar as juz
            , epbc.id as cqid, epbc.name as kelas
            , epbw.id as bobotid, epbw.name as namabobot, epbw.weight as bobot
            , grade
            , epba.pid
            from ep_bayanat_assessment epba
            join ep_bayanat_mapping_dtl epbmpd on epba.pid = epbmpd.pid
            join ep_bayanat_mapping epbm on epbmpd.hdr_id = epbm.id
            left outer join ep_bayanat_level epbl on epbm.level = epbl.id
            left outer join ep_bayanat_class epbc on epbm.ccid = epbc.id
            join ep_bayanat_weight epbw on epbw.id = epba.sub
            join aa_person ap on epbm.pid = ap.id
                and epbm.tid = '.config('id_active_term').'
                and epbm.ayid = '.config('id_active_academic_year').'
            where epba.tid = '.config('id_active_term').'
            and epba.ayid = '.config('id_active_academic_year').'
            and epba.pid in ('.implode(',',$arrayid).')';
        $return = DB::select($text);
        $return = collect($return);
        $return = json_decode(json_encode($return), true);
        return $return;
    }
    public static function getDecisionSet($nilai)
    {
        if($nilai>=60)
        {
            return 'ناجح';
        }
        elseif($nilai>=55)
        {
            return 'راسب';
        }
        else
        {
            return 'ناجح مع الإشراف';
        }
    }
    public static function getAppreciation($nilai)
    {
        if($nilai>=90)
        {
            return 'ممتاز';
        }
        elseif($nilai>=80)
        {
            return 'جيد جدا';
        }
        elseif($nilai>=70)
        {
            return 'جيد';
        }
        elseif($nilai>=60)
        {
            return 'مقبول';
        }
        elseif($nilai>=57)
        {
            return 'إشراف';
        }
        elseif($nilai>=55)
        {
            return 'ضعيف';
        }
        else
        {
            return 'إشراف تفوق';
        }
    }
    public static function getDecisionLevel($nilai)
    {
        if($nilai>=60)
        {
            return 'تم';
        }
        else
        {
            return 'لم يتم';
        }
    }
}
