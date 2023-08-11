<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CourseClass;
use App\Models\Employe;
use App\Models\BoardingGroup;
use App\Models\CourseClassDtl;
use App\Models\AcademicYear;
use App\Models\BoardingGradeDtl;
use App\Models\BoardingNote;
use App\Models\Student;
use Carbon\Carbon;
use DataTables;

class BoardingGroupController extends Controller
{
    public function boardingGroup(Request $request)
    {
        $app['aktif'] = 'rombel-pengasuhan';
        $app['judul'] = "Rombongan Pengasuhan";
        $app['classes'] = Employe::select('aa_employe.id as id', 'name')
            ->join('aa_person as a','aa_employe.pid','=','a.id')
            ->where('is_active','1')
            ->orderBy('name')
            ->get();
        $app['pilihkelas'] = (isset($_GET['pilih'])) ? $_GET['pilih'] : '';
        return view('halaman.boardinggroup', $app);
    }

    public function outsideBoardingGroup(Request $request)
    {
        $query = Student::join('aa_person', 'pid', '=', 'aa_person.id')
            ->select('aa_student.id', 'nis', 'name')
            ->whereNotIn('nis', function ($q) {
                $q->select('st.nis')
                    ->from('aa_employe as e')
                    ->join('ep_boarding_group as bg', 'e.id', '=', 'bg.eid')
                    ->join('aa_student as st', 'bg.sid', '=', 'st.id')
                    ->join('aa_person as pe', 'st.pid', '=', 'pe.id')
                    ->where('bg.ayid', config('id_active_academic_year'));
            });

        $query = $query->get()->toArray();

        $query1 = BoardingGroup::getStudentNonActiveEmploye();

        $query = array_merge($query,$query1);

        $squery = collect($query);

        if(isset($request->cari)) {
            $squery->where('name','like',"%".$request->cari."%")
                ->orWhere('nis','like',"%".$request->cari."%");
        }

        $studentsOutClass = $squery->toArray();

        return response()->json([
            'studentsOutClass' => $studentsOutClass
        ]);
    }

    public function insideBoardingGroup(Request $request)
    {
        $ccid = isset($request->ccid) ? $request->ccid : '';
        $query = BoardingGroup::select('st.id', 'st.nis', 'pe.name')
            ->join('aa_student as st', 'ep_boarding_group.sid', '=', 'st.id')
            ->join('aa_person as pe', 'st.pid', '=', 'pe.id')
            ->where('ep_boarding_group.ayid', config('id_active_academic_year'))
            ->where('ep_boarding_group.eid', $ccid)
            ->orderBy('st.nis');

        if(isset($request->cariDalam)) {
            $query->where('pe.name','like',"%".$request->cariDalam."%")
                ->orWhere('st.nis','like',"%".$request->cariDalam."%");
        }

        $studentsInClass = $query->get();

        return response()->json([
            'studentsInClass' => $studentsInClass
        ]);
    }

    public function boardingGroupExec(Request $request)
    {
        $tipe = $request->tipe;
        $ccid = $request->ccid;
        if ($tipe == 'gotoclass') {
            $postsid = explode(',', $request->sid);
            for ($i = 1; $i <= count($postsid); $i++) {
                $sid    = $postsid[$i - 1];
                $cekGroup = BoardingGroup::where('ayid', config('id_active_academic_year'))
                        ->where('sid', $sid);
                if($cekGroup->exists()) {
                    $set = $cekGroup->update([
                        'tid' => config('id_active_term'),
                        'eid' => $ccid,
                        'cby' => auth()->user()->id,
                        'uby' => auth()->user()->id
                    ]);
                } else {
                    $set = new BoardingGroup;
                    $set->ayid = config('id_active_academic_year');
                    $set->sid = $sid;
                    $set->tid = config('id_active_term');
                    $set->eid = $ccid;
                    $set->cby = auth()->user()->id;
                    $set->uby = auth()->user()->id;
                    $set->save();
                }

                $cekGroupNote = BoardingNote::where('ayid', config('id_active_academic_year'))
                        ->where('sid', $sid);
                if($cekGroupNote->exists()) {
                    $set = $cekGroupNote->update([
                        'eid' => $ccid,
                        'cby' => auth()->user()->id,
                        'uby' => auth()->user()->id
                    ]);
                }
            }
            $arr = array('status' => 'true', 'ccid' => $ccid);
            return Response()->json($arr);
        } else {
            $postid = explode(',', $request->sid);
            for ($i = 1; $i <= count($postid); $i++) {
                $sid    = $postid[$i - 1];
                $cekNilai = BoardingGradeDtl::where('ayid', config('id_active_academic_year'))
                            ->where('sid', $sid)
                            ->get();
                if(count($cekNilai)>=1) {
                    BoardingGroup::where('ayid', config('id_active_academic_year'))
                        ->where('eid', $ccid)
                        ->where('sid', $sid)
                        ->update(['eid'=>'', 'dby'=>auth()->user()->id, 'don'=>Carbon::now()]);
                } else {
                    BoardingGroup::where('ayid', config('id_active_academic_year'))
                        ->where('eid', $ccid)
                        ->where('sid', $sid)
                        ->delete();
                }
            }
            $arr = array('status' => 'true', 'ccid' => $ccid);
            return Response()->json($arr);
        }
    }
}
