<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class HrAttendanceDuty extends Model
{
    public $timestamps = false;
    protected $table = "hr_attendance_duty";
    protected $fillable = [
        'attendance_id', 'duration', 'duty_id', 'is_done'
    ];

    public static function getPerPerson($id)
    {
        $text = "SELECT * FROM hr_attendance_duty
            JOIN hr_attendance AS ha ON ha.id = attendance_id
            JOIN hr_component AS hc ON hc.id = duty_id
            WHERE pid = ".$id;
        $query = DB::select($text);
        $resultArray = json_decode(json_encode($query), true);
        return $resultArray;
    }
    public static function getPerAttendance($id)
    {
        $text = "SELECT * FROM hr_attendance_duty
            JOIN hr_attendance AS ha ON ha.id = attendance_id
            JOIN hr_component AS hc ON hc.id = duty_id
            WHERE ha.id = ".$id;
        $query = DB::select($text);
        $resultArray = json_decode(json_encode($query), true);
        return $resultArray;
    }
}
