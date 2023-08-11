<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Grade extends Model
{
    protected $table = "ep_grade";
    protected $fillable = [
        'format_code', 'ayid', 'tid', 'subject_id', 'sid', 'final_grade', 'passing_grade', 'remedy',
    ];
    public $timestamps = false;

    public static function getGradeStudent($ayid,$tid,$subjid,$sid)
    {
        $text = 'SELECT * FROM ep_grade
            WHERE ayid = '.$ayid.'
            AND tid = '.$tid.'
            AND subject_id = '.$subjid.'
            AND sid = '.$sid;
        $return = DB::select($text);
        $return = (count($return)>=1) ? collect($return[0]) : collect($return);
        $return = json_decode(json_encode($return), true);
        if(count($return)==0)
        {
            $return = ['id'=>'','ayid'=>$ayid,'tid'=>$tid,'subject_id'=>$subjid,'sid'=>$sid,'final_grade'=>0,'passing_grade'=>0,'remedy'=>0];
        }
        return $return;
    }
}
