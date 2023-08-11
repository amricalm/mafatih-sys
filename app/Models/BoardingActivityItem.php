<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class BoardingActivityItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    const DELETED_AT = 'don';

    protected $table = "ep_boarding_activity_item";
    protected $fillable = [
        'name', 'name_ar', 'activity_id', 'bypass', 'cby', 'uby'
    ];

    public static function getBoardingItem($periode="")
    {
        $text = 'SELECT ep_boarding_activity_item.id, ep_boarding_activity_item.name, ep_boarding_activity_item.bypass, ep_boarding_activity_item.activity_id';
        if($periode!='') {
            $text .= ', ep_boarding_grade.score_total';
        }
        $text .= ' FROM ep_boarding_activity_item
                LEFT JOIN ep_boarding_activity_nonactive non
                ON ep_boarding_activity_item.id = non.activity_id
                AND ayid = "'.config('id_active_academic_year').'"
                AND tid = "'.config('id_active_term').'"';
                if($periode!='') {
                    $text .= ' LEFT JOIN ep_boarding_grade
                            ON ep_boarding_grade.ayid = "'.config('id_active_academic_year').'"
                            AND ep_boarding_grade.tid = "'.config('id_active_term').'"
                            AND ep_boarding_grade.activity_id = ep_boarding_activity_item.id
                            AND periode = "'.$periode.'"
                            AND ep_boarding_grade.don IS NULL';
                }
        $text .= ' WHERE non.activity_id IS NULL
                AND ep_boarding_activity_item.don IS NULL
                ORDER BY seq ASC';

        $return = DB::select($text);
        $return = collect($return);
        $return = json_decode(json_encode($return), true);
        return $return;
    }

    public static function getBoardingGradeDtl($sid, $periode)
    {
        $text = DB::select('SELECT ep_boarding_activity_item.id, ep_boarding_activity_item.name, ep_boarding_activity_item.bypass, ep_boarding_activity_item.activity_id,
                            IFNULL(NULL, grade.score) AS score, IFNULL(NULL, grade.remission) AS remission, ep_boarding_grade.score_total
                            FROM ep_boarding_activity_item
                            LEFT JOIN ep_boarding_activity_nonactive non
                            ON ep_boarding_activity_item.id = non.activity_id
                            AND ayid = '.config('id_active_academic_year').'
                            AND tid = '.config('id_active_term').'
                            AND non.desc = "ITEM"
                            LEFT JOIN (
                                SELECT sid, activity_id, score, remission, ep_boarding_grade_dtl.ayid, ep_boarding_grade_dtl.tid, score_total, bgid
                                FROM ep_boarding_grade_dtl
                                LEFT JOIN ep_boarding_grade
                                ON bgid = ep_boarding_grade.id
                                WHERE ep_boarding_grade_dtl.ayid = '.config('id_active_academic_year').'
                                AND ep_boarding_grade_dtl.tid = '.config('id_active_term').'
                                AND ep_boarding_grade.periode = '.$periode.'
                                AND sid = '.$sid.'
                                GROUP BY sid, activity_id, score, remission, ep_boarding_grade_dtl.ayid, ep_boarding_grade_dtl.tid,score_total, bgid
                            ) AS grade
                            ON ep_boarding_activity_item.id = grade.activity_id
                            LEFT JOIN ep_boarding_grade
                            ON ep_boarding_activity_item.id = ep_boarding_grade.activity_id
                            AND ep_boarding_grade.ayid = '.config('id_active_academic_year').'
                            AND ep_boarding_grade.tid = '.config('id_active_term').'
                            AND ep_boarding_grade.periode = '.$periode.'
                            WHERE non.activity_id IS NULL
                            AND ep_boarding_activity_item.don IS NULL
                            ORDER BY seq ASC');
        $return = collect($text);
        $return = json_decode(json_encode($return), true);
        return $return;
    }
}
