<?php

namespace App\Http\Controllers;

use App\Models\RfCoreCompetence;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\SubjectDiknas;
use App\Models\SubjectDiknasMapping;
use App\Models\RfLevelClass;
use App\Models\SubjectDiknasBasic;
use App\SmartSystem\General;

class DiknasController extends Controller
{
    var $global;
    var $general;
    public function __construct()
    {
		$general = new General();
        $this->general = $general;
        $this->middleware(['auth']);
        $this->global['aktif'] = 'diknas';
        $this->global['judul'] = 'Konfigurasi Diknas';
    }

    public function index(Request $request)
    {
        $app['aktif'] = $this->global['aktif'];
        $app['judul'] = $this->global['judul'];
        return view('halaman.diknas', $app);
    }

    public function subject()
    {
        $app = array();
        $app['aktif'] = $this->global['aktif'];
        $app['judul'] = $this->global['judul'];
        $app['diknas'] = SubjectDiknas::get();

        return view('halaman.diknas-subject',$app);
    }
    public function show_subject(Request $request)
    {
        if($request->ajax())
        {
            $level = $request->level;
            $diknas = SubjectDiknas::get();
            $text   = '';
            $no     = 1;
                foreach($diknas as $key=>$val)
                {
                    $text .= '<tr>';
                    $text .= '<td>'.$no.'</td>';
                    $text .= '<td>'.$val->short_name.'</td>';
                    $text .= '<td>'.$val->name.'</td>';
                    $text .= '<td><button class="btn btn-sm btn-success" onclick="edit('.$val->id.')" ><i class="fa fa-edit"></i> Edit</button><button class="btn btn-sm btn-warning" onclick="hapus('.$val->id.')" ><i class="fa fa-trash"></i> Hapus</button></td>';
                    $text .= '</tr>';
                    $no++;
                }
            $text = ($text!='') ? $text : '<tr><td colspan="3" style="text-align:center;"> - Belum ada data - </td></tr>';
            echo $text;
        }
    }
    public function edit_subject($id)
    {
        $data = SubjectDiknas::find($id);
        return response()->json($data);
    }
    public function save_subject(Request $request)
    {
        if($request->ajax())
        {
            $datas = array();
            parse_str($request->data, $datas);
            if(empty($datas['id'])) {
                $get = SubjectDiknas::create(
                    [
                        'ayid' => config('id_active_academic_year'),
                        'tid' => config('id_active_term'),
                        'short_name' => $datas['nama_singkat'],
                        'name' => $datas['nama'],
                        'cby' => auth()->user()->id,
                        'con' => date('Y-m-d H:i:s')
                    ]
                );
            } else {
                $get = SubjectDiknas::find($datas['id']);
                $get->short_name = $datas['nama_singkat'];
                $get->name = $datas['nama'];
                $get->uby = auth()->user()->id;
                $get->save();
            }

            echo 'Berhasil';
        }
    }
    public function delete_subject(Request $request)
    {
        if($request->ajax())
        {
            $id = $request->id;
            SubjectDiknas::where('id',$id)->delete();
            echo 'Berhasil';
        }
    }

    public function mapping()
    {
        $app = array();
        $app['aktif'] = $this->global['aktif'];
        $app['judul'] = $this->global['judul'];
        $app['level'] = RfLevelClass::get();
        $app['diknas'] = SubjectDiknasMapping::join('ep_subject_diknas','subject_diknas_id','=','ep_subject_diknas.id')->orderBy('level')->orderBy('seq')->get();
        $app['subject_diknas'] = SubjectDiknas::orderBy('id')->get();
        $app['subject'] = Subject::orderBy('name')->get();

        return view('halaman.diknas-mapping',$app);
    }
    public function show_mapping(Request $request)
    {
        if($request->ajax())
        {
            $level = $request->level;
            $diknas = SubjectDiknasMapping::select('ep_subject_diknas_mapping.id','seq','name','group','is_mulok')
                ->join('ep_subject_diknas','subject_diknas_id','=','ep_subject_diknas.id')
                ->where('ayid',config('id_active_academic_year'))
                ->where('tid',config('id_active_term'))
                ->where('level',$level)
                ->orderBy('seq')
                ->get();
            $mapel = Subject::get();
            $text = '';
            if(count($mapel->toArray())>0)
            {
                foreach($diknas as $key=>$val)
                {
                    $kelompok = $this->general::mulok($val->is_mulok);
                    $text .= '<tr>';
                    $text .= '<td>'.$val->seq.'</td>';
                    $text .= '<td>'.$val->name.'</td>';
                    $mapelitu = json_decode($val->group,true);
                    $text .= '<td>';
                    $no = 0;
                    if(!empty($mapelitu))
                    {
                        foreach($mapelitu as $k=>$v)
                        {
                            foreach($mapel as $km=>$vm)
                            {
                                if($vm->id == $v)
                                {
                                    $text .= ($no!=0) ? ', ' : '';
                                    $text .= $vm->name;
                                    $no++;
                                }
                            }
                        }
                    }
                    $text .= '</td>';
                    $text .= '<td>'.$kelompok.'</td>';
                    $text .= '<td><button class="btn btn-sm btn-warning" onclick="hapus('.$level.','.$val->id.')" ><i class="fa fa-trash"></i> Hapus</button></td>';
                    $text .= '</tr>';
                }

            }
            $text = ($text!='') ? $text : '<tr><td colspan="3" style="text-align:center;"> - Belum ada data - </td></tr>';
            echo $text;
        }
    }
    public function edit_mapping($id)
    {
        $data = SubjectDiknasMapping::join('ep_subject_diknas','subject_diknas_id','=','ep_subject_diknas.id')->where('ep_subject_diknas_mapping',$id);
        return response()->json($data);
    }
    public function save_mapping(Request $request)
    {
        if($request->ajax())
        {
            $datas = array();
            parse_str($request->data, $datas);
            $app['ayid']    = config('id_active_academic_year');
            $app['tid']     = config('id_active_term');
            $app['level']   = $datas['level'];
            $app['seq']     = $datas['urutan'];
            $app['subject_diknas_id'] = $datas['subject_diknas'];
            $app['group']   = json_encode($datas['mpid']);
            $app['is_mulok'] = $datas['mulok'];
            $cekMapel = SubjectDiknasMapping::where('ayid', $app['ayid'])
                        ->where('tid', $app['tid'])
                        ->where('level', $app['level'])
                        ->where('subject_diknas_id', $app['subject_diknas_id']);
            if($cekMapel->exists()) {
                $setMapelDiknas = $cekMapel->update([
                                'group' => json_encode($datas['mpid']),
                                'seq' => $app['seq'],
                                'is_mulok' => $app['is_mulok'],
                                'uon' => date('Y-m-d H:i:s'),
                                'uby' => auth()->user()->id
                    ]);
            } else {
                $setMapelDiknas = SubjectDiknasMapping::create($app);
            }
            echo 'Berhasil';
        }
    }
    public function delete_mapping(Request $request)
    {
        if($request->ajax())
        {
            $id = $request->id;
            SubjectDiknasMapping::where('id',$id)->delete();
            echo 'Berhasil';
        }
    }

    public function kompetensi(Request $req) {
		$app['aktif'] = $this->global['aktif'];
        $app['judul'] = $this->global['judul'];
		$app['level'] = RfLevelClass::orderBy('level', 'asc')->get();
		$app['mapel'] = SubjectDiknas::orderBy('id', 'asc')->get();
		$app['core'] = RfCoreCompetence::get();
        $app['pilihtingkat'] = $req->pilihtingkat;
        $app['pilihmapel'] = $req->pilihmapel;
        $app['subject'] = array();
		$app['req'] = $req;
		if ($req->post()) {
		    $app['subject'] = SubjectDiknasBasic::getFromCore($req->pilihtingkat,$req->pilihmapel);
        }
		return view('halaman.diknas-kompetensi', $app);
	}

    public function kompetensi_exec(Request $request) {
		$tipe = $request->tipe;
		$datas = array();
		parse_str($request->data, $datas);
		switch ($tipe) {
		case 'insert':
			if ($datas['id'] != '') {
				$komponen = SubjectDiknasBasic::where('id', $datas['id'])->first();
				$komponen->level = $datas['level'];
				$komponen->subject_diknas_id = $datas['subject'];
				$komponen->core_competence = $datas['core'];
				$komponen->basic_competence = $datas['basic'];
				$komponen->sub_basic_competence = $datas['subbasic'];
				$komponen->desc = $datas['desc'];
				$komponen->uby = auth()->user()->id;
				$komponen->save();
			} else {
				$komponen = new SubjectDiknasBasic;
				$komponen->level = $datas['level'];
				$komponen->subject_diknas_id = $datas['subject'];
				$komponen->core_competence = $datas['core'];
				$komponen->basic_competence = $datas['basic'];
				$komponen->sub_basic_competence = $datas['subbasic'];
				$komponen->desc = $datas['desc'];
				$komponen->cby = auth()->user()->id;
				$komponen->save();
			}
			echo 'Berhasil';
			break;
		case 'show':
			$data = array();
			$data['komponen'] = SubjectDiknasBasic::where('id', $request->id)->first();
			echo json_encode($data, true);
			break;
		case 'delete':
			SubjectDiknasBasic::where('id', $request->id)->delete();
			echo 'Berhasil';
			break;
		default:
			break;
		}
	}
}
