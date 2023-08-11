<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\AcademicYear;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\SmartSystem\WpLibrary;
use App\Models\MsUpload;
use App\SmartSystem\General;
use App\Models\Address;
use App\Models\Student;
use App\Models\CourseClassDtl;
use App\Models\Homeroom;
use App\Models\BoardingGroup;
use App\Models\BoardingActivity;
use App\Models\BoardingActivityGroup;
use App\Models\BayanatMapping;
use App\Models\FinalGrade;
use App\Models\FinalGradeDtl;
use App\Models\CourseSubject;
use App\Models\Gpa;
use App\Models\MsJobs;
use App\Models\MsNotif;
use App\Models\BayanatResult;
use App\Models\BayanatResultDtl;
use App\Models\MedicalRecord;
use App\Models\Achievement;
use App\Models\Punishment;
use App\Models\Counselling;
use App\Models\SubjectDiknasMapping;
use App\Models\TahfidzResult;
use Carbon\Carbon;

class HomeController extends Controller
{
    protected $aktif, $judul, $profil;
    public function __construct()
    {
        $this->aktif = 'home';
        $this->judul = 'Dashboard';
        if(!Auth::check())
        {
            Redirect('login');
        }
    }
    public function index()
    {
        $page = 'mobile.halaman.home';
        $data = array();
        $data['aktif'] = $this->aktif;
        $data['judul'] = $this->judul;
        $data['menufooter'] = '0';
        $data += General::getProfil();
        return view($page,$data);
    }

    public function profil()
    {
        $page = 'mobile.halaman.profil';
        $data = array();
        $data += General::getProfil();
        $data['aktif'] = $this->aktif;
        $data['judul'] = 'Profil Anda';
        $data['menufooter'] = '0';
        $alamat = Address::where('pid',config('profil')['person']->id)->first();
        $data['jobs'] = MsJobs::get();
        $data['alamat'] = $alamat;
        $data['provinces'] = \Indonesia::allProvinces();
        $data['city'] = (empty($alamat)||($alamat['province']=='0'||$alamat['province']=='')) ? array() : \Indonesia::findProvince($data['alamat']['province'], ['cities'])->cities->pluck('name', 'id');
        $data['district'] = (empty($alamat)||($alamat['city']=='0'||$alamat['city']=='')) ? array() : \Indonesia::findCity($data['alamat']['city'], ['districts'])->districts->pluck('name', 'id');
        $data['village'] = (empty($alamat)||($alamat['district']=='0'||$alamat['district']=='')) ? array() : \Indonesia::findDistrict($data['alamat']['district'], ['villages'])->villages->pluck('name', 'id');
        $data['jobs'] = MsJobs::get();
        $data['jobs'] = MsJobs::orderBy('name','desc')->get();
        $data['ayah'] = ($data['person']['ayah_id']!='') ? Person::where('id', $data['person']['ayah_id'])->first() : array();
        $data['ibu'] = ($data['person']['ibu_id']!='') ? Person::where('id',$data['person']['ibu_id'])->first() : array();
        $data['wali'] = ($data['person']['wali_id']!='') ? Person::where('id',$data['person']['wali_id'])->first() : array();
        $data['alamat_ayah'] = ($data['person']['ayah_id']!=''&&$data['person']['ayah_id']!='0') ? Address::where('pid',$data['ayah']['id'])->where('type','person')->first() : array();

        return view($page,$data);
    }
    public function akademik()
    {
        $page = 'mobile.halaman.akademik';
        $data = array();
        $data['aktif'] = $this->aktif;
        $data['judul'] = 'Nilai Akademik';
        $data['menufooter'] = '0';
        $data += General::getProfil();
        $data['nilaiakademik'] = FinalGrade::where('format_code','0')
            ->where('sid',$data['detail']->id)
            ->join('ep_course_class','ccid','=','ep_course_class.id')
            ->select('ep_final_grade.*','ep_course_class.name','ep_course_class.level')
            ->get();
        $data['nilaiakademikdetail'] = FinalGradeDtl::where('sid',$data['detail']->id)
            ->where('format_code','0')
            ->join('ep_subject','subject_id','=','ep_subject.id')
            ->join('ep_course_class','ccid','=','ep_course_class.id')
            ->select('ep_final_grade_dtl.*','ep_subject.name as namapelajaran','ep_subject.name_ar','ep_course_class.name','ep_course_class.level')
            ->orderBy('subject_seq_no')
            ->get();
        $data['gpa'] = Gpa::where('sid',$data['detail']->id)
            ->join('aa_academic_year','aa_academic_year.id','=','ayid')
            ->orderBy('aa_academic_year.name')->orderBy('tid')
            ->get();
        $thn_ajar_orang = collect($data['nilaiakademik'])->pluck('ayid')->toArray();
        $data['thn_ajar_orang'] = array_unique($thn_ajar_orang);
        $data['thn_ajar'] = AcademicYear::orderBy('name')->whereIn('id',$data['thn_ajar_orang'])->get()->toArray();
        $data['matapelajarandetail'] = CourseSubject::whereIn('ayid',$data['thn_ajar_orang'])->get()->toArray();
        return view($page,$data);
    }
    public function pengasuhan()
    {
        $page = 'mobile.halaman.pengasuhan';
        $data = array();
        $data['aktif'] = $this->aktif;
        $data['judul'] = 'Nilai Pengasuhan';
        $data['menufooter'] = '0';
        $data += General::getProfil();
        $data['group'] = BoardingActivityGroup::orderBy('seq')->get();
        $data['data'] = BoardingActivity::orderBy('seq')->get();
        $data['finalboardingdtl'] = FinalGradeDtl::select('subject_id','final_grade','letter_grade','ayid','tid')
                ->where('sid',$data['detail']->id)
                ->where('format_code',"1")
                ->join('ep_boarding_activity','subject_id','=','ep_boarding_activity.id')
                ->orderBy('subject_seq_no')
                ->get();
        $thn_ajar_orang = collect($data['finalboardingdtl'])->pluck('ayid')->toArray();
        $data['thn_ajar_orang'] = array_unique($thn_ajar_orang);
        $data['thn_ajar'] = AcademicYear::orderBy('name')->whereIn('id',$data['thn_ajar_orang'])->get()->toArray();
        return view($page,$data);
    }
    public function pencapaian()
    {
        $page = 'mobile.halaman.pencapaian';
        $data = array();
        $data['aktif'] = $this->aktif;
        $data['judul'] = 'Pencapaian Diri';
        $data['menufooter'] = '0';
        $data += General::getProfil();
        $data['pencapaian'] = [
            ['name'=>'Prestasi'],
            ['name'=>'Pelanggaran'],
            ['name'=>'Riwayat Kesehatan'],
            ['name'=>'Bimbingan Konseling'],
        ];
        $ac = new Achievement();
        $data['prestasi'] = $ac->getFromPerson($data['person']->id);

        $pu = new Punishment();
        $data['levelpelanggaran'] = ['D9CE3F','E83A14','890F0D','630606'];
        $data['pelanggaran'] = $pu->getFromPerson($data['person']->id);

        $rc = new MedicalRecord();
        $data['kesehatan'] = $rc->getFromPerson($data['person']->id);

        $cl = new Counselling();
        $data['konseling'] = $cl->getFromPerson($data['person']->id);

        return view($page,$data);
    }
    public function alquran()
    {
        $page = 'mobile.halaman.alquran';
        $data = array();
        $data['aktif'] = $this->aktif;
        $data['judul'] = 'Pencapaian Diri';
        $data['menufooter'] = '0';
        $data += General::getProfil();
        $data['alquran'] = BayanatResult::getFromPerson(array($data['person']->id));
        $data['alqurandtl'] = BayanatResultDtl::getResultDtl($data['person']->id);
        $data['thn_ajar_orang'] = collect($data['alqurandtl'])->unique('ayid')->pluck('ayid')->toArray();
        $data['thn_ajar'] = AcademicYear::orderBy('name')->whereIn('id',$data['thn_ajar_orang'])->get()->toArray();

        return view($page,$data);
    }

    public function diknas(Request $request)
    {
        $page = 'mobile.halaman.diknas';
        $data = array();
        $data['aktif'] = $this->aktif;
        $data['judul'] = 'Nilai Diknas';
        $data['menufooter'] = '0';
        $data += General::getProfil();
        $data['nilaidiknas'] = FinalGrade::where('format_code','2')
            ->where('sid',$data['detail']->id)
            ->join('ep_course_class','ccid','=','ep_course_class.id')
            ->select('ep_course_class.level','ep_final_grade.ayid','ep_final_grade.tid','format_code')
            ->get();
        $data['nilaidiknasdetail'] = FinalGradeDtl::where('sid',$data['detail']->id)
            ->where('format_code','2')
            ->join('ep_subject_diknas','subject_id','=','ep_subject_diknas.id')
            ->join('ep_course_class','ccid','=','ep_course_class.id')
            ->select('ep_final_grade_dtl.ayid','ep_final_grade_dtl.tid','ep_final_grade_dtl.subject_id','final_grade','ep_subject_diknas.name as namapelajaran','ep_course_class.name','ep_course_class.level', 'letter_grade', 'knowledge_desc', 'skill_desc')
            ->get();
        $thn_ajar_orang = collect($data['nilaidiknas'])->pluck('ayid')->toArray();
        $data['thn_ajar_orang'] = array_unique($thn_ajar_orang);
        $data['thn_ajar'] = AcademicYear::orderBy('name')->whereIn('id',$data['thn_ajar_orang'])->get()->toArray();
        $data['matapelajarandetail'] = SubjectDiknasMapping::whereIn('ayid',$data['thn_ajar_orang'])->get()->toArray();

        return view($page,$data);
    }

    public function notifikasi(Request $request)
    {
        $page = 'mobile.halaman.notifikasi';
        $data = array();
        $data['aktif'] = $this->aktif;
        $data['judul'] = $this->judul;
        $data['menufooter'] = '0';
        $data += General::getProfil();
        $data['notif'] = MsNotif::orderBy('notif_datetime','desc')->paginate(10);

        return view($page,$data);
    }

    public function input_tahfidz()
    {
        $page = 'mobile.halaman.input-tahfidz';
        $data = array();
        $data['aktif'] = $this->aktif;
        $data['judul'] = $this->judul;
        $data['menufooter'] = '0';
        $data['dates']   = Carbon::now()->format('Y-m-d');
        $data['student'] = CourseClassDtl::where('ccid', 1)
                        ->where('ep_course_class_dtl.ayid', config('id_active_academic_year'))
                        ->join('aa_student as a', 'sid', '=', 'a.id')
                        ->join('aa_person as b', 'a.pid', '=', 'b.id')
                        ->join('ep_course_class', 'ccid', '=', 'ep_course_class.id')
                        ->select('a.id', 'b.name')
                        ->orderBy('b.name')
                        ->get();
        $data += General::getProfil();

        return view($page,$data);
    }
    public function tahfidz_exec(Request $request)
    {
        $datas = array();
        parse_str($request->data, $datas);
            $data = new TahfidzResult();
            $data['ccid'] = 1;
            $data['sid'] = 2;
            $data['ayid'] = 1;
            $data['tid'] = 1;
            $data['date'] = $datas['date'];
            $data['page'] = $datas['page'];
            $data['line'] = $datas['line'];
            $data['cby'] = auth()->user()->id;
            $data['uby'] = '0';
            $data->save();

        echo 'Berhasil';
    }
}
