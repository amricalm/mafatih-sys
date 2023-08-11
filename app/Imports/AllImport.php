<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Assessment;
use App\Models\GradeWeight;
use App\Models\FinalGrade;
use Illuminate\Support\Facades\DB;

class AllImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $no = 0;
        $array = array();
        switch($rows[0][4])
        {
            case 'FORMATIF':
                unset($rows[0]);
                $rows = $rows->toArray();
                for($i=0;$i<count($rows);$i++)
                {
                    $ayid = config('id_active_academic_year');
                    $tid = config('id_active_term');
                    $subject_id = $rows[$i+1][1];
                    $sid = (int)$rows[$i+1][0];
                    if(isset($rows[($i+1)][4]) && !is_null($rows[($i+1)][4]) && $rows[($i+1)][4]!='0')
                    {
                        $assess = ' DELETE FROM ep_assessment
                            WHERE ayid = '.$ayid.'
                            AND tid = '.$tid.'
                            AND subject_id = '.$subject_id.'
                            AND sid = '.$sid.'
                            AND grade_type = "TGS"
                        ';
                        // die($assess);
                        DB::select($assess);
                        $cek = new Assessment;
                        $cek->ayid = $ayid;
                        $cek->tid = $tid;
                        $cek->subject_id = $subject_id;
                        $cek->sid = $sid;
                        $cek->grade_type = 'TGS';
                        $cek->val = $rows[($i+1)][4];
                        $cek->cby = auth()->user()->id;
                        $cek->save();
                    }
                    if(!is_null($rows[($i+1)][5]) && $rows[($i+1)][5]!='0')
                    {
                        $assess = ' DELETE FROM ep_assessment
                            WHERE ayid = '.$ayid.'
                            AND tid = '.$tid.'
                            AND subject_id = '.$subject_id.'
                            AND sid = '.$sid.'
                            AND grade_type = "UTS"
                        ';
                        // die($assess);
                        DB::select($assess);
                        $cek = new Assessment;
                        $cek->ayid = $ayid;
                        $cek->tid = $tid;
                        $cek->subject_id = $subject_id;
                        $cek->sid = $sid;
                        $cek->grade_type = 'UTS';
                        $cek->val = $rows[($i+1)][5];
                        $cek->cby = auth()->user()->id;
                        $cek->save();
                    }
                    if(!is_null($rows[($i+1)][6]) && $rows[($i+1)][6]!='0')
                    {
                        $assess = ' DELETE FROM ep_assessment
                            WHERE ayid = '.$ayid.'
                            AND tid = '.$tid.'
                            AND subject_id = '.$subject_id.'
                            AND sid = '.$sid.'
                            AND grade_type = "UAS"
                        ';
                        // die($assess);
                        DB::select($assess);
                        $cek = new Assessment;
                        $cek->ayid = $ayid;
                        $cek->tid = $tid;
                        $cek->subject_id = $subject_id;
                        $cek->sid = $sid;
                        $cek->grade_type = 'UAS';
                        $cek->val = $rows[($i+1)][6];
                        $cek->cby = auth()->user()->id;
                        $cek->save();
                    }
                }
                break;
            default:
                break;
        }

        echo 'Berhasil';
    }
}
