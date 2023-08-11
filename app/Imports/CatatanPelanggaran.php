<?php

namespace App\Imports;

use App\Models\Punishment;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class CatatanPelanggaran implements ToCollection
{
    public function collection(Collection $rows)
    {
        unset($rows[0],$rows[1]);
        $rows = $rows->toArray();
        if(count($rows)!=0) {
            for($i=0;$i<count($rows);$i++)
            {
                $pid   = $rows[$i+2][0];
                $tgl  = Date::excelToTimestamp($rows[$i+2][3]);
                $level  = $rows[$i+2][4];
                $name  = $rows[$i+2][5];
                $desc  = $rows[$i+2][6];
                if($pid!=''&&$tgl!='') {
                    $cekNote    = Punishment::where('pid', $pid)
                        ->where('date', date('Y-m-d', $tgl))
                        ->where('level', $level)
                        ->where('name', $name)
                        ->where('desc', $desc);

                    if($cekNote->doesntExist())
                    {
                        $insert = new Punishment();
                        $insert->pid = $pid;
                        $insert->date = date('Y-m-d', $tgl);
                        $insert->year = date('Y', $tgl);
                        $insert->level = $level;
                        $insert->name = $name;
                        $insert->desc = $desc;
                        $insert->cby = auth()->user()->id;
                        $insert->save();
                    }
                }
            }
        }
        echo 'Berhasil';
    }
}
