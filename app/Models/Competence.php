<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Competence extends Model
{
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "ep_competence";
    protected $fillable = [
        'level', 'subject_diknas_id', 'core_competence', 'basic_competence', 'sub_basic_competence', 'desc', 'cby', 'uby'
    ];

    public static function getCompetencePerClass($level,$ccid,$subid,$core)
    {
        $text = DB::select('SELECT com.desc FROM ep_competence com
            LEFT JOIN ep_course_class cc
            ON com.level = cc.level
            WHERE com.level = '.$level.'
            AND cc.id = '.$ccid.'
            AND subject_diknas_id = '.$subid.'
            AND core_competence = '.$core);
        $return = collect($text);
        $return = json_decode(json_encode($return), true);
        return $return;
    }
}
