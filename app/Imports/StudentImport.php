<?php

namespace App\Imports;

use App\Models\Address;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Person;
use App\Models\Student;
use App\Models\SchoolOrigin;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class StudentImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        unset($rows[0]);
        $rows = $rows->toArray();

        for($i=0;$i<count($rows);$i++)
        {
            //aa_person
            $nis        = $rows[$i+1][0];
            $nisn       = $rows[$i+1][1];
            $nik        = $rows[$i+1][2];
            $aktalahir  = $rows[$i+1][3];
            $name       = $rows[$i+1][4];
            $name_ar    = $rows[$i+1][5];
            $nickname   = $rows[$i+1][6];
            $pob        = $rows[$i+1][7];
            $dob        = date('Y-m-d',Date::excelToTimestamp($rows[$i+1][8]));
            $sex        = $rows[$i+1][9];
            $religion   = $rows[$i+1][10];
            $hp         = strval($rows[$i+1][11]);
            $email      = $rows[$i+1][12];
            $citizen    = $rows[$i+1][13];
            $son_order  = $rows[$i+1][14];
            $siblings   = $rows[$i+1][15];
            $stepbros   = $rows[$i+1][16];
            $adoptives  = $rows[$i+1][17];
            $languages  = $rows[$i+1][18];

            //aa_address
            $address    = $rows[$i+1][19];
            $post_code  = $rows[$i+1][20];

            //aa_person
            $phone      = strval($rows[$i+1][21]);
            $stay_with_parent   = $rows[$i+1][22];
            $blood      = $rows[$i+1][23];
            $weight     = $rows[$i+1][24];
            $height     = $rows[$i+1][25];

            //aa_school_origin
            $school_origin_name = $rows[$i+1][26];
            $exam_number= $rows[$i+1][27];
            $skhu       = $rows[$i+1][28];
            $diploma_number     = $rows[$i+1][29];
            $study_year = $rows[$i+1][30];

            //aa_person
            $ayah_name  = $rows[$i+1][31];
            $ayah_nik   = $rows[$i+1][32];
            $ayah_pob   = $rows[$i+1][33];
            $ayah_dob   = date('Y-m-d',Date::excelToTimestamp($rows[$i+1][34]));
            $ayah_religion  = $rows[$i+1][35];
            $ayah_citizen   = $rows[$i+1][36];
            $ayah_address   = $rows[$i+1][37];
            $ayah_post_code = $rows[$i+1][38];
            $ayah_hp    = strval($rows[$i+1][39]);
            $ayah_last_education    = $rows[$i+1][40];
            $ayah_job   = $rows[$i+1][41];
            $ayah_income= $rows[$i+1][42];
            $ibu_name   = $rows[$i+1][43];
            $ibu_nik    = $rows[$i+1][44];
            $ibu_pob    = $rows[$i+1][45];
            $ibu_dob    = date('Y-m-d',Date::excelToTimestamp($rows[$i+1][46]));
            $ibu_religion   = $rows[$i+1][47];
            $ibu_citizen     = $rows[$i+1][48];
            $ibu_address    = $rows[$i+1][49];
            $ibu_post_code  = $rows[$i+1][50];
            $ibu_hp     = strval($rows[$i+1][51]);
            $ibu_last_education = $rows[$i+1][52];
            $ibu_job    = $rows[$i+1][53];
            $ibu_income = $rows[$i+1][54];
            $wali_name  = $rows[$i+1][55];
            $wali_nik   = $rows[$i+1][56];
            $wali_pob   = $rows[$i+1][57];
            $wali_dob   = date('Y-m-d',Date::excelToTimestamp($rows[$i+1][58]));
            $wali_religion  = $rows[$i+1][59];
            $wali_citizen    = $rows[$i+1][60];
            $wali_address   = $rows[$i+1][61];
            $wali_post_code = $rows[$i+1][62];
            $wali_hp    = strval($rows[$i+1][63]);
            $wali_last_education    = $rows[$i+1][64];
            $wali_job   = $rows[$i+1][65];
            $wali_income= $rows[$i+1][66];

            //jika ada nama ayah
            if($ayah_name!='') {
                $ayah = Person::updateOrCreate(
                    [
                        'name' => $ayah_name,
                    ],
                    [
                        'nik' => $ayah_nik,
                        'pob' => $ayah_pob,
                        'dob' => $ayah_dob,
                        'sex' => 'L',
                        'religion' => $ayah_religion,
                        'citizen' => $ayah_citizen,
                        'hp' => $ayah_hp,
                        'last_education' => $ayah_last_education,
                        'job' => $ayah_job,
                        'income' => $ayah_income,
                        'uby' => auth()->user()->id,
                        'cby' => auth()->user()->id,
                    ]
                );
            }
            $ayah_id    = isset($ayah->id) ? $ayah->id : '';

            //jika ada nama ibu
            if($ibu_name!='') {
                $ibu = Person::updateOrCreate(
                    [
                        'name' => $ibu_name,
                    ],
                    [
                        'nik' => $ibu_nik,
                        'pob' => $ibu_pob,
                        'dob' => $ibu_dob,
                        'sex' => 'P',
                        'religion' => $ibu_religion,
                        'citizen' => $ibu_citizen,
                        'hp' => $ibu_hp,
                        'last_education' => $ibu_last_education,
                        'job' => $ibu_job,
                        'income' => $ibu_income,
                        'uby' => auth()->user()->id,
                        'cby' => auth()->user()->id,
                    ]
                );
            }
            $ibu_id    = isset($ibu->id) ? $ibu->id : '';

            //jika ada nama wali
            if($wali_name!='') {
                $wali = Person::updateOrCreate(
                    [
                        'name' => $wali_name,
                    ],
                    [
                        'nik' => $wali_nik,
                        'pob' => $wali_pob,
                        'dob' => $wali_dob,
                        'sex' => 'L',
                        'religion' => $wali_religion,
                        'citizen' => $wali_citizen,
                        'hp' => $wali_hp,
                        'last_education' => $wali_last_education,
                        'job' => $wali_job,
                        'income' => $wali_income,
                        'uby' => auth()->user()->id,
                        'cby' => auth()->user()->id,
                    ]
                );
            }
            $wali_id    = isset($wali->id) ? $wali->id : '';

            //person
            $person = Person::updateOrCreate(
                [
                    'name' => $name,
                ],
                [
                    'nik' => $nik,
                    'aktalahir' => $aktalahir,
                    'name_ar' => $name_ar,
                    'nickname' => $nickname,
                    'pob' => $pob,
                    'dob' => $dob,
                    'sex' => $sex,
                    'religion' => $religion,
                    'hp' => $hp,
                    'email' => $email,
                    'citizen' => $citizen,
                    'son_order' => $son_order,
                    'siblings' => $siblings,
                    'stepbros' => $stepbros,
                    'adoptives' => $adoptives,
                    'languages' => $languages,
                    'ayah_id' => $ayah_id,
                    'ibu_id' => $ibu_id,
                    'wali_id' => $wali_id,
                    'phone' => $phone,
                    'stay_with_parent' => $stay_with_parent,
                    'blood' => $blood,
                    'weight' => $weight,
                    'height' => $height,
                    'uby' => auth()->user()->id,
                    'cby' => auth()->user()->id,
                ]
            );
            $person_id    = $person->id;

            //student
            Student::updateOrCreate(
                [
                    'pid' => $person_id,
                ],
                [
                    'nis' => $nis,
                    'nisn' => $nisn,
                    'uby' => auth()->user()->id,
                    'cby' => auth()->user()->id,
                ]
            );

            //sekolah asal
            if($school_origin_name!='') {
                SchoolOrigin::updateOrCreate(
                    [
                        'pid' => $person_id,
                    ],
                    [
                        'nis' => $nis,
                        'school_origin_name' => $school_origin_name,
                        'exam_number' => $exam_number,
                        'skhu' => $skhu,
                        'diploma_number' => $diploma_number,
                        'study_year' => $study_year,
                        'uby' => auth()->user()->id,
                        'cby' => auth()->user()->id,
                    ]
                );
            }

            //jika alamat siswa ada
            if($address!='') {
                if($person_id!='') {
                    Address::updateOrCreate(
                        [
                            'pid' => $person_id,
                        ],
                        [
                            'type' => 'person',
                            'address' => $address,
                            'post_code' => $post_code,
                            'uby' => auth()->user()->id,
                            'cby' => auth()->user()->id,
                        ]
                    );
                }
            }

            //jika alamat ayah ada
            if($ayah_address!='') {
                if($ayah_id!='') {
                    Address::updateOrCreate(
                        [
                            'pid' => $ayah_id,
                        ],
                        [
                            'type' => 'person',
                            'address' => $ayah_address,
                            'post_code' => $ayah_post_code,
                            'uby' => auth()->user()->id,
                            'cby' => auth()->user()->id,
                        ]
                    );
                }
            }

            //jika alamat ibu ada
            if($ibu_address!='') {
                if($ibu_id!='') {
                    Address::updateOrCreate(
                        [
                            'pid' => $ibu_id,
                        ],
                        [
                            'type' => 'person',
                            'address' => $ibu_address,
                            'post_code' => $ibu_post_code,
                            'uby' => auth()->user()->id,
                            'cby' => auth()->user()->id,
                        ]
                    );
                }
            }

            //jika alamat wali ada
            if($wali_address!='') {
                if($wali_id!='') {
                    Address::updateOrCreate(
                        [
                            'pid' => $wali_id,
                        ],
                        [
                            'type' => 'person',
                            'address' => $wali_address,
                            'post_code' => $wali_post_code,
                            'uby' => auth()->user()->id,
                            'cby' => auth()->user()->id,
                        ]
                    );
                }
            }
        }
        echo 'Berhasil';
    }
}
