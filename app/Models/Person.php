<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use function PHPSTORM_META\map;

class Person extends Model
{
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "aa_person";
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'nickname',
        'name_ar',
        'kk',
        'nik',
        'aktalahir',
        'sex',
        'pob',
        'dob',
        'son_order',
        'siblings',
        'stepbros',
        'adoptives',
        'citizen',
        'religion',
        'languages',
        'user_id',
        'ayah_id',
        'ibu_id',
        'wali_id',
        'age',
        'job',
        'last_education',
        'income',
        'stay_with_parent',
        'height',
        'weight',
        'blood',
        'is_glasses',
        'character',
        'hobbies',
        'disease',
        'traumatic',
        'disability',
        'disability_type',
        'hp',
        'email',
        'phone',
        'received_date',
        'out_date',
        'relation',
        'building_status',
        'building_area',
        'surface_area',
        'electricity_bills',
        'water_bills',
        'telecommunication_bills',
        'electronic',
        'vehicle',
        'assets',
        'cby',
        'uby'
    ];

    // public function address()
    // {
    //     return $this->hasMany(Address::class,['parent_id','type'=>'person']);
    // }
    // public function job()
    // {
    //     return $this->hasOne(Job::class,'job');
    // }

}
