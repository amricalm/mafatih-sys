<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\BoardingActivityItem;
use App\Models\BoardingGrade;
use App\Models\BoardingGradeDtl;
use App\Models\GradeWeight;

class NilaiPengasuhanImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        unset($rows[1]);
        $rows = $rows->toArray();
        $result = '';
        $arr = array();
        for($i=2;$i<=count($rows);$i++)
        {
            //cari id BoardingActivityItem
            $getBgItem = BoardingActivityItem::getBoardingItem();
            //looping id BoardingActivityItem
            foreach ($getBgItem as $k=>$v)
            {
                $nl = $k+7;
                $cols = $rows[0][$nl]; //mengambil isi dari baris ke 1 kolom ke berapa
                if($cols==$v['id'])
                {
                    //jika isi kolom sama dengan id BoardingActivityItem
                    $sid = (int)$rows[$i][0];
                    $periode = $rows[$i][1];
                    $ayid = $rows[$i][2];
                    $tid = $rows[$i][3];
                    $act = $rows[$i][6];

                    //cek BoardingGrade sudah ada atau belum
                    $getBg = BoardingGrade::select('id','activity_id','score_total')
                            ->where('ayid',$ayid)
                            ->where('tid',$tid)
                            ->where('periode',$periode)
                            ->where('activity_id', $v['id'])
                            ->first();

                    //jika BoardingGrade sudah ada
                    if($getBg) {
                        //ambil id BoardingGrade
                        $bgid = $getBg->id;
                        $bgScore = $getBg->score_total;
                    } else { //jika BoardingGrade belum
                        //Buat BoardingGrade
                        $bg = new BoardingGrade;
                        $bg->ayid = $ayid;
                        $bg->tid = $tid;
                        $bg->activity_id = $v['id'];
                        $bg->periode = $periode;
                        $bg->score_total = 0;
                        $bg->cby = auth()->user()->id;
                        $bg->uby = auth()->user()->id;
                        $bg->save();
                        //ambil id BoardingGrade
                        $bgid = $bg->id;
                        $bgScore = "";
                    }

                    switch ($act) {
                        case 'HDR':
                            if(!is_null($rows[$i][$nl])) {
                                $arr[$sid][$nl]['bgid']     = $bgid;
                                $arr[$sid][$nl]['sid']      = $sid;
                                $arr[$sid][$nl]['ayid']     = $ayid;
                                $arr[$sid][$nl]['tid']      = $tid;
                                $arr[$sid][$nl]['bgscore']  = $bgScore;
                                $arr[$sid][$nl]['score']    = is_numeric($rows[$i][$nl]) ? $rows[$i][$nl] : 0;
                            }
                            break;
                        case 'RSH':
                            if(!is_null($rows[$i][$nl])) {
                                $arr[$sid][$nl]['remission'] = is_numeric($rows[$i][$nl]) ? $rows[$i][$nl] : 0;
                            }
                            break;

                        default:
                            break;
                    }
                } else {
                    $result = 'Gagal';
                }
            }
        }
        
        foreach($arr AS $siswa=>$column) {
            foreach($column AS $key=>$val) {
                $setbgid        = $val['bgid'];
                $setsid         = $val['sid'];
                $setayid        = $val['ayid'];
                $settid         = $val['tid'];
                $totalScore     = $val['score'] + $val['remission'];
                $setscore       = ($totalScore <= $val['bgscore']) ? $val['score'] : NULL;
                $setremission   = ($totalScore <= $val['bgscore']) ? $val['remission'] : NULL;

                $getBgDtl = BoardingGradeDtl::where('bgid',$setbgid)
                            ->where('sid',$setsid)
                            ->where('ayid',$setayid)
                            ->where('tid',$settid);
                
                if($getBgDtl->exists()) {
                    if(isset($setscore)) {
                        $setbgDtl = $getBgDtl->update(['score'=>$setscore,'remission'=>$setremission]);
                    }
                } else {
                    $bgDtl = new BoardingGradeDtl;
                    $bgDtl->bgid   = $setbgid;
                    $bgDtl->sid    = $setsid;
                    $bgDtl->ayid   = $setayid;
                    $bgDtl->tid    = $settid;
                    $bgDtl->score  = $setscore;
                    $bgDtl->remission  = $setremission;
                    $bgDtl->cby = auth()->user()->id;
                    $bgDtl->uby = auth()->user()->id;
                    $bgDtl->save();
                }
                
                //jika ada total score yang melebihi target
                if(is_null($setscore)) {
                    $result = 'LebihDariTarget';
                }
            }
        }
        $result = $result=='' ? 'Berhasil' : $result;
        echo $result;
    }
}
