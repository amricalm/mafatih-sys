<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\SubjectDiknasBasic;
use Illuminate\Support\Facades\DB;

class KompetensiDasar implements ToCollection
{
    public function collection(Collection $rows)
    {
                unset($rows[0]);
                $rows = $rows->toArray();
                for($i=0;$i<count($rows);$i++)
                {
                    $level      = (int)$rows[$i+1][0];
                    $subject    = (int)$rows[$i+1][1];
                    $core       = (int)$rows[$i+1][2];
                    $basic      = (int)$rows[$i+1][3];
                    $subbasic   = isset($rows[$i+1][4]) ? (int)$rows[$i+1][4] : 0;
                    $desc       = $rows[$i+1][5];
                    if(isset($level) && !is_null($level) && $level!='0' &&
                    isset($subject) && !is_null($subject) && $subject!='0' &&
                    isset($core) && !is_null($core) && $core!='0' &&
                    isset($basic) && !is_null($basic) && $basic!='0')
                    {
                        $assess = ' DELETE FROM ep_subject_diknas_basic
                            WHERE level = '.$level.'
                            AND subject_diknas_id = '.$subject.'
                            AND core_competence = '.$core.'
                            AND basic_competence = '.$basic.'
                        ';

                        DB::select($assess);
                        $cek = new SubjectDiknasBasic;
                        $cek->level = $level;
                        $cek->subject_diknas_id = $subject;
                        $cek->core_competence = $core;
                        $cek->basic_competence = $basic;
                        $cek->sub_basic_competence = $subbasic;
                        $cek->desc = $desc;
                        $cek->cby = auth()->user()->id;
                        $cek->save();
                    }
                }

        echo 'Berhasil';
    }
}
