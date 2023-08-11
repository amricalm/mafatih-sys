<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CourseClass;
use App\Models\CourseClassDtl;
use App\Models\AcademicYear;
use App\Models\Student;
use App\Models\StudentPassed;
use DataTables;
use SebastianBergmann\Environment\Console;

class StudentMutationController extends Controller
{

    public function group(Request $request)
    {
        $app = array();
        $app['aktif'] = 'mutasi';
        $app['judul'] = 'Mutasi';
        $app['academicyear'] = AcademicYear::select('id', 'name')->get();

        return view('halaman.studentmutation', $app);
    }

    public function showgroup(Request $request)
    {
        $ayid = $request->id;
        $query = StudentPassed::join('aa_person as pe', 'pid', '=', 'pe.id')
            ->where('ayid', $ayid)
            ->where('status', 'PDH')
            ->get();
        $i = 1;
        foreach($query as $ky=>$vl)
        {
            $sex = $vl->sex == 'L' ? 'Laki-laki' : 'Perempuan';
            echo '<tr>';
            echo '<td>'.$i.'</td>';
            echo '<td>'.$vl->name.'</td>';
            echo '<td>'.$vl->nis.'</td>';
            echo '<td>'.$vl->nisn.'</td>';
            echo '<td>'.$sex.'</td>';
            echo '</tr>';
            $i++;
        }
    }

    public function studyGroup(Request $request)
    {
        $app['aktif'] = 'mutasi';
        $app['judul'] = "Proses";
        $app['classes'] = CourseClass::select('id', 'name')->get();
        $app['pilihkelas'] = (isset($_GET['pilih'])) ? $_GET['pilih'] : '';
        $app['academicyear'] = [config('id_active_academic_year')=>config('active_academic_year')];
        $app['pilihay'] = (isset($_GET['pilih'])) ? $_GET['pilih'] : '';
        $app['cari'] = (isset($_GET['cari'])) ? $_GET['cari'] : '';
        $app['cariDalam'] = (isset($_GET['cariDalam'])) ? $_GET['cariDalam'] : '';
        return view('halaman.studentmutation-process', $app);
    }

    public function outsideStudyGroup(Request $request)
    {
        $ayid = isset($request->ayid) ? $request->ayid : '';
        $query = StudentPassed::select('aa_student_passed.id', 'nis', 'name')
            ->join('aa_person as pe', 'pid', '=', 'pe.id')
            ->where('ayid', $ayid)
            ->where('status', 'PDH')
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
            ->where('ayid', config('id_active_academic_year'))
            ->where('ep_course_class.id', $ccid)
            ->whereNotIn('nis', function ($q) {
                $q->select('nis')->from('aa_student_passed');
            })
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
        $ayid = $request->ayid;

        if ($tipe == 'gotoclass') {
            $postsid = explode(',', $request->sid);
            for ($i = 1; $i <= count($postsid); $i++) {
                $sid    = $postsid[$i - 1];

                StudentPassed::where('id', $sid)->delete();
            }
            $arr = array('status' => 'true', 'ccid' => $ccid);
            return Response()->json($arr);
        } else {
            $postid = explode(',', $request->sid);
            for ($i = 1; $i <= count($postid); $i++) {
                $sid    = $postid[$i - 1];
                $getStudent = Student::where('id', $sid)->first();
                $ccd = StudentPassed::create([
                    'id' => $sid,
                    'ayid' => $ayid,
                    'pid' => $getStudent->pid,
                    'nis' => $getStudent->nis,
                    'nisn' => $getStudent->nisn,
                    'password' => $getStudent->password,
                    'remember_token' => $getStudent->remember_token,
                    'school_destination' => $request->school_destination,
                    'desc' => $request->desc,
                    'status' => 'PDH',
                    'cby' => auth()->user()->id,
                    'uby' => auth()->user()->id
                ]);
                if (!$ccd->wasRecentlyCreated) {
                    dd('Tidak berhasil tersimpan');
                }
            }
            $arr = array('status' => 'true', 'ccid' => $ccid, 'ayid' => $ayid);
            return Response()->json($arr);
        }
    }

    public function studyMutationDesc($id)
    {
        $data = Student::join('aa_person', 'pid', '=', 'aa_person.id')
                ->select('aa_student.id','pid','nis','nisn','password','remember_token','name')
                ->find($id);

        return response()->json($data);
    }
}
