<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BayanatMapping extends Model
{
    // use HasFactory;
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "ep_bayanat_mapping";
    protected $fillable = [
        'id',
        'ayid',
        'ccid',
        'level',
        'mm',
        'pid',
        'cby',
        'uby',
    ];

    public static function getall()
    {
        $text = 'SELECT em.id, ec.name_ar as classname,ap.name as teachername, concat(el.name," : ",el.name_ar) as level, el.id as levelid, mm
            FROM ep_bayanat_mapping AS em
            LEFT OUTER JOIN ep_bayanat_class AS ec ON ec.id = ccid
            LEFT OUTER JOIN ep_bayanat_level AS el ON el.id = em.level
            LEFT OUTER JOIN aa_person AS ap ON ap.id = em.pid
            WHERE em.ayid = '.config('id_active_academic_year').' AND em.tid = '.config('id_active_term');
        $return = DB::select($text);
        $return = collect($return);
        $return = json_decode(json_encode($return), true);
        return $return;
    }
    public static function getFromPerson($pid='',$current='1')
    {
        $text = 'SELECT em.id, ec.name_ar as classname, ap.sex as teachersex, ap.name as teachername,
            concat(el.name," : ",el.name_ar) as level, el.id as levelid
            FROM ep_bayanat_mapping_dtl AS emd
            INNER JOIN ep_bayanat_mapping AS em ON em.id = emd.hdr_id
            LEFT OUTER JOIN ep_bayanat_class AS ec ON ec.id = ccid
            LEFT OUTER JOIN ep_bayanat_level AS el ON el.id = em.level
            LEFT OUTER JOIN aa_person AS ap ON ap.id = em.pid ';
        $text .= ($current=='1') ? ' WHERE em.ayid = '.config('id_active_academic_year').' AND em.tid = '.config('id_active_term') : '';
        $text .= ($pid!='') ? (($current=='1') ? ' AND ' : ' WHERE ') : '';
        $text .= ($pid!='') ? (is_array($pid) ? 'emd.pid IN ('.implode(',',$pid).') ' : 'emd.pid = '.$pid.' ') : '';
        $return = DB::select($text);
        $return = collect($return);
        $return = json_decode(json_encode($return), true);
        return $return;
    }
}
