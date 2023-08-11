<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\BayanatAssessment;
use App\Models\BayanatResult;
use App\Models\BayanatWeight;
use App\Models\BayanatMappingDtl;
use Illuminate\Support\Facades\DB;

class NilaiBayanat implements ToCollection
{
    public function collection(Collection $rows)
    {
        $no = 0;
        $array = array();
        unset($rows[0]);
        $rows = $rows->toArray();
        $weight = BayanatWeight::get()->toArray();
        $ayid = config('id_active_academic_year');
        $tid = config('id_active_term');
        $jumlahweight = count($weight);

        //get all pid from excel
        $allpid = array();
        for($i=0;$i<count($rows);$i++)
        {
            if($rows[$i+1][0]!=null)
            {
                $allpid[] = $rows[$i+1][0];
            }
        }
        $detail = BayanatMappingDtl::where('ayid',$ayid)->where('tid',$tid)
            ->whereIn('ep_bayanat_mapping_dtl.pid',$allpid)
            ->join('ep_bayanat_mapping','hdr_id','=','ep_bayanat_mapping.id')
            ->select('ep_bayanat_mapping.*','ep_bayanat_mapping_dtl.pid','ep_bayanat_mapping.pid as eid')
            ->get();
        $text = '';
        $datainput = array();
        for($i=0;$i<count($rows);$i++)
        {
            if($i==count($rows))
            {
                break;
            }
            $sid = (int)$rows[$i+1][0];
            $datainput[$i]['pid'] = $sid;
            $dtid = $detail->where('pid',$sid)->toArray();
            $adtid = reset($dtid);
            for($j=0;$j<$jumlahweight;$j++)
            {
                $kode = (int)$rows[1][$j+3];
                if($rows[$i+1][$j+3]!=null)
                {
                    $nilai = (int)$rows[$i+1][$j+3];
                    $cek = BayanatAssessment::where('ayid',$ayid)
                        ->where('tid',$tid)
                        ->where('pid',$sid)
                        ->where('sub',$kode);
                    if($cek->exists())
                    {
                        $cek->update([
                            'grade' => $nilai,
                            'uby' => auth()->user()->pid,
                        ]);
                    }
                    else
                    {
                        $cek = new BayanatAssessment;
                        $cek->ayid = $ayid;
                        $cek->tid = $tid;
                        $cek->pid = $sid;
                        $cek->sub = $kode;
                        $cek->grade = $nilai;
                        $cek->cby = auth()->user()->pid;
                        $cek->save();
                    }
                }
            }
            if($rows[$i+1][$j+3]!=null)
            {
                $datainput[$i]['result_notes'] = $rows[$i+1][$j+3];
                $cek = BayanatResult::where('ayid',$ayid)
                    ->where('tid',$tid)
                    ->where('pid',$sid)
                    ->where('eid',$adtid['eid'])
                    ->where('cqid',$adtid['ccid']);
                if($cek->exists())
                {
                    $cek->update([
                        'result_notes' => $rows[$i+1][$j+3],
                        'uby' => auth()->user()->pid,
                    ]);
                }
                else
                {
                    $cek = new BayanatResult;
                    $cek->ayid = $ayid;
                    $cek->tid = $tid;
                    $cek->pid = $sid;
                    $cek->eid = $adtid['eid'];
                    $cek->cqid = $adtid['ccid'];
                    $cek->result_notes = $rows[$i+1][$j+3];
                    $cek->cby = auth()->user()->pid;
                    $cek->save();
                }
            }
            if($rows[$i+1][$j+4]!=null)
            {
                $datainput[$i]['juz_has_tasmik'] = $rows[$i+1][$j+4];
                $cek = BayanatResult::where('ayid',$ayid)
                    ->where('tid',$tid)
                    ->where('pid',$sid)
                    ->where('eid',$adtid['eid'])
                    ->where('cqid',$adtid['ccid']);
                if($cek->exists())
                {
                    $cek->update([
                        'juz_has_tasmik' => $rows[$i+1][$j+4],
                        'uby' => auth()->user()->pid,
                    ]);
                }
                else
                {
                    $cek = new BayanatResult;
                    $cek->ayid = $ayid;
                    $cek->tid = $tid;
                    $cek->pid = $sid;
                    $cek->eid = $adtid['eid'];
                    $cek->cqid = $adtid['ccid'];
                    $cek->juz_has_tasmik = $rows[$i+1][$j+4];
                    $cek->cby = auth()->user()->pid;
                    $cek->save();
                }
            }
        }
        echo 'Berhasil';
    }
}
