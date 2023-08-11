<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\BayanatResultDtl;

class BayanatResult extends Model
{
    // use HasFactory;
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    // public $incrementing = false;
    // public $primaryKey = 'id';
    protected $table = "ep_bayanat_result";
    protected $fillable = [
        'id',
        'pid',
        'eid',
        'ayid',
        'tid',
        'cqid',
        'juz_has_tasmik',
        'juz_is_studey',
        'result_halqah',
        'result_level_halqah',
        'result_eloquence',
        'result_fluency',
        'result_balance',
        'result_written',
        'result_notes',
        'result_set',
        'result_decision_set',
        'result_appreciation',
        'result_decision_level',
        'cby',
        'uby',
    ];

    public static function getFromPerson($person,$ayid='',$tid='')
    {

        $text = ' SELECT id, pid, eid, ayid, tid, cqid, juz_has_tasmik,
            juz_is_study, result_halqah, result_level_halqah,
            result_notes, result_set, result_decision_set, result_appreciation,
            result_decision_level FROM ep_bayanat_result
            WHERE pid IN ('.implode(',',$person).')';
        $text .= ($ayid!='') ? ' AND ayid = '.$ayid : '';
        $text .= ($tid!='') ? ' AND tid = '.$tid : '';
        $return = DB::select($text);
        return collect($return);
    }

    public static function insertFromProcess($nilaibayanat)
    {
        // Proses masukkan nilai-nilai bayanat ke bayanatresult
        for($i=0;$i<count($nilaibayanat);$i++)
        {
            $cekada = BayanatResult::where('pid',$nilaibayanat[$i]['pid'])
                ->where('ayid',$nilaibayanat[$i]['ayid'])
                ->where('tid',$nilaibayanat[$i]['tid'])
                ->where('cqid',$nilaibayanat[$i]['cqid'])
                ->where('eid',$nilaibayanat[$i]['eid']);
            if($cekada->exists())
            {
                $cekada->update(
                    [
                        'juz_is_study'=>$nilaibayanat[$i]['juz_is_study'],
                        'result_level_halqah'=>$nilaibayanat[$i]['result_level_halqah'],
                        'result_set'=>$nilaibayanat[$i]['result_set'],
                        'result_decision_set'=>$nilaibayanat[$i]['result_decision_set'],
                        'result_appreciation'=>$nilaibayanat[$i]['result_appreciation'],
                        // 'result_decision_level'=>$nilaibayanat[$i]['result_decision_level'],
                        'uby'=>auth()->user()->pid,
                        'uon'=>date('Y-m-d H:i:s'),
                    ]
                );
                $ada = $cekada->first();
                if(!is_null($ada))
                {
                    $id = $cekada->first()['id'];
                    $detail = array();
                    $nodetail = 0;
                    foreach($nilaibayanat[$i]['detail'] as $ky=>$vl)
                    {
                        $detail[$nodetail]['hid'] = $id;
                        $detail[$nodetail]['id_evaluation'] = $vl['id_evaluation'];
                        $detail[$nodetail]['weight_evaluation'] = $vl['weight_evaluation'];
                        $detail[$nodetail]['result_evaluation'] = $vl['result_evaluation'];
                        $nodetail++;
                    }
                    BayanatResultDtl::where('hid',$id)->delete();
                    BayanatResultDtl::insert($detail);
                }
            }
            else
            {
                $create = new BayanatResult();
                $create->pid = $nilaibayanat[$i]['pid'];
                $create->ayid = $nilaibayanat[$i]['ayid'];
                $create->tid = $nilaibayanat[$i]['tid'];
                $create->cqid = $nilaibayanat[$i]['cqid'];
                $create->eid = $nilaibayanat[$i]['eid'];
                $create->juz_is_study = $nilaibayanat[$i]['juz_is_study'];
                $create->result_level_halqah = $nilaibayanat[$i]['result_level_halqah'];
                $create->result_set = $nilaibayanat[$i]['result_set'];
                $create->result_decision_set = $nilaibayanat[$i]['result_decision_set'];
                $create->result_appreciation = $nilaibayanat[$i]['result_appreciation'];
                // $create->result_decision_level = $nilaibayanat[$i]['result_decision_level'];
                $create->cby = auth()->user()->pid;
                $create->con = date('Y-m-d H:i:s');
                $create->save();

                $ada = $create->id;
                if(!is_null($ada))
                {
                    $id = $ada;
                    $detail = array();
                    $nodetail = 0;
                    foreach($nilaibayanat[$i]['detail'] as $ky=>$vl)
                    {
                        $detail[$nodetail]['hid'] = $id;
                        $detail[$nodetail]['id_evaluation'] = $vl['id_evaluation'];
                        $detail[$nodetail]['weight_evaluation'] = $vl['weight_evaluation'];
                        $detail[$nodetail]['result_evaluation'] = $vl['result_evaluation'];
                        $nodetail++;
                    }
                    BayanatResultDtl::insert($detail);
                }
            }
        }
    }

}
