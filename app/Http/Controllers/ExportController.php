<?php

namespace App\Http\Controllers;

use App\Exports\AllExport;
use App\Models\AcademicYear;
use App\Models\CourseClass;
use App\Models\CourseClassDtl;
use App\Models\CourseSubject;
use App\Models\Employe;
use App\Models\HrAttendance;
use App\Models\StudentPassed;
use App\Models\Achievement;
use App\Models\Assessment;
use App\Models\BoardingGrade;
use App\Models\BoardingGroup;
use App\Models\BoardingActivityItem;
use App\Models\Punishment;
use App\Models\Counselling;
use App\Models\HrComponent;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\BayanatClass;
use App\Models\BayanatMapping;
use App\Models\BayanatMappingDtl;
use App\Models\BayanatWeight;
use App\Models\FinalGrade;
use App\Models\FinalGradeDtl;
use App\Models\RfLevelClass;
use App\Models\RfTerm;
use App\Models\SubjectDiknas;
use App\Models\SubjectDiknasBasic;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index(Request $request)
    {

    }
    public function kinerja(Request $request)
    {
        $array = array('type'=>'kinerja');
        $karyawan = Employe::where('is_active','1')
            ->join('aa_person','pid','=','aa_person.id')
            ->join('hr_position','position_id','=','hr_position.id')
            ->select('aa_person.*','hr_position.name as position')
            ->orderBy('name')
            ->get()
            ->toArray();
        $datapegawai = collect($karyawan);
        $datas = ['tgl_awal'=>$request->tgl_awal,'tgl_akhir'=>$request->tgl_akhir,'employe_id'=>$request->employe_id,'component_id'=>$request->component_id];
        $array['view'] = (count($datas['component_id'])>0 && $datas['component_id'][0]!='0') ? '-v2' : '';
        $alldata = HrAttendance::getAll($datas,$datapegawai);
        $array += $alldata;

        $namafile = 'kinerja.xls';
        $namaview = 'halaman.report-kinerja-all'.$array['view'];
        header('Content-Type: application/xls');
        header("Content-Disposition: attachment; filename=\"$namafile\"");
        echo view($namaview,$array);
    }
    public function kinerja_bulanan(Request $request)
    {
        $array = array('type'=>'kinerja-pekanan');
        $karyawan = Employe::where('is_active','1')
            ->join('aa_person','pid','=','aa_person.id')
            ->join('hr_position','position_id','=','hr_position.id')
            ->select('aa_person.*','hr_position.name as position_name')
            ->orderBy('name')
            ->where('aa_person.name','not like','%admin%')
            ->get()->toArray();
        $datapegawai = collect($karyawan);
        $datas = ['bulan'=>$request->bulan,'tahun'=>$request->tahun,'employe_id'=>$request->employe_id,'component_id'=>$request->component_id];
        if(count($datas['component_id'])=='1'&&$datas['component_id'][0]=='0')
        {
            $array['data'] = HrAttendance::getAllPekanan($datas,$datapegawai);
            $array['view'] = '';
        }
        else
        {
            $array['data'] = HrAttendance::getAllPekananKomponen($datas,$datapegawai);
            $array['view'] = '-v21';
        }
        $array['jmhrow'] = count($request->component_id);
        $array['komponen'] = HrComponent::whereRaw('id IN ('.implode(',',$datas['component_id']).')')->get()->toArray();
        $namafile = 'kinerja-pekanan.xls';
        $namaview = 'halaman.report-kinerja-pekanan-rekap'.$array['view'];
        header('Content-Type: application/xls');
        header("Content-Disposition: attachment; filename=\"$namafile\"");
        echo view($namaview,$array);
    }
    public function rombel(Request $request)
    {
        $array = array('type'=>'rombel');
        if($request->subject == 'lainnya')
        {
            $array += array('halaman'=>'lainnya');
        }
        $kelas = CourseClass::where('id',$request->id)->first();
        $rombel = CourseClassDtl::join('aa_student as st','sid','=','st.id')
            ->join('aa_person as ps','pid','=','ps.id')
            ->selectRaw('st.id , nis, ps.name, "'.$request->subject.'" as sbj')
            ->where('ccid',$request->id)
            ->where('ayid',config('id_active_academic_year'))
            ->orderBy('ps.name')
            ->get();
        $student = collect($rombel)->pluck('id')->toArray();
        $isi = array();
        $isidiknas = array();
        if($request->isi != '')
        {
            if($request->subject != 'lainnya')
            {
                $isi = Assessment::where('ayid',config('id_active_academic_year'))
                    ->where('tid',config('id_active_term'))
                    ->where('subject_id',$request->subject)
                    ->whereIn('sid',$student)
                    ->get()->toArray();
            }
            else
            {
                $isi = FinalGrade::where('ayid',config('id_active_academic_year'))
                    ->where('tid',config('id_active_term'))
                    ->where('format_code','0')
                    ->whereIn('sid',$student)
                    ->selectRaw('sid, absent_a, absent_i, absent_s, cleanliness, discipline, behaviour, activities_parent, note_from_student_affairs, result')
                    ->get()->toArray();
                $isidiknas = FinalGrade::where('ayid',config('id_active_academic_year'))
                    ->where('tid',config('id_active_term'))
                    ->where('format_code','2')
                    ->whereIn('sid',$student)
                    ->selectRaw('sid, absent_a, absent_i, absent_s, cleanliness, discipline, behaviour, activities_parent, note_from_student_affairs')
                    ->get()->toArray();
            }
        }
        $pelajaran = ($request->subject!='lainnya') ? Subject::where('id',$request->subject)->first()->toArray() : array('name'=>'lainnya');
        $array += array('alldata'=>$rombel,'isi'=>$isi,'isidiknas'=>$isidiknas);

        $namafile = str_replace('-','_',str_replace("'",'','Rombel_'.str_replace(' ','_',$kelas->name).'_'.str_replace('.','',str_replace(' ','_',$pelajaran['name'])).'.xls'));
        $namaview = (isset($array['halaman'])) ? 'halaman.studygroup-lainnya-export' : 'halaman.studygroup-export';
        header('Content-Type: application/xls');
        header("Content-Disposition: attachment; filename=\"$namafile\"");
        echo view($namaview,$array);
    }

    public function rombelPengasuhan(Request $request)
    {
        $array = array('type'=>'rombel-pengasuhan');
        $qry = BoardingGroup::select('st.id','ep_boarding_group.eid','nis','ps.name','ps.name_ar')
            ->leftJoin('aa_student as st','sid','=','st.id')
            ->leftJoin('aa_person as ps','pid','=','ps.id')
            ->where('ayid',config('id_active_academic_year'))
            ->where('eid',$request->id)
            ->orderBy('st.nis')
            ->get();

        $getBoardingItem = BoardingActivityItem::getBoardingItem($request->periode);

        $employe = Employe::select('name')
                    ->join('aa_person AS ps','pid','=','ps.id')
                    ->where('aa_employe.id',$request->id)->first();
        $ay = AcademicYear::select('name')->where('id',config('id_active_academic_year'))->first();
        $array += array('alldata'=>$qry,'periode'=>$request->periode,'boardingItem'=>$getBoardingItem);

        $namafile = 'Rombel-Pengasuhan_'.str_replace(' ','_',$employe->name).'_'.str_replace('/','_',$ay->name).'_Semester_'.config('id_active_term').'_Periode_'.$request->periode.'.xls';
        $namaview = 'halaman.boardinggroup-export';
        header('Content-Type: application/xls');
        header("Content-Disposition: attachment; filename=\"$namafile\"");
        echo view($namaview,$array);
    }

    public function rombelPengasuhanPerSemester(Request $request)
    {
        $array = array('type'=>'rombel-pengasuhan-persemester');
        $qry = BoardingGroup::select('st.id','ep_boarding_group.eid','nis','ps.name','ps.name_ar')
            ->leftJoin('aa_student as st','sid','=','st.id')
            ->leftJoin('aa_person as ps','pid','=','ps.id')
            ->where('ayid',config('id_active_academic_year'))
            ->where('eid',$request->id)
            ->orderBy('st.nis')
            ->get();
        $employe = Employe::select('name')
                    ->join('aa_person AS ps','pid','=','ps.id')
                    ->where('aa_employe.id',$request->id)->first();
        $ay = AcademicYear::select('name')->where('id',config('id_active_academic_year'))->first();
        $array += array('alldata'=>$qry);

        $namafile = 'Rombel-Pengasuhan_Per_Semester'.str_replace(' ','_',$employe->name).'_'.str_replace('/','_',$ay->name).'_Semester_'.config('id_active_term').'.xls';
        $namaview = 'halaman.boardinggrouppersemester-export';
        header('Content-Type: application/xls');
        header("Content-Disposition: attachment; filename=\"$namafile\"");
        echo view($namaview,$array);
    }

    public function catatanRombelPengasuhanPerSemester(Request $request)
    {
        $array = array('type'=>'catatan-pengasuhan');
        $qry = BoardingGroup::select('st.id','ep_boarding_group.eid','nis','ps.name','ps.name_ar')
            ->leftJoin('aa_student as st','sid','=','st.id')
            ->leftJoin('aa_person as ps','pid','=','ps.id')
            ->where('ayid',config('id_active_academic_year'))
            ->where('eid',$request->id)
            ->orderBy('st.nis')
            ->get();

        $employe = Employe::select('name')
                    ->join('aa_person AS ps','pid','=','ps.id')
                    ->where('aa_employe.id',$request->id)->first();
        $ay = AcademicYear::select('name')->where('id',config('id_active_academic_year'))->first();
        $array += array('alldata'=>$qry);

        $namafile = 'Catatan-Pengasuhan_Per_Semester_'.str_replace(' ','_',$employe->name).'_'.str_replace('/','_',$ay->name).'_Semester_'.config('id_active_term').'.xls';
        $namaview = 'halaman.boardinggrouppersemesternotes-export';
        header('Content-Type: application/xls');
        header("Content-Disposition: attachment; filename=\"$namafile\"");
        echo view($namaview,$array);
    }

    public function pelanggaranRombelPengasuhan(Request $request)
    {
        $array = array('type'=>'pelanggaran-pengasuhan');
        $qry = BoardingGroup::select('ps.id','ep_boarding_group.eid','nis','ps.name','ps.name_ar')
            ->leftJoin('aa_student as st','sid','=','st.id')
            ->leftJoin('aa_person as ps','pid','=','ps.id')
            ->where('ayid',config('id_active_academic_year'));
            if($request->id!=0) {
                $qry = $qry->where('eid',$request->id);
            }
            $qry = $qry->orderBy('st.nis')->get();

        $employe = Employe::select('name')
                    ->join('aa_person AS ps','pid','=','ps.id')
                    ->where('aa_employe.id',$request->id)->first();

        $array += array('alldata'=>$qry);
        $employeName = $employe ? '_'.str_replace(' ','_',$employe->name).'_' : '_';
        $namafile = 'Catatan-Pelanggaran-Pengasuhan'.$employeName.''.str_replace('/','_',config('active_academic_year')).'_Semester_'.config('id_active_term').'.xls';
        $namaview = 'halaman.punishmentboardinggroup-export';
        header('Content-Type: application/xls');
        header("Content-Disposition: attachment; filename=\"$namafile\"");
        echo view($namaview,$array);
    }

    public function headerSiswa(Request $request)
    {
        $array = array('type'=>'headersiswa');

        $namafile = 'template_siswa.xls';
        $namaview = 'halaman.studentheader-export';
        header('Content-Type: application/xls');
        header("Content-Disposition: attachment; filename=\"$namafile\"");
        echo view($namaview,$array);
    }

    public function alumni(Request $request)
    {
        $array = array('type'=>'alumni');
        $query = StudentPassed::join('aa_person as pe', 'pid', '=', 'pe.id')
            ->where('ayid', $request->ayid)
            ->where('status', 'LLS')
            ->get();
        $array += array('alldata'=>$query);

        $namafile = 'alumni.xls';
        $namaview = 'halaman.studentpassed-export';
        header('Content-Type: application/xls');
        header("Content-Disposition: attachment; filename=\"$namafile\"");
        echo view($namaview,$array);
    }

    public function mutasi(Request $request)
    {
        $array = array('type'=>'alumni');
        $query = StudentPassed::join('aa_person as pe', 'pid', '=', 'pe.id')
            ->where('ayid', $request->ayid)
            ->where('status', 'PDH')
            ->get();
        $array += array('alldata'=>$query);

        $namafile = 'mutasi.xls';
        $namaview = 'halaman.studentpassed-export';
        header('Content-Type: application/xls');
        header("Content-Disposition: attachment; filename=\"$namafile\"");
        echo view($namaview,$array);
    }

    public function prestasi(Request $request)
    {
        $array = array('type'=>'prestasi');
        $query = Achievement::join('aa_person as mrd', 'pid', '=', 'mrd.id')
            ->join('aa_student as st','st.pid','=','mrd.id')
            ->leftJoin('ep_course_class_dtl as ccd','ccd.sid','=','st.id')
            ->join('ep_course_class as cc','cc.id','=','ccd.ccid')
            ->select('aa_achievement.id','nis','mrd.name as santri','aa_achievement.name','desc','date','file')
            ->where('ayid', config('id_active_academic_year'));
        if(!empty($request->ccid)) {
            $query->where('cc.id', $request->ccid);
        }
        if(!empty($request->student)) {
            $query->where('mrd.id', $request->student);
        }
        $qry = $query->get();
        $array += array('alldata'=>$qry);

        $namafile = 'prestasi.xls';
        $namaview = 'halaman.achievement-export';
        header('Content-Type: application/xls');
        header("Content-Disposition: attachment; filename=\"$namafile\"");
        echo view($namaview,$array);
    }

    public function pelanggaran(Request $request)
    {
        $array = array('type'=>'pelanggaran');
        $query = Punishment::join('aa_person as mrd', 'pid', '=', 'mrd.id')
            ->join('aa_student as st','st.pid','=','mrd.id')
            ->leftJoin('ep_course_class_dtl as ccd','ccd.sid','=','st.id')
            ->join('ep_course_class as cc','cc.id','=','ccd.ccid')
            ->select('ep_punishment.id','nis','mrd.name as santri','ep_punishment.name','ep_punishment.level','desc','date','cc.name as ccname')
            ->where('ayid', config('id_active_academic_year'));

        if(!empty($request->ccid)) {
            $query->where('cc.id', $request->ccid);
        }
        $qry = $query->get();
        $array += array('alldata'=>$qry);

        $namafile = 'pelanggaran.xls';
        $namaview = 'halaman.punishment-export';
        header('Content-Type: application/xls');
        header("Content-Disposition: attachment; filename=\"$namafile\"");
        echo view($namaview,$array);
    }

    public function konseling(Request $request)
    {
        $array = array('type'=>'konseling');
        $query = Counselling::join('aa_person as mrd', 'pid', '=', 'mrd.id')
            ->join('aa_student as st','st.pid','=','mrd.id')
            ->leftJoin('ep_course_class_dtl as ccd','ccd.sid','=','st.id')
            ->join('ep_course_class as cc','cc.id','=','ccd.ccid')
            ->select('ep_counselling.id','nis','mrd.name as santri','ep_counselling.name','desc','date','cc.name as ccname')
            ->where('ayid', config('id_active_academic_year'));

        if(!empty($request->ccid)) {
            $query->where('cc.id', $request->ccid);
        }
        $qry = $query->get();
        $array += array('alldata'=>$qry);

        $namafile = 'bimbingan konseling.xls';
        $namaview = 'halaman.counselling-export';
        header('Content-Type: application/xls');
        header("Content-Disposition: attachment; filename=\"$namafile\"");
        echo view($namaview,$array);
    }
    public function rombel_bayanat(Request $request)
    {
        $array = array('type'=>'rombel_bayanat');
        $kelas = BayanatClass::where('id',$request->kelas)->first();
        $guru = BayanatMapping::where('pid',$request->guru)
            ->join('aa_person','pid','=','aa_person.id')
            ->first();
        $rombel = BayanatMappingDtl::join('ep_bayanat_mapping','hdr_id','=','ep_bayanat_mapping.id')
            ->where('ayid',config('id_active_academic_year'))
            ->where('tid',config('id_active_term'))
            ->where('ep_bayanat_mapping.pid',$request->guru)
            ->where('ccid',$request->kelas)
            ->join('aa_person','ep_bayanat_mapping_dtl.pid','=','aa_person.id')
            ->join('aa_student','aa_student.pid','=','aa_person.id')
            ->select('aa_person.name','aa_person.id','aa_student.nis')
            ->orderBy('aa_person.name')
            ->get();
        $pelajaran = BayanatWeight::get();
        $array += array('alldata'=>$rombel,'bobot'=>$pelajaran);

        $namafile = 'Halqah_'.str_replace(' ','_',$guru->name).'_'.str_replace('.','',str_replace(' ','_',$kelas->name)).'.xls';
        $namaview = 'halaman.bayanat-halaqah-export';
        header('Content-Type: application/xls');
        header("Content-Disposition: attachment; filename=\"$namafile\"");
        echo view($namaview,$array);
    }

    public function kompetensidasar(Request $request)
    {
        $data  = SubjectDiknas::select('ep_subject_diknas_basic.id','ep_subject_diknas.name','subject_diknas_id','level','core_competence','basic_competence','sub_basic_competence','desc')
                ->join('ep_subject_diknas_basic','subject_diknas_id','=','ep_subject_diknas.id', 'right outer')
                ->where('level',$request->id)
                ->where('subject_diknas_id',$request->subject);
                if($request->isi == '')
                {
                    $data = $data->limit(1);
                }
                $data = $data->get()->toArray();
        if(!$data || $request->isi == '') {
            $data[0]['name'] = SubjectDiknas::select('name')->where('id',$request->subject)->first(['name'])->name;
            $data[0]['level'] = $request->id;
            $data[0]['subject_diknas_id'] = $request->subject;
            $data[0]['core_competence'] = '';
            $data[0]['basic_competence'] = '';
            $data[0]['sub_basic_competence'] = '';
            $data[0]['desc'] = '';
        }
        $array = array('alldata'=>$data);
        $namafile = str_replace('-','_',str_replace("'",'','Kompetensi_Dasar_'.str_replace('.','',str_replace(' ','_',$data[0]['name'])).'_Level_'.str_replace(' ','_',$data[0]['level']).'.xls'));
        $namaview = 'halaman.diknas-template-export';
        header('Content-Type: application/xls');
        header("Content-Disposition: attachment; filename=\"$namafile\"");
        echo view($namaview,$array);
    }

    public function rekap_uts(Request $request)
    {
        $array = array('type'=>'rekap-uts');
        $kelas = CourseClass::where('id',$request->id)->first();
        $thajar= AcademicYear::where('id',config('id_active_academic_year'))->first();
        $term  = RfTerm::where('id',config('id_active_term'))->first();

        $mapel = CourseSubject::select('ep_course_subject.subject_id', 'ep_subject.name')
                ->join('ep_course_class','ep_course_subject.level','=','ep_course_class.level')
                ->join('ep_subject','ep_course_subject.subject_id','=','ep_subject.id')
                ->where('ep_course_class.id',$kelas->id)
                ->where('ayid',config('id_active_academic_year'))
                ->where('tid',config('id_active_term'))
                ->orderBy('seq')
                ->get();

        $siswa = CourseClassDtl::select('ep_course_class_dtl.sid', 'nis', 'aa_person.name', 'aa_person.name_ar', 'rf_level_class.desc_ar', 'ep_course_class.name_ar AS class_name_ar', 'sex')
                ->join('ep_course_class','ep_course_class_dtl.ccid','=','ep_course_class.id')
                ->join('aa_student','aa_student.id','=','sid')
                ->join('aa_person','aa_person.id','=','aa_student.pid')
                ->join('rf_level_class','ep_course_class.level','=','rf_level_class.level')
                ->where('ep_course_class.id',$kelas->id)
                ->where('ayid',config('id_active_academic_year'))
                ->orderBy('aa_person.name')
                ->get();

        $sid = collect($siswa)->pluck('sid')->toArray();

        $nilai = FinalGradeDtl::whereIn('ep_final_grade_dtl.sid',$sid)
                ->join('aa_student','aa_student.id','=','ep_final_grade_dtl.sid')
                ->join('aa_person','aa_person.id','=','aa_student.pid')
                ->where('ep_final_grade_dtl.ccid',$kelas->id)
                ->where('ayid',config('id_active_academic_year'))
                ->where('tid',config('id_active_term'))
                ->where('format_code','3')
                ->orderBy('aa_person.name')
                ->get();

        $array += array('siswa'=>$siswa,'mapel'=>$mapel,'nilai'=>$nilai);

        $namafile = 'Rekap_Raport_PTS_'.str_replace(' ','_',$kelas->name).'_'.$term->desc_ar.'_'.str_replace("/","-",$thajar->name).'.xls';
        $namaview = 'halaman.raport-rekap-uts-export';
        header('Content-Type: application/xls');
        header('Content-Disposition: attachment; filename='.$namafile);
        echo view($namaview,$array);
    }

    public function rekap_uas(Request $request)
    {
        $array = array('type'=>'rekap-uas');
        $kelas = CourseClass::where('id',$request->id)->first();
        $thajar= AcademicYear::where('id',config('id_active_academic_year'))->first();
        $term  = RfTerm::where('id',config('id_active_term'))->first();

        $mapel = CourseSubject::select('ep_course_subject.subject_id', 'ep_subject.name','week_duration')
                ->join('ep_course_class','ep_course_subject.level','=','ep_course_class.level')
                ->join('ep_subject','ep_course_subject.subject_id','=','ep_subject.id')
                ->where('ep_course_class.id',$kelas->id)
                ->where('ayid',config('id_active_academic_year'))
                ->where('tid',config('id_active_term'))
                ->orderBy('seq')
                ->get();

        $siswa = CourseClassDtl::select('ep_course_class_dtl.sid', 'nis', 'aa_person.name', 'aa_person.name_ar', 'rf_level_class.desc_ar', 'ep_course_class.name_ar AS class_name_ar', 'sex')
                ->join('ep_course_class','ep_course_class_dtl.ccid','=','ep_course_class.id')
                ->join('aa_student','aa_student.id','=','sid')
                ->join('aa_person','aa_person.id','=','aa_student.pid')
                ->join('rf_level_class','ep_course_class.level','=','rf_level_class.level')
                ->where('ep_course_class.id',$kelas->id)
                ->where('ayid',config('id_active_academic_year'))
                ->orderBy('aa_person.name')
                ->get();

        $sid = collect($siswa)->pluck('sid')->toArray();

        $nilai = FinalGradeDtl::whereIn('ep_final_grade_dtl.sid',$sid)
                ->join('aa_student','aa_student.id','=','ep_final_grade_dtl.sid')
                ->join('aa_person','aa_person.id','=','aa_student.pid')
                ->where('ep_final_grade_dtl.ccid',$kelas->id)
                ->where('ayid',config('id_active_academic_year'))
                ->where('tid',config('id_active_term'))
                ->where('format_code','0')
                ->orderBy('aa_person.name')
                ->get();

        $array += array('siswa'=>$siswa,'mapel'=>$mapel,'nilai'=>$nilai);

        $namafile = 'Rekap_Raport_UAS_'.str_replace(' ','_',$kelas->name).'_'.$term->desc_ar.'_'.str_replace("/","-",$thajar->name).'.xls';
        $namaview = 'halaman.raport-rekap-uas-export';
        header('Content-Type: application/xls');
        header('Content-Disposition: attachment; filename='.$namafile);
        echo view($namaview,$array);
    }

    public function rekap_total(Request $request)
    {
        $array = array('type'=>'rekap-total');
        $kelas = CourseClass::where('id',$request->id)->first();
        $thajar= AcademicYear::where('id',config('id_active_academic_year'))->first();
        $term  = RfTerm::where('id',config('id_active_term'))->first();

        $mapel = CourseSubject::select('ep_course_subject.subject_id', 'ep_subject.name','week_duration')
                ->join('ep_course_class','ep_course_subject.level','=','ep_course_class.level')
                ->join('ep_subject','ep_course_subject.subject_id','=','ep_subject.id')
                ->where('ep_course_class.id',$kelas->id)
                ->where('ayid',config('id_active_academic_year'))
                ->where('tid',config('id_active_term'))
                ->orderBy('seq')
                ->get();

        $siswa = CourseClassDtl::select('ep_course_class_dtl.sid', 'nis', 'aa_person.name', 'aa_person.name_ar', 'rf_level_class.desc_ar', 'ep_course_class.name_ar AS class_name_ar', 'sex')
                ->join('ep_course_class','ep_course_class_dtl.ccid','=','ep_course_class.id')
                ->join('aa_student','aa_student.id','=','sid')
                ->join('aa_person','aa_person.id','=','aa_student.pid')
                ->join('rf_level_class','ep_course_class.level','=','rf_level_class.level')
                ->where('ep_course_class.id',$kelas->id)
                ->where('ayid',config('id_active_academic_year'))
                ->orderBy('aa_person.name')
                ->get();

        $sid = collect($siswa)->pluck('sid')->toArray();

        $nilai = FinalGradeDtl::whereIn('ep_final_grade_dtl.sid',$sid)
                ->join('aa_student','aa_student.id','=','ep_final_grade_dtl.sid')
                ->join('aa_person','aa_person.id','=','aa_student.pid')
                ->where('ep_final_grade_dtl.ccid',$kelas->id)
                ->where('ayid',config('id_active_academic_year'))
                ->where('tid',config('id_active_term'))
                ->where('format_code','0')
                ->orderBy('aa_person.name')
                ->get();

        $finals = FinalGrade::whereIn('sid',$sid)
                ->where('ccid',$kelas->id)
                ->where('ayid',config('id_active_academic_year'))
                ->where('tid',config('id_active_term'))
                ->where('format_code','0')
                ->get();

        $array += array('siswa'=>$siswa,'mapel'=>$mapel,'nilai'=>$nilai,'finals'=>$finals);

        $namafile = 'Rekap_Raport_TOTAL_'.str_replace(' ','_',$kelas->name).'_'.$term->desc_ar.'_'.str_replace("/","-",$thajar->name).'.xls';
        $namaview = 'halaman.raport-rekap-total-export';
        header('Content-Type: application/xls');
        header('Content-Disposition: attachment; filename='.$namafile);
        echo view($namaview,$array);
    }

    public function rekap_pengasuhan(Request $request)
    {
        $array = array('type'=>'rekap-pengasuhan');
        $thajar= AcademicYear::where('id',config('id_active_academic_year'))->first();
        $term  = RfTerm::where('id',config('id_active_term'))->first();
        $employe = Employe::select('name')
                ->join('aa_person AS ps','pid','=','ps.id')
                ->where('aa_employe.id',$request->id)->first();
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
                ->where('eid',$request->id)
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

        $array += array('ms'=>$employe,'thajar'=>$thajar,'term'=>$term, 'finalboardingdtl'=>$finalboardingdtl);
        $namafile = 'Rekap_Raport_Pengasuhan_'.str_replace([',', '.', ' ', '*'],'_',$employe->name).'_'.str_replace("/","-",$thajar->name).'_'.$term->desc.'.xls';
        $namaview = 'halaman.raport-rekap-pengasuhan-export';
        header('Content-Type: application/xls');
        header('Content-Disposition: attachment; filename='.$namafile);
        echo view($namaview,$array);
    }
}
