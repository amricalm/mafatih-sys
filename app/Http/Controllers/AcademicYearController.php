<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AcademicYear;
use App\Models\AcademicYearDetail;
use App\SmartSystem\General;
use DataTables;

class AcademicYearController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = AcademicYear::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn =
                        '<div class="dropdown">
                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                <a class="dropdown-item detail" href="javascript:void(0)" data-id="' . $row->id . '"><i class="fas fa-info"></i> Detail </a>
                                <a class="dropdown-item edit" href="javascript:void(0)" data-id="' . $row->id . '"><i class="fa fa-pencil"></i> Edit</a>
                                <a class="dropdown-item delete" href="javascript:void(0)" data-id="' . $row->id . '"><i class="fa fa-trash"></i> Hapus</a>
                            </div>
                        </div>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $app['aktif'] = 'tahunajaran';
        $app['judul'] = "Tahun Pelajaran";

        return view('halaman.academicyear', $app);
    }

    public function store(Request $request)
    {
        AcademicYear::updateOrCreate(
            ['id' => $request->id],
            ['name' => $request->name, 'desc' => $request->desc, 'cby' => auth()->user()->id, 'uby' => auth()->user()->id]
        );

        $arr = array('status' => 'true', 'msg' => 'Berhasil');
        return Response()->json($arr);
    }

    public function edit($id)
    {
        $data = AcademicYear::find($id);
        return response()->json($data);
    }

    public function destroy($id)
    {
        AcademicYear::find($id)->delete();

        $arr = array('status' => 'true', 'msg' => 'Berhasil');
        return Response()->json($arr);
    }
    public function saveDetail(Request $request)
    {
		$data = array();
		parse_str($request->datas, $data);
        unset($data['_token']);
        $separated = array();
        foreach($data as $k=>$y)
        {
            if(strpos($k,'1')!==false)
            {
                $ak = explode('1',$k);
                $separated[1][$ak[0]] = $y;
            }
            if(strpos($k,'2')!==false)
            {
                $ak = explode('2',$k);
                $separated[2][$ak[0]] = $y;
            }
        }
        $error = '';
        foreach($separated as $ka=>$ya)
        {
            $tgluts = $ya['tgl_uts'];
            $puts = (isset($ya['publish_uts'])) ? $ya['publish_uts'] : '0';
            $tgluas = $ya['tgl_uas'];
            $puas = (isset($ya['publish_uas'])) ? $ya['publish_uas'] : '0';
            $tglhuts = $ya['tgl_uts_hijri'];
            $tglhuas = $ya['tgl_uas_hijri'];

            $cek = AcademicYearDetail::where('ayid',$data['ayid'])->where('tid',$ka)->get()->toArray();
            $datass = ['mid_exam_date'=>$tgluts,'hijri_mid_exam_date'=>$tglhuts,'publish_mid_exam'=>$puts,'final_exam_date'=>$tgluas,'hijri_final_exam_date'=>$tglhuas,'publish_final_exam'=>$puas];
            if(count($cek)>0)
            {
                $datass['uby'] = auth()->user()->id;
                $datass['uon'] = time();
            }
            else
            {
                $datass['cby'] = auth()->user()->id;
                $datass['con'] = time();
            }
            try {
                $detail = AcademicYearDetail::updateOrCreate(
                    ['ayid'=>$data['ayid'],'tid'=>$ka],
                    $datass
                );
            } catch (\Throwable $th) {
                $error = $th;
            }
        }
        echo ($error=='') ? 'Berhasil' : $error;
    }
    public function loadDetail(Request $request)
    {
        $id = $request->id;
        $data = AcademicYearDetail::where('ayid',$id)->get();
        $datas = array();
        return json_encode($data->toArray());
    }
}
