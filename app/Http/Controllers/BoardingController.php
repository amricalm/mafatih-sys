<?php

namespace App\Http\Controllers;

use App\Models\CourseClass;
use Illuminate\Http\Request;
use App\Models\BoardingActivityGroup;
use App\Models\BoardingActivity;
use App\Models\CourseSubject;
use App\Models\Employe;
use DataTables;

class BoardingController extends Controller
{
    //Kegiatan Santri
    public function index(Request $request)
    {
        $data = BoardingActivity::orderBy('group_id')->get();
        if ($request->ajax()) {
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
                                <a class="dropdown-item edit" href="javascript:void(0)" data-id="' . $row->id . '"><i class="fa fa-pencil"></i> Edit</a>
                                <a class="dropdown-item delete" href="javascript:void(0)" data-id="' . $row->id . '"><i class="fa fa-trash"></i> Hapus</a>
                            </div>
                        </div>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $app['aktif'] = 'kegiatan-siswa';
        $app['judul'] = "Kegiatan Santri";

        return view('halaman.boarding-activity', $app);
    }

    public function store(Request $request)
    {
        BoardingActivity::updateOrCreate(
            ['id' => $request->id],
            ['name' => $request->name, 'name_ar' => $request->name_ar, 'point' => $request->point, 'cby' => auth()->user()->id, 'uby' => auth()->user()->id]
        );

        $arr = array('status' => 'true', 'msg' => 'Berhasil');
        return Response()->json($arr);
    }

    public function edit($id)
    {
        $data = BoardingActivity::find($id);
        return response()->json($data);
    }

    public function destroy($id)
    {
        BoardingActivity::find($id)->delete();

        $arr = array('status' => 'true', 'msg' => 'Berhasil');
        return Response()->json($arr);
    }
}
