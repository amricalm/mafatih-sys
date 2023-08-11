<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MainDuties;
use App\Models\Position;
use DataTables;

class MainDutiesController extends Controller
{
    public function index(Request $request)
    {
        $data = MainDuties::join('hr_position', 'aa_main_duties.hrpid', '=', 'hr_position.id')
            ->select('aa_main_duties.id', 'hrpid', 'name', 'desc')
            ->get();
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

        $app['aktif'] = 'tupoksi';
        $app['judul'] = "Tugas Pokok & Fungsi";

        return view('halaman.mainduties', $app);
    }

    public function filter(Request $request)
    {
        $data = MainDuties::join('hr_position', 'aa_main_duties.hrpid', '=', 'hr_position.id')
            ->select('aa_main_duties.id', 'hrpid', 'name', 'desc')
            ->get();
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
                ->filter(function ($data) use ($request) {
                    if (!empty($request->get('position'))) {
                        $data->where('hrpid', $request->get('position'));
                    }
                    if (!empty($request->get('search'))) {
                        $data->where(function ($w) use ($request) {
                            $search = $request->get('search');
                            $w->orWhere('desc', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $app['aktif'] = 'tupoksi';
        $app['judul'] = "Tugas Pokok & Fungsi";
        $app['position'] = Position::select('id', 'name')->get();

        return view('halaman.mainduties', $app);
    }

    public function store(Request $request)
    {
        MainDuties::updateOrCreate(
            ['id' => $request->id],
            ['hrpid' => $request->hrpid, 'desc' => $request->desc, 'cby' => auth()->user()->id, 'uby' => auth()->user()->id]
        );

        $arr = array('status' => 'true', 'msg' => 'Berhasil');
        return Response()->json($arr);
    }

    public function edit($id)
    {
        $data = MainDuties::find($id);
        return response()->json($data);
    }

    public function destroy($id)
    {
        MainDuties::find($id)->delete();

        $arr = array('status' => 'true', 'msg' => 'Berhasil');
        return Response()->json($arr);
    }
}
