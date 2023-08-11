<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BayanatResultDtl extends Model
{
    public $timestamps = false;
    protected $table = "ep_bayanat_result_dtl";
    protected $fillable = [
        'hid',
        'id_evaluation',
        'result_evaluation',
    ];

    public static function getResultDtl($id,$ayid='-',$tid='-')
    {
        $text = 'select ep_bayanat_result.*,ep_bayanat_result_dtl.*,ap.name as teachername,
            ap.name_ar as teachernamear, ap.sex as teachersex, ep_bayanat_level.name as levelname,
            ep_bayanat_weight.name as weightname, ep_bayanat_weight.name_ar as weightnamear,
            ep_bayanat_weight.is_group, ep_bayanat_class.name_ar, ep_bayanat_mapping.mm, ep_bayanat_level.level
            from `ep_bayanat_result`
            left outer join `ep_bayanat_result_dtl` on `ep_bayanat_result`.`id` = `hid`
            left outer join `ep_bayanat_level` on `ep_bayanat_level`.`id` = `result_level_halqah`
            left outer join `ep_bayanat_weight` on `ep_bayanat_weight`.`id` = `id_evaluation`
            inner join ep_bayanat_mapping_dtl on ep_bayanat_mapping_dtl.pid = ep_bayanat_result.pid
            inner join ep_bayanat_mapping on ep_bayanat_mapping_dtl.hdr_id = ep_bayanat_mapping.id
                and ep_bayanat_mapping.ayid = ep_bayanat_result.ayid
                and ep_bayanat_mapping.tid = ep_bayanat_result.tid
            inner join ep_bayanat_class on ep_bayanat_class.id = ep_bayanat_mapping.ccid
            inner join `aa_person` as `ap` on `ep_bayanat_result`.`eid` = `ap`.`id`
            where `ep_bayanat_result`.`pid` = '.$id;
        $text .= ($ayid!=''&&$ayid!='-') ? ' and ep_bayanat_result.ayid = '.$ayid.'' : '';
        $text .= ($tid!=''&&$tid!='-') ? ' and ep_bayanat_result.tid = '.$tid.'' : '';
        $return = DB::select($text);
        $return = json_decode(json_encode($return), true);
        return $return;
    }
}
