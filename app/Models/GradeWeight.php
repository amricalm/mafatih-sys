<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GradeWeight extends Model
{
    protected $table = "ep_grade_weight";
    protected $fillable = [
        'ayid', 'type', 'val', 'cby', 'uby',
    ];

    public static function getActive()
    {
        $text = ' SELECT id, type, val FROM ep_grade_weight WHERE val != 0 ';
        $return = DB::select($text);
        return collect($return);
    }
}
