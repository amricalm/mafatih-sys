<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Student extends Model
{
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "aa_student";
    protected $fillable = [
        'id', 'pid', 'nis', 'nisn', 'active', 'cby', 'uby'
    ];

    public function get()
    {
        $query = DB::table($this->table);
    }

    public function getForDropdown($id='')
    {
        $text = " SELECT aa_person.*, nis, nisn, active
            FROM aa_student
            INNER JOIN aa_person ON pid = aa_person.id ";
        if($id!='')
        {
            $text .= (is_array($id)) ? " WHERE id in (".implode($id,',').")" : ' WHERE id = '.$id;
        }
        return DB::select($text);
    }

    public static function mustawa($id,$ayid,$tid)
    {
        $text = 'select ep_course_class.name, level, (level-1)*2 + '.$tid.' as mustawa
            FROM aa_student
            join ep_course_class_dtl on sid = aa_student.id
            join ep_course_class on ccid = ep_course_class.id
            where aa_student.id = '.$id.'
            and ayid = '.$ayid;
        $return = DB::select($text);
        $return = collect($return[0]);
        $return = json_decode(json_encode($return), true);
        return $return['mustawa'];
    }
}
