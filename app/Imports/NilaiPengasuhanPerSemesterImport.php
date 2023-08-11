<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\BoardingActivity;
use App\Models\BoardingGradePredicate;

class NilaiPengasuhanPerSemesterImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        unset($rows[1]);
        $rows = $rows->toArray();
        for($i=2;$i<=count($rows);$i++)
        {
            //cari id BoardingActivityItem
            $getBgItem = BoardingActivity::select('id')->where('type', 'ITEM')->orderBy('seq')->get();
            //looping id BoardingActivityItem
            foreach ($getBgItem as $k=>$v)
            {
                $nl = $k+5;
                $cols = $rows[0][$nl]; //mengambil isi dari baris ke 1 kolom ke berapa
                if($cols==$v->id)
                {
                    //jika isi kolom sama dengan id BoardingActivityItem
                    $sid = (int)$rows[$i][0];
                    $ayid = $rows[$i][1];
                    $tid = $rows[$i][2];

                    $getBgDtl = BoardingGradePredicate::where('sid',$sid)
                                ->where('ayid',$ayid)
                                ->where('tid',$tid)
                                ->where('activity_id', $v->id)
                                ->first();
                    if($getBgDtl) {
                        BoardingGradePredicate::where('sid',$sid)
                        ->where('ayid',$ayid)
                        ->where('tid',$tid)
                        ->where('activity_id', $v->id)
                        ->update(['predicate'=>$rows[$i][$nl],'uby'=>auth()->user()->id]);
                    } else {
                        $bgDtl = new BoardingGradePredicate;
                        $bgDtl->sid    = $sid;
                        $bgDtl->ayid   = $ayid;
                        $bgDtl->tid    = $tid;
                        $bgDtl->activity_id   = $v->id;
                        $bgDtl->predicate  = $rows[$i][$nl];
                        $bgDtl->cby = auth()->user()->id;
                        $bgDtl->uby = auth()->user()->id;
                        $bgDtl->save();
                    }
                }
            }
        }
        echo 'Berhasil';
    }
}
