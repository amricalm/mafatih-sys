<?php

namespace App\Imports;

use App\Models\BoardingNote;
use App\Models\CourseClassDtl;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\FinalGrade;

class CatatanPengasuhanPerSemesterImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        unset($rows[0]);
        $rows = $rows->toArray();
        $k = ($rows[1][2] == 1) ? 0 : 1;
        for($i=$k;$i<count($rows);$i++)
        {
            $sid   = $rows[$i+1][0];
            $ayid  = $rows[$i+1][1];
            $tid   = $rows[$i+1][2];
            $eid   = $rows[$i+1][3];
            if($tid==1) {
                $note  = $rows[$i+1][6];
            } else {
                $noteAkademik  = $rows[$i+1][6];
                $note  = $rows[$i+1][7];
            }
            $cekNote    = BoardingNote::where('ayid', $ayid)
                        ->where('tid', $tid)
                        ->where('sid', $sid)
                        ->first();
            $class = CourseClassDtl::select('ccid')
                        ->where('ayid',config('id_active_academic_year'))
                        ->where('sid',$sid)
                        ->first();

            if(is_null($cekNote))
            {
                $insert = new BoardingNote;
                $insert->ayid = $ayid;
                $insert->tid = $tid;
                $insert->sid = $sid;
                $insert->eid = $eid;
                $insert->note = $note;
                $insert->uby = auth()->user()->id;
                $insert->cby = auth()->user()->id;
                $insert->save();
            } else {
                if($note!='') {
                    $update = BoardingNote::find($cekNote->id);
                    $update->eid = $eid;
                    $update->note = $note;
                    $update->cby = auth()->user()->id;
                    $update->uby = auth()->user()->id;
                    $update->save();
                }
            }
            if($tid==2) {
                $cariFinalGrade = FinalGrade::where('ayid',config('id_active_academic_year'))
                            ->where('tid',config('id_active_term'))
                            ->where('sid',$sid)
                            ->where('ccid',$class->ccid)
                            ->where('format_code','0');

                if($cariFinalGrade->exists())
                {
                    if($noteAkademik!='')
                    {
                        $cariFinalGrade->update(['note_from_student_affairs'=>$noteAkademik,'uby'=>auth()->user()->id]);
                    }
                }
                else
                {
                    $cariFinalGrade = new FinalGrade;
                    $cariFinalGrade->ayid = config('id_active_academic_year');
                    $cariFinalGrade->tid = config('id_active_term');
                    $cariFinalGrade->sid = $sid;
                    $cariFinalGrade->ccid = $class->ccid;
                    $cariFinalGrade->format_code = '0';
                    $cariFinalGrade->note_from_student_affairs = $noteAkademik;
                    $cariFinalGrade->cby = auth()->user()->id;
                    $cariFinalGrade->save();
                }
            }
        }
        echo 'Berhasil';
    }
}
