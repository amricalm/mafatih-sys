<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Homeroom;
use App\Models\CourseClass;
use App\Models\Employe;
use DataTables;

class HomeroomController extends Controller
{
    public function index(Request $request)
    {
        $app['aktif'] = 'walikelas';
        $app['judul'] = "Wali Kelas";

        return view('halaman.homeroom', $app);
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('ep_course_class as cc')
                ->leftJoin('aa_homeroom as hr', function ($join) {
                    $join->on('cc.id', '=', 'hr.ccid')
                        ->where('hr.ayid', '=', config('id_active_academic_year'));
                })
                ->leftJoin('aa_employe as em', 'hr.emid', '=', 'em.id')
                ->leftJoin('aa_person as pe', 'em.pid', '=', 'pe.id')
                ->select('cc.id', 'cc.name as class', 'pe.name as homeroom','pe.name_ar')
                ->get();
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
                            </div>
                        </div>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $app['aktif'] = 'walikelas';
        $app['judul'] = "Wali Kelas";

        return view('halaman.homeroom-list', $app);
    }

    public function show($id)
    {
        $app['aktif']   = 'walikelas';
        $app['judul']   = 'Edit';
        $app['id']      = $id;
        $app['employes'] = Employe::where('is_active','1')
            ->join('aa_person', 'pid', '=', 'aa_person.id')
            ->select('aa_employe.id', 'name')
            ->orderBy('name')
            ->get();
        $app['getClass'] = CourseClass::where('id', $id)->first();
        $app['data']    = CourseClass::leftJoin('aa_homeroom AS hr', 'ep_course_class.id', '=', 'hr.ccid')
            ->select('ep_course_class.id as ccid', 'hr.id as hrid', 'emid', 'name')
            ->where('ep_course_class.id', '=', $id)
            ->where('hr.ayid', '=', config('id_active_academic_year'))
            ->get();
        return view('halaman.homeroom-edit', $app);
    }

    public function update(Request $request)
    {
        $cekdata = Homeroom::where('id', $request->hrid);
        if ($cekdata->exists()) {
            $data = $cekdata->update(['emid'=>$request->emid, 'uby'=>auth()->user()->id]);
        } else {
            $data = new Homeroom();
            $data->ayid = config('id_active_academic_year');
            $data->ccid = $request->ccid;
            $data->emid = $request->emid;
            $data->cby  = auth()->user()->id;
            $data->uby  = auth()->user()->id;
            $data->save();
        }

        return redirect()->route('homeroom.list');
    }
}
