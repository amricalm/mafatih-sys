<?php

namespace App\Http\Controllers;

use App\Models\BayanatAssessment;
use App\Models\BayanatClass;
use App\Models\BayanatLevel;
use App\Models\BayanatMapping;
use App\Models\BayanatMappingDtl;
use App\Models\BayanatWeight;
use App\Models\BayanatResult;
use App\Models\BayanatResultDtl;
use App\Models\Employe;
use App\Models\Student;
use App\SmartSystem\General;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BayanatQuranController extends Controller {
	public function __construct() {
        $this->middleware(['auth']);
		$general = new General();
		$this->general = $general;
		$this->menu['aktif'] = 'bayanat-quran';
		$this->menu['judul'] = 'Bayanat Quran';
	}
	public function index(Request $request) {
		$app = $this->menu;
		return view('halaman.bayanat', $app);
	}
	public function halaqah(Request $request) {
		$app = $this->menu;
		$app['kelas'] = BayanatClass::orderBy('id', 'asc')->where('is_deleted', '0')->get();
		return view('halaman.bayanat-halaqah2', $app);
	}
	public function save(Request $request) {
		$datas = array();
		parse_str($request->data, $datas);
		$name = $datas['name'];
		$name_ar = $datas['name_ar'];
		if ($datas['id'] != '') {
			$cek = BayanatClass::where('id', $datas['id'])->first();
			$cek->name = $name;
			$cek->name_ar = $name_ar;
			$cek->uby = auth()->user()->id;
			$cek->save();
		} else {
			$data = new BayanatClass;
			$data->name = $name;
			$data->name_ar = $name_ar;
			$data->cby = auth()->user()->id;
			$data->save();
		}
		echo 'Berhasil';
	}
	public function show(Request $request) {
		$id = $request->id;
		$ada = BayanatClass::where('id', $id)->first();
		echo json_encode($ada, true);
	}
	public function delete(Request $request) {
		$id = $request->id;
		$cek = BayanatClass::where('id', $id)->first();
		$cek->is_deleted = '1';
		$cek->uby = auth()->user()->id;
		$cek->save();
		echo 'Berhasil';
	}
	public function weight(Request $request) {
		$app = $this->menu;
		$app['mapel'] = BayanatWeight::orderBy('id', 'asc')->where('is_deleted', '0')->get();
		return view('halaman.bayanat-weight', $app);
	}
	public function weight_exec(Request $request) {
		$tipe = $request->tipe;
		$datas = array();
		parse_str($request->data, $datas);
		switch ($tipe) {
            case 'insert':
                if ($datas['id'] != '') {
                    $komponen = BayanatWeight::where('id', $datas['id']);
                    if(count($komponen->get())>0)
                    {
                        $komponenupdate = [
                            'name' => $datas['name'],
                            'name_ar' => $datas['name_ar'],
                            'weight' => $datas['weight'],
                            'uby' => auth()->user()->id,
                        ];
                        if(isset($datas['is_group'])&&$datas['is_group']!='0')
                        {
                            $komponenupdate['is_group'] = 1;
                        }
                        $komponen->update( $komponenupdate );
                    }
                } else {
                    $komponen = new BayanatWeight;
                    $komponen->name = $datas['name'];
                    $komponen->name_ar = trim($datas['name_ar']);
                    $komponen->weight = $datas['weight'];
                    if(isset($datas['is_group'])&&$datas['is_group']!='0')
                    {
                        $komponen->is_group = 1;
                    }
                    $komponen->cby = auth()->user()->id;
                    $komponen->save();

                }
                echo 'Berhasil';
                break;
            case 'show':
                $komponen = BayanatWeight::where('id', $request->id)->first();
                echo json_encode($komponen, true);
                break;
            case 'delete':
                $komponen = BayanatWeight::where('id', $request->id)->first();
                $komponen->is_deleted = 1;
                $komponen->save();
                echo 'Berhasil';
                break;
            default:
                break;
		}
	}
	public function level(Request $request) {
		$app = $this->menu;
		$app['level'] = BayanatLevel::orderBy('level', 'asc')->where('is_deleted', '0')->get();
		return view('halaman.bayanat-level', $app);
	}
	public function level_exec(Request $request) {
		$tipe = $request->tipe;
		$datas = array();
		parse_str($request->data, $datas);
		switch ($tipe) {
		case 'insert':
			if ($datas['id'] != '') {
				$komponen = BayanatLevel::where('id', $datas['id'])->first();
				$komponen->name = $datas['name'];
				$komponen->name_ar = trim($datas['name_ar']);
				$komponen->level = $datas['level'];
				$komponen->uby = auth()->user()->id;
				$komponen->save();
			} else {
				$komponen = new BayanatLevel;
				$komponen->name = $datas['name'];
				$komponen->name_ar = trim($datas['name_ar']);
				$komponen->level = $datas['level'];
				$komponen->cby = auth()->user()->id;
				$komponen->save();

			}
			echo 'Berhasil';
			break;
		case 'show':
			$komponen = BayanatLevel::where('id', $request->id)->first();
			echo json_encode($komponen, true);
			break;
		case 'delete':
			$komponen = BayanatLevel::where('id', $request->id)->first();
			$komponen->is_deleted = 1;
			$komponen->save();
			echo 'Berhasil';
			break;
		default:
			break;
		}
	}

	public function mapping(Request $request) {
		$app = $this->menu;
		$app['level'] = BayanatLevel::orderBy('level', 'asc')->where('is_deleted', '0')->get();
		$app['kelas'] = BayanatClass::orderBy('name', 'asc')->where('is_deleted', '0')->get();
		$app['mapping'] = BayanatMapping::getall();
		$app['mappingdtl'] = BayanatMappingDtl::getall();
		$mdtls = collect($app['mappingdtl']);
		$pid = (count($app['mappingdtl']) > 0) ? $mdtls->pluck('pid')->toArray() : [];
		$app['musyrif'] = Employe::where('is_active','1')
            ->join('aa_person', 'pid', '=', 'aa_person.id')
            ->orderBy('aa_person.name', 'asc')
            ->get();
		$santri = Student::join('aa_person', 'pid', '=', 'aa_person.id')
			->orderBy('aa_person.name', 'asc');
		$app['santri'] = ($pid) ? $santri->whereRaw('pid NOT IN (' . implode(',', $pid) . ')')->get() : $santri->get();
		return view('halaman.bayanat-mapping', $app);
	}
	public function mapping_exec(Request $request) {
		$tipe = $request->tipe;
		$datas = array();
		parse_str($request->data, $datas);
		switch ($tipe) {
		case 'insert':
			if ($datas['id'] != '') {
				$komponen = BayanatMapping::where('id', $datas['id'])->first();
				$komponen->ayid = config('id_active_academic_year');
                $komponen->tid = config('id_active_term');
				$komponen->ccid = $datas['ccid'];
				$komponen->level = $datas['level'];
				$komponen->pid = $datas['pid'];
                $komponen->mm = $datas['mm'];
				$komponen->uby = auth()->user()->id;
				$komponen->save();

				$id = $komponen->id;
				BayanatMappingDtl::where('hdr_id', $id)->delete();
				$datadetail = array();
				for ($i = 0; $i < count($datas['pidss']); $i++) {
					$komponendtl = BayanatMappingDtl::updateOrCreate(['hdr_id' => $id, 'pid' => $datas['pidss'][$i]]);
				}
			} else {
				$komponen = new BayanatMapping;
				$komponen->ayid = config('id_active_academic_year');
                $komponen->tid = config('id_active_term');
				$komponen->ccid = $datas['ccid'];
				$komponen->level = $datas['level'];
				$komponen->pid = $datas['pid'];
                $komponen->mm = $datas['mm'];
				$komponen->cby = auth()->user()->id;
				$komponen->save();

				$id = $komponen->id;
				BayanatMappingDtl::where('hdr_id', $id)->delete();
				$datadetail = array();
				for ($i = 0; $i < count($datas['pidss']); $i++) {
					$komponendtl = BayanatMappingDtl::updateOrCreate(['hdr_id' => $id, 'pid' => $datas['pidss'][$i]]);
				}
			}
			echo 'Berhasil';
			break;
		case 'show':
			$data = array();
			$data['komponen'] = BayanatMapping::where('id', $request->id)->first();
			$data['komponendtl'] = BayanatMappingDtl::where('hdr_id', $request->id)
				->join('aa_person', 'pid', '=', 'aa_person.id')
				->select('ep_bayanat_mapping_dtl.id', 'aa_person.name', 'pid', 'hdr_id')
				->orderBy('id', 'asc')
				->get();
			echo json_encode($data, true);
			break;
		case 'delete':
			BayanatMappingDtl::where('hdr_id', $request->id)->delete();
			BayanatMapping::where('id', $request->id)->delete();
			echo 'Berhasil';
			break;
		default:
			break;
		}
	}
	public function assessment(Request $request) {
		$app = array();
		$app['aktif'] = 'bayanat-quran';
		$app['judul'] = 'Input Nilai Bayanat Quran';
		$app['student'] = Student::join('aa_person as a', 'a.id', '=', 'pid')->get();
		$app['employe'] = Employe::where('is_active','1')
            ->join('aa_person', 'pid', '=', 'aa_person.id')
            ->orderBy('aa_person.name', 'asc')
            ->get();
		$app['grade'] = BayanatWeight::get();
        $app['mapping'] = BayanatMapping::join('aa_person','pid','=','aa_person.id')
            ->groupBy('pid')
            ->orderBy('aa_person.name')
            ->where('ayid',config('id_active_academic_year'))
            ->where('tid',config('id_active_term'))
            ->get();
        $app['kelas'] = BayanatMapping::join('ep_bayanat_class','ccid','=','ep_bayanat_class.id')
            ->orderBy('ep_bayanat_class.name')
            ->select('pid','ep_bayanat_class.id','name','name_ar')
            ->where('ep_bayanat_mapping.ayid',config('id_active_academic_year'))
            ->where('ep_bayanat_mapping.tid',config('id_active_term'))
            ->get()->toArray();
		if (auth()->user()->role == '3') {
			$app['mapping'] = $app['mapping']->where('pid', auth()->user()->pid);
			$app['kelas'] = collect($app['kelas'])->where('pid',auth()->user()->pid);
		}
        $app['pilihGuru'] = '';
		$app['pilihlevel'] = '';
        $app['student'] = null;
		$app['req'] = $request;
        $app['assessment'] = null;
		if ($request->post()) {
            $app['pilihGuru'] = $request->pengampu;
            $app['pilihlevel'] = $request->class;
            $app['student'] = BayanatMappingDtl::join('ep_bayanat_mapping','hdr_id','=','ep_bayanat_mapping.id')
                ->where('ayid',config('id_active_academic_year'))
                ->where('tid',config('id_active_term'))
                ->where('ep_bayanat_mapping.pid',$request->pengampu)
                ->where('ccid',$request->class)
                ->join('aa_person','ep_bayanat_mapping_dtl.pid','=','aa_person.id')
                ->select('aa_person.name','aa_person.id')
                ->orderBy('name')
                ->get();
            $id_student = collect($app['student'])->pluck('id')->toArray();
            $app['assessment'] = BayanatAssessment::where('ayid',config('id_active_academic_year'))
                ->where('tid',config('id_active_term'))
                ->whereIn('pid',$id_student)
                ->get();
            $app['catatan'] = BayanatResult::where('ayid',config('id_active_academic_year'))
                ->where('tid',config('id_active_term'))
                ->whereIn('pid',$id_student)
                ->where('eid',$app['pilihGuru'])
                ->where('cqid',$app['pilihlevel'])
                ->get()->toArray();
		}
		return view('halaman.assessment-bayanat', $app);
	}
    public function assessment_exec(Request $request)
    {
		$datas = array();
		parse_str($request->data, $datas);
        if($request->post())
        {
            foreach($datas['val'] as $k=>$v)
            {
                foreach($v as $kk=>$vv)
                {
                    if($vv!='')
                    {
                        $dataassessment = BayanatAssessment::where('pid',$k)
                            ->where('ayid',config('id_active_academic_year'))
                            ->where('tid',config('id_active_term'))
                            ->where('sub',$kk);
                        if($dataassessment->exists())
                        {
                            $dataassessment->update(
                                [
                                    'grade' => $vv,
                                    'uby' => auth()->user()->pid,
                                ]
                            );
                        }
                        else
                        {
                            $dataassessment = new BayanatAssessment;
                            $dataassessment->pid = $k;
                            $dataassessment->ayid = config('id_active_academic_year');
                            $dataassessment->tid = config('id_active_term');
                            $dataassessment->sub = $kk;
                            $dataassessment->grade = $vv;
                            $dataassessment->cby = auth()->user()->pid;
                            $dataassessment->save();
                        }
                    }
                }
            }
            $datainput = array();
            $no = 0;
            foreach($datas['catatan'] as $k=>$v)
            {
                $datainput[$no]['pid'] = $k;
                $datainput[$no]['result_notes'] = ($datas['catatan'][$k]!='') ? $datas['catatan'][$k] : '';
                $no++;

            }
            $no = 0;
            foreach($datas['juz_has_tasmik'] as $k=>$v)
            {
                $datainput[$no]['pid'] = $k;
                $datainput[$no]['juz_has_tasmik'] = ($datas['juz_has_tasmik'][$k]!='') ? $datas['juz_has_tasmik'][$k] : '';
                $no++;
            }
            foreach($datainput as $k=>$v)
            {
                BayanatResult::updateOrCreate
                (
                    [
                        'pid'=>$v['pid'],
                        'eid'=>$datas['eid'],
                        'ayid'=>config('id_active_academic_year'),
                        'tid'=>config('id_active_term'),
                        'cqid'=>$datas['ccid']
                    ],
                    [
                        'result_notes'=>$v['result_notes'],
                        'juz_has_tasmik'=>$v['juz_has_tasmik'],
                        'cby'=>auth()->user()->pid,
                        'uby'=>auth()->user()->pid
                    ]
                );
            }

            echo 'Berhasil';
        }
    }
    public function export(Request $request)
    {
        $pid = (auth()->user()->role=='3') ? auth()->user()->pid : $request->guru;
        $ccid = $request->kelas;

    }
}
