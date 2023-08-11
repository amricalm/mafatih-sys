<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Student;
use App\Models\Person;
use App\Models\Address;
use App\Models\MsJobs;
use App\Models\MsConfig;
use App\Models\AcademicYear;
use App\Models\AcademicYearDetail;
use App\Models\Sibling;
use App\Models\Achievement;
use App\Models\BayanatMapping;
use App\Models\BayanatResult;
use App\Models\BayanatResultDtl;
use App\Models\CourseClass;
use App\Models\MedicalRecord;
use App\Models\School;
use App\Models\SchoolOrigin;
use App\Models\MsUpload;
use App\Models\Employe;
use App\Models\Ppdb;
use App\Models\CourseClassDtl;
use App\Models\CourseSubjectTeacher;
use App\Models\FinalGradeDtl;
use App\Models\BoardingActivityGroup;
use App\Models\BoardingActivity;
use App\Models\BoardingGroup;
use App\Models\Homeroom;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\RaportController;
use Psy\Readline\Hoa\Console;

class StudentController extends Controller
{
    var $global;
    public function __construct()
    {
        $this->global['aktif'] = 'siswa';
        $this->global['judul'] = 'Santri';
    }
    public function index(Request $request)
    {
        $app['aktif'] = $this->global['aktif'];
        $app['judul'] = "Data Siswa";
        $app['cari'] = (isset($_GET['cari'])&&$_GET['cari']!='') ? $_GET['cari'] : '';
        $app['student'] = Student::join('aa_person', 'pid', '=', 'aa_person.id')
            ->select('aa_person.id', 'aa_student.nis', 'aa_student.nisn', 'name', 'name_ar');
        $app['student'] = ($app['cari']!='') ? $app['student']->where('aa_person.name','LIKE','%'.$app['cari'].'%')->paginate(config('paging')) : $app['student']->paginate(config('paging'));
        $app['foto'] = MsUpload::get();
        $app['kelas'] = CourseClass::get();

        return view('halaman.student', $app);
    }

    public function new()
    {
        $app['aktif'] = $this->global['aktif'];
        $app['judul'] = "Tambah ".$this->global['judul'];
        $app['provinces'] = \Indonesia::allProvinces();
        $app['jobs'] = MsJobs::orderBy('name', 'desc')->get();

        return view('halaman.student-new', $app);
    }

    public function save(Request $request)
    {
        $person = Person::create([
            'name' => $request->name,
            'nickname' => $request->nickname,
            'name_ar' => $request->name_ar,
            'kk' => $request->kk,
            'nik' => $request->nik,
            'aktalahir' => $request->aktalahir,
            'pob' => $request->pob,
            'dob' => $request->dob,
            'sex' => $request->sex,
            'son_order' => $request->son_order,
            'siblings' => $request->siblings,
            'stepbros' => $request->stepbros,
            'adoptives' => $request->adoptives,
            'citizen' => $request->citizen,
            'religion' => $request->religion,
            'languages' => $request->languages,
            'user_id' => auth()->user()->id,
            'cby' => auth()->user()->id,
            'uby' => '0'
        ]);

        $id = $person->id;


        $alamat = Address::create([
            'pid' => $id,
            'type' => 'person',
            'address' => $request->alamat,
            'province' => $request->provinsi,
            'city' => $request->kota,
            'district' => $request->kecamatan,
            'village' => $request->desa,
            'post_code' => $request->post,
            'cby' => auth()->user()->id,
            'uby' => '0'
        ]);

        $student = Student::create([
            'pid' => $id,
            'nis' => $request->nis,
            'nisn' => $request->nisn,
            'cby' => auth()->user()->id,
            'uby' => '0'
        ]);

        return redirect('siswa/'.$id.'/edit')->with('success', 'Simpan data Berhasil');
    }
    public function show(Request $request)
    {
        $app = array();
        $app['aktif'] = $this->global['aktif'];
        $app['judul'] = 'Edit '.$this->global['judul'];
        $app['id'] = $request->id;
        $app['student'] = Student::where('pid',$app['id'])->first();
        $app['kelas'] = CourseClassDtl::getClassFromStudent($request->id)[0] ?? '';
        $app['walikelas'] = isset($app['kelas']['ccid']) ? Homeroom::getFromClass($app['kelas']['ccid']) : '';
        $app['pengasuhan'] = BoardingGroup::getFromBoarding($app['student']['id']);
        $app['bayanat'] = BayanatMapping::getFromPerson($request->id);
        $app['person'] = Person::where('id', $request->id)->first();
        $app['origin'] = SchoolOrigin::where('pid', $request->id)->first();
        $app['student'] = Student::where('pid',$request->id)->first();
        $app['files'] = MsUpload::where('pid',$request->id)->get();
        $alamat = Address::where('pid',$request->id)->where('type','person')->first();
        $app['alamat'] = (!empty($alamat)) ? $alamat : array('address'=>'','province'=>'','city'=>'','district'=>'','village'=>'','post_code'=>'');
        $app['jobs'] = MsJobs::orderBy('name','desc')->get();
        $app['ayah'] = ($app['person']['ayah_id']!='') ? Person::where('id', $app['person']['ayah_id'])->first() : array();
        $app['ibu'] = ($app['person']['ibu_id']!='') ? Person::where('id',$app['person']['ibu_id'])->first() : array();
        $app['wali'] = ($app['person']['wali_id']!='') ? Person::where('id',$app['person']['wali_id'])->first() : array();
        $app['alamat_ayah'] = ($app['person']['ayah_id']!=''&&$app['person']['ayah_id']!='0') ? Address::where('pid',$app['ayah']['id'])->where('type','person')->first() : array();
        $app['provinces'] = \Indonesia::allProvinces();
        $app['city'] = (empty($alamat)||($alamat['province']=='0'||$alamat['province']=='')) ? array() : \Indonesia::findProvince($app['alamat']['province'], ['cities'])->cities->pluck('name', 'id');
        $app['district'] = (empty($alamat)||($alamat['city']=='0'||$alamat['city']=='')) ? array() : \Indonesia::findCity($app['alamat']['city'], ['districts'])->districts->pluck('name', 'id');
        $app['village'] = (empty($alamat)||($alamat['district']=='0'||$alamat['district']=='')) ? array() : \Indonesia::findDistrict($app['alamat']['district'], ['villages'])->villages->pluck('name', 'id');
        return view('halaman.student-edit', $app);
    }

    public function view(Request $request)
    {
        $app = array();
        $app['aktif'] = $this->global['aktif'];
        $app['judul'] = 'Edit '.$this->global['judul'];
        $app['id'] = $request->id;
        $app['student'] = Student::where('pid',$app['id'])->first();
        $app['kelas'] = CourseClassDtl::getClassFromStudent($request->id)[0] ?? '';
        $app['walikelas'] = isset($app['kelas']['ccid']) ? Homeroom::getFromClass($app['kelas']['ccid']) : '';
        $app['pengasuhan'] = BoardingGroup::getFromBoarding($app['student']['id']);
        $app['bayanat'] = BayanatMapping::getFromPerson($request->id);
        $app['person'] = Person::where('id', $request->id)->first();
        $app['origin'] = SchoolOrigin::where('pid', $request->id)->first();
        $app['student'] = Student::where('pid',$request->id)->first();
        $app['files'] = MsUpload::where('pid',$request->id)->get();
        $alamat = Address::where('pid',$request->id)->where('type','person')->first();
        $app['alamat'] = (!empty($alamat)) ? $alamat : array('address'=>'','province'=>'','city'=>'','district'=>'','village'=>'','post_code'=>'');
        $app['jobs'] = MsJobs::orderBy('name','desc')->get();
        $app['ayah'] = ($app['person']['ayah_id']!='') ? Person::where('id', $app['person']['ayah_id'])->first() : array();
        $app['ibu'] = ($app['person']['ibu_id']!='') ? Person::where('id',$app['person']['ibu_id'])->first() : array();
        $app['wali'] = ($app['person']['wali_id']!='') ? Person::where('id',$app['person']['wali_id'])->first() : array();
        $app['alamat_ayah'] = ($app['person']['ayah_id']!=''&&$app['person']['ayah_id']!='0') ? Address::where('pid',$app['ayah']['id'])->where('type','person')->first() : array();
        $app['provinces'] = \Indonesia::allProvinces();
        $app['city'] = (empty($alamat)||($alamat['province']=='0'||$alamat['province']=='')) ? array() : \Indonesia::findProvince($app['alamat']['province'], ['cities'])->cities->pluck('name', 'id');
        $app['district'] = (empty($alamat)||($alamat['city']=='0'||$alamat['city']=='')) ? array() : \Indonesia::findCity($app['alamat']['city'], ['districts'])->districts->pluck('name', 'id');
        $app['village'] = (empty($alamat)||($alamat['district']=='0'||$alamat['district']=='')) ? array() : \Indonesia::findDistrict($app['alamat']['district'], ['villages'])->villages->pluck('name', 'id');
        return view('halaman.student-view', $app);
    }

    public function getOne(Request $request)
    {
        $app = array();
        $app['aktif'] = $this->global['aktif'];
        $app['judul'] = 'Edit '.$this->global['judul'];
        $app['id'] = $request->id;
        $app['student'] = Student::where('pid',$app['id'])->first();
        $app['kelas'] = CourseClassDtl::getClassFromStudent($request->id)[0];
        $app['walikelas'] = Homeroom::getFromClass($app['kelas']['ccid']);
        $app['pengasuhan'] = BoardingGroup::getFromBoarding($app['student']['id']);
        $app['bayanat'] = BayanatMapping::getFromPerson($request->id)[0];
        $app['person'] = Person::where('id', $request->id)->first();
        $app['origin'] = SchoolOrigin::where('pid', $request->id)->first();
        $app['student'] = Student::where('pid',$request->id)->first();
        $app['files'] = MsUpload::where('pid',$request->id)->get();
        $alamat = Address::where('pid',$request->id)->where('type','person')->first();
        $app['alamat'] = (!empty($alamat)) ? $alamat : array('address'=>'','province'=>'','city'=>'','district'=>'','village'=>'','post_code'=>'');
        $app['jobs'] = MsJobs::orderBy('name','desc')->get();
        $app['ayah'] = ($app['person']['ayah_id']!='') ? Person::where('id', $app['person']['ayah_id'])->first() : array();
        $app['ibu'] = ($app['person']['ibu_id']!='') ? Person::where('id',$app['person']['ibu_id'])->first() : array();
        $app['wali'] = ($app['person']['wali_id']!='') ? Person::where('id',$app['person']['wali_id'])->first() : array();
        $app['alamat_ayah'] = ($app['person']['ayah_id']!=''&&$app['person']['ayah_id']!='0') ? Address::where('pid',$app['ayah']['id'])->where('type','person')->first() : array();
        $app['provinces'] = \Indonesia::allProvinces();
        $app['city'] = (empty($alamat)||($alamat['province']=='0'||$alamat['province']=='')) ? array() : \Indonesia::findProvince($app['alamat']['province'], ['cities'])->cities->pluck('name', 'id');
        $app['district'] = (empty($alamat)||($alamat['city']=='0'||$alamat['city']=='')) ? array() : \Indonesia::findCity($app['alamat']['city'], ['districts'])->districts->pluck('name', 'id');
        $app['village'] = (empty($alamat)||($alamat['district']=='0'||$alamat['district']=='')) ? array() : \Indonesia::findDistrict($app['alamat']['district'], ['villages'])->villages->pluck('name', 'id');
        return view('halaman.student-show', $app);
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        Person::where('id',$id)->delete();
        Student::where('pid',$id)->delete();
        Address::where('pid',$id)->where('type','person')->delete();
        Sibling::where('pid',$id)->delete();
        Achievement::where('pid',$id)->delete();
        MedicalRecord::where('pid',$id)->delete();
        return redirect('siswa')->with('success','Berhasil dihapus!');
    }
    public function update(Request $request)
    {
        $datas = array();
        parse_str($request->data, $datas);
        switch ($_GET['step']) {
            case '1':
                // PERSON
                $person = Person::find($datas['pid']);
                $person->name = $datas['name'];
                $person->nickname = $datas['nickname'];
                $person->name_ar = $datas['name_ar'];
                $person->kk = $datas['kk'];
                $person->nik = $datas['nik'];
                $person->aktalahir = $datas['aktalahir'];
                $person->pob = $datas['pob'];
                $person->dob = $datas['dob'];
                $person->sex = $datas['sex'];
                $person->son_order = !empty($datas['son_order']) ? $datas['son_order'] : 0;
                $person->siblings = $datas['siblings'];
                $person->stepbros = $datas['stepbros'];
                $person->adoptives = $datas['adoptives'];
                $person->citizen = $datas['citizen'];
                $person->stepbros = $datas['stepbros'];
                $person->adoptives = $datas['adoptives'];
                $person->citizen = $datas['citizen'];
                $person->religion = $datas['religion'];
                $person->languages = $datas['languages'];
                $person->user_id = auth()->user()->id;
                $person->uby = auth()->user()->id;
                $person->save();

                Student::where('id',$datas['student_id'])
                    ->where('pid',$datas['pid'])
                    ->update([
                        'nis' => $datas['nis'],
                        'nisn' => $datas['nisn'],
                    ]);



                Address::where('pid',$datas['pid'])
                    ->where('type','person')
                    ->update([
                        'address' => $datas['alamat'],
                        'province' => $datas['provinsi'],
                        'city' => $datas['kota'],
                        'district' => $datas['kecamatan'],
                        'village' => $datas['desa'],
                        'post_code' => $datas['post'],
                        'uby' => auth()->user()->id,
                    ]);

                echo 'Berhasil';
                break;
            case '2':
                // echo '<pre>';print_r($datas);die();
                // CARI DATA AYAH, IBU DAN WALI
                $person = Person::where('id',$datas['pid'])->first();
                $ayah_id = '';
                $ibu_id = '';
                $wali_id = '';
                // AYAH
                if($person->ayah_id=='')
                {
                    $ayah = new Person();
                    $ayah['nik'] = $datas['ayah_nik'];
                    $ayah['name'] = $datas['ayah_nama'];
                    $ayah['pob'] = $datas['ayah_pob'];
                    if($datas['ayah_dob']) {
                        $ayah['dob'] = $datas['ayah_dob'];
                    }
                    $ayah['sex'] = 'L';
                    // $ayah['age'] = ($datas['ayah_age']!='') ? $datas['ayah_age'] : '0';
                    $ayah['last_education'] = $datas['ayah_last_education'];
                    $ayah['job'] = ($datas['ayah_job']!='') ? $datas['ayah_job'] : '0';
                    $ayah['income'] = ($datas['ayah_income']!='') ? $datas['ayah_income'] : '0';
                    $ayah['languages'] = $datas['ayah_languages'];
                    $ayah['citizen'] = $datas['ayah_citizen'];
                    $ayah['cby'] = auth()->user()->id;
                    $ayah['uby'] = '0';
                    $ayah->save();

                    $ayah_id = $ayah->id;
                }
                else
                {
                    $dataayah = [];
                    $dataayah['nik'] = $datas['ayah_nik'];
                    $dataayah['name'] = $datas['ayah_nama'];
                    $dataayah['pob'] = $datas['ayah_pob'];
                    if($datas['ayah_dob']) {
                        $dataayah['dob'] = $datas['ayah_dob'];
                    }
                    $dataayah['sex'] = 'L';
                    // $dataayah['age'] = ($datas['ayah_age']!='') ? $datas['ayah_age'] : '0';
                    $dataayah['last_education'] = $datas['ayah_last_education'];
                    $dataayah['job'] = ($datas['ayah_job']!='') ? $datas['ayah_job'] : '0';
                    $dataayah['income'] = ($datas['ayah_income']!='') ? $datas['ayah_income'] : '0';
                    $dataayah['languages'] = $datas['ayah_languages'];
                    $dataayah['citizen'] = $datas['ayah_citizen'];
                    $dataayah['uby'] = auth()->user()->id;
                    $ayah = Person::where('id',$person->ayah_id)
                        ->update($dataayah);

                    $ayah_id = $person->ayah_id;
                }

                // IBU
                if($person->ibu_id=='')
                {
                    $ibu = new Person();
                    $ibu['nik'] = $datas['ibu_nik'];
                    $ibu['name'] = $datas['ibu_nama'];
                    $ibu['pob'] = $datas['ibu_pob'];
                    if($datas['ibu_dob']) {
                        $ibu['dob'] = $datas['ibu_dob'];
                    }
                    $ibu['sex'] = 'P';
                    // $ibu['age'] = ($datas['ibu_age']!='') ? $datas['ibu_age'] : '0';
                    $ibu['last_education'] = $datas['ibu_last_education'];
                    $ibu['job'] = ($datas['ibu_job']!='') ? $datas['ibu_job'] : '0';
                    $ibu['income'] = ($datas['ibu_income']!='') ? $datas['ibu_income'] : '0';
                    $ibu['languages'] = $datas['ibu_languages'];
                    $ibu['citizen'] = $datas['ibu_citizen'];
                    $ibu['cby'] = auth()->user()->id;
                    $ibu['uby'] = '0';
                    $ibu->save();

                    $ibu_id = $ibu->id;
                }
                else
                {
                    $dataibu = [];
                    $dataibu['nik'] = $datas['ibu_nik'];
                    $dataibu['name'] = $datas['ibu_nama'];
                    $dataibu['pob'] = $datas['ibu_pob'];
                    if($datas['ibu_dob']) {
                        $dataibu['dob'] = $datas['ibu_dob'];
                    }
                    $dataibu['sex'] = 'P';
                    // $dataibu['age'] = ($datas['ibu_age']!='') ? $datas['ibu_age'] : '0';
                    $dataibu['last_education'] = $datas['ibu_last_education'];
                    $dataibu['job'] = ($datas['ibu_job']!='') ? $datas['ibu_job'] : '0';
                    $dataibu['income'] = ($datas['ibu_income']!='') ? $datas['ibu_income'] : '0';
                    $dataibu['languages'] = $datas['ibu_languages'];
                    $dataibu['citizen'] = $datas['ibu_citizen'];
                    $dataibu['uby'] = auth()->user()->id;
                    $ibu = Person::where('id',$person->ibu_id)
                        ->update($dataibu);
                    $ibu_id = $person->ibu_id;
                }

                // WALI
                if(isset($datas['stay_with_wali'])) {
                    if($person->wali_id=='')
                    {
                        $wali = new Person();
                        $wali['nik'] = $datas['wali_nik'];
                        $wali['name'] = $datas['wali_nama'];
                        $wali['pob'] = $datas['wali_pob'];
                        if($datas['wali_dob']) {
                            $wali['dob'] = $datas['wali_dob'];
                        }
                        $wali['sex'] = 'L';
                        // $wali['age'] = ($datas['wali_age']!='') ? $datas['wali_age'] : '0';
                        $wali['last_education'] = $datas['wali_last_education'];
                        $wali['job'] = ($datas['wali_job']!='') ? $datas['wali_job'] : '0';
                        $wali['income'] = ($datas['wali_income']!='') ? $datas['wali_income'] : '0';
                        $wali['languages'] = $datas['wali_languages'];
                        $wali['citizen'] = $datas['wali_citizen'];
                        $wali['relation'] = $datas['wali_relation'];
                        $wali['cby'] = auth()->user()->id;
                        $wali['uby'] = '0';
                        $wali->save();

                        $wali_id = $wali->id;
                    }
                    else
                    {
                        $datawali = [];
                        $datawali['nik'] = $datas['wali_nik'];
                        $datawali['name'] = $datas['wali_nama'];
                        $datawali['pob'] = $datas['wali_pob'];
                        if($datas['wali_dob']) {
                            $datawali['dob'] = $datas['wali_dob'];
                        }
                        $datawali['sex'] = 'L';
                        // $datawali['age'] = ($datas['wali_age']!='') ? $datas['wali_age'] : '0';
                        $datawali['last_education'] = $datas['wali_last_education'];
                        $datawali['job'] = ($datas['wali_job']!='') ? $datas['wali_job'] : '0';
                        $datawali['income'] = ($datas['wali_income']!='') ? $datas['wali_income'] : '0';
                        $datawali['languages'] = $datas['wali_languages'];
                        $datawali['citizen'] = $datas['wali_citizen'];
                        $datawali['relation'] = $datas['wali_relation'];
                        $datawali['uby'] = auth()->user()->id;
                        $wali = Person::where('id',$person->wali_id)
                            ->update($datawali);

                        $wali_id = $person->wali_id;
                    }
                } else {
                    if(!empty($person->wali_id)) {
                        Person::where('id',$person->wali_id)->delete();
                    }
                }


                // PERSON
                $datas['stay_with_parent'] = isset($datas['stay_with_parent']) ? $datas['stay_with_parent'] : 0;
                $person = Person::find($datas['pid']);
                $person->stay_with_parent = $datas['stay_with_parent'];
                $person->ayah_id = $ayah_id;
                $person->ibu_id = $ibu_id;
                $person->wali_id = isset($datas['stay_with_wali']) ? $wali_id : 0;
                $person->save();

                // ALAMAT AYAH
                if($datas['stay_with_parent']!='1')
                {
                    $cekalamat = Address::where('pid',$ayah_id);
                    if($cekalamat->count()==0)
                    {
                        $alamat = Address::create([
                            'pid' => $ayah_id,
                            'type' => 'person',
                            'address' => $datas['ayah_alamat'],
                            'province' => $datas['ayah_provinsi'],
                            'city' => $datas['ayah_kota'],
                            'district' => $datas['ayah_kecamatan'],
                            'village' => $datas['ayah_desa'],
                            'post_code' => $datas['ayah_post'],
                            'cby' => auth()->user()->id,
                            'uby' => '0'
                        ]);
                    }
                    else
                    {
                        $idalamat = $cekalamat->first()->id;
                        $alamat = Address::where('id',$idalamat)
                            ->update([
                                'pid' => $ayah_id,
                                'address' => $datas['ayah_alamat'],
                                'province' => $datas['ayah_provinsi'],
                                'city' => $datas['ayah_kota'],
                                'district' => $datas['ayah_kecamatan'],
                                'village' => $datas['ayah_desa'],
                                'post_code' => $datas['ayah_post'],
                                'uby' => auth()->user()->id,
                        ]);
                    }
                }
                echo 'Berhasil';
                break;
            case '3':
                $saudara = Person::create([
                    'name' => $datas['saudara_nama'],
                    'age' => $datas['saudara_age'],
                    'sex' => $datas['saudara_sex'],
                    'last_education' => $datas['saudara_last_education'],
                    'job' => $datas['saudara_job'],
                    'cby' => auth()->user()->id,
                    'uby' => '0'
                ]);
                $saudaraid = $saudara->id;

                Sibling::create([
                    'pid' => $datas['pid'],
                    'sid' => $saudaraid,
                    'cby' => auth()->user()->id,
                ]);

                echo 'Berhasil';
                break;
            case '4':
                $person = Person::find($datas['pid']);
                $person->height = $datas['height'];
                $person->weight = $datas['weight'];
                $person->is_glasses = (!empty($datas['is_glasses'])) ? $datas['is_glasses'] : '0';
                $person->character = $datas['character'];
                $person->hobbies = $datas['hobbies'];
                $person->blood = $datas['blood'];
                $person->traumatic = $datas['traumatic'];
                $person->disability = $datas['disability'];
                $person->disability_type = $datas['disability_type'];
                if($datas['received_date']) {
                    $person->received_date = $datas['received_date'];
                }
                $person->email = $datas['email'];
                $person->phone = $datas['phone'];
                $person->uby = auth()->user()->id;
                $person->save();

                // PPDB
                // Ppdb::where('id',$datas['ppdb_id'])
                //     ->where('pid',$datas['pid'])
                //     ->update([
                //         'process' => '3',
                //     ]);

                echo 'Berhasil';
                break;
            case '5':
                $prestasi = new Achievement;
                $prestasi->pid = $datas['pid'];
                $prestasi->name = $datas['prestasi_name'];
                $prestasi->year = $datas['prestasi_year'];
                $prestasi->desc = $datas['prestasi_desc'];
                $prestasi->cby = auth()->user()->id;
                $prestasi->uby = '0';
                $prestasi->save();

                echo 'Berhasil';
                break;
            case '6':
                $medical = new MedicalRecord;
                $medical->pid = $datas['pid'];
                $medical->name = $datas['sakit_name'];
                $medical->year = $datas['sakit_year'];
                $medical->desc = $datas['sakit_desc'];
                $medical->cby = auth()->user()->id;
                $medical->uby = '0';
                $medical->save();

                echo 'Berhasil';
                break;
            case '7':

                $person = Person::find($datas['pid']);

                Person::where('id',$person->ayah_id)
                    ->update([
                        'building_status' => $datas['building_status'],
                        'building_area' => $datas['building_area'],
                        'surface_area' => $datas['surface_area'],
                        'electricity_bills' => $datas['electricity_bills'],
                        'water_bills' => $datas['water_bills'],
                        'telecommunication_bills' => $datas['telecommunication_bills'],
                        'electronic' => $datas['electronic'],
                        'vehicle' => $datas['vehicle'],
                        'assets' => $datas['assets'],
                        'uby' => auth()->user()->id,
                    ]);

                // PPDB
                // Ppdb::where('id',$datas['ppdb_id'])
                //     ->where('pid',$datas['pid'])
                //     ->update([
                //         'process' => '4',
                //     ]);

                echo 'Berhasil';
                break;
            case '8':
                $schoolOrigin = SchoolOrigin::where('pid',$datas['pid'])->first();
                if(empty($schoolOrigin))
                {
                    $origin = new SchoolOrigin;
                    $origin->pid = $datas['pid'];
                    $origin->school_origin = $datas['school_origin'];
                    $origin->school_origin_name = $datas['school_origin_name'];
                    $origin->diploma_number = $datas['diploma_number'];
                    if($datas['diploma_year']) {
                        $origin->diploma_year = $datas['diploma_year'];
                    }
                    $origin->exam_number = $datas['exam_number'];
                    $origin->skhu = $datas['skhu'];
                    if($datas['study_year']) {
                        $origin->study_year = $datas['study_year'];
                    }
                    $origin->school_origin_tf = $datas['school_origin_tf'];
                    if($datas['move_date']) {
                        $origin->move_date = $datas['move_date'];
                    }
                    $origin->from_class = (!empty($datas['from_class'])) ? $datas['from_class'] : '0';
                    $origin->in_class = (!empty($datas['in_class'])) ? $datas['in_class'] : '0';
                    $origin->cby = auth()->user()->id;
                    $origin->uby = 0;
                    $origin->save();
                } else {
                    $dataorigin = [];
                    $dataorigin['school_origin'] = $datas['school_origin'];
                    $dataorigin['school_origin_name'] = $datas['school_origin_name'];
                    $dataorigin['diploma_number'] = $datas['diploma_number'];
                    if($datas['diploma_year']) {
                        $dataorigin['diploma_year'] = $datas['diploma_year'];
                    }
                    $dataorigin['exam_number'] = $datas['exam_number'];
                    $dataorigin['skhu'] = $datas['skhu'];
                    if($datas['study_year']) {
                        $dataorigin['study_year'] = $datas['study_year'];
                    }
                    $dataorigin['school_origin_tf'] = $datas['school_origin_tf'];
                    if($datas['move_date']) {
                        $dataorigin['move_date'] = $datas['move_date'];
                    }
                    $dataorigin['from_class'] = (!empty($datas['from_class'])) ? $datas['from_class'] : '0';
                    $dataorigin['in_class'] = (!empty($datas['in_class'])) ? $datas['in_class'] : '0';
                    $dataorigin['uby'] = auth()->user()->id;
                    $origin = SchoolOrigin::where('pid',$datas['pid'])->update($dataorigin);
                }
                echo 'Berhasil';
                break;
            default:
                # code...
                break;
        }
    }
    public function getData(Request $request)
    {
        switch ($request->table) {
            case 'sibling':
                $sibling = Sibling::where('pid',$request->pid)->get();
                $no=0;
                foreach($sibling as $item)
                {
                    $person = Person::where('id',$item->sid)->first();
                    $job = MsJobs::where('id',$person['job'])->first();
                    $no++;
                    echo '<tr>
                    <td>'.$no.'</td>
                    <td>
                        <div class="row">
                            <div class="col-md-6">'.$person['name'].'</div>
                            <div class="col-md-3">'.(($person['sex']=='L')?'Laki-laki':'Perempuan').'</div>
                            <div class="col-md-3">'.$person['age'].' tahun</div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">Pendidikan: '.$person['last_education'].'</div>
                            <div class="col-md-5">Pekerjaan: '.((!empty($job))?$job['name']:'').'</div>
                            <div class="col-md-2 text-right"><a style="cursor:pointer;" onclick="hapussibling('.$person['id'].')"><i class="fa fa-trash"></i></a></div>
                        </div>
                    </td>
                    </tr>';
                }
                break;
            case 'achievement':
                $prestasi = Achievement::where('pid',$request->pid)->get();
                $no=0;
                foreach($prestasi as $item)
                {
                    $no++;
                    echo '<tr>
                    <td>'.$item->name.'</td>
                    <td>'.$item->year.'</td>
                    <td>'.$item->desc.'</td>
                    <td><a style="cursor:pointer;" onclick="hapusprestasi('.$item->id.')"><i class="fa fa-trash"></i></a></td>
                    </tr>';
                }
                break;
            case 'medicalrecord':
                $medicalrecord = MedicalRecord::where('pid',$request->pid)->get();
                $no=0;
                foreach($medicalrecord as $item)
                {
                    $no++;
                    echo '<tr>
                    <td>'.$item->name.'</td>
                    <td>'.$item->year.'</td>
                    <td>'.$item->desc.'</td>
                    <td><a style="cursor:pointer;" onclick="hapussakit('.$item->id.')"><i class="fa fa-trash"></i></a></td>
                    </tr>';
                }
                break;
            default:
                # code...
                break;
        }
    }
    public function hapus(Request $request)
    {
        $table = $request->table;
        switch ($table) {
            case 'sibling':
                Person::where('id',$request->id)->delete();
                Sibling::where('sid',$request->id)->delete();
                echo 'Berhasil';
                break;
            case 'prestasi':
                Achievement::where('id',$request->id)->delete();
                echo 'Berhasil';
                break;
            case 'sakit':
                MedicalRecord::where('id',$request->id)->delete();
                echo 'Berhasil';
                break;
            default:
                # code...
                break;
        }
    }
    public function hapusfile(Request $request)
    {
        $tipe = $request->tipe;
        $file = MsUpload::where('pid',$request->id)->where('desc',$tipe)->first();
        MsUpload::where('pid',$request->id)->where('desc',$tipe)->delete();
        File::delete(public_path($file['original_file']));
        echo 'Berhasil';
    }
    public function search(Request $request)
    {
        $app['aktif'] = $this->global['aktif'];
        $app['judul'] = "Cari Siswa";
        $app['nomenu'] = 'yes';
        $app['hasil'] = '';
        $app['request'] = $request;
        $app['data'] = array();
        $app['nis'] = ''; $app['tgl'] = '';
        $app['publish'] = AcademicYearDetail::where('ayid',config('id_active_academic_year'))
            ->where('tid',config('id_active_term'))
            ->first();
        if($request->post())
        {
            $app['nis'] = $request->nis;
            $app['tgl'] = $request->tgllahir;
            $student = Student::where('nis',$request->nis)
                ->join('aa_person','pid','=','aa_person.id')
                ->select('aa_student.id','aa_student.nis','aa_person.dob','aa_person.name','aa_person.name_ar','aa_student.pid')
                ->first();

            if($student==null)
            {
                $app['hasil'] = '<div class="alert alert-danger" role="alert">
                        Data tidak ditemukan. Cek kembali NIS!
                    </div>';
            }
            else
            {
                $app['hasil'] = 'ada';
            }
            if($student->dob!=$request->tgllahir)
            {
                $app['hasil'] = '<div class="alert alert-success" role="alert">
                        Data ditemukan. Tapi tidak cocok tanggal lahir! Cek tanggal lahir!
                    </div>';
            }
            else
            {
                if($app['publish']==null)
                {
                    $app['hasil'] = '<div class="alert alert-success" role="alert">
                    Data Tahun Ajaran Detail, belum lengkap. Mohon tunggu.
                    </div>';
                }
                else
                {
                    $pubmid = $app['publish']->publish_mid_exam;
                    $pubfin = $app['publish']->publish_final_exam;
                    $app['kelas'] = CourseClassDtl::getClassFromStudent($student->pid)[0];
                    $app['walikelas'] = Homeroom::getFromClass($app['kelas']['ccid']);
                    $app['pengasuhan'] = BoardingGroup::getFromBoarding($student->pid);
                    $app['bayanat'] = BayanatMapping::getFromPerson($student->pid);
                    $kelas = CourseClassDtl::where('sid',$student->id)
                        ->where('ep_course_class_dtl.ayid',config('id_active_academic_year'))
                        ->join('ep_course_class','ep_course_class_dtl.ccid','=','ep_course_class.id')
                        ->join(DB::raw('(SELECT * FROM aa_homeroom WHERE ayid="'.config('id_active_academic_year').'") as homeroom'),'homeroom.ccid','=','ep_course_class.id')
                        ->join('aa_employe','emid','=','aa_employe.id')
                        ->join('aa_person','aa_person.id','=','aa_employe.pid')
                        ->select('ep_course_class.id','level','ep_course_class.name as namakelas','ep_course_class.name_ar as namakelas_ar','aa_person.name as namaguru','aa_person.name_ar as namaguru_ar','aa_person.sex')
                        ->first();

                    $nilaiuts = ($pubmid=='1') ? FinalGradeDtl::selectRaw('ep_final_grade_dtl.*,ep_subject.*,ep_course_subject.grade_pass')
                        ->join('ep_subject','subject_id','=','ep_subject.id')
                        ->leftJoin('ep_course_class','ep_final_grade_dtl.ccid','=','ep_course_class.id')
                        ->rightJoin('ep_course_subject', function($join) {
                            $join->on('ep_course_class.level','=','ep_course_subject.level');
                            $join->on('ep_course_subject.ayid','=',DB::raw(config('id_active_academic_year')));
                            $join->on('ep_course_subject.tid','=',DB::raw(config('id_active_term')));
                            $join->on('ep_subject.id','=','ep_course_subject.subject_id');
                        })
                        ->where('ep_final_grade_dtl.sid',$student->id)
                        ->where('ep_final_grade_dtl.format_code','3')
                        ->where('ep_final_grade_dtl.ayid',config('id_active_academic_year'))
                        ->where('ep_final_grade_dtl.tid',config('id_active_term'))
                        ->orderBy('subject_seq_no')
                        ->get() : '';

                    $nilaiuas = ($pubfin=='1') ? FinalGradeDtl::selectRaw('ep_final_grade_dtl.*,ep_subject.*,ep_course_subject.grade_pass')
                        ->join('ep_subject','subject_id','=','ep_subject.id')
                        ->leftJoin('ep_course_class','ep_final_grade_dtl.ccid','=','ep_course_class.id')
                        ->rightJoin('ep_course_subject', function($join) {
                            $join->on('ep_course_class.level','=','ep_course_subject.level');
                            $join->on('ep_course_subject.ayid','=',DB::raw(config('id_active_academic_year')));
                            $join->on('ep_course_subject.tid','=',DB::raw(config('id_active_term')));
                            $join->on('ep_subject.id','=','ep_course_subject.subject_id');
                        })
                        ->where('ep_final_grade_dtl.sid',$student->id)
                        ->where('ep_final_grade_dtl.format_code','0')
                        ->where('ep_final_grade_dtl.ayid',config('id_active_academic_year'))
                        ->where('ep_final_grade_dtl.tid',config('id_active_term'))
                        ->orderBy('subject_seq_no')
                        ->get()  : '';

                    $boarding = FinalGradeDtl::select('subject_id','final_grade','letter_grade')
                        ->where('sid',$student->id)
                        ->where('format_code','3')
                        ->where('ayid',config('id_active_academic_year'))
                        ->where('tid',config('id_active_term'))
                        ->join('ep_boarding_activity','subject_id','=','ep_boarding_activity.id')
                        ->orderBy('subject_seq_no')
                        ->get();

                    $pelajaran = CourseSubjectTeacher::where('level',$kelas->level)
                        ->where('ccid',$kelas->id)
                        ->where('ayid',config('id_active_academic_year'))
                        ->where('tid',config('id_active_term'))
                        ->join('aa_person','eid','=','aa_person.id')
                        ->get();
                    $quran = BayanatResultDtl::where('pid',$student->pid)
                        ->where('ayid',config('id_active_academic_year'))
                        ->where('tid',config('id_active_term'))
                        ->join('ep_bayanat_weight','id_evaluation','=','ep_bayanat_weight.id')
                        ->join('ep_bayanat_result','hid','ep_bayanat_result.id')
                        ->get();

                    $student['kelas']       = $kelas;
                    $student['nilaiuts']    = $nilaiuts;
                    $student['nilaiuas']    = $nilaiuas;
                    $student['pengasuhan']  = $boarding;
                    $student['quran']       = $quran;
                    $student['aktivitas']     = BoardingActivity::get();
                    $student['groupaktivitas']= BoardingActivityGroup::get();
                    $student['pelajaran']   = $pelajaran;
                    $app['data']['profil']  = $student;
                    $app['data']['nilai']   = array();
                }
            }
        }
        return view('halaman.student-search',$app);
    }
    public function daftar_ulang(Request $request)
    {
        $app['aktif'] = $this->global['aktif'];
        $app['noreg'] = $request->noreg;
        $app['judul'] = "Daftar Ulang";
        $app['nomenu'] = 'yes';
        $app['hasil'] = '';
        $app['data'] = array();
        $app['nis'] = ''; $app['tgl'] = '';
        $app['publish'] = AcademicYearDetail::where('ayid',config('id_active_academic_year'))
            ->where('tid',config('id_active_term'))
            ->first();
        $app['request'] = $request;
        if($request->post != '')
        {

        }
        return view('halaman.daftar-ulang-v1',$app);
    }
    public function print_raport(Request $request)
    {
        // KONFIGURASI PDF
        $pdfconf = new \App\SmartSystem\PdfConfig;
        $mpdfconf = $pdfconf->config();
        $pdf = 'pdf';

        $tipe = $request->tipe;
        $pid = $request->pid;
        $token = $request->token;
        $dectoken = \App\SmartSystem\EasyEncrypt::decrypt($token);
        $person = Person::where('id',$pid)->first();
        if($dectoken!=$person['dob'])
        {
            return redirect('https://mahadsyarafulharamain.sch.id');
            die();
        }
        $tipe = explode('-',$tipe);
        $semester = $tipe[1];
        $tipe = $tipe[0];
        $ayid           = config('id_active_academic_year');
        $tid            = config('id_active_term');
        switch ($tipe) {
            case 'akademik':
                $formatcode = 0;
                $final          = new \App\Models\FinalGrade;
                $app['final']   = (object)$final->getStudentFinalGrade($pid,$formatcode,$ayid,$tid);

                break;
            default:
                break;
        }
    }
    // public function print_raport_temp(Request $request)
    // {

    //     $tipe = $request->tipe;
    //     $pid = $request->pid;
    //     $token = $request->token;
    //     $dectoken = \App\SmartSystem\EasyEncrypt::decrypt($token);
    //     $person = Person::where('id',$pid)->first();
    //     if($dectoken!=$person['dob'])
    //     {
    //         return redirect('https://mahadsyarafulharamain.sch.id');
    //         die();
    //     }
    //     $tipe = explode('-',$tipe);
    //     $semester = $tipe[1];
    //     $tipe = $tipe[0];
    //     switch ($tipe) {
    //         case 'akademik':

    //             $app['aktif'] = 'raport/modul';
    //             $app['judul']   = 'Cetak Raport';
    //             $idprint        = $request->id;
    //             $formatcode     = new \App\Models\RfFormatCode;
    //             $formatcode     = $formatcode->getFormatCode($idprint);
    //             $pdf            = $request->pdf;
    //             $final          = new \App\Models\FinalGrade;
    //             $ayid           = config('id_active_academic_year');
    //             $tid            = config('id_active_term');
    //             $tgl = Carbon::now()->addMonth();
    //             $app['tglhijriah'] = Hijri::DateIndicDigits('j F Y', $tgl);
    //             // cek sekalian
    //             $tglleg = FinalGrade::getDateRaport($ayid, $tid);
    //             $app['final']   = (object)$final->getStudentFinalGrade($request->pid,$formatcode,$ayid,$tid);

    //             $app['student'] = Student::where('aa_student.id',$request->pid)
    //                 ->join('aa_person','pid','=','aa_person.id')
    //                 ->select('aa_student.id','aa_person.name','aa_person.name_ar','nis','aa_person.sex','aa_person.id as pid')
    //                 ->first();
    //             $app['kelas']   = CourseClass::select('ep_course_class.id','ep_course_class.name',
    //                     'ep_course_class.name_ar','rf_level_class_dtl.level','rf_level_class.desc_ar',
    //                     'rf_level_class_dtl.desc_ar AS desc_ar_dtl')
    //                 ->leftJoin('ep_course_class_dtl','ep_course_class.id','=','ep_course_class_dtl.ccid')
    //                 ->leftJoin('rf_level_class','ep_course_class.level','=','rf_level_class.level')
    //                 ->rightJoin('rf_level_class_dtl', function($join) {
    //                     $join->on('rf_level_class.level','=','rf_level_class_dtl.level')->where('rf_level_class_dtl.tid','=',config('id_active_term'));
    //                 })
    //                 ->where('ayid',config('id_active_academic_year'))
    //                 ->where('ep_course_class_dtl.sid',$request->pid)
    //                 ->first();
    //             $rfterm = new \App\Models\RfTerm;
    //             $app['term'] = $rfterm::where('id',config('id_active_term'))->first();

    //             $g = new \App\SmartSystem\General;
    //             $pecahan = explode('-',$tglleg['date_legalization']);
    //             if(collect($app['final'])->count()>0)
    //             {
    //                 $app['tgl_hj_raport']= $app['final']->hijri_date_legalization;
    //                 $studentName        = $app['final']->student_name_ar=='' ? $app['final']->student_name : $app['final']->student_name_ar;
    //                 $app['studentName'] = General::santri($app['final']->student_sex).' : '.$studentName;
    //                 $pecahan            = explode('-',$app['final']->date_legalization);
    //                 $app['tgl_raport']  = $g->convertToArabic($pecahan[0],$pecahan[1],$pecahan[2],' ');
    //                 $app['kepalasekolah']= General::ustadz($app['final']->principal_sex).' '.$app['final']->principal_name_ar;
    //                 $app['kurikulum']    = General::ustadz($app['final']->curriculum_sex).' '. $app['final']->curriculum_name_ar;
    //                 $app['kesiswaan']    = General::ustadz($app['final']->studentaffair_sex).' '.$app['final']->studentaffair_name_ar;
    //                 $app['walikelas']    = General::ustadz($app['final']->formteacher_sex).' '. $app['final']->formteacher_name_ar;
    //                 $app['musyrifSakan'] = General::ustadz($app['final']->houseleader_sex).' '. $app['final']->houseleader_name_ar;
    //                 $app['walikelasGender'] = General::getGenderAr($app['final']->formteacher_sex); //Jenis kelamin walikelas dalam bahasa arab
    //                 $app['musyrifSakanGender']     = General::getGenderAr($app['final']->houseleader_sex); //Jenis kelamin dalam bahasa arab
    //             }
    //             else
    //             {
    //                 $aydetail = AcademicYearDetail::where('ayid',config('id_active_academic_year'))->where('tid',config('id_active_term'))->first();
    //                 $pecahan = ($formatcode=='3') ? explode('-',$aydetail['mid_exam_date']) : explode('-',$aydetail['final_exam_date']);
    //                 $app['tgl_hj_raport']= ($formatcode=='3') ? $aydetail['hijri_mid_exam_date'] : $aydetail['hijri_final_exam_date'];
    //                 $studentName        = $app['student']->name_ar=='' ? $app['student']->name : $app['student']->name_ar;
    //                 $app['studentName'] = General::santri($app['student']->student_sex).' : '.$studentName;
    //                 $app['tgl_raport']  = $g->convertToArabic($pecahan[0],$pecahan[1],$pecahan[2],' ');
    //             }
    //             $app['tgl_raport']  = $g->convertToArabic($pecahan[0],$pecahan[1],$pecahan[2],' ');
    //             $app['tahun']['masehi'] = $g->angka_arab($pecahan[0]);
    //             $app['tahun']['arab'] = $g->angka_arab($g->convertToHijriah($pecahan[0],$pecahan[1],$pecahan[2],'','tahun_hijriyah'));
    //             $mahmul = RemedyClass::getMahmulforRaportv2($request->pid);
    //             $app['mahmul'] = collect($mahmul)->pluck('pelajaran_ar')->toArray();
    //             $app['ipk'] = Gpa::getIPK($request->pid,config('active_academic_year'),config('id_active_term'));
    //             $app['result'] = BayanatResultDtl::getResultDtl($app['student']->pid);
    //             $app['nilaiqurantingkat'] = (count($app['result'])>0) ? collect($app['result'])->first()['result_decision_level'] : '-';
    //             $nilaiquranhalaqah = (count($app['result'])>0) ? collect($app['result'])->first()['result_decision_set'] : '-';
    //             $app['nilaiquranhalaqah'] = '-';
    //             if($nilaiquranhalaqah!='-')
    //             {
    //                 $app['nilaiquranhalaqah'] = ($nilaiquranhalaqah=='ناجح') ? 'تم' : 'لم يتم';
    //             }
    //             break;

    //         default:
    //             # code...
    //             break;
    //     }
    // }
}
