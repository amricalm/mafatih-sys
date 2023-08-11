<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\School;
use App\Models\Assessment;
use App\Models\CourseClass;
use App\Models\CourseClassDtl;
use App\Models\CourseSubject;
use App\Models\CourseSubjectTeacher;
use App\Models\SubjectBasicDetail;
use App\Models\SubjectDiknas;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Employe;
use App\Models\GradeWeight;
use App\Models\GradeType;
use App\Models\Grade;
use App\Models\Person;
use App\Models\Gpa;
use Alkoumi\LaravelHijriDate\Hijri;
use App\Models\BoardingActivityGroup;
use App\Models\BoardingActivity;
use App\Models\BoardingGroup;
use Illuminate\Support\Carbon;
use App\Models\FinalGrade;
use App\Models\FinalGradeDtl;
use App\Models\Homeroom;
use App\Models\RfTerm;
use App\Models\RfFormatCode;
use App\Models\Translate;
use App\Models\SubjectBasic;
use App\SmartSystem\General;
use App\SmartSystem\PdfConfig;
use Illuminate\Http\RedirectResponse;
use App\Models\BayanatResult;
use App\Models\BayanatResultDtl;
use App\Models\BayanatMapping;
use App\Models\BayanatMappingDtl;
use App\Models\AcademicYearDetail;
use App\Models\BayanatLevel;
use App\Models\RemedyClass;
use App\Models\RfLevelClass;
use App\Models\SignedPosition;
use App\Models\Achievement;
use App\Models\BayanatWeight;
use App\Models\RfSchoolType;
use App\Models\Subject;
use App\Models\SubjectDiknasMapping;
use App\SmartSystem\EasyEncrypt;
use PDF;

class RaportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index(Request $req)
    {
        $app = array();
        $app['aktif'] = 'raport/modul';
        $app['judul'] = 'Cetak Raport';
        $app['student'] = Student::join('aa_person as a','a.id','=','pid')->get();
        $app['employe'] = (auth()->user()->role=='1') ? Employe::get() : Employe::where('pid',auth()->user()->pid)->first();
        $app['homeroom'] = (auth()->user()->role=='1') ? array() : Homeroom::where('emid',$app['employe']['id'])->select('ccid')->where('ayid',config('id_active_academic_year'))->get()->toArray();
        $app['homeroom'] = array_column($app['homeroom'], 'ccid');
        $app['class'] = (auth()->user()->role=='1') ? CourseClass::get() : CourseClass::whereIn('id',$app['homeroom'])->get();
        $app['grade'] = GradeType::get();
        $app['subject'] = array();
        $app['student'] = array();
        $app['assessment'] = array();
        $app['req'] = $req;

        if ($req->post())
        {
            $app['student'] = CourseClassDtl::selectRaw('a.id, b.name, c.id AS akademik, d.id AS pengasuhan, e.id AS diknas, f.id AS pts, b.id as pid')
                ->join('aa_student as a','sid','=','a.id')
                ->join('aa_person as b','a.pid','=','b.id')
                ->leftJoin('ep_final_grade AS c', function($join) {
                    $join->on('a.id','=','c.sid');
                    $join->on('ep_course_class_dtl.ayid','=','c.ayid');
                    $join->on('c.tid','=',DB::raw(config('id_active_term')));
                    $join->on('c.format_code','=',DB::raw("'0'"));
                })
                ->leftJoin('ep_final_grade AS d', function($join) {
                    $join->on('a.id','=','d.sid');
                    $join->on('ep_course_class_dtl.ayid','=','d.ayid');
                    $join->on('d.tid','=',DB::raw(config('id_active_term')));
                    $join->on('d.format_code','=',DB::raw("'1'"));
                })
                ->leftJoin('ep_final_grade AS e', function($join) {
                    $join->on('a.id','=','e.sid');
                    $join->on('ep_course_class_dtl.ayid','=','e.ayid');
                    $join->on('e.tid','=',DB::raw(config('id_active_term')));
                    $join->on('e.format_code','=',DB::raw("'2'"));
                })
                ->leftJoin('ep_final_grade AS f', function($join) {
                    $join->on('a.id','=','f.sid');
                    $join->on('ep_course_class_dtl.ayid','=','f.ayid');
                    $join->on('f.tid','=',DB::raw(config('id_active_term')));
                    $join->on('f.format_code','=',DB::raw("'3'"));
                })
                ->where('ep_course_class_dtl.ccid',$req->class)
                ->where('ep_course_class_dtl.ayid',config('id_active_academic_year'))
                ->orderBy('b.name')
                ->get();
            $app['pid'] = $app['student']->pluck('pid');
            $app['raportQuran'] = BayanatResult::whereIn('pid',$app['pid'])
                ->where('ep_bayanat_result.ayid',config('id_active_academic_year'))
                ->where('ep_bayanat_result.tid',config('id_active_term'))
                ->join('ep_bayanat_level','result_level_halqah','=','ep_bayanat_level.id')
                ->join('ep_bayanat_class','cqid','=','ep_bayanat_class.id')
                ->select('ep_bayanat_result.*','ep_bayanat_level.*','ep_bayanat_class.name as kelas','ep_bayanat_class.name_ar as kelas_ar')
                ->get();
        }

        return view('halaman.raport', $app);
    }

    public function modules(Request $request)
    {
        $app['aktif'] = 'raport/modul';
        $app['judul'] = 'Cetak Raport';

        return view('halaman.raport-module', $app);
    }

    public function boarding(Request $req)
    {
        $app = array();
        $app['aktif'] = 'raport/modul';
        $app['judul'] = 'Cetak Raport Pengasuhan';
        $app['student'] = array();
        $app['employe'] = BoardingGroup::getMsPerAyid('');
        if (auth()->user()->role == '3')
        {
            $app['employe'] = BoardingGroup::getMsPerAyid(auth()->user()->pid);
        }
        $app['grade'] = array();
        $app['req'] = $req;

        if ($req->post())
        {
            $app['subject'] = CourseSubject::where('level',$req->class)
                ->join('ep_subject as a','a.id','=','subject_id')
                ->get();
            $app['student'] = BoardingGroup::select('a.id','a.pid','a.nis', 'b.name','b.name_ar', 'd.id AS pengasuhan')
                ->join('aa_student as a','sid','=','a.id')
                ->join('aa_person as b','a.pid','=','b.id')
                ->leftJoin('ep_final_grade AS d', function($join) {
                    $join->on('a.id','=','d.sid');
                    $join->on('ep_boarding_group.ayid','=','d.ayid');
                    $join->on('d.tid','=',DB::raw(config('id_active_term')));
                    $join->on('d.format_code','=',DB::raw("'1'"));
                })
                ->where('eid',$req->employe)
                ->where('ep_boarding_group.ayid',config('id_active_academic_year'))
                ->orderBy('a.nis', 'ASC')
                ->get();
        }

        return view('halaman.raport-list-boarding', $app);
    }

    public function print(Request $request)
    {
        if($request->id==3) {
            return $this->print_diknas($request);
        }
        $app['aktif'] = 'raport/modul';
        $app['judul']   = 'Cetak Raport';
        $idprint        = $request->id;
        $formatcode     = new RfFormatCode;
        $formatcode     = $formatcode->getFormatCode($idprint);
        $pdf            = $request->pdf;
        $tgl            = Carbon::now()->addMonth();
        $app['tglhijriah'] = Hijri::DateIndicDigits('j F Y', $tgl);
        $ayid           = config('id_active_academic_year');
        $tid            = config('id_active_term');
        // cek sekalian
        $tglleg = FinalGrade::getDateRaport($ayid,$tid);
        if(!$tglleg)
        {
            return redirect()->to('/raport');
        }

        //get parameter mobile
        if (auth()->user()->role == '2')
        {
            $pid = $request->pid;
            $token = $request->token;
            $ayid = $request->tahunajar;
            $tid = $request->semester;
            $dectoken = EasyEncrypt::decrypt($token);
            $person = Student::select('aa_person.dob')
                ->join('aa_person','aa_person.id','=','pid')
                ->where('aa_student.id',$pid)
                ->first();
            if($dectoken!=$person['dob'])
            {
                return redirect('https://mahadsyarafulharamain.sch.id');
                die();
            }
        }

        $pdfconf        = new PdfConfig;
        $mpdfconf       = $pdfconf->config();
        $final          = new FinalGrade;
        $app['final']   = (object)$final->getStudentFinalGrade($request->pid,$formatcode,$ayid,$tid);
        $app['student'] = Student::where('aa_student.id',$request->pid)
            ->join('aa_person','pid','=','aa_person.id')
            ->select('aa_student.id','aa_person.name','aa_person.name_ar','nis','aa_person.sex','aa_person.id as pid')
            ->first();
        $app['kelas']   = CourseClass::select('ep_course_class.id','ep_course_class.name',
                'ep_course_class.name_ar','rf_level_class_dtl.level','rf_level_class.desc_ar',
                'rf_level_class_dtl.desc_ar AS desc_ar_dtl')
            ->leftJoin('ep_course_class_dtl','ep_course_class.id','=','ep_course_class_dtl.ccid')
            ->leftJoin('rf_level_class','ep_course_class.level','=','rf_level_class.level')
            ->rightJoin('rf_level_class_dtl', function($join) use ($tid) {
                $join->on('rf_level_class.level','=','rf_level_class_dtl.level')->where('rf_level_class_dtl.tid','=',$tid);
            })
            ->where('ayid',$ayid)
            ->where('ep_course_class_dtl.sid',$request->pid)
            ->first();
        $app['term'] = RfTerm::where('id',$tid)->first();
        $g = new General;
        $pecahan = explode('-',$tglleg['date_legalization']);
        if(collect($app['final'])->count()>0)
        {
            $app['tgl_hj_raport']= $app['final']->hijri_date_legalization;
            $studentName        = $app['final']->student_name_ar=='' ? $app['final']->student_name : $app['final']->student_name_ar;
            $app['studentName'] = General::santri($app['final']->student_sex).' : '.$studentName;
            $pecahan            = explode('-',$app['final']->date_legalization);
            $app['tgl_raport']  = $g->convertToArabic($pecahan[0],$pecahan[1],$pecahan[2],' ');
            $app['kepalasekolah']= General::ustadz($app['final']->principal_sex).' '.$app['final']->principal_name_ar;
            $app['kurikulum']    = General::ustadz($app['final']->curriculum_sex).' '. $app['final']->curriculum_name_ar;
            $app['kesiswaan']    = General::ustadz($app['final']->studentaffair_sex).' '.$app['final']->studentaffair_name_ar;
            $app['walikelas']    = General::ustadz($app['final']->formteacher_sex).' '. $app['final']->formteacher_name_ar;
            $app['musyrifSakan'] = General::ustadz($app['final']->houseleader_sex).' '. $app['final']->houseleader_name_ar;
            $app['walikelasGender'] = General::getGenderAr($app['final']->formteacher_sex); //Jenis kelamin walikelas dalam bahasa arab
            $app['musyrifSakanGender']     = General::getGenderAr($app['final']->houseleader_sex); //Jenis kelamin dalam bahasa arab
        }
        else
        {
            $aydetail = AcademicYearDetail::where('ayid',$ayid)->where('tid',$tid)->first();
            $pecahan = ($formatcode=='3') ? explode('-',$aydetail['mid_exam_date']) : explode('-',$aydetail['final_exam_date']);
            $app['tgl_hj_raport']= ($formatcode=='3') ? $aydetail['hijri_mid_exam_date'] : $aydetail['hijri_final_exam_date'];
            $studentName        = $app['student']->name_ar=='' ? $app['student']->name : $app['student']->name_ar;
            $app['studentName'] = General::santri($app['student']->student_sex).' : '.$studentName;
            $app['tgl_raport']  = $g->convertToArabic($pecahan[0],$pecahan[1],$pecahan[2],' ');
        }
        $app['tgl_raport']  = $g->convertToArabic($pecahan[0],$pecahan[1],$pecahan[2],' ');
        $app['tahun']['masehi'] = $g->angka_arab($pecahan[0]);
        $app['tahun']['arab'] = $g->angka_arab($g->convertToHijriah($pecahan[0],$pecahan[1],$pecahan[2],'','tahun_hijriyah'));
        $mahmul = RemedyClass::getMahmulforRaportv2($request->pid);
        $app['mahmul'] = collect($mahmul)->pluck('pelajaran_ar')->toArray();
        $app['ipk'] = Gpa::getIPK($request->pid,$ayid,$tid);
        dd($app['ipk']);
        $app['rankingkelas'] = key(collect(Gpa::getRankingClass($app['kelas']['id']))->where('sid',$app['student']['id'])->toArray())+1;
        $app['rankinglevel'] = key(collect(Gpa::getRankingLevel($app['kelas']['level'],$app['student']['sex']))->where('sid',$app['student']['id'])->toArray())+1;
        $app['result'] = BayanatResultDtl::getResultDtl($app['student']->pid,$ayid,$tid);
        $app['nilaiqurantingkat'] = '-'; $app['nilaiquranhalaqah'] = '-';

        // Mustawa
        $app['mustawa'] = Student::mustawa($request->pid,$ayid,$tid);

        if(count($app['result'])>0)
        {
            $nilaiqurantingkat = ($app['result'][0]['mm']!='')
                ? (int)$app['result'][0]['juz_has_tasmik'] >= (int)$app['result'][0]['level']
                : false;
            $nilaiqurantingkat = (int)$app['result'][0]['juz_has_tasmik'] >= (int)$app['mustawa'];
            $nilaiquranhalaqah = ($app['result'][0]['level']!='')
                ? (int)$app['result'][0]['juz_has_tasmik'] >= (int)$app['result'][0]['mm']
                : false;

            $app['nilaiqurantingkat'] = ($nilaiqurantingkat) ? 'تم' : 'لم يتم';
            $app['nilaiquranhalaqah'] = ($nilaiquranhalaqah) ? 'تم' : 'لم يتم';
        }
        // dd($app);
        $app['muqorrormustawa'] = BayanatLevel::where('level',$app['mustawa'])->first();

        // $app['nilaiquranhalqah'] = (count($app['result'])>0) ? (int)$app['result'][0]['result_tingkat']
        // $app['nilaiqurantingkat'] = (count($app['result'])>0) ? collect($app['result'])->first()['result_decision_level'] : '-';
        // $nilaiquranhalaqah = (count($app['result'])>0) ? collect($app['result'])->first()['result_decision_set'] : '-';
        // $app['nilaiquranhalaqah'] = '-';
        // if($nilaiquranhalaqah!='-')
        // {
            // $app['nilaiquranhalaqah'] = ($nilaiquranhalaqah=='ناجح') ? 'تم' : 'لم يتم';
        // }
        if($idprint=='rq')
        {

            // tanggal langsung ngambil dari academicyeardetail
            // $aydetail = AcademicYearDetail::where('ayid',$ayid)->where('tid',$tid)->first();
            // $pecahan = ($formatcode=='3') ? explode('-',$aydetail['mid_exam_date']) : explode('-',$aydetail['final_exam_date']);

            $app['judul'] .= ' Quran '.$app['student']->name;
            $app['atribut'] = SignedPosition::allAttribut();
            $app['studentName'] = General::santri($app['student']->sex).' : '.$app['student']->name_ar;
            $app['jmh_group'] = collect($app['result'])->where('is_group','1')->count('is_group');
            $app['result_hdr'] = $app['result'][0];
            $app['juz_has_tasmik'] = '0'; $hasil = ''; $app['result_decision_level'] = 'Tidak Sempurna';
            if($app['result_hdr']['juz_has_tasmik']!='')
            {
                $app['juz_has_tasmik'] = !empty($app['result_hdr']['juz_has_tasmik']) ? (int)$app['result_hdr']['juz_has_tasmik'] : 0;
                $app['juz_has_tasmik'] = (is_numeric($app['juz_has_tasmik'])) ? $app['juz_has_tasmik'] : '0';
                $hasil = $app['juz_has_tasmik'] - $app['mustawa'];
                $app['result_decision_level'] = ($hasil>=0) ? 'Sempurna' : 'Tidak Sempurna';
            }

            if(!empty($pdf)) {
                $mpdf = new \Mpdf\Mpdf($mpdfconf);
                $mpdf->WriteHTML(view('halaman.print.raport-rq',$app));
                $mpdf->SetDirectionality('rtl');
                $mpdf->Output($app['judul'].'.pdf',"D");
            } else {
                return view('halaman.raport-rq',$app);
            }
        }

        $app['mapel']   = CourseSubject::where('level',$app['kelas']->level)
            ->join('ep_subject','subject_id','=','ep_subject.id')
            ->get();
        $mudalfashl = SubjectBasicDetail::where('ayid',$ayid)
            ->join('ep_subject_basic','subject_basic_id','=','ep_subject_basic.id')
            ->where('level',$app['kelas']->level)->get();
        $app['mf'] = collect($mudalfashl)->groupBy('id')->toArray();
        $app['mudalfashl'] = SubjectBasic::whereIn('id',array_keys($app['mf']))->get()->toArray();
        $app['mapelGroup'] = SubjectBasicDetail::selectRaw('ep_subject_basic.id AS id,ep_subject_basic.name_group_ar AS name_group_ar, ep_final_grade_dtl.sid, ROUND(SUM(ep_final_grade_dtl.weighted_grade) / SUM(ep_final_grade_dtl.lesson_hours)) AS subject_basic_grade')
            ->join('ep_subject','subject_id','=','ep_subject.id')
            ->join('ep_subject_basic','subject_basic_id','=','ep_subject_basic.id')
            ->join('ep_final_grade_dtl', function($join) {
                $join->on('ep_subject_basic.ayid','=','ep_final_grade_dtl.ayid');
                $join->on('ep_subject_basic_dtl.subject_id','=','ep_final_grade_dtl.subject_id');
            })
            ->where('ep_subject_basic.ayid',$ayid)
            ->where('ep_subject_basic.level',$app['kelas']->level)
            ->groupBy('ep_subject_basic.id', 'ep_final_grade_dtl.sid')
            ->get();
        $app['group'] = BoardingActivityGroup::orderBy('seq')->get();
        $app['gradepass'] = Grade::where('format_code', $formatcode)
            ->where('ayid', $ayid)
            ->where('tid', $tid)
            ->where('sid', $request->pid)
            ->get();

        $app['data'] = BoardingActivity::orderBy('seq')->get();

        $app['finaldtl'] = FinalGradeDtl::selectRaw('ep_final_grade_dtl.*,ep_subject.*,ep_course_subject.grade_pass')
            ->join('ep_subject','subject_id','=','ep_subject.id')
            ->leftJoin('ep_course_class','ep_final_grade_dtl.ccid','=','ep_course_class.id')
            ->rightJoin('ep_course_subject', function($join) use ($ayid,$tid) {
                $join->on('ep_course_class.level','=','ep_course_subject.level');
                $join->on('ep_course_subject.ayid','=',DB::raw($ayid));
                $join->on('ep_course_subject.tid','=',DB::raw($tid));
                $join->on('ep_subject.id','=','ep_course_subject.subject_id');
            })
            ->where('ep_final_grade_dtl.sid',$request->pid)
            ->where('ep_final_grade_dtl.format_code',$formatcode)
            ->where('ep_final_grade_dtl.ayid',$ayid)
            ->where('ep_final_grade_dtl.tid',$tid)
            ->orderBy('subject_seq_no')
            ->get();
        $app['jmhmapel'] = $app['finaldtl']->count();
        $app['finalboardingdtl'] = FinalGradeDtl::select('subject_id','final_grade','letter_grade')
            ->where('sid',$request->pid)
            ->where('format_code',$formatcode)
            ->where('ayid',$ayid)
            ->where('tid',$tid)
            ->join('ep_boarding_activity','subject_id','=','ep_boarding_activity.id')
            ->orderBy('subject_seq_no')
            ->get();

        switch ($idprint) {
            case '1':
                $app['judul'] .= ' Akademik '.$app['student']->name;
                if(!empty($pdf)) {
                    header('Content-Type: application/pdf');
                    $mpdf = new \Mpdf\Mpdf($mpdfconf);
                    $mpdf->WriteHTML(view('halaman.print.raport1',$app));
                    $mpdf->SetDirectionality('rtl');
                    $mpdf->Output($app['judul'].'.pdf',"D");
                } else {
                    return view('halaman.raport1',$app);
                }
                break;
            case '2':
                $app['judul'] .= ' Pengasuhan '.$app['student']->name;
                if(!empty($pdf)) {
                    $mpdf = new \Mpdf\Mpdf($mpdfconf);
                    $mpdf->WriteHTML(view('halaman.print.raport2',$app));
                    $mpdf->SetDirectionality('rtl');
                    $mpdf->Output($app['judul'].'.pdf',"D");
                } else {
                    return view('halaman.raport2',$app);
                }
                break;
            case 'pts':
                $app['judul'] .= ' UTS '.$app['student']->name;
                if(!empty($pdf)) {
                    $mpdf = new \Mpdf\Mpdf($mpdfconf);
                    $mpdf->WriteHTML(view('halaman.print.raport-pts',$app));
                    $mpdf->SetDirectionality('rtl');
                    $mpdf->Output($app['judul'].'.pdf',"D");
                } else {
                    return view('halaman.raport-pts',$app);
                }
                break;
            default:
                # code...
                break;
        }
    }

    public function print_diknas(Request $request)
    {
        // Konfigurasi Raport
        $pdfconf = new PdfConfig;
        $mpdfconf = $pdfconf->config();

        $app['aktif']   = 'raport/modul';
        $app['judul']   = 'Cetak Raport';
        $idprint        = $request->id;
        $formatcode     = new RfFormatCode;
        $formatcode     = $formatcode->getFormatCode($idprint);
        $pdf            = $request->pdf;
        $ayid           = config('id_active_academic_year');
        $tid            = config('id_active_term');
        $g              = new General;
        $tglleg         = FinalGrade::getDateRaport($ayid,$tid);

        if (auth()->user()->role == '2')
        {
            $pid    = $request->pid;
            $token  = $request->token;
            $ayid   = $request->tahunajar;
            $tid    = $request->semester;
            $dectoken = EasyEncrypt::decrypt($token);
            $person = Student::select('aa_person.dob')
                ->join('aa_person','aa_person.id','=','pid')
                ->where('aa_student.id',$pid)
                ->first();
            if($dectoken!=$person['dob'])
            {
                return redirect('https://mahadsyarafulharamain.sch.id');
                die();
            }
        }

        //=== DIKNAS ===//
        $app['school']  = School::getActiveSchool(config('id_active_school'));
        $app['student'] = FinalGrade::select('ep_course_class.name as class_name','ep_course_class.level','aa_student.id','aa_person.name','nis','nisn','aa_person.sex','absent_s','absent_i','absent_a','note_from_student_affairs')
                            ->join('aa_student','sid','=','aa_student.id')
                            ->join('aa_person','pid','=','aa_person.id')
                            ->join('ep_course_class','ep_final_grade.ccid','=','ep_course_class.id')
                            ->where('format_code',0) //mengambil data siswa dari akademik
                            ->where('ayid', $ayid)
                            ->where('tid', $tid)
                            ->where('sid', $request->pid)
                            ->first();
        $app['student_from_diknas'] = FinalGrade::select('note_from_student_affairs')
                            ->where('format_code',2) //mengambil data catatan wali kelas dari finalgrade diknas
                            ->where('ayid', $ayid)
                            ->where('tid', $tid)
                            ->where('sid', $request->pid)
                            ->first();
        $app['school_type'] = RfSchoolType::get();
        $app['raport']  = FinalGradeDtl::where('ep_final_grade_dtl.format_code',$formatcode)
                            ->where('ep_final_grade_dtl.ayid', $ayid)
                            ->where('ep_final_grade_dtl.tid', $tid)
                            ->where('ep_final_grade_dtl.sid', $request->pid)
                            ->leftJoin('ep_subject_diknas','subject_id','=','ep_subject_diknas.id')
                            ->select('letter_grade','ep_subject_diknas.id','ep_subject_diknas.name','final_grade','knowledge_desc','skill_desc','mapping.is_mulok')
                            ->join(DB::raw('(SELECT subject_diknas_id, is_mulok
                                            FROM ep_subject_diknas_mapping
                                            WHERE ayid = '.$ayid.'
                                            AND tid = '.$tid.'
                                            AND level = '.$app['student']->level.'
                                            ) AS mapping'),
                            function($join)
                            {
                                $join->on('mapping.subject_diknas_id', '=', 'ep_final_grade_dtl.subject_id');
                            })
                            ->orderBy('subject_seq_no')
                            ->get()->toArray();
        $app['extraculiculer'] = FinalGradeDtl::select('subject_id', 'ep_boarding_activity_group.name AS group_name', 'ep_boarding_activity.name AS activity_name', 'letter_grade')
                                ->join('ep_boarding_activity','subject_id','=','ep_boarding_activity.id')
                                ->leftJoin('ep_boarding_activity_group','ep_boarding_activity.group_id','=','ep_boarding_activity_group.id')
                                ->where('format_code',1) //mengambil format_code pengasuhan dari ep_final_grade_dtl
                                ->where('ayid',$ayid)
                                ->where('tid',$tid)
                                ->where('sid',$request->pid)
                                ->whereRaw("letter_grade REGEXP 'A|B|C|D'")
                                ->whereIn('subject_id',array(15,16,17,18,19)) //mengambil aktifitas pengasuhan dari ep_boarding_activity
                                ->get();
        $app['achievement'] =  Achievement::select('name','desc')
                                ->join('aa_student','aa_achievement.pid','=','aa_student.pid')
                                ->where('aa_student.id', $request->pid)
                                ->get();
        $principal   = FinalGrade::select('aa_person.name','aa_employe.nik as nip')
                                ->join('aa_employe','principal','=','aa_employe.id')
                                ->join('aa_person','pid','=','aa_person.id')
                                ->where('format_code',$formatcode)
                                ->where('ayid', $ayid)
                                ->where('tid', $tid)
                                ->where('sid', $request->pid);
        $app['signed'] = FinalGrade::select('aa_person.name','aa_employe.nik as nip')
                                ->join('aa_person','form_teacher','=','aa_person.id')
                                ->join('aa_employe','aa_person.id','=','aa_employe.pid')
                                ->where('format_code',$formatcode)
                                ->where('ayid', $ayid)
                                ->where('tid', $tid)
                                ->where('sid', $request->pid)
                                ->union($principal)
                                ->get();
        $app['tgl_raport']  = $g->convertDate($tglleg['date_legalization']);

        $app['judul'] .= ' Diknas '.$app['student']->name;
        if(!empty($pdf)) {
            $mpdf = new \Mpdf\Mpdf($mpdfconf);
            $mpdf->WriteHTML(view('halaman.print.raport3',$app));
            $mpdf->Output($app['judul'].'.pdf',"D");
        } else {
            return view('halaman.raport3',$app);
        }
    }

    public function rekap(Request $request)
    {
        $app = array();
        $app['aktif'] = 'raport-rekap';
        $app['judul'] = 'Rekap Raport';

        return view('halaman.raport-rekap', $app);
    }
    public function rekap_uts(Request $request)
    {
        $app = array();
        $app['aktif'] = 'raport-rekap';
        $app['judul'] = 'Rekap Raport UTS';
        $app['employe'] = (auth()->user()->role=='1') ? Employe::get() : Employe::where('pid',auth()->user()->pid)->first();
        $app['homeroom'] = (auth()->user()->role=='1') ? array() : Homeroom::where('emid',$app['employe']['id'])->select('ccid')->where('ayid',config('id_active_academic_year'))->get()->toArray();
        $app['homeroom'] = array_column($app['homeroom'], 'ccid');
        $app['kelas'] = (auth()->user()->role=='1') ? CourseClass::get() : CourseClass::whereIn('id',$app['homeroom'])->get();
        $app['mapel'] = array();
        $app['siswa'] = array();
        $app['nilai'] = array();
        $app['pilihkelas'] = $request->pilihkelas;
        $app['req'] = $request;
        if($request->post()){
            $app['mapel'] = CourseSubject::select('ep_course_subject.subject_id', 'ep_subject.name')
                            ->join('ep_course_class','ep_course_subject.level','=','ep_course_class.level')
                            ->join('ep_subject','ep_course_subject.subject_id','=','ep_subject.id')
                            ->where('ep_course_class.id',$app['pilihkelas'])
                            ->where('ayid',config('id_active_academic_year'))
                            ->where('tid',config('id_active_term'))
                            ->orderBy('seq')
                            ->get();
            $app['siswa'] = CourseClassDtl::select('ep_course_class_dtl.sid', 'nis', 'aa_person.name', 'aa_person.name_ar', 'rf_level_class.desc_ar', 'ep_course_class.name_ar AS class_name_ar', 'sex')
                            ->join('ep_course_class','ep_course_class_dtl.ccid','=','ep_course_class.id')
                            ->join('aa_student','aa_student.id','=','sid')
                            ->join('aa_person','aa_person.id','=','aa_student.pid')
                            ->join('rf_level_class','ep_course_class.level','=','rf_level_class.level')
                            ->where('ep_course_class.id',$app['pilihkelas'])
                            ->where('ayid',config('id_active_academic_year'))
                            ->orderBy('aa_person.name')
                            ->get();

            $sid = collect($app['siswa'])->pluck('sid')->toArray();
            $app['nilai'] = FinalGradeDtl::whereIn('ep_final_grade_dtl.sid',$sid)
                            ->join('aa_student','aa_student.id','=','ep_final_grade_dtl.sid')
                            ->join('aa_person','aa_person.id','=','aa_student.pid')
                            ->where('ep_final_grade_dtl.ccid',$app['pilihkelas'])
                            ->where('ayid',config('id_active_academic_year'))
                            ->where('tid',config('id_active_term'))
                            ->where('format_code','3')
                            ->orderBy('aa_person.name')
                            ->get();
        }

        return view('halaman.raport-rekap-uts',$app);
    }

    public function rekap_uas(Request $request)
    {
        $app = array();
        $app['aktif'] = 'raport-rekap';
        $app['judul'] = 'Rekap Raport UAS';
        $app['employe'] = (auth()->user()->role=='1') ? Employe::get() : Employe::where('pid',auth()->user()->pid)->first();
        $app['homeroom'] = (auth()->user()->role=='1') ? array() : Homeroom::where('emid',$app['employe']['id'])->select('ccid')->where('ayid',config('id_active_academic_year'))->get()->toArray();
        $app['homeroom'] = array_column($app['homeroom'], 'ccid');
        $app['kelas'] = CourseClass::get();
        $app['mapel'] = array();
        $app['siswa'] = array();
        $app['nilai'] = array();
        $app['pilihkelas'] = $request->pilihkelas;
        $app['req'] = $request;
        if($request->post()){
            $app['mapel'] = CourseSubject::select('ep_course_subject.subject_id', 'ep_subject.name','week_duration')
                            ->join('ep_course_class','ep_course_subject.level','=','ep_course_class.level')
                            ->join('ep_subject','ep_course_subject.subject_id','=','ep_subject.id')
                            ->where('ep_course_class.id',$app['pilihkelas'])
                            ->where('ayid',config('id_active_academic_year'))
                            ->where('tid',config('id_active_term'))
                            ->orderBy('seq')
                            ->get();
            $app['siswa'] = CourseClassDtl::select('ep_course_class_dtl.sid', 'nis', 'aa_person.name', 'aa_person.name_ar',
                            'rf_level_class.desc_ar', 'ep_course_class.name_ar AS class_name_ar', 'sex','aa_person.id as pid')
                            ->join('ep_course_class','ep_course_class_dtl.ccid','=','ep_course_class.id')
                            ->join('aa_student','aa_student.id','=','sid')
                            ->join('aa_person','aa_person.id','=','aa_student.pid')
                            ->join('rf_level_class','ep_course_class.level','=','rf_level_class.level')
                            ->where('ep_course_class.id',$app['pilihkelas'])
                            ->where('ayid',config('id_active_academic_year'))
                            ->orderBy('aa_person.name')
                            ->get();
            $sid = collect($app['siswa'])->pluck('sid')->toArray();
            $app['ipk'] = Gpa::getIPK($sid,config('id_active_academic_year'),config('id_active_term'));
            $app['nilai'] = FinalGradeDtl::whereIn('ep_final_grade_dtl.sid',$sid)
                            ->join('aa_student','aa_student.id','=','ep_final_grade_dtl.sid')
                            ->join('aa_person','aa_person.id','=','aa_student.pid')
                            ->where('ep_final_grade_dtl.ccid',$app['pilihkelas'])
                            ->where('ayid',config('id_active_academic_year'))
                            ->where('tid',config('id_active_term'))
                            ->where('format_code','0')
                            ->orderBy('aa_person.name')
                            ->get();
        }

        return view('halaman.raport-rekap-uas',$app);
    }

    public function rekap_total(Request $request)
    {
        $app = array();
        $app['aktif'] = 'raport-rekap';
        $app['judul'] = 'Rekap Raport TOTAL';
        $app['employe'] = (auth()->user()->role=='1') ? Employe::get() : Employe::where('pid',auth()->user()->pid)->first();
        $app['homeroom'] = (auth()->user()->role=='1') ? array() : Homeroom::where('emid',$app['employe']['id'])->select('ccid')->where('ayid',config('id_active_academic_year'))->get()->toArray();
        $app['homeroom'] = array_column($app['homeroom'], 'ccid');
        $app['kelas'] = CourseClass::get();
        $app['mapel'] = array();
        $app['siswa'] = array();
        $app['nilai'] = array();
        $app['pilihkelas'] = $request->pilihkelas;
        $app['req'] = $request;
        if($request->post()){
            $app['mapel'] = CourseSubject::select('ep_course_subject.subject_id', 'ep_subject.name','week_duration')
                            ->join('ep_course_class','ep_course_subject.level','=','ep_course_class.level')
                            ->join('ep_subject','ep_course_subject.subject_id','=','ep_subject.id')
                            ->where('ep_course_class.id',$app['pilihkelas'])
                            ->where('ayid',config('id_active_academic_year'))
                            ->where('tid',config('id_active_term'))
                            ->orderBy('seq')
                            ->get();
            $app['siswa'] = CourseClassDtl::select('ep_course_class_dtl.sid', 'nis', 'aa_person.name', 'aa_person.name_ar',
                            'rf_level_class.desc_ar', 'ep_course_class.name_ar AS class_name_ar', 'sex','aa_person.id as pid')
                            ->join('ep_course_class','ep_course_class_dtl.ccid','=','ep_course_class.id')
                            ->join('aa_student','aa_student.id','=','sid')
                            ->join('aa_person','aa_person.id','=','aa_student.pid')
                            ->join('rf_level_class','ep_course_class.level','=','rf_level_class.level')
                            ->where('ep_course_class.id',$app['pilihkelas'])
                            ->where('ayid',config('id_active_academic_year'))
                            ->orderBy('aa_person.name')
                            ->get();
            $sid = collect($app['siswa'])->pluck('sid')->toArray();
            $app['ipk'] = Gpa::getIPK($sid,config('id_active_academic_year'),config('id_active_term'));
            $app['nilai'] = FinalGradeDtl::whereIn('ep_final_grade_dtl.sid',$sid)
                            ->join('aa_student','aa_student.id','=','ep_final_grade_dtl.sid')
                            ->join('aa_person','aa_person.id','=','aa_student.pid')
                            ->where('ep_final_grade_dtl.ccid',$app['pilihkelas'])
                            ->where('ayid',config('id_active_academic_year'))
                            ->where('tid',config('id_active_term'))
                            ->where('format_code','0')
                            ->orderBy('aa_person.name')
                            ->get();
            $app['finals'] = FinalGrade::whereIn('sid',$sid)
                            ->where('ccid',$app['pilihkelas'])
                            ->where('ayid',config('id_active_academic_year'))
                            ->where('tid',config('id_active_term'))
                            ->where('format_code','0')
                            ->get();
        }

        return view('halaman.raport-rekap-total',$app);
    }

    public function rekap_pengasuhan(Request $request)
    {
        $app = array();
        $app['aktif'] = 'raport-rekap';
        $app['judul'] = 'Rekap Raport Pengasuhan';
        $app['employe'] = BoardingGroup::getMsPerAyid('');
        if (auth()->user()->role == '3')
        {
            $app['employe'] = BoardingGroup::getMsPerAyid(auth()->user()->pid);
        }
        $app['mapel'] = array();
        $app['siswa'] = array();
        $app['nilai'] = array();
        $app['group'] = array();
        $app['finalboardingdtl'] = array();
        $app['pilih'] = $request->pilih;
        $app['req']   = $request;
        if($request->post()) {
            $siswa = BoardingGroup::select('a.id','a.nis', 'b.name','b.name_ar','ep_course_class.name_ar AS class')
                    ->join('aa_student as a','sid','=','a.id')
                    ->join('aa_person as b','a.pid','=','b.id')
                    ->leftJoin('ep_course_class_dtl', function($join)
                    {
                        $join->on('ep_boarding_group.ayid','=','ep_course_class_dtl.ayid');
                        $join->on('a.id','=','ep_course_class_dtl.sid');
                    })
                    ->join('ep_course_class','ep_course_class_dtl.ccid','=','ep_course_class.id')
                    ->where('ep_boarding_group.ayid',config('id_active_academic_year'))
                    ->where('eid',$request->pilih)
                    ->orderBy('a.nis', 'ASC')
                    ->get();
            $finalboardingdtl = array();
            foreach ($siswa as $key=>$rows) {
                $getFinalboardingdtl = FinalGradeDtl::getBoardingFinalGradeDtl($rows['id']);
                $data['id']     = $rows['id'];
                $data['name']   = $rows['name'];
                $data['name_ar']= $rows['name_ar'];
                $data['nis']    = $rows['nis'];
                $data['class']    = $rows['class'];
                $data['nilai']  = $getFinalboardingdtl;
                $finalboardingdtl[] = $data;
            }
            $app['finalboardingdtl'] = $finalboardingdtl;
        }

        return view('halaman.raport-rekap-pengasuhan',$app);
    }

    public function mahmul(Request $req)
    {
		$app = array();
		$levelngajar = '';
		$app['aktif'] = 'raport-rekap';
        $app['costumdatatable'] = 'yes';
		$app['judul'] = 'Madah Mahmulah';
        $app['pelajarankelas'] = null;
		$app['student'] = array();
		$app['kelas'] = CourseClass::get();
		if (auth()->user()->role == '3') {
            $app['kelas'] = CourseClass::join('aa_homeroom','ccid','=','ep_course_class.id')
                ->join('aa_employe','emid','=','aa_employe.id')
                ->join('aa_person','pid','=','aa_person.id')
                ->where('aa_person.id',auth()->user()->pid)
                ->select('ep_course_class.id','ep_course_class.name')
                ->get();
		}
        $app['pelajaran'] = Subject::orderBy('name')->get();
        $app['pilihkelas'] = '';
        $app['pilihpelajaran'] = '';
		$app['req'] = $req;
        $app['siswa'] = array();
        $siswa = CourseClassDtl::where('ep_course_class_dtl.ayid', config('id_active_academic_year'))
            ->join('aa_student as a', 'sid', '=', 'a.id')
            ->join('aa_person as b', 'a.pid', '=', 'b.id')
            ->join('ep_course_class', 'ccid', '=', 'ep_course_class.id')
            ->join('rf_level_class','ep_course_class.level','=','rf_level_class.level')
            ->select('a.id', 'b.name', 'b.name_ar','ccid', 'ep_course_class.name_ar as class_name','rf_level_class.desc_ar','b.sex')
            ->orderBy('b.name')->get()->toArray();
        if($req->pilihkelas!='' && $req->pilihkelas!='0')
        {
            $siswas = collect($siswa)->where('ccid', $req->pilihkelas)->toArray();
            $app['pilihkelas'] = $req->pilihkelas;
		} else {
            $siswas = collect($siswa)->toArray();
        }
        if($req->pilihpelajaran!='' && $req->pilihpelajaran!='0')
        {
            $app['pilihpelajaran'] = $req->pilihpelajaran;
        }
        if($req->filter=='yes')
        {
            $app['siswa'] = $siswas;
            $app['allstudent'] = [];
            $app['mahmul'] = [];
            $app['student'] = [];
            if(!empty($app['siswa']))
            {
                $app['allstudent'] = ($app['siswa']!=[]) ? collect($app['siswa'])->pluck('id')->toArray() : [];
                $app['mahmul'] = RemedyClass::getMahmul($app['allstudent'],$app['pilihpelajaran']);
                $app['student'] = collect($app['mahmul'])->groupBy('sid')->toArray();
            }
            $namakelas = collect($app['kelas'])->where('id',$req->pilihkelas)->pluck('name')->toArray();
            $namakelas = reset($namakelas);
            $app['namakelas'] = $namakelas.' '.config('active_academic_year').' '.config('active_term');
            if($req->file!='')
            {
                $namafile = 'mahmul_'.str_replace(' ','_',str_replace('/','_',strtolower($app['namakelas']))).'.xls';
                header('Content-Type: application/xls');
                header("Content-Disposition: attachment; filename=\"$namafile\"");
                echo view('halaman.assessment-mahmul-export',$app);
                die();
            }
        }
        $app['siswa'] = ($req->filter=='yes') ? $app['siswa'] : [];

		return view('halaman.assessment-mahmul', $app);
    }
    public function tarakumi(Request $req)
    {
		$app = array();
		$levelngajar = '';
		$app['aktif'] = 'raport-rekap';
		$app['judul'] = 'Rekap Tarakumi';
        $app['kelas'] = CourseClass::get();
		if (auth()->user()->role == '3') {
            $app['kelas'] = CourseClass::join('aa_homeroom','ccid','=','ep_course_class.id')
                ->join('aa_employe','emid','=','aa_employe.id')
                ->join('aa_person','pid','=','aa_person.id')
                ->where('aa_person.id',auth()->user()->pid)
                ->select('ep_course_class.id','ep_course_class.name')
                ->get();
		}
        $app['pilihkelas'] = '';
		$app['siswa'] = array();
		$app['req'] = $req;
        $ayid = config('id_active_academic_year');
        $tid  = config('id_active_term');
        if($req->pilihkelas!='' && $req->pilihkelas!='0')
        {
            $app['murid'] = Student::join('ep_course_class_dtl','sid','=','aa_student.id')
                ->join('aa_person','aa_person.id','=','aa_student.pid')
                ->where('ayid',config('id_active_academic_year'))
                ->where('ccid',$req->pilihkelas)
                ->orderBy('aa_person.name')
                ->get();
            $murid = collect($app['murid'])->pluck('sid')->toArray();
            if(count($murid)!=0)
            {
                $app['ipk'] = Gpa::getIPKSemester($murid,$ayid,$tid);
                dd($app['ipk']);
                $namakelas = collect($app['kelas'])->where('id',$req->pilihkelas)->pluck('name')->toArray();
                $namakelas = reset($namakelas);
                $app['namakelas'] = $namakelas.' '.config('active_academic_year').' '.config('active_term');
                if($req->file!='')
                {
                    $namafile = 'tarakumi_'.str_replace(' ','_',str_replace('/','_',strtolower($app['namakelas']))).'.xls';
                    header('Content-Type: application/xls');
                    header("Content-Disposition: attachment; filename=\"$namafile\"");
                    echo view('halaman.raport-rekap-tarakumi-export',$app);
                    die();
                }
            }
        }
        return view('halaman.raport-rekap-tarakumi',$app);
    }
    public function rekap_diknas(Request $req)
    {
		$app = array();
		$levelngajar = '';
		$app['aktif'] = 'raport-rekap';
		$app['judul'] = 'Rekap Diknas';
        $app['kelas'] = CourseClass::get();
		if (auth()->user()->role == '3') {
            $app['kelas'] = CourseClass::join('aa_homeroom','ccid','=','ep_course_class.id')
                ->join('aa_employe','emid','=','aa_employe.id')
                ->join('aa_person','pid','=','aa_person.id')
                ->where('aa_person.id',auth()->user()->pid)
                ->select('ep_course_class.id','ep_course_class.name','ep_course_class.level')
                ->get();
		}
        $app['pilihkelas'] = '';
		$app['siswa'] = array();
		$app['ipk'] = array();
		$app['mapel'] = array();
		$app['jnnilai'] = array('PENG'=>'3','KET'=>'4');
		$app['req'] = $req;
        if($req->pilihkelas!='' && $req->pilihkelas!='0')
        {
            $app['murid'] = Student::select('sid','nis','nisn','name','sex')
                ->join('ep_course_class_dtl','sid','=','aa_student.id')
                ->join('aa_person','aa_person.id','=','aa_student.pid')
                ->where('ayid',config('id_active_academic_year'))
                ->where('ccid',$req->pilihkelas)
                ->orderBy('aa_person.name')
                ->get();
            $murid = collect($app['murid'])->pluck('sid')->toArray();
            if(count($murid)!=0)
            {
                $app['nilaipengetahuan'] = SubjectDiknasMapping::getNilaiDiknas($murid,$app['jnnilai']['PENG']);
                $app['nilaiketerampilan'] = SubjectDiknasMapping::getNilaiDiknas($murid,$app['jnnilai']['KET']);
                $app['level'] = RfLevelClass::get();
                $app['mapel'] = SubjectDiknasMapping::getFromLevel($app['kelas'][0]['level'],config('id_active_academic_year'),config('id_active_term'));
                $namakelas = collect($app['kelas'])->where('id',$req->pilihkelas)->pluck('name')->toArray();
                $namakelas = reset($namakelas);
                $app['namakelas'] = $namakelas .' '.config('active_academic_year').' '.config('active_term');
                if($req->file!='')
                {
                    $namafile = 'rekap_diknas_'.str_replace(' ','_',str_replace('/','_',strtolower($app['namakelas']))).'.xls';
                    header('Content-Type: application/xls');
                    header("Content-Disposition: attachment; filename=\"$namafile\"");
                    echo view('halaman.raport-rekap-diknas-export',$app);
                    die();
                }
            }
        }
        return view('halaman.raport-rekap-diknas',$app);
    }
    public function rangking(Request $req)
    {
		$app = array();
		$levelngajar = '';
		$app['aktif'] = 'raport-rekap';
		$app['judul'] = 'Rekap Rangking';
        $app['kelas'] = CourseClass::get();
        $app['level'] = RfLevelClass::get();
        $app['pilihkelas'] = '';
		$app['siswa'] = array();
		$app['req'] = $req;
        if($req->pilihlevel!='' && $req->pilihlevel!='0')
        {
            $app['murid'] = Student::join('ep_course_class_dtl','sid','=','aa_student.id')
                ->join('ep_course_class','ccid','=','ep_course_class.id')
                ->join('aa_person','aa_person.id','=','aa_student.pid')
                ->where('ayid',config('id_active_academic_year'))
                ->where('level',$req->pilihlevel)
                ->select('pid','nis','aa_person.name','aa_person.name_ar','ccid','ep_course_class.name as classname','sid','sex');
            $app['murid'] = ($req->pilihjkl!='0'&&$req->pilihjkl!='0') ? $app['murid']->where('sex',$req->pilihjkl) : $app['murid'];
            $app['murid'] = $app['murid']->get();
            $murid = collect($app['murid'])->pluck('sid')->toArray();
            if(count($murid)!=0)
            {
                $ipk = Gpa::getIPK($murid,config('id_active_academic_year'),config('id_active_term'));
                $app['ipk'] = collect($ipk)->sortByDesc('ipk')->values()->all();
                $namakelas = collect($app['murid'])->pluck('classname','ccid')->toArray();
                $app['namakelas'] = collect(array_unique($namakelas));
                if($req->file!='')
                {
                    $namafile = 'rangking_level'.$req->pilihlevel;
                    $namafile .= ($req->pilihjkl!=''&&$req->pilihjkl!='0') ? '_'.$req->pilihjkl : '';
                    header('Content-Type: application/xls');
                    header("Content-Disposition: attachment; filename=\"$namafile\".xls");
                    echo view('halaman.raport-rekap-rangking-export',$app);
                    die();
                }
            }
        }
        return view('halaman.raport-rekap-rangking',$app);
    }
    public function rekap_alquran(Request $request)
    {
        $app = array();
        $app['aktif'] = 'raport-rekap';
        $app['judul'] = 'Rekap Raport UTS';
        $app['employe'] = (auth()->user()->role=='1') ? Employe::get() : Employe::where('pid',auth()->user()->pid)->first();
        $app['homeroom'] = (auth()->user()->role=='1') ? array() : Homeroom::where('emid',$app['employe']['id'])->select('ccid')->where('ayid',config('id_active_academic_year'))->get()->toArray();
        $app['homeroom'] = array_column($app['homeroom'], 'ccid');
        $app['kelas'] = CourseClass::get();
        $app['mapel'] = array();
        $app['siswa'] = array();
        $app['nilai'] = array();
        $app['pilihkelas'] = $request->pilihkelas;
        $app['req'] = $request;
        $app['weight'] = BayanatWeight::get();
        if($request->filter!=''){
            $namakelas = $app['kelas']->where('id',$app['pilihkelas'])->first()['name'];
            $app['namakelas'] = str_replace("'",'',$namakelas);
            $app['siswa'] = CourseClassDtl::select('ep_course_class_dtl.sid', 'nis', 'aa_person.name', 'aa_person.name_ar',
                'rf_level_class.desc_ar', 'ep_course_class.name_ar AS class_name_ar', 'sex','aa_person.id as pid')
                ->join('ep_course_class','ep_course_class_dtl.ccid','=','ep_course_class.id')
                ->join('aa_student','aa_student.id','=','sid')
                ->join('aa_person','aa_person.id','=','aa_student.pid')
                ->join('rf_level_class','ep_course_class.level','=','rf_level_class.level')
                ->where('ep_course_class.id',$app['pilihkelas'])
                ->where('ayid',config('id_active_academic_year'))
                ->orderBy('aa_person.name')
                ->get();
            if($request->file!='')
            {
                $namafile = 'bayanat_'.str_replace(' ','_',str_replace('/','_',strtolower($app['namakelas']))).'.xls';
                header('Content-Type: application/xls');
                header("Content-Disposition: attachment; filename=\"$namafile\"");
                echo view('halaman.raport-rekap-quran-export',$app);
                die();
            }
        }

        return view('halaman.raport-rekap-quran',$app);
    }
    public function rekap_idhafiyah(Request $request)
    {
        $app = array();
        $app['aktif']       = 'raport-rekap';
        $app['judul']       = 'Rekap Nilai Bayanat Idhafiyah';
        $app['kelass']      = CourseClass::get();
        $app['pilihkelas']  = $request->pilihkelas;
        $app['employe']     = (auth()->user()->role=='1') ? Employe::get() : Employe::where('pid',auth()->user()->pid)->first();
        $app['homeroom']    = (auth()->user()->role=='1') ? array() : Homeroom::where('emid',$app['employe']['id'])->select('ccid')->where('ayid',config('id_active_academic_year'))->get()->toArray();
        $app['homeroom']    = array_column($app['homeroom'], 'ccid');
        $ayid               = config('id_active_academic_year');
        $tid                = config('id_active_term');
        $app['siswa']       = array();
        $app['finaldtl']    = array();
        $app['mudalfashl']  = array();
        $app['req']         = $request;

        if($request->filter!=''){
            $app['siswa']   = CourseClassDtl::select('ep_course_class_dtl.sid', 'nis', 'aa_person.name', 'aa_person.name_ar','ep_course_class.id AS class_id',
                            'rf_level_class.desc_ar', 'ep_course_class.name_ar AS class_name_ar','ep_course_class.level', 'sex','aa_person.id as pid')
                            ->join('ep_course_class','ep_course_class_dtl.ccid','=','ep_course_class.id')
                            ->join('aa_student','aa_student.id','=','sid')
                            ->join('aa_person','aa_person.id','=','aa_student.pid')
                            ->join('rf_level_class','ep_course_class.level','=','rf_level_class.level')
                            ->where('ep_course_class.id',$app['pilihkelas'])
                            ->where('ayid',config('id_active_academic_year'))
                            ->orderBy('aa_person.name')
                            ->get();
            $app['kelas']   = collect($app['kelass'])->where('id',$app['pilihkelas'])->first();
            $mudalfashl     = SubjectBasicDetail::where('ayid',$ayid)
                            ->join('ep_subject_basic','subject_basic_id','=','ep_subject_basic.id')
                            ->where('level',$app['kelas']->level)->get();
            $app['mf']      = collect($mudalfashl)->groupBy('id')->toArray();
            $app['mudalfashl'] = SubjectBasic::whereIn('id',array_keys($app['mf']))->get()->toArray();
            $app['finaldtl'] = FinalGradeDtl::selectRaw('ep_final_grade_dtl.*,ep_subject.*,ep_course_subject.grade_pass')
                            ->join('ep_subject','subject_id','=','ep_subject.id')
                            ->leftJoin('ep_course_class','ep_final_grade_dtl.ccid','=','ep_course_class.id')
                            ->rightJoin('ep_course_subject', function($join) use ($ayid,$tid) {
                                $join->on('ep_course_class.level','=','ep_course_subject.level');
                                $join->on('ep_course_subject.ayid','=',DB::raw($ayid));
                                $join->on('ep_course_subject.tid','=',DB::raw($tid));
                                $join->on('ep_subject.id','=','ep_course_subject.subject_id');
                            })
                            ->where('ep_final_grade_dtl.sid',$request->pid)
                            ->where('ep_final_grade_dtl.format_code',0)
                            ->where('ep_final_grade_dtl.ayid',$ayid)
                            ->where('ep_final_grade_dtl.tid',$tid)
                            ->orderBy('subject_seq_no')
                            ->get();
            $app['namakelas'] = str_replace("'",'',$app['kelas']->name);
            if($request->file!='')
            {
                $namafile   = 'bayanat_idhafiyah_'.str_replace(' ','_',str_replace('/','_',strtolower($app['namakelas']))).'.xls';
                header('Content-Type: application/xls');
                header("Content-Disposition: attachment; filename=\"$namafile\"");
                echo view('halaman.raport-rekap-idhafiyah-export',$app);
                die();
            }
        }

        return view('halaman.raport-rekap-idhafiyah',$app);
    }
}
