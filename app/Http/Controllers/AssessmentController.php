<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Assessment;
use App\Models\BayanatAssessment;
use App\Models\BayanatResult;
use App\Models\BayanatResultDtl;
use App\Models\BoardingActivity;
use App\Models\BoardingActivityItem;
use App\Models\BoardingGradeDtl;
use App\Models\Competence;
use App\Models\CourseClass;
use App\Models\CourseClassDtl;
use App\Models\CourseSubject;
use App\Models\CourseSubjectTeacher;
use App\Models\Employe;
use App\Models\FinalGrade;
use App\Models\FinalGradeDtl;
use App\Models\Grade;
use App\Models\GradeType;
use App\Models\GradeWeight;
use App\Models\Homeroom;
use App\Models\RfLevelClass;
use App\Models\Student;
use App\Models\Gpa;
use App\Models\User;
use App\SmartSystem\General;
use Illuminate\Http\Request;
use App\Models\AcademicYearDetail;
use App\Models\BayanatMapping;
use App\Models\BayanatWeight;
use App\Models\BoardingGroup;
use App\Models\BoardingNote;
use App\Models\RemedyClass;
use App\Models\SignedPosition;
use App\Models\SubjectDiknasBasic;
use App\Models\SubjectDiknasMapping;
use Illuminate\Support\Facades\DB;

class AssessmentController extends Controller {

	public function __construct() {
		$general = new General();
        $this->middleware(['auth']);
	}

	public function index(Request $req)
    {
		$app = array();
		$levelngajar = '';
		$pljrnngajar = '';
		$app['aktif'] = 'inputnilai';
		$app['judul'] = 'Input Nilai Siswa';
        $app['pelajarankelas'] = null;
        $app['cekwalas'] = User::where('pid',auth()->user()->pid)->where('role','1')->exists();
		$app['student'] = array();
		$app['kelas'] = CourseClass::get();
		$app['grade'] = GradeWeight::join('rf_grade_type', 'type', '=', 'code')
			->where('val', '!=', '0')
			->orderBy('seq')
			->get();
		if (auth()->user()->role == '3') {
			$app['pelajarankelas'] = CourseSubjectTeacher::where('eid', auth()->user()->pid)->get();
			$levelngajar = array_keys(json_decode(json_encode($app['pelajarankelas']->groupBy('ccid')), true));
			$app['kelas'] = $app['kelas']->whereIn('id', $levelngajar);
            $app['cekwalas'] = Homeroom::join('aa_employe','aa_employe.id','=','emid')
                ->join('aa_person','aa_person.id','=','aa_employe.id')
                ->where('ayid',config('id_active_academic_year'))
                ->where('pid',auth()->user()->pid)
                ->exists();
        }
		$app['subject'] = array();
		$app['student'] = array();
		$app['assessment'] = array();
        $app['pljrnngajar'] = null;
		$app['req'] = $req;
		if ($req->post()) {
            $app['subject'] = (object) CourseSubject::getFromClass(['id' => $req->class]);
            if (auth()->user()->role == '3') {
                $pljrnngajar = array_keys(json_decode(json_encode($app['pelajarankelas']->where('ccid', $req->class)->groupBy('subject_id')), true));
                $app['subject'] = collect($app['subject'])->whereIn('id', $pljrnngajar);
            }
            $app['pljrnngajar'] = $pljrnngajar;
            $app['student'] = CourseClassDtl::where('ccid', $req->class)
                ->where('ep_course_class_dtl.ayid', config('id_active_academic_year'))
                ->join('aa_student as a', 'sid', '=', 'a.id')
                ->join('aa_person as b', 'a.pid', '=', 'b.id')
                ->join('ep_course_class', 'ccid', '=', 'ep_course_class.id')
                ->select('a.id', 'b.name')
                ->orderBy('b.name')
                ->get();
            $student = collect($app['student'])->pluck('id')->toArray();
            $app['assessment'] = Assessment::where('ayid', config('id_active_academic_year'))
                ->where('tid', config('id_active_term'))
                ->where('subject_id', $req->subject)
                ->whereIn('sid',$student)
                ->get();
		}

		return view('halaman.assessment', $app);
	}
	public function save(Request $request) {
		$datas = array();
		parse_str($request->data, $datas);
		$ccid = $datas['ccid'];
		$subject_id = $datas['subject_id'];
		$kelas = CourseClass::where('id', $datas['ccid'])->first();
		$level = $kelas->level;
		$coursesubject = CourseSubject::where('level', $level)
			->where('subject_id', $subject_id)
			->first();

		foreach ($datas['val'] as $k => $v) {
			$gradeval = 0;
			foreach ($datas['val'][$k] as $kk => $vv) {
				$iassessment = array();
				$iassessment['ayid'] = config('id_active_academic_year');
				$iassessment['tid'] = config('id_active_term');
				$iassessment['subject_id'] = $subject_id;
				$iassessment['sid'] = $k;
				$iassessment['grade_type'] = $kk;
				$ibssessment['val'] = ($vv != '') ? $vv : '0';
				$ibssessment['cby'] = auth()->user()->id;
				$ibssessment['uby'] = auth()->user()->id;

				$assessment = Assessment::updateOrCreate($iassessment, $ibssessment);

				$weight = GradeWeight::where('type', $kk)->first();
				$gradeval += ($vv != '') ? (($weight['val'] / 100) * $vv) : '0';
			}

			$igrade = array();
			$igrade['ayid'] = config('id_active_academic_year');
			$igrade['tid'] = config('id_active_term');
			$igrade['subject_id'] = $subject_id;
			$igrade['sid'] = $k;
			$igrade['final_grade'] = $gradeval;
			$igrade['passing_grade'] = $coursesubject->grade_pass;
			$igrade['remedy'] = ($gradeval < $coursesubject->grade_pass) ? 1 : 0;

			$grade = Grade::updateOrCreate([
				'ayid' => $igrade['ayid'],
				'tid' => $igrade['tid'],
				'subject_id' => $igrade['subject_id'],
				'sid' => $k,
			],
				[
					'final_grade' => $gradeval,
					'passing_grade' => $coursesubject->grade_pass,
					'remedy' => ($gradeval < $coursesubject->grade_pass) ? 1 : 0,
				]);
		}
		echo 'Berhasil';
	}
	public function saveother(Request $request) {
		$tipe = $request->tipe;
        $format_code = 0;
        $format_code_diknas = 2;
		$datas = array();
		parse_str($request->data, $datas);
		switch ($tipe) {
		case 'absen':
			foreach ($datas['s'] as $k => $v) {
				$ifinal = array();
				$ifinalw = array();
				$ifinalw['ayid'] = config('id_active_academic_year');
				$ifinalw['tid'] = config('id_active_term');
				$ifinalw['sid'] = $k;
				$ifinalw['ccid'] = $datas['ccid'];
				$ifinalw['format_code'] = $format_code;
				$ifinal['absent_s'] = ($v == '') ? '0' : $v;
				$ifinal['absent_i'] = ($datas['i'][$k] == '') ? '0' : $datas['i'][$k];
				$ifinal['absent_a'] = ($datas['a'][$k] == '') ? '0' : $datas['a'][$k];
				$ifinal['cby'] = auth()->user()->id;
				$ifinal['uby'] = auth()->user()->id;
				$final = FinalGrade::updateOrCreate($ifinalw, $ifinal);
			}
			break;
		case 'perilaku':
			foreach ($datas['cleanliness'] as $k => $v) {
				$ifinal = array();
				$ifinalw = array();
				$ifinalw['ayid'] = config('id_active_academic_year');
				$ifinalw['tid'] = config('id_active_term');
				$ifinalw['sid'] = $k;
				$ifinalw['ccid'] = $datas['ccid'];
				$ifinalw['format_code'] = $format_code;
				$ifinal['cleanliness'] = ($v == '') ? '0' : $v;
				$ifinal['discipline'] = ($datas['discipline'][$k] == '') ? '0' : $datas['discipline'][$k];
				$ifinal['behaviour'] = ($datas['behaviour'][$k] == '') ? '0' : $datas['behaviour'][$k];
				$ifinal['cby'] = auth()->user()->id;
				$ifinal['uby'] = auth()->user()->id;

				$final = FinalGrade::updateOrCreate($ifinalw, $ifinal);
			}
			break;
		case 'lainnya':
			foreach ($datas['aktifortu'] as $k => $v) {
                if($datas['aktifortu'][$k]=='')
                {
                    // kalau kosong, lanjut ke index selanjutnya
                    continue;
                }
				$ifinal = array();
				$ifinalw = array();
				$ifinalw['ayid'] = config('id_active_academic_year');
				$ifinalw['tid'] = config('id_active_term');
				$ifinalw['sid'] = $k;
				$ifinalw['ccid'] = $datas['ccid'];
				$ifinalw['format_code'] = $format_code;
				$ifinal['memorizing_quran'] = '';
				$ifinal['activities_parent'] = ($datas['aktifortu'][$k] == '') ? '0' : $datas['aktifortu'][$k];
				$ifinal['result'] = $datas['result'][$k];
				$ifinal['cby'] = auth()->user()->id;
                $ifinal['con'] = date('Y-m-d H:i:s');
				$ifinal['uby'] = auth()->user()->id;
                $ifinal['uon'] = date('Y-m-d H:i:s');
                $cek = FinalGrade::where('ayid',$ifinalw['ayid'])
                    ->where('tid',$ifinalw['tid'])
                    ->where('sid',$ifinalw['sid'])
                    ->where('ccid',$ifinalw['ccid'])
                    ->where('format_code',$ifinalw['format_code']);
                if($cek->exists())
                {
                    unset($ifinal['cby']);
                    unset($ifinal['con']);
                    $cek->update($ifinal);
                }
                else
                {
                    $cek = new FinalGrade;
                    $cek->ayid = $ifinalw['ayid'];
                    $cek->tid = $ifinalw['tid'];
                    $cek->sid = $ifinalw['sid'];
                    $cek->ccid = $ifinalw['ccid'];
                    $cek->format_code = $ifinalw['format_code'];
                    $cek->activities_parent = $ifinal['activities_parent'];
                    $cek->result = $ifinal['result'];
                    $cek->cby = $ifinal['cby'];
                    $cek->con = $ifinal['con'];
                    $cek->save();
                }
			}
			break;
		case 'catatan':
			foreach ($datas['notes'] as $k => $v) {
				$ifinal = array();
				$ifinalw = array();
				$ifinalw['ayid'] = config('id_active_academic_year');
				$ifinalw['tid'] = config('id_active_term');
				$ifinalw['sid'] = $k;
				$ifinalw['ccid'] = $datas['ccid'];
				$ifinalw['format_code'] = $format_code_diknas;
				$ifinal['note_from_student_affairs'] = $v;
				$ifinal['cby'] = auth()->user()->id;
				$ifinal['uby'] = auth()->user()->id;

				$final = FinalGrade::updateOrCreate($ifinalw, $ifinal);
			}
			break;
		default:
			break;
		}

		echo 'Berhasil';
	}
	public function saveexcel(Request $request) {
		$datas = array();
		parse_str($request->data, $datas);

	}
	public function absen(Request $request) {
		$app = array();
		$app['aktif'] = 'inputlain';
		$app['judul'] = 'Input Lainnya';
		$app['student'] = Student::join('aa_person as a', 'a.id', '=', 'pid')->get();
		$app['kelas'] = CourseClass::get();
		$app['grade'] = GradeType::get();
		$app['subject'] = array();
		$app['student'] = array();
		$app['assessment'] = array();
        $format_code = 0;
        $format_code_diknas = 2;
		$app['req'] = $request;
		$levelngajar = '';
		if (auth()->user()->role == '3') {
			$app['pelajarankelas'] = CourseSubjectTeacher::where('eid', auth()->user()->pid)->get();
			$levelngajar = array_keys(json_decode(json_encode($app['pelajarankelas']->groupBy('ccid')), true));
			$app['kelas'] = $app['kelas']->whereIn('id', $levelngajar);
		}

		if ($request->post()) {
			$app['student'] = CourseClassDtl::join('aa_student as a', 'sid', '=', 'a.id')
				->join('aa_person as b', 'a.pid', '=', 'b.id')
				->where('ccid', $request->class)
				->where('ayid', config('id_active_academic_year'))
				->select('a.id', 'b.name')
                ->orderBy('b.name')
				->get();
			$app['finalgrade'] = FinalGrade::where('ayid', config('id_active_academic_year'))
				->where('tid', config('id_active_term'))
				->where('ccid', $request->class)
				->where('format_code', $format_code)
				->get();
            $app['finalgradediknas'] = FinalGrade::where('ayid', config('id_active_academic_year'))
				->where('tid', config('id_active_term'))
				->where('ccid', $request->class)
				->where('format_code', $format_code_diknas)
				->get();
		}

		return view('halaman.assessment-absen', $app);
	}
	public function process(Request $req)
    {
		$app            = array();
		$app['aktif']   = 'prosesnilai';
		$app['judul']   = 'Proses Nilai Siswa';
        $ayid           = config('id_active_academic_year');
		$tid            = config('id_active_term');
		$app['kelas']   = User::where('pid',auth()->user()->pid)->where('role','1')->exists() ? CourseClass::get() : '';
        if(auth()->user()->role == '3')
        {
            $kelas = array();
            $app['walas'] = Homeroom::where('ayid',$ayid)
                ->where('pid',auth()->user()->pid)
                ->join('aa_employe','aa_employe.id','=','emid')
                ->join('aa_person','aa_person.id','=','aa_employe.id')
                ->get()->pluck('ccid')->toArray();
            for($i=0;$i<count($app['walas']);$i++)
            {
                $kelas[] = $app['walas'][$i];
            }
		    $app['kelas'] = (count($kelas)>0) ? CourseClass::whereIn('id',$kelas)->get() : '';
            // INI KALAU MAU YANG PROSES GURU MAPEL JUGA
            // $app['gurumapel'] = CourseSubjectTeacher::where('ayid',$ayid)
            //     ->where('tid',$tid)
            //     ->where('pid',auth()->user()->pid)
            //     ->join('aa_employe','aa_employe.id','=','eid')
            //     ->join('aa_person','aa_person.id','=','aa_employe.id')
            //     ->select('ep_course_subject_teacher.*')
            //     ->get()->pluck('ccid')->toArray();

            // for($i=0;$i<count($app['gurumapel']);$i++)
            // {
            //     $kelas[] = $app['gurumapel'][$i];
            // }

        }
		$app['tingkat'] = RfLevelClass::get();
		$app['musyrifsakan'] = BoardingGroup::getMsPerAyid('');
        $musyrifquran = BayanatMapping::getall();
        $app['musyrifquran'] = collect($musyrifquran)->sortBy('teachername')->toArray();
        if (auth()->user()->role == '3')
        {
            $app['musyrifsakan'] = BoardingGroup::getMsPerAyid(auth()->user()->pid);
		}

		return view('halaman.assessmentprocess', $app);
	}
    public function processing_alquran(Request $req)
    {
        $format_code = ($req->mode=='UTS') ? '3' : '0';
        $format_code_diknas = 2;
        $ayid = config('id_active_academic_year');
        $tid = config('id_active_term');

        $signed = SignedPosition::where('ayid',$ayid);
        if(!$signed->exists())
        {
            die('Mohon tentukan Kepala Sekolah tahun ajaran '.config('active_academic_year').'. Hubungi Admin!');
        }
        $signed = $signed->first();

        $tanggal = AcademicYearDetail::select('mid_exam_date','hijri_mid_exam_date','final_exam_date','hijri_final_exam_date')->where('ayid',$ayid)->where('tid',$tid);
        if($format_code==3) {
            if(!$tanggal->exists() || $tanggal->first()->mid_exam_date=='0000-00-00')
            {
                die('Mohon tentukan Tanggal Raport '.$req->mode.'. Hubungi Admin!');
            }
        } else {
            if(!$tanggal->exists() || $tanggal->first()->final_exam_date=='0000-00-00')
            {
                die('Mohon tentukan Tanggal Raport '.$req->mode.'. Hubungi Admin!');
            }
        }
        $tanggal = $tanggal->first();
        $tanggalfix = ($format_code==3) ? $tanggal['mid_exam_date'] : $tanggal['final_exam_date'];
        $tanggalhfix = ($format_code=='3') ? $tanggal['hijri_mid_exam_date'] : $tanggal['hijri_final_exam_date'];

        $kelas = array();
        parse_str($req->kls,$kelas);
        $kelasterpilih = $kelas['chkmsq'];
        foreach($kelasterpilih as $kelasterpilih)
        {
            $kelas = CourseClass::where('id',$kelasterpilih)->first()->toArray();
            $level = $kelas['level'];
            $pelajaran = CourseSubject::getFromLevel($level,$ayid,$tid);
            $pelajaranDiknas = SubjectDiknasMapping::getFromLevel($level,$ayid,$tid);
            $grade = GradeWeight::getActive();
            $type = $grade->pluck('type')->toArray();
            $murid = CourseClassDtl::getStudentPerClass($kelas['id']);
            $person = collect($murid)->pluck('pid')->toArray();
            $student = collect($murid)->pluck('id')->toArray();
            $formTeacher    = Homeroom::getFromClass($kelas['id']);
            $formTeacherId  = isset($formTeacher['id']) ? $formTeacher['id'] : '';

            $notesbayanatsemua = BayanatResult::getFromPerson($person,$ayid,$tid);

            $all            = array();
            $arrSbjDiknas   = array();
            $nilaiakhirall  = array();
            $nilaibayanat   = array();
            $mahmul = [];
            $no = 0;

            foreach($murid as $key => $val)
            {
                //Ambil data Bayanat Quran per kelas
                $nilaibayanatsemua = BayanatAssessment::getAssessmentToProcess($person);
                $groupnilaibayanat = collect($nilaibayanatsemua)->groupBy('pid');
                $gradebayanat = BayanatWeight::get()->toArray();
                if($format_code!='3')
                {
                    // proses nilai Bayanat jika bukan UTS
                    $text = '';
                    $text1 = '';
                    $index = 0;
                    foreach($groupnilaibayanat as $key=>$val)
                    {
                        $nilaitotal = 0;
                        foreach($val as $key1 => $val1)
                        {
                            $nilaitotal += ($val1['bobot']/100) * $val1['grade'];
                        }
                        $nilaibayanat[$index]['pid'] = $val[0]['pid'];
                        $nilaibayanat[$index]['ayid'] = $ayid;
                        $nilaibayanat[$index]['tid'] = $tid;
                        $nilaibayanat[$index]['cqid'] = $val[0]['cqid'];
                        $nilaibayanat[$index]['eid'] = $val[0]['eid'];
                        $nilaibayanat[$index]['juz_is_study'] = $val[0]['juz'];
                        $nilaibayanat[$index]['result_level_halqah'] = $val[0]['juzid'];
                        $nilaibayanat[$index]['result_set'] = (int)round($nilaitotal);
                        $nilaibayanat[$index]['result_decision_set'] = BayanatAssessment::getDecisionSet($nilaitotal);
                        $nilaibayanat[$index]['result_appreciation'] = BayanatAssessment::getAppreciation($nilaitotal);
                        $indexdetail = 0;
                        foreach($val as $key1 => $val1)
                        {
                            $nilaibayanat[$index]['detail'][$indexdetail]['id_evaluation'] = $val1['bobotid'];
                            $nilaibayanat[$index]['detail'][$indexdetail]['weight_evaluation'] = $val1['bobot'];
                            $nilaibayanat[$index]['detail'][$indexdetail]['result_evaluation'] = $val1['grade'];
                            $indexdetail++;
                        }
                        $index++;
                    }
                }
            }

            //Ambil data Bayanat Quran per kelas
            $nilaibayanatsemua = BayanatAssessment::getAssessmentToProcess($person);
            $groupnilaibayanat = collect($nilaibayanatsemua)->groupBy('pid');
            $notesbayanatsemua = BayanatResult::where('ayid',$ayid)
                ->where('tid',$tid)
                ->whereIn('pid',$person)
                ->get();
            $gradebayanat = BayanatWeight::get()->toArray();
            if($format_code!='3')
            {
                // proses nilai Bayanat jika bukan UTS
                $text = '';
                $text1 = '';
                $index = 0;
                foreach($groupnilaibayanat as $key=>$val)
                {
                    $nilaitotal = 0;
                    foreach($val as $key1 => $val1)
                    {
                        $nilaitotal += ($val1['bobot']/100) * $val1['grade'];
                    }
                    $nilaibayanat[$index]['pid'] = $val[0]['pid'];
                    $nilaibayanat[$index]['ayid'] = $ayid;
                    $nilaibayanat[$index]['tid'] = $tid;
                    $nilaibayanat[$index]['cqid'] = $val[0]['cqid'];
                    $nilaibayanat[$index]['eid'] = $val[0]['eid'];
                    $nilaibayanat[$index]['juz_is_study'] = $val[0]['juz'];
                    $nilaibayanat[$index]['result_level_halqah'] = $val[0]['juzid'];
                    $nilaibayanat[$index]['result_set'] = round($nilaitotal,2);
                    $nilaibayanat[$index]['result_decision_set'] = \App\SmartSystem\General::hasil_kelulusan($nilaitotal);
                    $nilaibayanat[$index]['result_appreciation'] = \App\SmartSystem\General::predikat($nilaitotal);
                    $indexdetail = 0;
                    foreach($val as $key1 => $val1)
                    {
                        $nilaibayanat[$index]['detail'][$indexdetail]['id_evaluation'] = $val1['bobotid'];
                        $nilaibayanat[$index]['detail'][$indexdetail]['weight_evaluation'] = $val1['bobot'];
                        $nilaibayanat[$index]['detail'][$indexdetail]['result_evaluation'] = $val1['grade'];
                        $indexdetail++;
                    }
                    $index++;
                }

                // Proses masukkan nilai-nilai bayanat ke bayanatresult
                for($i=0;$i<count($nilaibayanat);$i++)
                {
                    $cekada = BayanatResult::where('pid',$nilaibayanat[$i]['pid'])
                        ->where('ayid',$nilaibayanat[$i]['ayid'])
                        ->where('tid',$nilaibayanat[$i]['tid'])
                        ->where('cqid',$nilaibayanat[$i]['cqid'])
                        ->where('eid',$nilaibayanat[$i]['eid']);
                    if($cekada->exists())
                    {
                        $cekada->update(
                            [
                                'juz_is_study'=>$nilaibayanat[$i]['juz_is_study'],
                                'result_level_halqah'=>$nilaibayanat[$i]['result_level_halqah'],
                                'result_set'=>$nilaibayanat[$i]['result_set'],
                                'result_decision_set'=>$nilaibayanat[$i]['result_decision_set'],
                                'result_appreciation'=>$nilaibayanat[$i]['result_appreciation'],
                                'uby'=>auth()->user()->pid,
                                'uon'=>date('Y-m-d H:i:s'),
                            ]
                        );
                        $ada = $cekada->first();
                        if(!is_null($ada))
                        {
                            $id = $cekada->first()['id'];
                            $detail = array();
                            $nodetail = 0;
                            foreach($nilaibayanat[$i]['detail'] as $ky=>$vl)
                            {
                                $detail[$nodetail]['hid'] = $id;
                                $detail[$nodetail]['id_evaluation'] = $vl['id_evaluation'];
                                $detail[$nodetail]['weight_evaluation'] = $vl['weight_evaluation'];
                                $detail[$nodetail]['result_evaluation'] = $vl['result_evaluation'];
                                $nodetail++;
                            }
                            BayanatResultDtl::where('hid',$id)->delete();
                            BayanatResultDtl::insert($detail);
                        }
                    }
                    else
                    {
                        $create = new BayanatResult();
                        $create->pid = $nilaibayanat[$i]['pid'];
                        $create->ayid = $nilaibayanat[$i]['ayid'];
                        $create->tid = $nilaibayanat[$i]['tid'];
                        $create->cqid = $nilaibayanat[$i]['cqid'];
                        $create->eid = $nilaibayanat[$i]['eid'];
                        $create->juz_is_study = $nilaibayanat[$i]['juz_is_study'];
                        $create->result_level_halqah = $nilaibayanat[$i]['result_level_halqah'];
                        $create->result_set = $nilaibayanat[$i]['result_set'];
                        $create->result_decision_set = $nilaibayanat[$i]['result_decision_set'];
                        $create->result_appreciation = $nilaibayanat[$i]['result_appreciation'];
                        $create->cby = auth()->user()->pid;
                        $create->con = date('Y-m-d H:i:s');
                        $create->save();

                        $ada = $create->id;
                        if(!is_null($ada))
                        {
                            $id = $ada;
                            $detail = array();
                            $nodetail = 0;
                            foreach($nilaibayanat[$i]['detail'] as $ky=>$vl)
                            {
                                $detail[$nodetail]['hid'] = $id;
                                $detail[$nodetail]['id_evaluation'] = $vl['id_evaluation'];
                                $detail[$nodetail]['weight_evaluation'] = $vl['weight_evaluation'];
                                $detail[$nodetail]['result_evaluation'] = $vl['result_evaluation'];
                                $nodetail++;
                            }
                            BayanatResultDtl::insert($detail);
                        }
                    }
                }
            }
        }
        echo 'Berhasil';
    }

    public function processing_v2(Request $req)
    {
        $format_code = ($req->mode=='UTS') ? '3' : '0';
        $ayid = config('id_active_academic_year');
        $tid = config('id_active_term');

        $signed = SignedPosition::where('ayid',$ayid);
        if(!$signed->exists())
        {
            die('Mohon tentukan Kepala Sekolah tahun ajaran '.config('active_academic_year').'. Hubungi Admin!');
        }
        $signed = $signed->first();

        $tanggal = AcademicYearDetail::select('mid_exam_date','hijri_mid_exam_date','final_exam_date','hijri_final_exam_date')->where('ayid',$ayid)->where('tid',$tid);
        if($format_code==3) {
            if(!$tanggal->exists() || $tanggal->first()->mid_exam_date=='0000-00-00')
            {
                die('Mohon tentukan Tanggal Raport '.$req->mode.'. Hubungi Admin!');
            }
        } else {
            if(!$tanggal->exists() || $tanggal->first()->final_exam_date=='0000-00-00')
            {
                die('Mohon tentukan Tanggal Raport '.$req->mode.'. Hubungi Admin!');
            }
        }
        $tanggal = $tanggal->first();
        $tanggalfix = ($format_code==3) ? $tanggal['mid_exam_date'] : $tanggal['final_exam_date'];
        $tanggalhfix = ($format_code=='3') ? $tanggal['hijri_mid_exam_date'] : $tanggal['hijri_final_exam_date'];

        $kelas = array();
        parse_str($req->kls,$kelas);
        $kelasterpilih = $kelas['chk'];
        foreach($kelasterpilih as $kelasterpilih)
        {
            $kelas = CourseClass::where('id',$kelasterpilih)->first()->toArray();
            $level = $kelas['level'];
            $pelajaran = CourseSubject::getFromLevel($level,$ayid,$tid);
            $grade = GradeWeight::getActive();
            $murid = CourseClassDtl::getStudentPerClass($kelas['id']);
            $formTeacher    = Homeroom::getFromClass($kelas['id']);
            $formTeacherId  = isset($formTeacher['id']) ? $formTeacher['id'] : '';

            $all            = array();
            $nilaiakhirall  = array();
            $mahmul = [];
            $no = 0;

            foreach($murid as $key => $val)
            {
                $seq = 0;
                if($pelajaran->count() > 0)
                {
                    foreach ($pelajaran as $kk => $vv)
                    {
                        $nilai = array();
                        $nilaitotal = 0;
                        if($format_code=='3')
                        {
                            $nilaiid = Assessment::getAssessmentStudent($ayid,$tid,$vv->subject_id,'UTS',$val['id']);
                            $nilai['mid_exam'] = (is_null($nilaiid['val'])) ? '0' : $nilaiid['val'];
                            $nilaitotal += $nilai['mid_exam'];
                        }
                        else
                        {
                            foreach ($grade as $keyk => $valv) {
                                $nilaiid = Assessment::getAssessmentStudent($ayid, $tid, $vv->subject_id, $valv->type, $val['id']);
                                switch ($valv->type) {
                                    case 'TGS':
                                        $nilai['formative_val'] = (is_null($nilaiid['val'])) ? '0' : $nilaiid['val'];
                                        $gradethis = $grade->where('type', 'TGS')->first();
                                        $nilaitotal += ($gradethis->val / 100) * $nilai['formative_val'];
                                        break;
                                    case 'UTS':
                                        $nilai['mid_exam'] = (is_null($nilaiid['val'])) ? '0' : $nilaiid['val'];
                                        $gradethis = $grade->where('type', 'UTS')->first();
                                        $nilaitotal += ($gradethis->val / 100) * $nilai['mid_exam'];
                                        break;
                                    case 'UAS':
                                        $nilai['final_exam'] = (is_null($nilaiid['val'])) ? '0' : $nilaiid['val'];
                                        $gradethis = $grade->where('type', 'UAS')->first();
                                        $nilaitotal += ($gradethis->val / 100) * $nilai['final_exam'];
                                        break;
                                }
                            }
                        }

                        //all nilai
                        $nilaiakhirall[$no]['sid'] = $val['id'];
                        $nialiakhirall[$no]['nilai'] = $nilaitotal;

                        // untuk simpan di ep_final_grade_dtl
                        $all[$no]['format_code'] = $format_code;
                        $all[$no]['ayid'] = $ayid;
                        $all[$no]['tid'] = $tid;
                        $all[$no]['ccid'] = $kelas['id'];
                        $all[$no]['subject_id'] = $vv->subject_id;
                        $all[$no]['subject_seq_no'] = $vv->seq;
                        $all[$no]['sid'] = $val['id'];
                        $all[$no]['formative_val'] = (isset($nilai['formative_val'])) ? $nilai['formative_val'] : 0;
                        $all[$no]['mid_exam'] = $nilai['mid_exam'];
                        $all[$no]['final_exam'] = (isset($nilai['final_exam'])) ? $nilai['final_exam'] : 0;
                        $all[$no]['final_grade'] = $nilaitotal;
                        $all[$no]['lesson_hours'] = $vv->week_duration;
                        $all[$no]['weighted_grade'] = $all[$no]['lesson_hours'] * $all[$no]['final_grade'];
                        $all[$no]['class_avg'] = 0;
                        $all[$no]['sum_weighted_grade'] = 0;
                        $all[$no]['sum_lesson_hours'] = 0;
                        $all[$no]['ips'] = 0;
                        $all[$no]['gpa_prev'] = 0;
                        $all[$no]['gpa'] = 0;
                        $terbilang = \App\SmartSystem\General::terbilang($nilaitotal);
                        $all[$no]['letter_grade'] = ltrim($terbilang);
                        $all[$no]['grade_pass'] = $vv->grade_pass;
                        $all[$no]['mahmul'] = ($nilaitotal < $vv->grade_pass) ? '1' : '0';

                        $seq++;
                        $no++;
                    }
                }
            }

            $no = 0;
            $nos = 0;
            $allheader = array();
            $allsubject = array();

            //Petakan semua dari assessment untuk masuk ke finalgrade & finalgradedtl
            if($pelajaran->count() > 0)
            {
                // Rata-rata MP per Kelas
                foreach ($pelajaran as $kk => $vv)
                {
                    $murid = collect($all)->where('ccid',$kelas['id'])->where('subject_id', $vv->subject_id);
                    $jmhmurid = $murid->count();
                    $sumsubfinalgrade = $murid->sum('final_grade');
                    $avgsubfinalgrade = $sumsubfinalgrade/$jmhmurid;

                    $allsubject[$nos]['subject_id'] = $vv->subject_id;
                    $allsubject[$nos]['ccid'] = $kelas['id'];
                    $allsubject[$nos]['class_avg'] = round($avgsubfinalgrade, 2);

                    for($xx=0;$xx<count($all);$xx++)
                    {
                        if(
                            $all[$xx]['format_code']==$format_code
                            && $all[$xx]['ayid']==$ayid
                            && $all[$xx]['tid']==$tid
                            && $all[$xx]['ccid']==$kelas['id']
                            && $all[$xx]['subject_id']==$vv->subject_id
                        )
                        {
                            $all[$xx]['class_avg'] = round($avgsubfinalgrade,0);
                        }
                    }

                    $nos++;
                }

                // Jumlah Tiap Orang
                $murid = CourseClassDtl::getStudentPerClass($kelas['id']);
                $sumweightgrade = 0;
                $sumlessonhour = 0;
                foreach ($murid as $kk => $vv)
                {
                    $pelajaran = collect($all)->where('sid', $vv['id']);
                    $sumfinalgrade = $pelajaran->sum('final_grade');
                    $sumlessonhour = $pelajaran->sum('lesson_hours');
                    $sumweightgrade = $pelajaran->sum('weighted_grade');

                    $allheader[$no]['sid'] = $vv['id'];
                    $allheader[$no]['ccid'] = $kelas['id'];
                    $allheader[$no]['sum_final_grade'] = $sumfinalgrade;
                    $allheader[$no]['sum_weighted_grade'] = $sumweightgrade;
                    $allheader[$no]['sum_lesson_hours'] = $sumlessonhour;
                    $allheader[$no]['gpa'] = round($allheader[$no]['sum_weighted_grade'] / $allheader[$no]['sum_lesson_hours'], 2);

                    for($xx=0;$xx<count($all);$xx++)
                    {
                        if(
                            $all[$xx]['format_code']==$format_code
                            && $all[$xx]['ayid']==$ayid
                            && $all[$xx]['tid']==$tid
                            && $all[$xx]['ccid']==$kelas['id']
                            && $all[$xx]['sid']==$vv['id']
                        )
                        {
                            $all[$xx]['sum_final_grade'] = $sumfinalgrade;
                            $all[$xx]['sum_weighted_grade'] = $sumweightgrade;
                            $all[$xx]['sum_lesson_hours'] = $sumlessonhour;
                        }
                    }
                    $no++;
                }
            }

            $semuamuridarray = collect($allheader)->pluck('sid')->toArray();

            // Mahmul
            $mahmul = collect($all)->where('mahmul', '1');

            //Buat Variable untuk masukkan ke finalgrade langsung semua
            $arraytofinalgrade = [];
            for ($i = 0; $i < count($allheader); $i++)
            {
                $satuorangmahmul = implode(',',$mahmul->where('sid',$allheader[$i]['sid'])->pluck('subject_id')->toArray());
                $houseLeader = BoardingGroup::getFromBoarding($allheader[$i]['sid']);
                $houseLeaderId = isset($houseLeader['id']) ? $houseLeader['id'] : '';
                $arraytofinalgrade[$i]['ayid'] = $ayid;
                $arraytofinalgrade[$i]['tid'] = $tid;
                $arraytofinalgrade[$i]['format_code'] = $format_code;
                $arraytofinalgrade[$i]['ccid'] = $allheader[$i]['ccid'];
                $arraytofinalgrade[$i]['sid'] = $allheader[$i]['sid'];
                $arraytofinalgrade[$i]['date_legalization'] = $tanggalfix;
                $arraytofinalgrade[$i]['hijri_date_legalization'] = $tanggalhfix;
                $arraytofinalgrade[$i]['sum_weighted_grade'] = $allheader[$i]['sum_weighted_grade'];
                $arraytofinalgrade[$i]['sum_lesson_hours'] = $allheader[$i]['sum_lesson_hours'];
                $gpa = round($arraytofinalgrade[$i]['sum_weighted_grade']/$arraytofinalgrade[$i]['sum_lesson_hours'],2);
                $arraytofinalgrade[$i]['gpa'] = $gpa;
                $arraytofinalgrade[$i]['subject_remedy'] = $satuorangmahmul;
                $arraytofinalgrade[$i]['principal'] = $signed->principal;
                $arraytofinalgrade[$i]['curriculum'] = $signed->curriculum;
                $arraytofinalgrade[$i]['studentaffair'] = $signed->studentaffair;
                $arraytofinalgrade[$i]['form_teacher'] = $formTeacherId;
                $arraytofinalgrade[$i]['housemaster'] = $signed->housemaster;
                $arraytofinalgrade[$i]['houseleader'] = $houseLeaderId;
                $arraytofinalgrade[$i]['cby'] = auth()->user()->id;
                $arraytofinalgrade[$i]['con'] = date('Y-m-d H:i:s');
                $cekfinalgrade = FinalGrade::where('ayid',$ayid)
                    ->where('tid',$tid)
                    ->where('format_code',$format_code)
                    ->where('sid',$allheader[$i]['sid']);
                if($cekfinalgrade->exists())
                {
                    $cekfinalgrade->update([
                        'ccid' => $arraytofinalgrade[$i]['ccid'],
                        'date_legalization' => $tanggalfix,
                        'hijri_date_legalization' => $tanggalhfix,
                        'sum_weighted_grade' => $arraytofinalgrade[$i]['sum_weighted_grade'],
                        'sum_lesson_hours' => $arraytofinalgrade[$i]['sum_lesson_hours'],
                        'gpa' => $gpa,
                        'subject_remedy' => $satuorangmahmul,
                        'principal' => $signed->principal,
                        'curriculum' => $signed->curriculum,
                        'studentaffair' => $signed->studentaffair,
                        'form_teacher' => $formTeacherId,
                        'housemaster' => $signed->housemaster,
                        'houseleader' => $houseLeaderId,
                        'uby' => auth()->user()->id,
                        'uon' => date('Y-m-d H:i:s')
                    ]);
                }
                else
                {
                    $finalgrade = FinalGrade::create($arraytofinalgrade[$i]);
                }
            }

            if($format_code!='3')
            {
                for($i=0;$i<count($arraytofinalgrade);$i++)
                {
                    $gpa = round($arraytofinalgrade[$i]['sum_weighted_grade'] / $arraytofinalgrade[$i]['sum_lesson_hours'],2);
                    $cekgpa = Gpa::where('ayid',$ayid)->where('tid',$tid)->where('sid',$arraytofinalgrade[$i]['sid']);
                    if($cekgpa->exists())
                    {
                        $cekgpa->update(['gpa'=>$gpa]);
                    }
                    else
                    {
                        $cekgpa = new Gpa;
                        $cekgpa->ayid = $ayid;
                        $cekgpa->tid = $tid;
                        $cekgpa->sid = $arraytofinalgrade[$i]['sid'];
                        $cekgpa->gpa = $gpa;
                        $cekgpa->save();
                    }
                }
            }

            // Hapus FinalGradeDtl dulu semua
            $pelajaran = collect($all)->pluck('subject_id')->toArray();
            $pelajaran = array_unique($pelajaran);
            $text = FinalGradeDtl::delete_first($ayid,$tid,$semuamuridarray,$format_code);
            if($text!='Berhasil')
            {
                die('Gagal menghapus data lama!');
            }

            // Siapkan variable untuk insert semua ke finalgradedtl
            $arraytofinalgradedtl = [];
            for($x=0;$x<count($all);$x++)
            {
                $arraytofinalgradedtl[$x]['format_code'] = $format_code;
                $arraytofinalgradedtl[$x]['ayid'] = $ayid;
                $arraytofinalgradedtl[$x]['tid'] = $tid;
                $arraytofinalgradedtl[$x]['subject_id'] = $all[$x]['subject_id'];
                $arraytofinalgradedtl[$x]['sid'] = $all[$x]['sid'];
                $arraytofinalgradedtl[$x]['ccid'] = $all[$x]['ccid'];
                $arraytofinalgradedtl[$x]['subject_seq_no'] = $all[$x]['subject_seq_no'];
                $arraytofinalgradedtl[$x]['formative_val'] = $all[$x]['formative_val'];
                $arraytofinalgradedtl[$x]['mid_exam'] = $all[$x]['mid_exam'];
                $arraytofinalgradedtl[$x]['final_exam'] = $all[$x]['final_exam'];
                $arraytofinalgradedtl[$x]['final_grade'] = $all[$x]['final_grade'];
                $arraytofinalgradedtl[$x]['lesson_hours'] = $all[$x]['lesson_hours'];
                $arraytofinalgradedtl[$x]['weighted_grade'] = $all[$x]['weighted_grade'];
                $arraytofinalgradedtl[$x]['letter_grade'] = $all[$x]['letter_grade'];
                $arraytofinalgradedtl[$x]['class_avg'] = $all[$x]['class_avg'];
                $arraytofinalgradedtl[$x]['sum_weighted_grade'] = $all[$x]['sum_weighted_grade'];
                $arraytofinalgradedtl[$x]['sum_lesson_hours'] = $all[$x]['sum_lesson_hours'];
                $arraytofinalgradedtl[$x]['cby'] = auth()->user()->id;
                $arraytofinalgradedtl[$x]['con'] = date('Y-m-d H:i:s');
            }

            // Simpan ke FinalGradeDtl
            FinalGradeDtl::insert($arraytofinalgradedtl);

            // Generate IPK
            // Gpa::updateIPK($semuamuridarray,$ayid,$tid);

            if($format_code!='3')
            {
                // Hapus Mahmul untuk ayid tid dan siswa
                RemedyClass::delete_first($semuamuridarray,$ayid,$tid);
                // Masukkan langsung
                if($mahmul->count()>0)
                {
                    $datamahmul = []; $nod = 0;
                    foreach($mahmul as $kym => $vym)
                    {
                        $cekremedy = RemedyClass::where('ayid',$ayid)
                            ->where('tid',$tid)
                            ->where('sid',$vym['sid']);
                        if($cekremedy->exists())
                        {
                            $cekremedy->update([
                                'course_subject_id' => $vym['subject_id'],
                                'grade_before' => $vym['final_grade'],
                                'grade_pass' => $vym['grade_pass'],
                                'uon' => date('Y-m-d H:i:s'),
                                'uby' => auth()->user()->id
                            ]);
                        }
                        else
                        {
                            $cekremedy = new RemedyClass;
                            $cekremedy->ayid = $ayid;
                            $cekremedy->tid = $tid;
                            $cekremedy->sid = $vym['sid'];
                            $cekremedy->course_subject_id = $vym['subject_id'];
                            $cekremedy->grade_before = $vym['final_grade'];
                            $cekremedy->grade_pass = $vym['grade_pass'];
                            $cekremedy->con = date('Y-m-d H:i:s');
                            $cekremedy->cby = auth()->user()->id;
                        }

                        $datamahmul[$nod]['ayid'] = $ayid;
                        $datamahmul[$nod]['tid'] = $tid;
                        $datamahmul[$nod]['sid'] = $vym['sid'];
                        $datamahmul[$nod]['course_subject_id'] = $vym['subject_id'];
                        $datamahmul[$nod]['grade_before'] = $vym['final_grade'];
                        $datamahmul[$nod]['grade_pass'] = $vym['grade_pass'];
                        $datamahmul[$nod]['con'] = date('Y-m-d H:i:s');
                        $datamahmul[$nod]['cby'] = auth()->user()->id;
                        $nod++;
                    }
                    RemedyClass::insert($datamahmul);
                }
            }
        }
        echo 'Berhasil';
    }

	public function processing_v1(Request $req)
    {
		$format_code    = ($req->mode=='UTS') ? '3' : '0';
		$ayid           = config('id_active_academic_year');
		$tid            = config('id_active_term');

        //get Kepala Sekolah
        $signed         = SignedPosition::where('ayid', $ayid)->first();
        if(is_null($signed))
        {
            die('Mohon tentukan Kepala Sekolah tahun ajaran '.config('active_academic_year').'. Hubungi Admin!');
        }

        //Tanggal untuk diraport
        $tanggal        = AcademicYearDetail::select('final_exam_date','hijri_final_exam_date')->where('ayid',$ayid)->where('tid',$tid)->first();
        if(is_null($tanggal) || $tanggal['final_exam_date']=="0000-00-00")
        {
            die('Mohon tentukan Tanggal Raport '.$req->mode.'. Hubungi Admin!');
        }
        $tanggalfix     = $tanggal['final_exam_date'];
        $tanggalhfix    = $tanggal['hijri_final_exam_date'];

		$kelas          = array();
		parse_str($req->kls, $kelas);

		$kelasterpilih  = $kelas['chk'];
		$kelas          = CourseClass::whereIn('id', $kelasterpilih)->get();
        $level          = $kelas->pluck('level')->toArray();
        $level          = array_unique($level);
        $pelajaran      = CourseSubject::select('id', 'subject_id', 'week_duration', 'grade_pass', 'seq','level')
            ->where('ayid',$ayid)
            ->where('tid', $tid)
            ->whereIn('level', $level)
            ->get();
		$grade          = GradeWeight::where('val', '!=', '0')->get();
		$grade          = collect($grade);
		$all            = array();
		$nilaiakhirall  = array();
        $nilaibayanat   = array();
        $student = array();
		$no = 0;

		foreach ($kelas as $k => $v)
        {
			$murid          = CourseClassDtl::getStudentPerClass($v->id);
            $person         = collect($murid)->pluck('pid')->toArray();
            $student        = collect($murid)->pluck('id')->toArray();
            $formTeacher    = Homeroom::getFromClass($v->id);
            $formTeacherId  = isset($formTeacher['id']) ? $formTeacher['id'] : '';
			foreach ($murid as $key => $val)
            {
				$seq = 0;
                $pelajaranmurid = collect($pelajaran)->where('level',$v->level);
                if($pelajaran->count() > 0)
                {
                    foreach ($pelajaran as $kk => $vv)
                    {
                        $nilai = array();
                        $nilaitotal = 0;
                        if($format_code=='3')
                        {
                            $nilaiid = Assessment::getAssessmentStudent($ayid,$tid,$vv->subject_id,'UTS',$val['id']);
                            $nilai['mid_exam'] = (is_null($nilaiid['val'])) ? '0' : $nilaiid['val'];
                            $nilaitotal += $nilai['mid_exam'];
                        }
                        else
                        {
                            foreach ($grade as $keyk => $valv) {
                                $nilaiid = Assessment::getAssessmentStudent($ayid, $tid, $vv->subject_id, $valv->type, $val['id']);
                                switch ($valv->type) {
                                    case 'TGS':
                                        $nilai['formative_val'] = (is_null($nilaiid['val'])) ? '0' : $nilaiid['val'];
                                        $gradethis = $grade->where('type', 'TGS')->first();
                                        $nilaitotal += ((int) $gradethis['val'] / 100) * $nilai['formative_val'];
                                        break;
                                    case 'UTS':
                                        $nilai['mid_exam'] = (is_null($nilaiid['val'])) ? '0' : $nilaiid['val'];
                                        $gradethis = $grade->where('type', 'UTS')->first();
                                        $nilaitotal += ((int) $gradethis['val'] / 100) * $nilai['mid_exam'];
                                        break;
                                    case 'UAS':
                                        $nilai['final_exam'] = (is_null($nilaiid['val'])) ? '0' : $nilaiid['val'];
                                        $gradethis = $grade->where('type', 'UAS')->first();
                                        $nilaitotal += ((int) $gradethis['val'] / 100) * $nilai['final_exam'];
                                        break;
                                }
                            }
                        }

                        // $finalgrade = Grade::getGradeStudent($ayid, $tid, $vv->subject_id, $val['id']);
                        $nilaitotal = round($nilaitotal);

                        //all nilai
                        $nilaiakhirall[$no]['sid'] = $val['id'];
                        $nialiakhirall[$no]['nilai'] = $nilaitotal;

                        // untuk simpan di ep_final_grade_dtl
                        $all[$no]['format_code'] = $format_code;
                        $all[$no]['ayid'] = $ayid;
                        $all[$no]['tid'] = $tid;
                        $all[$no]['ccid'] = $v->id;
                        $all[$no]['subject_id'] = $vv->subject_id;
                        $all[$no]['subject_seq_no'] = $vv->seq;
                        $all[$no]['sid'] = $val['id'];
                        $all[$no]['formative_val'] = (isset($nilai['formative_val'])) ? $nilai['formative_val'] : 0;
                        $all[$no]['mid_exam'] = $nilai['mid_exam'];
                        $all[$no]['final_exam'] = (isset($nilai['final_exam'])) ? $nilai['final_exam'] : 0;
                        $all[$no]['final_grade'] = $nilaitotal;
                        $all[$no]['lesson_hours'] = $vv->week_duration;
                        $all[$no]['weighted_grade'] = $all[$no]['lesson_hours'] * $all[$no]['final_grade'];
                        $all[$no]['class_avg'] = 0;
                        $all[$no]['sum_weighted_grade'] = 0;
                        $all[$no]['sum_lesson_hours'] = 0;
                        $all[$no]['ips'] = 0;
                        $all[$no]['gpa_prev'] = 0;
                        $all[$no]['gpa'] = 0;
                        $all[$no]['result'] = 0;
                        $terbilang = \App\SmartSystem\General::terbilang($nilaitotal);
                        $all[$no]['letter_grade'] = ltrim($terbilang);
                        $all[$no]['grade_pass'] = $vv->grade_pass;
                        $all[$no]['mahmul'] = ($nilaitotal < $vv->grade_pass) ? '1' : '0';

                        $seq++;
                        $no++;
                    }
                }
			}

            //Ambil data Bayanat Quran per kelas
            $nilaibayanatsemua = BayanatAssessment::getAssessmentToProcess($person);
            $groupnilaibayanat = collect($nilaibayanatsemua)->groupBy('pid');
            $notesbayanatsemua = BayanatResult::where('ayid',$ayid)
                ->where('tid',$tid)
                ->whereIn('pid',$person)
                ->get();
            $gradebayanat = BayanatWeight::get()->toArray();
            if($format_code!='3')
            {
                // proses nilai Bayanat jika bukan UTS
				$text = '';
				$text1 = '';
                $index = 0;
                foreach($groupnilaibayanat as $key=>$val)
                {
                    $nilaitotal = 0;
                    foreach($val as $key1 => $val1)
                    {
                        $nilaitotal += ($val1['bobot']/100) * $val1['grade'];
                    }
                    $nilaibayanat[$index]['pid'] = $val[0]['pid'];
                    $nilaibayanat[$index]['ayid'] = $ayid;
                    $nilaibayanat[$index]['tid'] = $tid;
                    $nilaibayanat[$index]['cqid'] = $val[0]['cqid'];
                    $nilaibayanat[$index]['eid'] = $val[0]['eid'];
                    $nilaibayanat[$index]['juz_is_study'] = $val[0]['juz'];
                    $nilaibayanat[$index]['result_level_halqah'] = $val[0]['juzid'];
                    $nilaibayanat[$index]['result_set'] = (int)round($nilaitotal);
                    $nilaibayanat[$index]['result_decision_set'] = BayanatAssessment::getDecisionSet($nilaitotal);
                    $nilaibayanat[$index]['result_appreciation'] = BayanatAssessment::getAppreciation($nilaitotal);
                    $indexdetail = 0;
                    foreach($val as $key1 => $val1)
                    {
                        $nilaibayanat[$index]['detail'][$indexdetail]['id_evaluation'] = $val1['bobotid'];
                        $nilaibayanat[$index]['detail'][$indexdetail]['weight_evaluation'] = $val1['bobot'];
                        $nilaibayanat[$index]['detail'][$indexdetail]['result_evaluation'] = $val1['grade'];
                        $indexdetail++;
                    }
                    $index++;
                }
            }
		}

        // dd(collect($all)->where('sid',118));
		$no = 0;
		$nos = 0;
		$allheader = array();
		$allsubject = array();

		foreach ($kelas as $k => $v) {
            if($pelajaran->count() > 0)
            {
                foreach ($pelajaran as $kk => $vv) {
                    $murid = collect($all)->where('ccid',$v->id)->where('subject_id', $vv->subject_id);
                    $sumsubfinalgrade = $murid->sum('final_grade');
                    $avgsubfinalgrade = $sumsubfinalgrade/count($murid->toArray());

                    $allsubject[$nos]['subject_id'] = $vv['id'];
                    $allsubject[$nos]['ccid'] = $v['id'];
                    $allsubject[$nos]['class_avg'] = round($avgsubfinalgrade, 0);

                    for($xx=0;$xx<count($all);$xx++)
                    {
                        if(
                            $all[$xx]['format_code']==$format_code
                            && $all[$xx]['ayid']==$ayid
                            && $all[$xx]['tid']==$tid
                            && $all[$xx]['ccid']==$v['id']
                            && $all[$xx]['subject_id']==$vv->subject_id
                        )
                        {
                            $all[$xx]['class_avg'] = round($avgsubfinalgrade,0);
                        }
                    }

                    $nos++;
                }
                $murid = CourseClassDtl::getStudentPerClass($v->id);
                $sumweightgrade = 0;
                $sumlessonhour = 0;
                foreach ($murid as $kk => $vv) {
                    $pelajaran = collect($all)->where('sid', $vv['id']);
                    $sumfinalgrade = $pelajaran->sum('final_grade');
                    $sumlessonhour = $pelajaran->sum('lesson_hours');
                    $sumweightgrade = $pelajaran->sum('weighted_grade');

                    $allheader[$no]['sid'] = $vv['id'];
                    $allheader[$no]['ccid'] = $v['id'];
                    $allheader[$no]['sum_final_grade'] = $sumfinalgrade;
                    $allheader[$no]['sum_weighted_grade'] = $sumweightgrade;
                    $allheader[$no]['sum_lesson_hours'] = $sumlessonhour;
                    $allheader[$no]['gpa'] = round($allheader[$no]['sum_weighted_grade'] / $allheader[$no]['sum_lesson_hours'], 0);

                    for($xx=0;$xx<count($all);$xx++)
                    {
                        if(
                            $all[$xx]['format_code']==$format_code
                            && $all[$xx]['ayid']==$ayid
                            && $all[$xx]['tid']==$tid
                            && $all[$xx]['ccid']==$v['id']
                            && $all[$xx]['sid']==$vv['id']
                        )
                        {
                            $all[$xx]['sum_final_grade'] = $sumfinalgrade;
                            $all[$xx]['sum_weighted_grade'] = $sumweightgrade;
                            $all[$xx]['sum_lesson_hours'] = $sumlessonhour;
                        }
                    }
                    $no++;
                }
            }
		}

		$callsubject = collect($allsubject);
		for ($i = 0; $i < count($allheader); $i++) {
            $houseLeader = BoardingGroup::getFromBoarding($allheader[$i]['sid']);
            $houseLeaderId = isset($houseLeader['id']) ? $houseLeader['id'] : '';
			FinalGrade::updateOrCreate(
				[
					'ayid' => $ayid,
					'tid' => $tid,
                    'format_code' => $format_code,
					'ccid' => $allheader[$i]['ccid'],
					'sid' => $allheader[$i]['sid'],
				],
				[
					'date_legalization' => $tanggalfix,
					'hijri_date_legalization' => $tanggalhfix,
					'sum_weighted_grade' => $allheader[$i]['sum_weighted_grade'],
					'sum_lesson_hours' => $allheader[$i]['sum_lesson_hours'],
					'gpa' => round($allheader[$i]['sum_weighted_grade'] / $allheader[$i]['sum_lesson_hours'], 2),
                    'principal' => $signed->principal,
                    'curriculum' => $signed->curriculum,
                    'studentaffair' => $signed->studentaffair,
                    'form_teacher' => $formTeacherId,
                    'housemaster' => $signed->housemaster,
                    'houseleader' => $houseLeaderId,
                    'cby' => auth()->user()->id,
					'uby' => auth()->user()->id,
				]
			);
            if($format_code!='3')
            {
                $gpa = ($allheader[$i]['sum_weighted_grade'] / $allheader[$i]['sum_lesson_hours']);
                $cekgpa = Gpa::where('ayid',$ayid)->where('tid',$tid)->where('sid',$allheader[$i]['sid']);
                if($cekgpa->exists())
                {
                    $cekgpa->update(['gpa'=>$gpa]);
                }
                else
                {
                    $cekgpa = new Gpa;
                    $cekgpa->ayid = $ayid;
                    $cekgpa->tid = $tid;
                    $cekgpa->sid = $allheader[$i]['sid'];
                    $cekgpa->gpa = $gpa;
                    $cekgpa->save();
                }
            }
		}
        sleep(1);

        /* HAPUS TERLEBIH DAHULU YANG ADA */
        $pelajaran = collect($all)->pluck('subject_id')->toArray();
        $pelajaran = array_unique($pelajaran);
        $siswa = collect($all)->pluck('sid')->toArray();
        $siswa = array_unique($siswa);
        if($text!='Berhasil')
        {
            die('Gagal menghapus data lama!');
        }

        $errorfinalgradedtl = '';
        for($x=0;$x<count($all);$x++)
        {
            try {
                FinalGradeDtl::updateOrCreate(
                    [
                        'format_code' => $format_code,
                        'ayid' => $all[$x]['ayid'],
                        'tid' => $all[$x]['tid'],
                        'subject_id' => $all[$x]['subject_id'],
                        'sid' => $all[$x]['sid'],
                    ],
                    [
                        'ccid' => $all[$x]['ccid'],
                        'subject_seq_no' => $all[$x]['subject_seq_no'],
                        'formative_val' => $all[$x]['formative_val'],
                        'mid_exam' => $all[$x]['mid_exam'],
                        'final_exam' => $all[$x]['final_exam'],
                        'final_grade' => $all[$x]['final_grade'],
                        'lesson_hours' => $all[$x]['lesson_hours'],
                        'weighted_grade' => $all[$x]['weighted_grade'],
                        'letter_grade' => $all[$x]['letter_grade'],
						'class_avg' => $all[$x]['class_avg'],
						'sum_weighted_grade' => $all[$x]['sum_weighted_grade'],
						'sum_lesson_hours' => $all[$x]['sum_lesson_hours'],
                        'cby' => auth()->user()->id,
                        'con' => date('Y-m-d H:i:s'),
                        'uby' => auth()->user()->id,
                        'uon' => date('Y-m-d H:i:s'),
                    ]
                );
            } catch (\Throwable $th) {
                $errorfinalgradedtl .= $th.'-';
            }
        }

        sleep(1);
		$mahmul = collect($all)->where('mahmul', '1');
        if($mahmul->count()>0)
        {
            foreach($mahmul as $kym => $vym)
            {
                RemedyClass::insert([
                    'ayid' => $ayid,
                    'tid' => $tid,
                    'sid' => $vym['sid'],
                    'course_subject_id' => $vym['subject_id'],
                    'grade_before' => $vym['final_grade'],
                    'con' => date('Y-m-d H:i:s'),
                    'cby' => auth()->user()->id,
                ]);
            }
        }

        sleep(1);
		if($format_code!='3')
		{
			for($i=0;$i<count($nilaibayanat);$i++)
			{
                $cekada = BayanatResult::where('pid',$nilaibayanat[$i]['pid'])
                    ->where('ayid',$nilaibayanat[$i]['ayid'])
                    ->where('tid',$nilaibayanat[$i]['tid'])
                    ->where('cqid',$nilaibayanat[$i]['cqid'])
                    ->where('eid',$nilaibayanat[$i]['eid']);
                if($cekada->exists())
                {
                    $cekada->update(
                        [
                            'juz_is_study'=>$nilaibayanat[$i]['juz_is_study'],
                            'result_level_halqah'=>$nilaibayanat[$i]['result_level_halqah'],
                            'result_set'=>$nilaibayanat[$i]['result_set'],
                            'result_decision_set'=>$nilaibayanat[$i]['result_decision_set'],
                            'result_appreciation'=>$nilaibayanat[$i]['result_appreciation'],
                            'uby'=>auth()->user()->pid,
                            'uon'=>date('Y-m-d H:i:s'),
                        ]
                    );
                    $ada = $cekada->first();
                    if(!is_null($ada))
                    {
                        $id = $cekada->first()['id'];
                        $detail = array();
                        $nodetail = 0;
                        foreach($nilaibayanat[$i]['detail'] as $ky=>$vl)
                        {
                            $detail[$nodetail]['hid'] = $id;
                            $detail[$nodetail]['id_evaluation'] = $vl['id_evaluation'];
                            $detail[$nodetail]['weight_evaluation'] = $vl['weight_evaluation'];
                            $detail[$nodetail]['result_evaluation'] = $vl['result_evaluation'];
                            $nodetail++;
                        }
                        BayanatResultDtl::where('hid',$id)->delete();
                        BayanatResultDtl::insert($detail);
                    }
                }
                else
                {
                    $create = new BayanatResult();
                    $create->pid = $nilaibayanat[$i]['pid'];
                    $create->ayid = $nilaibayanat[$i]['ayid'];
                    $create->tid = $nilaibayanat[$i]['tid'];
                    $create->cqid = $nilaibayanat[$i]['cqid'];
                    $create->eid = $nilaibayanat[$i]['eid'];
                    $create->juz_is_study = $nilaibayanat[$i]['juz_is_study'];
                    $create->result_level_halqah = $nilaibayanat[$i]['result_level_halqah'];
                    $create->result_set = $nilaibayanat[$i]['result_set'];
                    $create->result_decision_set = $nilaibayanat[$i]['result_decision_set'];
                    $create->result_appreciation = $nilaibayanat[$i]['result_appreciation'];
                    // $create->result_decision_level = $nilaibayanat[$i]['result_decision_level'];
                    $create->cby = auth()->user()->pid;
                    $create->con = date('Y-m-d H:i:s');
                    $create->save();

                    $ada = $create->id;
                    if(!is_null($ada))
                    {
                        $id = $ada;
                        $detail = array();
                        $nodetail = 0;
                        foreach($nilaibayanat[$i]['detail'] as $ky=>$vl)
                        {
                            $detail[$nodetail]['hid'] = $id;
                            $detail[$nodetail]['id_evaluation'] = $vl['id_evaluation'];
                            $detail[$nodetail]['weight_evaluation'] = $vl['weight_evaluation'];
                            $detail[$nodetail]['result_evaluation'] = $vl['result_evaluation'];
                            $nodetail++;
                        }
                        BayanatResultDtl::insert($detail);
                    }
                }
			}
		}
		echo 'Berhasil';
	}

	public function processingBoarding(Request $req)
    {
		$format_code    = '1';
		$ayid           = config('id_active_academic_year');
		$tid            = config('id_active_term');

		$musyrif = array();
		parse_str($req->musyrif, $musyrif);
		$musyrifterpilih = $musyrif['chkms'];
		$musyrif = Employe::select('id')->whereIn('id', $musyrifterpilih)->get();
		$all = array();
		$no = 0;

        //get Kepala Sekolah
        $signed         = SignedPosition::where('ayid', $ayid)->first();
        if(is_null($signed))
        {
            die('Mohon tentukan Kepala Sekolah tahun ajaran '.config('active_academic_year').'. Hubungi Admin!');
        }

        //Tanggal untuk diraport
        $tanggal = AcademicYearDetail::select('final_exam_date','hijri_final_exam_date')->where('ayid',$ayid)->where('tid',$tid)->first();
        if(is_null($tanggal) || $tanggal['final_exam_date']=="0000-00-00")
        {
            die('Mohon tentukan Tanggal '.$req->mode.'. Hubungi Admin!');
        }
        $tanggalfix = $tanggal['final_exam_date'];
        $tanggalhfix = $tanggal['hijri_final_exam_date'];
		//MS yang dipilih
		foreach ($musyrif as $k => $v)
        {
			//Siswa yang berada didalam rombongan kamar per Musyrif Sakan
			$murid = BoardingGroup::getStudentPerMusyrif($v->id);
			foreach ($murid as $siswa)
            {
                //Hapus dahulu nilai siswa yang ada
                $qDelete = "DELETE hdr, dtl
                FROM ep_final_grade hdr
                INNER JOIN ep_final_grade_dtl dtl
                ON hdr.format_code = dtl.format_code
                AND hdr.ayid = dtl.ayid
                AND hdr.tid = dtl.tid
                AND hdr.sid = dtl.sid
                WHERE hdr.format_code = $format_code
                AND hdr.ayid = $ayid
                AND hdr.tid = $tid
                AND hdr.sid = ".$siswa['id'];
                DB::statement($qDelete);

                //Mendapatkan Kelas Siswa
                $qClass = CourseClassDtl::select('ccid')
                        ->where('ayid',$ayid)
                        ->where('sid',$siswa['id'])
                        ->first();
                $class = isset($qClass->ccid) ? $qClass->ccid : '';

                $notes = BoardingNote::select('note')
                        ->where('ayid',$ayid)
                        ->where('tid',$tid)
                        ->where('sid',$siswa['id'])
                        ->first();

                $note = isset($notes) ? $notes->note : '';

                $housemaster    = $siswa['sex']=='L' ? $signed['housemaster_male'] : $signed['housemaster_female'];

                //Simpan ke Final Grade
                $cekhdr = FinalGrade::where('format_code',$format_code)
                                            ->where('ayid',$ayid)
                                            ->where('tid',$tid)
                                            ->where('ccid',$class)
                                            ->where('sid',$siswa['id']);
                if($cekhdr->exists()) {
                    $cekhdr->update(
                        [
                            'date_legalization' => $tanggalfix,
                            'hijri_date_legalization' => $tanggalhfix,
                            'note_boarding' => $note,
                            'principal' => $signed->principal,
                            'curriculum' => $signed->curriculum,
                            'studentaffair' => $signed->studentaffair,
                            'housemaster' => $housemaster,
                            'houseleader' => $v->id,
                            'cby' => auth()->user()->id,
                            'uby' => auth()->user()->id,
                        ]
                    );
                } else {
                    $hdr = new FinalGrade;
                    $hdr->format_code = $format_code;
                    $hdr->ayid = $ayid;
                    $hdr->tid = $tid;
                    $hdr->ccid = $class;
                    $hdr->sid = $siswa['id'];
                    $hdr->date_legalization = $tanggalfix;
                    $hdr->hijri_date_legalization = $tanggalhfix;
                    $hdr->note_boarding = $note;
                    $hdr->principal = $signed->principal;
                    $hdr->curriculum = $signed->curriculum;
                    $hdr->studentaffair = $signed->studentaffair;
                    $hdr->housemaster = $housemaster;
                    $hdr->houseleader = $v->id;
                    $hdr->cby = auth()->user()->id;
                    $hdr->uby = auth()->user()->id;
                    $hdr->save();
                }


                $activity = BoardingActivity::select('id','seq')->get();
                $seq = 0;

                foreach ($activity as $ka => $va)
                {
                    $nilaipredikatid = Assessment::getBoardingAssessmentPredicateStudent($ayid, $tid,$siswa['id'], $va->id);
                    $nilaiakhirhuruf = $nilaipredikatid['predicate']!='' ? $nilaipredikatid['predicate'] : '-';

                    $activityItem    = BoardingActivityItem::getBoardingItem('');
                    $item = 0;
                    $nilaiperactivity = 0;

                    foreach ($activityItem as $kai => $vai)
                    {
                        if($vai['activity_id'] == $va->id) {
                            $nilai          = Assessment::getBoardingAssessmentStudent($ayid, $tid, $siswa['id'], $vai['id']);
                            $target         = Assessment::getBoardingAssessmentStudentTarget($ayid, $tid, $vai['id']);

                            $tscore         = $nilai['tscore'];
                            $tremission     = $nilai['tremission'];
                            $tscoretarget   = $target['tscoretarget'];
                            $tscoretrem     = $tscore + $tremission;
                            $nilaiperactivityitem = ($tscoretrem >= 1 && $tscoretarget != 0) ? 100 * ($tscoretrem / $tscoretarget) : 0;

                            $nilaiperactivity += $nilaiperactivityitem;
                            $item++;
                        }
                    }
                    $nilaiakhir = $nilaiperactivity >= 1 ? round($nilaiperactivity / $item) : 0;
                    $all[$no]['subject_id']     = $va->id;
                    $all[$no]['subject_seq_no'] = $va->seq!='' ? $va->seq : 0;
                    $all[$no]['ccid']           = $class;
                    $all[$no]['sid']            = $siswa['id'];
                    $all[$no]['final_grade']    = $nilaiakhir;
                    $all[$no]['letter_grade']   = $nilaiakhirhuruf;

                    $cekDtl = FinalGradeDtl::where('format_code',$format_code)
                        ->where('ayid',$ayid)
                        ->where('tid', $tid)
                        ->where('subject_id',$all[$no]['subject_id'])
                        ->where('ccid', $all[$no]['ccid'])
                        ->where('sid', $all[$no]['sid']);
                    if($cekDtl->exists()) {
                        $cekDtl->update([
                            'subject_seq_no' => $all[$no]['subject_seq_no'],
                            'final_grade' => $all[$no]['final_grade'],
                            'letter_grade' => $all[$no]['letter_grade'],
                            'cby' => auth()->user()->id,
                            'uby' => auth()->user()->id,
                        ]);
                    } else {
                        $dtl = new FinalGradeDtl;
                        $dtl->format_code = $format_code;
                        $dtl->ayid = $ayid;
                        $dtl->tid = $tid;
                        $dtl->subject_id = $all[$no]['subject_id'];
                        $dtl->ccid = $all[$no]['ccid'];
                        $dtl->sid = $all[$no]['sid'];
                        $dtl->subject_seq_no = $all[$no]['subject_seq_no'];
                        $dtl->final_grade = $all[$no]['final_grade'];
                        $dtl->letter_grade = $all[$no]['letter_grade'];
                        $dtl->cby = auth()->user()->id;
                        $dtl->uby = auth()->user()->id;
                        $dtl->save();
                    }
                    $seq++;
                    $no++;
                }
			}
		}
		echo 'Berhasil';
	}

    public function processing_diknas(Request $req)
    {
        $format_code_diknas = 2;
        $ayid = config('id_active_academic_year');
        $tid = config('id_active_term');

        $signed = SignedPosition::where('ayid',$ayid);
        if(!$signed->exists())
        {
            die('Mohon tentukan Kepala Sekolah tahun ajaran '.config('active_academic_year').'. Hubungi Admin!');
        }
        $signed = $signed->first();

        $tanggal = AcademicYearDetail::select('mid_exam_date','hijri_mid_exam_date','final_exam_date','hijri_final_exam_date')->where('ayid',$ayid)->where('tid',$tid);

        if(!$tanggal->exists() || $tanggal->first()->final_exam_date=='0000-00-00')
        {
            die('Mohon tentukan Tanggal Raport '.$req->mode.'. Hubungi Admin!');
        }
        $tanggal = $tanggal->first();
        $tanggalfix = $tanggal['final_exam_date'];
        $tanggalhfix = $tanggal['hijri_final_exam_date'];

        $kelas = array();
        parse_str($req->kls,$kelas);
        $kelasterpilih = $kelas['chkdiknas'];
        foreach($kelasterpilih as $kelasterpilih)
        {
            $kelas = CourseClass::where('id',$kelasterpilih)->first()->toArray();
            $level = $kelas['level'];
            $pelajaranDiknas = SubjectDiknasMapping::getFromLevel($level,$ayid,$tid);
            $murid = CourseClassDtl::getStudentPerClass($kelas['id']);
            $formTeacher    = Homeroom::getFromClass($kelas['id']);
            $formTeacherId  = isset($formTeacher['id']) ? $formTeacher['id'] : '';
            $arrSbjDiknas   = array();
            $noDiknas       = 0;

            foreach($murid as $key => $val)
            {
                //=== Mapel Diknas ===//
                $kkm_diknas = 71;
                if($pelajaranDiknas->count() > 0)
                {
                    foreach ($pelajaranDiknas as $kk => $vv)
                    {
                        $sumWeightedGradeDiknas = 0;
                        $sumLessonHoursDiknas = 0;
                        $sumAssesmentTgsDiknas = 0;
                        $countSbj = 0;
                        $coreCompetence = ['spiritual'=>1,'sosial'=>2,'pengetahuan'=>3,'keterampilan'=>4];
                        $subjectDiknasGroupId = json_decode($vv->group);
                        if($subjectDiknasGroupId) {
                            foreach ($subjectDiknasGroupId as $subjectDiknasGroupId)
                            {
                                $getSbj = FinalGradeDtl::select('ep_final_grade_dtl.ccid','ep_final_grade_dtl.sid','final_grade','lesson_hours','weighted_grade','ep_assessment.val AS tgs')
                                        ->leftJoin('ep_assessment', function($join) {
                                            $join->on('ep_final_grade_dtl.ayid','=','ep_assessment.ayid');
                                            $join->on('ep_final_grade_dtl.tid','=','ep_assessment.tid');
                                            $join->on('ep_final_grade_dtl.sid','=','ep_assessment.sid');
                                            $join->on('ep_final_grade_dtl.subject_id','=','ep_assessment.subject_id');
                                            $join->on('ep_assessment.grade_type','=',DB::raw("'TGS'"));
                                        })
                                        ->where('ep_final_grade_dtl.format_code',0)
                                        ->where('ep_final_grade_dtl.ayid', $ayid)
                                        ->where('ep_final_grade_dtl.tid', $tid)
                                        ->where('ep_final_grade_dtl.ccid', $kelas['id'])
                                        ->where('ep_final_grade_dtl.sid', $val['id'])
                                        ->where('ep_final_grade_dtl.subject_id', $subjectDiknasGroupId)
                                        ->get();
                                foreach ($getSbj as $kSbjDiknas => $vSbjDiknas) {
                                    $sumWeightedGradeDiknas+= $getSbj[$kSbjDiknas]['weighted_grade'];
                                    $sumLessonHoursDiknas+=$getSbj[$kSbjDiknas]['lesson_hours'];
                                    $sumAssesmentTgsDiknas+= $getSbj[$kSbjDiknas]['tgs'];
                                    $countSbj++;
                                }
                            }
                        }
                        $arrSbjDiknas[$noDiknas]['format_code']     = $format_code_diknas;
                        $arrSbjDiknas[$noDiknas]['ayid']            = $ayid;
                        $arrSbjDiknas[$noDiknas]['tid']             = $tid;
                        $arrSbjDiknas[$noDiknas]['subject_id']      = $vv->subject_diknas_id;
                        $arrSbjDiknas[$noDiknas]['subject_seq_no']  = $vv->seq;
                        $arrSbjDiknas[$noDiknas]['ccid']            = $kelas['id'];
                        $arrSbjDiknas[$noDiknas]['sid']             = $val['id'];
                        $arrSbjDiknas[$noDiknas]['weighted_grade']  = $sumWeightedGradeDiknas;
                        $arrSbjDiknas[$noDiknas]['lesson_hours']    = $sumLessonHoursDiknas;
                        $arrSbjDiknas[$noDiknas]['final_grade_kgn'] = $arrSbjDiknas[$noDiknas]['lesson_hours']!=0 ? $arrSbjDiknas[$noDiknas]['weighted_grade'] / $arrSbjDiknas[$noDiknas]['lesson_hours'] : 0; //Rumus Nilai Pengetahuan (Total NA / Total Jam)
                        $arrSbjDiknas[$noDiknas]['final_grade_psk'] = $countSbj!=0 ? $sumAssesmentTgsDiknas / $countSbj : 0; //Rumus Nilai Keterampilan (Nilai Tugas / Jumlah Mapel)

                        //Mengambil KD dari Database
                        $getSubjectDiknasBasic = SubjectDiknasBasic::where('level', $level)->where('subject_diknas_id',$arrSbjDiknas[$noDiknas]['subject_id'])->get()->toArray();

                        //Spiritual Deskripsi
                        if($arrSbjDiknas[$noDiknas]['subject_id']==1) {
                            $getAfkSpt = collect($getSubjectDiknasBasic)->where('core_competence',$coreCompetence['spiritual'])->pluck('desc')->toArray();
                            if(count($getAfkSpt)!=0) {
                                $arrAfkSptDesc = array();
                                for ($i=0; $i <count($getAfkSpt) ; $i++) {
                                    $arrAfkSptDesc[] = $getAfkSpt[$i];
                                }
                                $strAfkSptDesc = implode("|",$arrAfkSptDesc);
                                if($arrSbjDiknas[$noDiknas]['final_grade_kgn'] >= $kkm_diknas) {
                                    $afkSptDesc = 'Sikap yang menonjol adalah {'.$strAfkSptDesc.'}';
                                } else {
                                    $afkSptDesc = 'Sikap yang menonjol adalah {'.$strAfkSptDesc.'}, perlu bimbingan dalam {'.$strAfkSptDesc.'}';
                                }
                            }
                            $arrSbjDiknas[$noDiknas]['spiritual_desc'] = (count($getAfkSpt)!=0) ? $this->spintaxProcess($afkSptDesc) : '';
                        }

                        //Sosial Deskripsi
                        if($arrSbjDiknas[$noDiknas]['subject_id']==2) {
                            $getAfkSos = collect($getSubjectDiknasBasic)->where('core_competence',$coreCompetence['sosial'])->pluck('desc')->toArray();
                            if(count($getAfkSos)!=0) {
                                $arrAfkSosDesc = array();
                                for ($i=0; $i <count($getAfkSos) ; $i++) {
                                    $arrAfkSosDesc[] = $getAfkSos[$i];
                                }
                                $strAfkSosDesc = implode("|",$arrAfkSosDesc);
                                if($arrSbjDiknas[$noDiknas]['final_grade_psk'] >= $kkm_diknas) {
                                    $afkSosDesc = 'Sikap yang menonjol adalah {'.$strAfkSosDesc.'}';
                                } else {
                                    $afkSosDesc = 'Sikap yang menonjol adalah {'.$strAfkSosDesc.'}, perlu bimbingan dalam {'.$strAfkSosDesc.'}';
                                }
                            }
                            $arrSbjDiknas[$noDiknas]['sosial_desc'] = (count($getAfkSos)!=0) ? $this->spintaxProcess($afkSosDesc) : '';
                        }

                        //Pengetahuan Deskripsi
                        $getKgn = collect($getSubjectDiknasBasic)->where('core_competence',$coreCompetence['pengetahuan'])->pluck('desc')->toArray();
                        if(count($getKgn)!=0) {
                            $arrKgnDesc = array();
                            for ($i=0; $i <count($getKgn) ; $i++) {
                                $arrKgnDesc[] = $getKgn[$i];
                            }
                            $strKgnDesc = implode("|",$arrKgnDesc);
                            if($arrSbjDiknas[$noDiknas]['final_grade_kgn'] >= $kkm_diknas) {
                                $kgnDesc = 'Mampu dalam {'.$strKgnDesc.'}';
                            } else {
                                $kgnDesc = 'Mampu dalam {'.$strKgnDesc.'}, perlu ditingkatkan dalam {'.$strKgnDesc.'}';
                            }
                        }
                        $arrSbjDiknas[$noDiknas]['knowledge_desc'] = (count($getKgn)!=0) ? $this->spintaxProcess($kgnDesc) : '';

                        //Keterampilan Deskripsi
                        $getPsk = collect($getSubjectDiknasBasic)->where('core_competence',$coreCompetence['keterampilan'])->pluck('desc')->toArray();
                        if(count($getPsk)!=0) {
                            $arrPskDesc = array();
                            for ($i=0; $i <count($getPsk) ; $i++) {
                                $arrPskDesc[] = $getPsk[$i];
                            }
                            $strPskDesc = implode("|",$arrPskDesc);
                            if($arrSbjDiknas[$noDiknas]['final_grade_psk'] >= $kkm_diknas) {
                                $pskDesc = 'Terampil dalam {'.$strPskDesc.'}';
                            } else {
                                $pskDesc = 'Terampil dalam {'.$strPskDesc.'}, kurang terampil dalam {'.$strPskDesc.'}';
                            }
                        }
                        $arrSbjDiknas[$noDiknas]['skill_desc'] = (count($getPsk)!=0) ? $this->spintaxProcess($pskDesc) : '';

                        $noDiknas++;
                    }
                }

                //masukan ke finalgrade & finalgradedtl
                $houseLeader = BoardingGroup::getFromBoarding($val['id']);
                $arrdiknastofinalgrade[$key]['houseleader'] = isset($houseLeader['id']) ? $houseLeader['id'] : '';
                $arrdiknastofinalgrade[$key]['ayid'] = $ayid;
                $arrdiknastofinalgrade[$key]['tid'] = $tid;
                $arrdiknastofinalgrade[$key]['format_code'] = $format_code_diknas;
                $arrdiknastofinalgrade[$key]['ccid'] = $kelas['id'];
                $arrdiknastofinalgrade[$key]['sid'] = $val['id'];
                $arrdiknastofinalgrade[$key]['date_legalization'] = $tanggalfix;
                $arrdiknastofinalgrade[$key]['hijri_date_legalization'] = $tanggalhfix;
                $arrdiknastofinalgrade[$key]['principal'] = $signed->principal;
                $arrdiknastofinalgrade[$key]['curriculum'] = $signed->curriculum;
                $arrdiknastofinalgrade[$key]['studentaffair'] = $signed->studentaffair;
                $arrdiknastofinalgrade[$key]['form_teacher'] = $formTeacherId;
                $arrdiknastofinalgrade[$key]['housemaster'] = $signed->housemaster;
                $arrdiknastofinalgrade[$key]['cby'] = auth()->user()->id;
                $arrdiknastofinalgrade[$key]['con'] = date('Y-m-d H:i:s');
                $cekdiknasfinalgrade = FinalGrade::where('ayid',$ayid)
                                    ->where('tid',$tid)
                                    ->where('format_code',$format_code_diknas)
                                    ->where('sid',$arrdiknastofinalgrade[$key]['sid']);
                if($cekdiknasfinalgrade->exists())
                {
                    $cekdiknasfinalgrade->update([
                        'ccid' => $arrdiknastofinalgrade[$key]['ccid'],
                        'date_legalization' => $arrdiknastofinalgrade[$key]['date_legalization'],
                        'hijri_date_legalization' => $arrdiknastofinalgrade[$key]['hijri_date_legalization'],
                        'principal' => $arrdiknastofinalgrade[$key]['principal'],
                        'curriculum' => $arrdiknastofinalgrade[$key]['curriculum'],
                        'studentaffair' => $arrdiknastofinalgrade[$key]['studentaffair'],
                        'form_teacher' => $arrdiknastofinalgrade[$key]['form_teacher'],
                        'housemaster' => $arrdiknastofinalgrade[$key]['housemaster'],
                        'houseleader' => $arrdiknastofinalgrade[$key]['houseleader'],
                        'uby' => auth()->user()->id,
                        'uon' => date('Y-m-d H:i:s')
                    ]);
                }
                else
                {
                    $diknasfinalgrade = FinalGrade::create($arrdiknastofinalgrade[$key]);
                }
            }


            // ==== DIKNAS final_grade_dtl  =====//
            // Simpan Nilai Sikap Spiritual ke FinalGradeDtl
            if($arrSbjDiknas) {
                foreach ($arrSbjDiknas AS $k=>$v) {
                    if($arrSbjDiknas[$k]['subject_id']==1)
                    {
                        $cekafkspr = DB::table('ep_final_grade_dtl')
                            ->where('ayid', $arrSbjDiknas[$k]['ayid'])
                            ->where('tid', $arrSbjDiknas[$k]['tid'])
                            ->where('format_code', $arrSbjDiknas[$k]['format_code'])
                            ->where('sid', $arrSbjDiknas[$k]['sid'])
                            ->where('ccid', $arrSbjDiknas[$k]['ccid'])
                            ->where('subject_id', $arrSbjDiknas[$k]['subject_id'])
                            ->where('letter_grade', $coreCompetence['spiritual']);

                        if($cekafkspr->doesntExist()) {
                            $afkspr['format_code']       = $arrSbjDiknas[$k]['format_code'];
                            $afkspr['ayid']              = $arrSbjDiknas[$k]['ayid'];
                            $afkspr['tid']               = $arrSbjDiknas[$k]['tid'];
                            $afkspr['sid']               = $arrSbjDiknas[$k]['sid'];
                            $afkspr['ccid']              = $arrSbjDiknas[$k]['ccid'];
                            $afkspr['subject_id']        = $arrSbjDiknas[$k]['subject_id'];
                            $afkspr['subject_seq_no']    = $arrSbjDiknas[$k]['subject_seq_no'];
                            $afkspr['final_grade']       = $arrSbjDiknas[$k]['final_grade_kgn'];
                            $afkspr['lesson_hours']      = $arrSbjDiknas[$k]['lesson_hours'];
                            $afkspr['weighted_grade']    = $arrSbjDiknas[$k]['weighted_grade'];
                            $afkspr['letter_grade']      = $coreCompetence['spiritual']; //menandakan bahwa ini nilai sikap spiritual
                            $spiritual_desc              = ($afkspr['final_grade']!=0) ? $arrSbjDiknas[$k]['spiritual_desc'] : '';
                            $afkspr['knowledge_desc']    = $spiritual_desc;
                            $afkspr['cby']               = auth()->user()->id;
                            $afkspr['con']               = date('Y-m-d H:i:s');
                            $afksprtofinalgradedtl    = FinalGradeDtl::insert($afkspr);
                        } else {
                            $cekdesafkspr = $cekafkspr->where(function ($qry){
                                $qry->whereNotNull('knowledge_desc');
                                $qry->where('knowledge_desc','!=',"");
                            });
                            if($cekdesafkspr->exists()) {
                                $updateafkspr = $cekdesafkspr->update([
                                    'final_grade' => $arrSbjDiknas[$k]['final_grade_kgn'],
                                    'lesson_hours' => $arrSbjDiknas[$k]['lesson_hours'],
                                    'weighted_grade' => $arrSbjDiknas[$k]['weighted_grade'],
                                    'uby' => auth()->user()->id
                                ]);
                            } else {
                                $updateafkspr = DB::table('ep_final_grade_dtl')
                                    ->where('ayid', $arrSbjDiknas[$k]['ayid'])
                                    ->where('tid', $arrSbjDiknas[$k]['tid'])
                                    ->where('format_code', $arrSbjDiknas[$k]['format_code'])
                                    ->where('sid', $arrSbjDiknas[$k]['sid'])
                                    ->where('ccid', $arrSbjDiknas[$k]['ccid'])
                                    ->where('subject_id', $arrSbjDiknas[$k]['subject_id'])
                                    ->where('letter_grade', $coreCompetence['spiritual'])
                                    ->update([
                                        'final_grade' => $arrSbjDiknas[$k]['final_grade_kgn'],
                                        'lesson_hours' => $arrSbjDiknas[$k]['lesson_hours'],
                                        'weighted_grade' => $arrSbjDiknas[$k]['weighted_grade'],
                                        'knowledge_desc' => $arrSbjDiknas[$k]['spiritual_desc'],
                                        'uby' => auth()->user()->id
                                    ]);
                            }
                        }
                    }
                }
            }

            // Simpan Nilai Sikap Sosial ke FinalGradeDtl
            if($arrSbjDiknas) {
                foreach ($arrSbjDiknas AS $k=>$v) {
                    if($arrSbjDiknas[$k]['subject_id']==2)
                    {
                        $cekafksos = DB::table('ep_final_grade_dtl')
                            ->where('ayid', $arrSbjDiknas[$k]['ayid'])
                            ->where('tid', $arrSbjDiknas[$k]['tid'])
                            ->where('format_code', $arrSbjDiknas[$k]['format_code'])
                            ->where('sid', $arrSbjDiknas[$k]['sid'])
                            ->where('ccid', $arrSbjDiknas[$k]['ccid'])
                            ->where('subject_id', $arrSbjDiknas[$k]['subject_id'])
                            ->where('letter_grade', $coreCompetence['sosial']);

                        if($cekafksos->doesntExist()) {
                            $afksos['format_code']       = $arrSbjDiknas[$k]['format_code'];
                            $afksos['ayid']              = $arrSbjDiknas[$k]['ayid'];
                            $afksos['tid']               = $arrSbjDiknas[$k]['tid'];
                            $afksos['sid']               = $arrSbjDiknas[$k]['sid'];
                            $afksos['ccid']              = $arrSbjDiknas[$k]['ccid'];
                            $afksos['subject_id']        = $arrSbjDiknas[$k]['subject_id'];
                            $afksos['subject_seq_no']    = $arrSbjDiknas[$k]['subject_seq_no'];
                            $afksos['final_grade']       = $arrSbjDiknas[$k]['final_grade_kgn'];
                            $afksos['lesson_hours']      = $arrSbjDiknas[$k]['lesson_hours'];
                            $afksos['weighted_grade']    = $arrSbjDiknas[$k]['weighted_grade'];
                            $afksos['letter_grade']      = $coreCompetence['sosial']; //menandakan bahwa ini nilai sikap sosial
                            $sosial_desc                 = ($afksos['final_grade']!=0) ? $arrSbjDiknas[$k]['sosial_desc'] : '';
                            $afksos['knowledge_desc']    = $sosial_desc;
                            $afksos['cby']               = auth()->user()->id;
                            $afksos['con']               = date('Y-m-d H:i:s');
                            $afksostofinalgradedtl    = FinalGradeDtl::insert($afksos);
                        } else {
                            $cekdesafksos = $cekafksos->where(function ($qry){
                                $qry->whereNotNull('knowledge_desc');
                                $qry->where('knowledge_desc','!=',"");
                            });
                            if($cekdesafksos->exists()) {
                                $updateafksos = $cekdesafksos->update([
                                    'final_grade' => $arrSbjDiknas[$k]['final_grade_kgn'],
                                    'lesson_hours' => $arrSbjDiknas[$k]['lesson_hours'],
                                    'weighted_grade' => $arrSbjDiknas[$k]['weighted_grade'],
                                    'uby' => auth()->user()->id
                                ]);
                            } else {
                                $updateafksos = DB::table('ep_final_grade_dtl')
                                    ->where('ayid', $arrSbjDiknas[$k]['ayid'])
                                    ->where('tid', $arrSbjDiknas[$k]['tid'])
                                    ->where('format_code', $arrSbjDiknas[$k]['format_code'])
                                    ->where('sid', $arrSbjDiknas[$k]['sid'])
                                    ->where('ccid', $arrSbjDiknas[$k]['ccid'])
                                    ->where('subject_id', $arrSbjDiknas[$k]['subject_id'])
                                    ->where('letter_grade', $coreCompetence['sosial'])
                                    ->update([
                                        'final_grade' => $arrSbjDiknas[$k]['final_grade_kgn'],
                                        'lesson_hours' => $arrSbjDiknas[$k]['lesson_hours'],
                                        'weighted_grade' => $arrSbjDiknas[$k]['weighted_grade'],
                                        'knowledge_desc' => $arrSbjDiknas[$k]['sosial_desc'],
                                        'uby' => auth()->user()->id
                                    ]);
                            }
                        }
                    }
                }
            }

            // Simpan Nilai Pengetahuan ke FinalGradeDtl
            if($arrSbjDiknas) {
                foreach ($arrSbjDiknas AS $k=>$v) {
                    $cekkgn = DB::table('ep_final_grade_dtl')
                        ->where('ayid', $arrSbjDiknas[$k]['ayid'])
                        ->where('tid', $arrSbjDiknas[$k]['tid'])
                        ->where('format_code', $arrSbjDiknas[$k]['format_code'])
                        ->where('sid', $arrSbjDiknas[$k]['sid'])
                        ->where('ccid', $arrSbjDiknas[$k]['ccid'])
                        ->where('subject_id', $arrSbjDiknas[$k]['subject_id'])
                        ->where('letter_grade', $coreCompetence['pengetahuan']);

                    if($cekkgn->doesntExist()) {
                        $kgn['format_code']      = $arrSbjDiknas[$k]['format_code'];
                        $kgn['ayid']             = $arrSbjDiknas[$k]['ayid'];
                        $kgn['tid']              = $arrSbjDiknas[$k]['tid'];
                        $kgn['sid']              = $arrSbjDiknas[$k]['sid'];
                        $kgn['ccid']             = $arrSbjDiknas[$k]['ccid'];
                        $kgn['subject_id']       = $arrSbjDiknas[$k]['subject_id'];
                        $kgn['subject_seq_no']   = $arrSbjDiknas[$k]['subject_seq_no'];
                        $kgn['final_grade']      = $arrSbjDiknas[$k]['final_grade_kgn'];
                        $kgn['lesson_hours']     = $arrSbjDiknas[$k]['lesson_hours'];
                        $kgn['weighted_grade']   = $arrSbjDiknas[$k]['weighted_grade'];
                        $kgn['letter_grade']     = $coreCompetence['pengetahuan']; //menandakan bahwa ini nilai pengetahuan
                        $knowledge_desc          = ($kgn['final_grade']!=0) ? $arrSbjDiknas[$k]['knowledge_desc'] : '';
                        $kgn['knowledge_desc']   = $knowledge_desc;
                        $kgn['cby']              = auth()->user()->id;
                        $kgn['con']              = date('Y-m-d H:i:s');
                        $kgntofinalgradedtl = FinalGradeDtl::insert($kgn);
                    } else {
                        $cekdeskgn = DB::table('ep_final_grade_dtl')
                        ->where('ayid', $arrSbjDiknas[$k]['ayid'])
                        ->where('tid', $arrSbjDiknas[$k]['tid'])
                        ->where('format_code', $arrSbjDiknas[$k]['format_code'])
                        ->where('sid', $arrSbjDiknas[$k]['sid'])
                        ->where('ccid', $arrSbjDiknas[$k]['ccid'])
                        ->where('subject_id', $arrSbjDiknas[$k]['subject_id'])
                        ->where('letter_grade', $coreCompetence['pengetahuan'])
                        ->where(function ($qry){
                            $qry->whereNotNull('knowledge_desc');
                            $qry->where('knowledge_desc','!=',"");
                        });
                        if($cekdeskgn->exists()) {
                            $updatekgn = DB::table('ep_final_grade_dtl')
                            ->where('ayid', $arrSbjDiknas[$k]['ayid'])
                            ->where('tid', $arrSbjDiknas[$k]['tid'])
                            ->where('format_code', $arrSbjDiknas[$k]['format_code'])
                            ->where('sid', $arrSbjDiknas[$k]['sid'])
                            ->where('ccid', $arrSbjDiknas[$k]['ccid'])
                            ->where('subject_id', $arrSbjDiknas[$k]['subject_id'])
                            ->where('letter_grade', $coreCompetence['pengetahuan'])
                            ->update([
                                'final_grade' => $arrSbjDiknas[$k]['final_grade_kgn'],
                                'lesson_hours' => $arrSbjDiknas[$k]['lesson_hours'],
                                'weighted_grade' => $arrSbjDiknas[$k]['weighted_grade'],
                                'uby' => auth()->user()->id
                            ]);
                        } else {
                            $updatekgn = DB::table('ep_final_grade_dtl')
                            ->where('ayid', $arrSbjDiknas[$k]['ayid'])
                            ->where('tid', $arrSbjDiknas[$k]['tid'])
                            ->where('format_code', $arrSbjDiknas[$k]['format_code'])
                            ->where('sid', $arrSbjDiknas[$k]['sid'])
                            ->where('ccid', $arrSbjDiknas[$k]['ccid'])
                            ->where('subject_id', $arrSbjDiknas[$k]['subject_id'])
                            ->where('letter_grade', $coreCompetence['pengetahuan'])
                            ->update([
                                    'final_grade' => $arrSbjDiknas[$k]['final_grade_kgn'],
                                    'lesson_hours' => $arrSbjDiknas[$k]['lesson_hours'],
                                    'weighted_grade' => $arrSbjDiknas[$k]['weighted_grade'],
                                    'knowledge_desc' => $arrSbjDiknas[$k]['knowledge_desc'],
                                    'uby' => auth()->user()->id
                                ]);
                        }
                    }
                }
            }

            // Simpan Nilai Keterampilan ke FinalGradeDtl
            if($arrSbjDiknas) {
                foreach ($arrSbjDiknas AS $k=>$v) {
                    $cekpsk = DB::table('ep_final_grade_dtl')
                        ->where('ayid', $arrSbjDiknas[$k]['ayid'])
                        ->where('tid', $arrSbjDiknas[$k]['tid'])
                        ->where('format_code', $arrSbjDiknas[$k]['format_code'])
                        ->where('sid', $arrSbjDiknas[$k]['sid'])
                        ->where('ccid', $arrSbjDiknas[$k]['ccid'])
                        ->where('subject_id', $arrSbjDiknas[$k]['subject_id'])
                        ->where('letter_grade', $coreCompetence['keterampilan']);

                    if($cekpsk->doesntExist()) {
                        $psk['format_code']     = $arrSbjDiknas[$k]['format_code'];
                        $psk['ayid']            = $arrSbjDiknas[$k]['ayid'];
                        $psk['tid']             = $arrSbjDiknas[$k]['tid'];
                        $psk['sid']             = $arrSbjDiknas[$k]['sid'];
                        $psk['ccid']            = $arrSbjDiknas[$k]['ccid'];
                        $psk['subject_id']      = $arrSbjDiknas[$k]['subject_id'];
                        $psk['subject_seq_no']  = $arrSbjDiknas[$k]['subject_seq_no'];
                        $psk['final_grade']     = $arrSbjDiknas[$k]['final_grade_psk'];
                        $psk['lesson_hours']    = $arrSbjDiknas[$k]['lesson_hours'];
                        $psk['weighted_grade']  = $arrSbjDiknas[$k]['weighted_grade'];
                        $psk['letter_grade']    = $coreCompetence['keterampilan']; //menandakan bahwa ini nilai keterampilan
                        $skill_desc             = ($psk['final_grade']!=0) ? $arrSbjDiknas[$k]['skill_desc'] : '';
                        $psk['skill_desc']      = $skill_desc;
                        $psk['cby']             = auth()->user()->id;
                        $psk['con']             = date('Y-m-d H:i:s');
                        $psktofinalgradedtl = FinalGradeDtl::insert($psk);
                    } else {
                        $cekdespsk = DB::table('ep_final_grade_dtl')
                        ->where('ayid', $arrSbjDiknas[$k]['ayid'])
                        ->where('tid', $arrSbjDiknas[$k]['tid'])
                        ->where('format_code', $arrSbjDiknas[$k]['format_code'])
                        ->where('sid', $arrSbjDiknas[$k]['sid'])
                        ->where('ccid', $arrSbjDiknas[$k]['ccid'])
                        ->where('subject_id', $arrSbjDiknas[$k]['subject_id'])
                        ->where('letter_grade', $coreCompetence['keterampilan'])
                        ->where(function ($qry){
                            $qry->whereNotNull('knowledge_desc');
                            $qry->where('knowledge_desc','!=',"");
                        });
                        if($cekdespsk->exists()) {
                            $updatepsk = DB::table('ep_final_grade_dtl')
                            ->where('ayid', $arrSbjDiknas[$k]['ayid'])
                            ->where('tid', $arrSbjDiknas[$k]['tid'])
                            ->where('format_code', $arrSbjDiknas[$k]['format_code'])
                            ->where('sid', $arrSbjDiknas[$k]['sid'])
                            ->where('ccid', $arrSbjDiknas[$k]['ccid'])
                            ->where('subject_id', $arrSbjDiknas[$k]['subject_id'])
                            ->where('letter_grade', $coreCompetence['keterampilan'])
                            ->update([
                                'final_grade' => $arrSbjDiknas[$k]['final_grade_psk'],
                                'lesson_hours' => $arrSbjDiknas[$k]['lesson_hours'],
                                'weighted_grade' => $arrSbjDiknas[$k]['weighted_grade'],
                                'uby' => auth()->user()->id
                            ]);
                        } else {
                            $updatepsk = DB::table('ep_final_grade_dtl')
                            ->where('ayid', $arrSbjDiknas[$k]['ayid'])
                            ->where('tid', $arrSbjDiknas[$k]['tid'])
                            ->where('format_code', $arrSbjDiknas[$k]['format_code'])
                            ->where('sid', $arrSbjDiknas[$k]['sid'])
                            ->where('ccid', $arrSbjDiknas[$k]['ccid'])
                            ->where('subject_id', $arrSbjDiknas[$k]['subject_id'])
                            ->where('letter_grade', $coreCompetence['keterampilan'])
                            ->update([
                                    'final_grade' => $arrSbjDiknas[$k]['final_grade_psk'],
                                    'lesson_hours' => $arrSbjDiknas[$k]['lesson_hours'],
                                    'weighted_grade' => $arrSbjDiknas[$k]['weighted_grade'],
                                    'skill_desc' => $arrSbjDiknas[$k]['skill_desc'],
                                    'uby' => auth()->user()->id
                                ]);
                        }
                    }
                }
            }
            // ==== END DIKNAS  =====//
        }
        echo 'Berhasil';
    }

    public function checkpublishraport(Request $req)
    {
        $mode = $req->mode;
        $ayid = ($req->ayid) ? $req->ayid : config('id_active_academic_year');
        $tid = ($req->tid) ? $req->tid : config('id_active_term');
        $q = AcademicYearDetail::where('ayid',$ayid)
            ->where('tid',$tid);
        if($q->exists()) {
            $q = $q->first();
            if($mode=='UTS') {
                echo $q['publish_mid_exam'];
            } elseif($mode=='UAS') {
                echo $q['publish_final_exam'];
            }
        }
        else
        {
            echo '0';
        }
    }

    public function mahmul_exec(Request $request)
    {
        $simpan = RemedyClass::where('id',$request->id);
        if($simpan->exists())
        {
            $remedy = $simpan->first()->toArray();

            $cek = RemedyClass::where('course_subject_id',$remedy['course_subject_id'])
                ->where('sid',$remedy['sid'])
                ->selectRaw('min(id) as id')
                ->first()->toArray();
            $remedyberpengaruh = RemedyClass::where('id',$cek['id'])->first()->toArray();

            //Simpan ke remedy dulu
            $lulus = ($request->lulus=='1') ? '1' : '0';
            $data = ['grade_after'=>$request->nilai,'is_passed'=>$lulus];
            if($lulus=='1')
            {
                $data['ayid_remedy'] = $remedyberpengaruh['ayid'];
                $data['tid_remedy'] = $remedyberpengaruh['tid'];
            }
            $data['uby'] = auth()->user()->id;
            $data['uon'] = date('Y-m-d H:i:s');
            $simpan = RemedyClass::where('id',$request->id)->update($data);

            //Ubah IPK ditambah mahmul jika lulus
            // if($lulus=='1')
            // {
                $jmhpelajaran = 0;
                $totalnilai = 0;
                $totaljam = 0;
                $array = array();
                $allremedy = RemedyClass::where('sid',$remedyberpengaruh['sid'])
                    ->where('ayid_remedy',$remedyberpengaruh['ayid'])
                    ->where('tid_remedy',$remedyberpengaruh['tid'])
                    ->where('is_passed','1')
                    ->get()->toArray();
                $subjectidremedypassed = collect($allremedy)->pluck('course_subject_id')->toArray();
                $studentkelas = CourseClassDtl::where('ayid',$remedyberpengaruh['ayid'])
                    ->where('sid',$remedyberpengaruh['sid'])
                    ->join('ep_course_class','ep_course_class.id','=','ccid')
                    ->first();
                $kelas = $studentkelas->ccid;
                $level = $studentkelas->level;
                $pelajaran = CourseSubject::where('ayid',$remedyberpengaruh['ayid'])
                    ->where('tid',$remedyberpengaruh['tid'])
                    ->where('level',$level)
                    ->whereIn('subject_id',$subjectidremedypassed)
                    ->get();
                $raport = FinalGrade::getOnePerson($remedyberpengaruh['sid'],$remedyberpengaruh['ayid'],$remedyberpengaruh['tid']);
                $raportdtl = FinalGradeDtl::getOnePerson($remedyberpengaruh['sid'],$remedyberpengaruh['ayid'],$remedyberpengaruh['tid']);
                $totaljam = collect($raport)->first()->sum_lesson_hours;
                $pelajarandtl = collect($raportdtl)->groupBy('subject_id')->toArray();
                foreach($raportdtl as $k=>$v)
                {
                    $array[$jmhpelajaran] = collect($v)->toArray();
                    $subjectid = $v->subject_id;
                    $nilai = $v->final_grade;
                    if($request->lulus == '1')
                    {
                        foreach($allremedy as $krem=>$vrem)
                        {
                            if($subjectid == $vrem['course_subject_id'])
                            {
                                $nilai = collect($pelajaran)->where('subject_id',$subjectid)->first()['grade_pass'];
                                break;
                            }
                        }
                    }
                    $totalnilai += $nilai*$v->lesson_hours;
                    $jmhpelajaran++;
                }
                $rata = $totalnilai/$totaljam;

                $ipk = Gpa::where('ayid',$remedyberpengaruh['ayid'])
                    ->where('tid',$remedyberpengaruh['tid'])
                    ->where('sid',$remedyberpengaruh['sid'])
                    ->update(['gpa'=>$rata]);
            // }
            echo 'Berhasil';
        }
    }
    public function cekmahmul(Request $req)
    {
        $ayid = config('active_academic_year');
        $cekremedy = RemedyClass::getBefore($ayid);
        $app['mahmul'] = collect($cekremedy)->sortBy('name');
        if($req->ajax())
        {
            if($req->type=='hapus')
            {
                $remedy = RemedyClass::where('id',$req->id)->delete();
                echo 'Berhasil';
                die();
            }
            if($req->type=='hapuspelajaran')
            {
                $remedy = RemedyClass::where('course_subject_id',$req->subjectid)->where('sid',$req->id)->delete();
                echo 'Berhasil';
                die();
            }
            $pid = $req->id;
            $cek = [];
            $active_tid = config('id_active_term');
            $active_ayid = str_replace('/','',$ayid);
            $cek = RemedyClass::select('ep_remedy_class.*','aa_academic_year.name')
                ->join('aa_academic_year','ayid','=','aa_academic_year.id');
            $cek = ($req->subjectid!='') ? $cek->where('course_subject_id',$req->subjectid) : $cek;
            $cek = ($req->id!='') ? $cek->where('sid',$pid) : $cek;
            $cek = $cek->orderBy('aa_academic_year.name','asc')->get()->toArray();
            foreach($cek as $k=>$v)
            {
                $ayid = str_replace('/','',$v['name']);
                if($active_ayid>=$ayid) {
                    $selisih = ($active_ayid - $ayid)/10001;
                    if($selisih!=0)
                    {
                        for($indexselisih=0;$indexselisih<=$selisih;$indexselisih++)
                        {
                            $besarselisih = ($indexselisih)*10001;
                            $nextayidname1 = (int)$ayid + (int)$besarselisih;
                            $nextayids = substr($nextayidname1,0,4);
                            $nextayidname = $nextayids.($nextayids+1);
                            $nextayidnames = $nextayids.'/'.($nextayids+1);
                            $nextayid = AcademicYear::where('name',$nextayidnames);
                            if($nextayid->exists())
                            {
                                $nextayid = $nextayid->first()->id;
                                $jumlah_tid = 2;
                                if((int)$nextayidname1==(int)$active_ayid)
                                {
                                    $jumlah_tid = $active_tid;
                                }
                                for($indextid=0;$indextid<$jumlah_tid;$indextid++)
                                {
                                    if($nextayid==$v['ayid']&&$v['tid']=='2') continue;
                                    $cek = RemedyClass::where('sid',$v['sid'])
                                        ->where('ayid',$nextayid)
                                        ->where('tid',($indextid+1))
                                        ->where('course_subject_id',$v['course_subject_id']);
                                    if($cek->exists())
                                    {
                                        $cek = $cek->first()->is_passed;
                                        if($cek=='1')
                                        {
                                            break;
                                        }
                                    }
                                    else {
                                        $cek = new RemedyClass;
                                        $cek->sid = $v['sid'];
                                        $cek->ayid = $nextayid;
                                        $cek->tid = ($indextid+1);
                                        $cek->course_subject_id = $v['course_subject_id'];
                                        $cek->grade_pass = $v['grade_pass'];
                                        $cek->grade_before = $v['grade_after'];
                                        $cek->grade_after = 0;
                                        $cek->cby = auth()->user()->id;
                                        $cek->con = date('Y-m-d H:i:s');
                                        $cek->save();
                                    }
                                }
                            }
                        }
                        if($active_tid == '2')
                        {
                            $cek = RemedyClass::where('sid',$v['sid'])
                                ->where('ayid',$v['ayid'])
                                ->where('tid','2')
                                ->where('course_subject_id',$v['course_subject_id']);
                            if($cek->exists())
                            {
                                $cek = $cek->first()->is_passed;
                                if($cek=='1')
                                {
                                    break;
                                }
                            }
                            else {
                                $cek = new RemedyClass;
                                $cek->sid = $v['sid'];
                                $cek->ayid = $v['ayid'];
                                $cek->tid = '2';
                                $cek->course_subject_id = $v['course_subject_id'];
                                $cek->grade_pass = $v['grade_pass'];
                                $cek->grade_before = $v['grade_after'];
                                $cek->grade_after = 0;
                                $cek->cby = auth()->user()->id;
                                $cek->con = date('Y-m-d H:i:s');
                                $cek->save();
                            }
                        }
                    }
                    else
                    {
                        for($indextid=($active_tid-1);$indextid<2;$indextid++)
                        {
                            $cek = RemedyClass::where('sid',$v['sid'])
                                ->where('ayid',$v['ayid'])
                                ->where('tid',($indextid+1))
                                ->where('course_subject_id',$v['course_subject_id']);
                            if($cek->exists())
                            {
                                $cek = $cek->first()->is_passed;
                                if($cek=='1')
                                {
                                    break;
                                }
                            }
                            else {
                                $cek = new RemedyClass;
                                $cek->sid = $v['sid'];
                                $cek->ayid = $v['ayid'];
                                $cek->tid = ($indextid+1);
                                $cek->course_subject_id = $v['course_subject_id'];
                                $cek->grade_pass = $v['grade_pass'];
                                $cek->grade_before = $v['grade_after'];
                                $cek->grade_after = 0;
                                $cek->cby = auth()->user()->id;
                                $cek->con = date('Y-m-d H:i:s');
                                $cek->save();
                            }
                        }
                    }
                }
            }
            echo 'Berhasil';
            die();
        }
        return view('halaman.cekmahmul',$app);
    }

    public function spintaxProcess($text)
    {
        return preg_replace_callback(
            '/\{(((?>[^\{\}]+)|(?R))*?)\}/x',
            array($this, 'replace'),
            $text
        );
    }

    public function replace($text)
    {
        $text = $this->spintaxProcess($text[1]);
        $parts = explode('|', $text);
        return $parts[array_rand($parts)];
    }
}
