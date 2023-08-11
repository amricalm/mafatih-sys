<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AllExport implements FromView
{
    var $data;
    public function __construct(array $array)
    {
        $this->data = $array;
    }
    public function view(): View
    {
        $datas = $this->data;
        switch ($datas['type']) {
            case 'kinerja':
                unset($datas['type']);
                $view = 'halaman.report-kinerja-all'.$datas['view'];
                unset($datas['view']);
                return view($view,$datas);
                break;
            case 'kinerja-pekanan':
                unset($datas['type']);
                $view = 'halaman.report-kinerja-pekanan-rekap'.$datas['view'];
                unset($datas['view']);
                return view($view,$datas);
                break;
            case 'rombel':
                unset($datas['type']);
                $view = 'halaman.studygroup-export';
                if(isset($datas['halaman']) && $datas['halaman']=='lainnya')
                {
                    $view = 'halaman.studygroup-lainnya-export';
                }
                return view($view,$datas);
                break;
            case 'rombel-pengasuhan':
                unset($datas['type']);
                return view('halaman.boardinggroup-export',$datas);
                break;
            case 'rombel-pengasuhan-persemester':
                unset($datas['type']);
                return view('halaman.boardinggrouppersemester-export',$datas);
                break;
            case 'headersiswa':
                    unset($datas['type']);
                    return view('halaman.studentheader-export',$datas);
                    break;
            case 'alumni':
                unset($datas['type']);
                return view('halaman.studentpassed-export',$datas);
                break;
            case 'prestasi':
                unset($datas['type']);
                return view('halaman.achievement-export',$datas);
                break;
            case 'pelanggaran':
                    unset($datas['type']);
                    return view('halaman.punishment-export',$datas);
                    break;
            case 'konseling':
                unset($datas['type']);
                return view('halaman.counselling-export',$datas);
                break;
            case 'rombel_bayanat':
                unset($datas['type']);
                return view('halaman.bayanat-halaqah-export',$datas);
                break;

            default:
                break;
        }
    }
}
