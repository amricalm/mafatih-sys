<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Assessment;
use App\Models\GradeWeight;
use App\Models\FinalGrade;
use App\Models\CourseClassDtl;
use Illuminate\Support\Facades\DB;

class NilaiLainnya implements ToCollection
{
    public function collection(Collection $rows)
    {
        $no = 0;
        $format_code = 0;
        $format_code_diknas = 2;
        unset($rows[0]);
        $rows = $rows->toArray();
        for($i=2;$i<=(count($rows));$i++)
        {
            $ayid = config('id_active_academic_year');
            $tid = config('id_active_term');
            $sid = $rows[$i][0];
            $class = CourseClassDtl::where('ayid',$ayid)->where('sid',$sid)->first();
            $ccid = $class->ccid;
            $adatidak = FinalGrade::where('ayid',$ayid)
                ->where('tid',$tid)
                ->where('sid',$sid)
                ->where('ccid',$ccid)
                ->where('format_code', $format_code);

            $adatidakDiknas = FinalGrade::where('ayid',$ayid)
                ->where('tid',$tid)
                ->where('sid',$sid)
                ->where('ccid',$ccid)
                ->where('format_code', $format_code_diknas);

            if(!is_null($adatidak->first()))
            {
                $ada        = $adatidak->first();
                $absent_a   = ($rows[$i][3]!='') ? $rows[$i][3] : $ada->absent_a;
                $absent_i   = ($rows[$i][4]!='') ? $rows[$i][4] : $ada->absent_i;
                $absent_s   = ($rows[$i][5]!='') ? $rows[$i][5] : $ada->absent_s;
                $cleanliness= ($rows[$i][6]!='') ? $rows[$i][6] : $ada->cleanliness;
                $discipline = ($rows[$i][7]!='') ? $rows[$i][7] : $ada->discipline;
                $behaviour  = ($rows[$i][8]!='') ? $rows[$i][8] : $ada->behaviour;
                $activities_parent = ($rows[$i][9]!='') ? $rows[$i][9] : $ada->activities_parent;
                $result = ($rows[$i][11]!='') ? $rows[$i][11] : $ada->result;
                $adatidak->update([
                    'absent_a' => $absent_a,
                    'absent_i' => $absent_i,
                    'absent_s' => $absent_s,
                    'cleanliness' => $cleanliness,
                    'discipline' => $discipline,
                    'behaviour' => $behaviour,
                    'activities_parent' => $activities_parent,
                    'result' => $result,
                    'uon' => date('Y-m-d H:i:s'),
                    'uby' => auth()->user()->id,
                ]);
            }
            else
            {
                $finalgrade = FinalGrade::create(
                    [
                        'ayid' => $ayid,
                        'tid' => $tid,
                        'sid' => $sid,
                        'ccid' => $ccid,
                        'format_code' => $format_code,
                        'absent_a' => $rows[$i][3],
                        'absent_i' => $rows[$i][4],
                        'absent_s' => $rows[$i][5],
                        'cleanliness' => $rows[$i][6],
                        'discipline' => $rows[$i][7],
                        'behaviour' => $rows[$i][8],
                        'activities_parent' => $rows[$i][9],
                        'result' => $rows[$i][11],
                        'con' => date('Y-m-d H:i:s'),
                        'cby' => auth()->user()->id,
                    ]
                );
            }

            if(!is_null($adatidakDiknas->first()))
            {
                $adadiknas        = $adatidakDiknas->first();
                $absent_adiknas   = ($rows[$i][3]!='') ? $rows[$i][3] : $adadiknas->absent_a;
                $absent_idiknas   = ($rows[$i][4]!='') ? $rows[$i][4] : $adadiknas->absent_i;
                $absent_sdiknas   = ($rows[$i][5]!='') ? $rows[$i][5] : $adadiknas->absent_s;
                $cleanlinessdiknas= ($rows[$i][6]!='') ? $rows[$i][6] : $adadiknas->cleanliness;
                $disciplinediknas = ($rows[$i][7]!='') ? $rows[$i][7] : $adadiknas->discipline;
                $behaviourdiknas  = ($rows[$i][8]!='') ? $rows[$i][8] : $adadiknas->behaviour;
                $activities_parentdiknas = ($rows[$i][9]!='') ? $rows[$i][9] : $adadiknas->activities_parent;
                $note_from_student_affairs = ($rows[$i][10]!='') ? $rows[$i][10] : $adadiknas->note_from_student_affairs;
                $resultdiknas = ($rows[$i][11]!='') ? $rows[$i][11] : $adadiknas->result;
                $adatidakDiknas->update([
                    'absent_a' => $absent_adiknas,
                    'absent_i' => $absent_idiknas,
                    'absent_s' => $absent_sdiknas,
                    'cleanliness' => $cleanlinessdiknas,
                    'discipline' => $disciplinediknas,
                    'behaviour' => $behaviourdiknas,
                    'activities_parent' => $activities_parentdiknas,
                    'note_from_student_affairs' => $note_from_student_affairs,
                    'result' => $resultdiknas,
                    'uon' => date('Y-m-d H:i:s'),
                    'uby' => auth()->user()->id,
                ]);
            }
            else
            {
                $finalgrade = FinalGrade::create(
                    [
                        'ayid' => $ayid,
                        'tid' => $tid,
                        'sid' => $sid,
                        'ccid' => $ccid,
                        'format_code' => $format_code_diknas,
                        'absent_a' => $rows[$i][3],
                        'absent_i' => $rows[$i][4],
                        'absent_s' => $rows[$i][5],
                        'cleanliness' => $rows[$i][6],
                        'discipline' => $rows[$i][7],
                        'behaviour' => $rows[$i][8],
                        'activities_parent' => $rows[$i][9],
                        'note_from_student_affairs' => $rows[$i][10],
                        'result' => $rows[$i][11],
                        'con' => date('Y-m-d H:i:s'),
                        'cby' => auth()->user()->id,
                    ]
                );
            }
        }
        echo 'Berhasil';
    }
}
