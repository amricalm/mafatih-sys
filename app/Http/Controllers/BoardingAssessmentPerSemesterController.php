<?php

namespace App\Http\Controllers;

use App\Models\BoardingActivity;
use App\Models\BoardingGradePredicate;
use App\Models\BoardingGroup;
use App\Models\BoardingNote;
use App\Models\CourseClass;
use App\Models\Employe;
use App\Models\FinalGrade;
use App\Models\CourseClassDtl;
use App\SmartSystem\General;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BoardingAssessmentPerSemesterController extends Controller
{
    public function __construct() {
		$general = new General();
        $this->general = $general;
        $this->middleware(['auth']);
	}

    public function index(Request $req)
    {
        $app = array();
        $app['aktif'] = 'inputpengasuhanpersemester/modul';
        $app['judul'] = 'Input Nilai Pengasuhan Per Semester';
        $app['student'] = array();
        $app['activity'] = array();
        $app['employe'] = Employe::select('aa_employe.id as id', 'name')
                            ->join('aa_person as a','a.id','=','pid')
                            ->where('is_active','1')
                            ->orderBy('name')
                            ->get();
        if(auth()->user()->role=='3')
        {
            $app['employe'] = Employe::select('aa_employe.id as id', 'a.name')
                            ->join('aa_person as a','a.id','=','pid')
                            ->join('ep_boarding_group as b', function($join)
                            {
                                $join->on('aa_employe.id','=','b.eid')->where('b.ayid','=',config('id_active_academic_year'));
                            })
                            ->where('a.id',auth()->user()->pid)
                            ->groupBy('aa_employe.id')
                            ->where('is_active','1')
                            ->orderBy('name')
                            ->get();
        }
        $app['kelas'] = CourseClass::get();
        $app['grade'] = array();
        $app['req'] = $req;
        if ($req->post())
        {
            if($req->student) {
                $app['student'] = BoardingGroup::where('eid',$req->class)
                                ->where('ayid',config('id_active_academic_year'))
                                ->join('aa_student as a','sid','=','a.id')
                                ->join('aa_person as b','a.pid','=','b.id')
                                ->select('a.id','a.nis', 'b.name','b.name_ar')
                                ->orderBy('a.nis', 'ASC')
                                ->get();
            }
            $app['activity'] = BoardingActivity::where('type',"ITEM")->orderBy('id','asc')->get();
            $app['grade'] = BoardingGradePredicate::where('ayid',config('id_active_academic_year'))
                            ->where('tid',config('id_active_term'))
                            ->where('sid',$req->student)
                            ->get();
        }

		return view('halaman.boardingassessmentpersemester', $app);
	}

    public function modul(Request $request)
    {
        $app['aktif'] = 'inputpengasuhanpersemester/modul';
        $app['judul'] = "Input Nilai Pengasuhan per Semester";

        return view('halaman.boardingassessmentpersemestermodul', $app);
    }

	public function save(Request $request)
    {
		$datas = array();
		parse_str($request->data, $datas);

		foreach ($datas['val'] as $k => $v)
        {
            $predicate = $v!='' ? $v : '';
            $student_id = $datas['student_id'];
            $q = BoardingGradePredicate::select('id')
                ->where('sid',$student_id)
                ->where('ayid',config('id_active_academic_year'))
                ->where('tid',config('id_active_term'))
                ->where('activity_id',$k)
                ->orderBy('id','DESC')
                ->take(1)
                ->first();
            if(!isset($q)) {
                $data = new BoardingGradePredicate;
                $data->sid = $student_id;
                $data->ayid = config('id_active_academic_year');
                $data->tid = config('id_active_term');
                $data->activity_id = $k;
                $data->predicate = $predicate;
                $data->cby = auth()->user()->id;
                $data->uby = auth()->user()->id;
                $data->save();
            } else {
                $data = BoardingGradePredicate::find($q->id);
                $data->predicate = $predicate;
                $data->cby = auth()->user()->id;
                $data->uby = auth()->user()->id;
                $data->save();
            }
		}
		echo 'Berhasil';
	}

    public function notes(Request $req)
    {
        $format_code = 1;
        $app = array();
        $app['aktif'] = 'inputpengasuhanpersemester/modul';
        $app['judul'] = 'Input Catatan Pengasuhan';
        $app['student'] = array();
        $app['employe'] = Employe::select('aa_employe.id as id', 'name')
                            ->join('aa_person as a','a.id','=','pid')
                            ->where('is_active','1')
                            ->orderBy('name')
                            ->get();
        if(auth()->user()->role=='3')
        {
            $app['employe'] = Employe::select('aa_employe.id as id', 'a.name')
                            ->join('aa_person as a','a.id','=','pid')
                            ->join('ep_boarding_group as b', function($join)
                            {
                                $join->on('aa_employe.id','=','b.eid')->where('b.ayid','=',config('id_active_academic_year'));
                            })
                            ->where('a.id',auth()->user()->pid)
                            ->groupBy('aa_employe.id')
                            ->where('is_active','1')
                            ->orderBy('name')
                            ->get();
        }
        $app['notesAcademic'] = array();
        $app['grade'] = array();
        $app['req'] = $req;
        if ($req->post())
        {
            $app['student'] = BoardingGroup::where('eid',$req->employe)
                            ->where('ayid',config('id_active_academic_year'))
                            ->join('aa_student as a','sid','=','a.id')
                            ->join('aa_person as b','a.pid','=','b.id')
                            ->select('a.id','a.nis', 'b.name','b.name_ar')
                            ->orderBy('a.nis', 'ASC')
                            ->get();
            $arrNoteAcademic = array();
            foreach($app['student'] AS $student) {
                $arrNoteAcademic[] = FinalGrade::select('sid','note_from_student_affairs')
                                    ->where('ayid',config('id_active_academic_year'))
                                    ->where('tid',config('id_active_term'))
                                    ->where('sid', $student->id)
                                    ->where('format_code',0)
                                    ->get();
            }
            $app['notesAcademic'] = $arrNoteAcademic;

            $app['grade'] = BoardingNote::select('sid','note')
                            ->where('ayid',config('id_active_academic_year'))
                            ->where('tid',config('id_active_term'))
                            ->where('eid',$req->employe)
                            ->get();
        }

		return view('halaman.boardingassessmentpersemesternotes', $app);
	}

    public function savenotes(Request $request)
    {
        $format_code    = 1;
		$datas          = array();
		parse_str($request->data, $datas);
        $eid            = $datas['eid'];
		foreach ($datas['val'] as $sid => $note)
        {
            $class = CourseClassDtl::select('ccid')
                    ->where('ayid',config('id_active_academic_year'))
                    ->where('sid',$sid)
                    ->first();
            $setBoardingNote = BoardingNote::updateOrCreate([
                'ayid' => config('id_active_academic_year'),
                'tid' => config('id_active_term'),
                'sid' => $sid,
            ],
            [
                'eid' => $eid,
                'note' => $note,
                'cby' => auth()->user()->id,
                'uby' => auth()->user()->id
            ]);
        }

        if(isset($datas['catatan'])) {
            foreach ($datas['catatan'] as $ksid => $vnote)
            {
                $class = CourseClassDtl::select('ccid')
                    ->where('ayid',config('id_active_academic_year'))
                    ->where('sid',$ksid)
                    ->first();
                if($class)
                {
                    $cariFinalGrade = FinalGrade::where('ayid',config('id_active_academic_year'))
                        ->where('tid',config('id_active_term'))
                        ->where('sid',$ksid)
                        ->where('ccid',$class->ccid)
                        ->where('format_code','0');
                    if($cariFinalGrade->exists())
                    {
                        if($vnote!='')
                        {
                            $cariFinalGrade->update(['note_from_student_affairs'=>$vnote,'uby'=>auth()->user()->id]);
                        }
                    }
                    else
                    {
                        $cariFinalGrade = new FinalGrade;
                        $cariFinalGrade->ayid = config('id_active_academic_year');
                        $cariFinalGrade->tid = config('id_active_term');
                        $cariFinalGrade->sid = $ksid;
                        $cariFinalGrade->ccid = $class->ccid;
                        $cariFinalGrade->format_code = '0';
                        $cariFinalGrade->note_from_student_affairs = $vnote;
                        $cariFinalGrade->cby = auth()->user()->id;
                        $cariFinalGrade->save();
                    }
                }
            }
        }

		echo 'Berhasil';
	}

	public function getFromBoardingClass(Request $req) {
		$student = BoardingGroup::where('eid', $req->id)
			->where('ayid', config('id_active_academic_year'))
			->leftjoin('aa_student as a', 'sid', '=', 'a.id')
			->join('aa_person as b', 'a.pid', '=', 'b.id')
			->select('a.id', 'b.name')
			->get();
		if (!empty($student)) {
			echo json_encode($student);
		}
	}
}
