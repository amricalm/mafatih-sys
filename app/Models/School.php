<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class School extends Model
{
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "aa_school";
    protected $fillable = [
        'institution_id',
        'nss',
        'name',
        'year',
        'school_type_id',
        'accreditation',
        'phone',
        'email',
        'surface_area',
        'building_area',
        'land_status',
    ];

    public static function getActiveSchool($schid)
    {
        $sql = 'SELECT
            aa_school.*, address, post_code, latitude, longitude,
            province, id_provinces.name AS provincename,
            city, id_cities.name AS cityname,
            district, id_districts.name AS districtname,
            village, id_villages.name AS villagename
            FROM
            aa_school
            INNER JOIN (SELECT * FROM aa_address WHERE TYPE="school" LIMIT 1)aa_address ON TYPE="school" AND aa_school.id = pid
            INNER JOIN id_provinces ON province = id_provinces.id
            INNER JOIN id_cities ON city = id_cities.id
            INNER JOIN id_districts ON district = id_districts.id
            INNER JOIN id_villages ON village = id_villages.id
            WHERE aa_school.id = '.$schid;
        $return = DB::select($sql);
        $return = (count($return)>=1) ? collect($return[0]) : collect($return);
        return $return;
    }
}
