<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Assessment;
use App\Models\GradeWeight;

class NilaiImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $no = 0;
        $array = array();
        unset($rows[0]);
        $rows = $rows->toArray();
        for($i=0;$i<count($rows);$i++)
        {
            $ayid = config('id_active_academic_year');
            $tid = config('id_active_term');
            $subject_id = $rows[$i+1][1];
            $sid = (int)$rows[$i+1][0];

            Assessment::updateOrCreate(
                [
                    'ayid' => $ayid,
                    'tid' => $tid,
                    'subject_id' => $subject_id,
                    'sid' => $sid,
                    'grade_type' => 'TGS',
                ],
                [
                    'val' => $rows[($i+1)][4],
                    'uby' => auth()->user()->id,
                    'cby' => auth()->user()->id,
                ]
            );
            Assessment::updateOrCreate(
                [
                    'ayid' => $ayid,
                    'tid' => $tid,
                    'subject_id' => $subject_id,
                    'sid' => $sid,
                    'grade_type' => 'UTS',
                ],
                [
                    'val' => $rows[$i+1][5],
                    'uby' => auth()->user()->id,
                    'cby' => auth()->user()->id,
                ]
            );
            Assessment::updateOrCreate(
                [
                    'ayid' => $ayid,
                    'tid' => $tid,
                    'subject_id' => $subject_id,
                    'sid' => $sid,
                    'grade_type' => 'UAS',
                ],
                [
                    'val' => $rows[($i+1)][6],
                    'uby' => auth()->user()->id,
                    'cby' => auth()->user()->id,
                ]
            );

        }
        echo 'Berhasil';
    }
}
