<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CourseClass;
use App\Models\CourseClassDtl;
use App\Models\School;
use App\Models\Student;
use DataTables;
use SebastianBergmann\Environment\Console;

class CourseClassController extends Controller
{
    public function index(Request $request)
    {
        $app['aktif'] = 'kelas';
        $app['judul'] = "Kelas";

        if ($request->ajax()) {
            $data = CourseClass::select('id', 'name','name_ar','level')->get();
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

        return view('halaman.courseclass', $app);
    }

    public function store(Request $request)
    {
        CourseClass::updateOrCreate(
            ['id' => $request->id],
            ['name' => $request->name, 'name_ar' => $request->name_ar, 'level' => $request->level, 'name_en' => '', 'cby' => auth()->user()->id, 'uby' => auth()->user()->id]
        );

        $arr = array('status' => 'true', 'msg' => 'Berhasil');
        return Response()->json($arr);
    }

    public function edit($id)
    {
        $data = CourseClass::find($id);
        return response()->json($data);
    }

    public function destroy($id)
    {
        CourseClass::find($id)->delete();

        $arr = array('status' => 'true', 'msg' => 'Berhasil');
        return Response()->json($arr);
    }

    public function studyGroup(Request $request)
    {
        $app['aktif'] = 'rombel';
        $app['judul'] = "Rombongan Belajar";
        $app['classes'] = CourseClass::get();
        $app['pilihkelas'] = (isset($_GET['pilih'])) ? $_GET['pilih'] : '';
        $app['cari'] = (isset($_GET['cari'])) ? $_GET['cari'] : '';
        $app['cariDalam'] = (isset($_GET['cariDalam'])) ? $_GET['cariDalam'] : '';
        $app['sekolah'] = School::join('rf_school_type','rf_school_type.id','=','aa_school.school_type_id')->get();

        return view('halaman.studygroup', $app);
    }

    public function outsideStudyGroup(Request $request)
    {
        $query = Student::join('aa_person', 'pid', '=', 'aa_person.id')
            ->select('aa_student.id', 'nis', 'name')
            ->whereNotIn('nis', function ($q) {
                $q->select('st.nis')
                    ->from('ep_course_class as cc')
                    ->join('ep_course_class_dtl as ccd', 'cc.id', '=', 'ccd.ccid')
                    ->join('aa_student as st', 'ccd.sid', '=', 'st.id')
                    ->join('aa_person as pe', 'st.pid', '=', 'pe.id')
                    ->where('ccd.ayid', config('id_active_academic_year'));
            })
            ->whereNotIn('nis', function ($q) {
                $q->select('nis')->from('aa_student_passed');
            })
            ->where('aa_student.active', 1)
            ->orderBy('name');

        if(isset($request->cari)) {
        $query->where('name','like',"%".$request->cari."%")
		    ->orWhere('nis','like',"%".$request->cari."%");
        }
        $studentsOutClass = $query->get();

        return response()->json([
            'studentsOutClass' => $studentsOutClass
        ]);
    }

    public function insideStudyGroup(Request $request)
    {
        $ccid = isset($request->ccid) ? $request->ccid : '';
        $query = CourseClass::select('st.id', 'st.nis', 'pe.name')
            ->join('ep_course_class_dtl as ccd', 'ep_course_class.id', '=', 'ccd.ccid')
            ->join('aa_student as st', 'ccd.sid', '=', 'st.id')
            ->join('aa_person as pe', 'st.pid', '=', 'pe.id')
            ->where('ep_course_class.id', $ccid)
            ->where('ccd.ayid', config('id_active_academic_year'))
            ->orderBy('pe.name');
        if(isset($request->cariDalam)) {
            $query->where('pe.name','like',"%".$request->cariDalam."%")
                ->orWhere('st.nis','like',"%".$request->cariDalam."%");
        }
        $studentsInClass = $query->get();

        return response()->json([
            'studentsInClass' => $studentsInClass
        ]);
    }

    public function studyGroupExec(Request $request)
    {
        $tipe = $request->tipe;
        $ccid = $request->ccid;
        if ($tipe == 'gotoclass') {
            $postsid = explode(',', $request->sid);
            for ($i = 1; $i <= count($postsid); $i++) {
                $sid    = $postsid[$i - 1];
                $ccd = CourseClassDtl::create([
                    'ccid' => $ccid,
                    'ayid' => config('id_active_academic_year'),
                    'sid' => $sid,
                    'cby' => auth()->user()->id,
                    'uby' => auth()->user()->id
                ]);
                if (!$ccd->wasRecentlyCreated) {
                    dd('Tidak berhasil tersimpan');
                }
            }
            $arr = array('status' => 'true', 'ccid' => $ccid);
            return Response()->json($arr);
        } else {
            $postid = explode(',', $request->sid);
            for ($i = 1; $i <= count($postid); $i++) {
                $sid    = $postid[$i - 1];
                CourseClassDtl::where('ccid', $ccid)
                    ->where('ayid', config('id_active_academic_year'))
                    ->where('sid', $sid)
                    ->delete();
            }
            $arr = array('status' => 'true', 'ccid' => $ccid);
            return Response()->json($arr);
        }
    }
    public function lihat(Request $request)
    {
        $id = $request->id;
        $kelas = CourseClass::where('ep_course_class.id',$id)
            ->join('aa_homeroom as b','b.ccid','=','ep_course_class.id')
            ->join('aa_employe as c','b.emid','=','ep_course_class')
            ->join('aa_person as d','d.')->get();

        echo '<div class="row">
                <div class="col-md-12">
                    <h4 id="namakelas">'.$kelas->name.'</h4>
                    <table class="table table-striped" id="tablekelas">
                        <tr>
                            <th>Nama Arab</th>
                            <th>'.$kelas->name_ar.'</th>
                        </tr>
                        <tr>
                            <th>Wali Kelas</th>
                            <th></th>
                        </tr>
                    </table>
                </div>
                <div class="col-md-12">
                    <h5 id="">Daftar Siswa</h5>
                    <table class="table table-striped" id="tablesiswakelas"></table>
                </div>
            </div>';
    }
}
