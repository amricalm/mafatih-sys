<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MedicalRecord extends Model
{
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "aa_medical_record";
    protected $fillable = [
        'pid',
        'name',
        'year',
        'date',
        'desc',
        'handle',
        'handly_by',
        'is_finish',
        'is_publish',
        'cby',
        'uby',
    ];

    public function getFromPerson($id='')
    {
        $text = " SELECT aa_medical_record.id, pid, aa_medical_record.name, aa_medical_record.year,
            aa_medical_record.date, aa_medical_record.desc, handle, handle_by,
            aa_person.name as handlebyname, aa_person.sex,
            is_finish, is_publish,
            aa_medical_record.cby, aa_medical_record.uby, aa_medical_record.uby, aa_medical_record.uon
            FROM aa_medical_record
            LEFT OUTER JOIN aa_person ON handle_by = aa_person.id ";
        if(is_array($id))
        {
            $text .= " WHERE pid IN (".implode($id).")";
        }
        else
        {
            $text .= " WHERE pid = ".$id;
        }
        $text .= ' ORDER BY uon DESC ';
        return collect(DB::select($text));
    }
}
