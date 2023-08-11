<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SubjectDiknasBasic extends Model
{
    use HasFactory;
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "ep_subject_diknas_basic";
    protected $fillable = [
        'level', 'subject_diknas_id', 'core_competence', 'basic_competence', 'sub_basic_competence', 'desc', 'cby', 'uby'
    ];

    public static function getFromCore($level,$subject)
    {
        $text = ' SELECT *
                FROM ep_subject_diknas_basic
                WHERE level = '.$level.'
                AND subject_diknas_id = '.$subject;
        $return  = DB::select($text);
        return collect($return);
    }
}
