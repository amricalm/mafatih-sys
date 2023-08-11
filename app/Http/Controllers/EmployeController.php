<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employe;
use App\Models\Person;
use App\Models\Address;
use App\Models\MsJobs;
use App\Models\MsConfig;
use App\Models\AcademicYear;
use App\Models\Sibling;
use App\Models\Achievement;
use App\Models\MedicalRecord;
use App\Models\School;
use App\Models\Student;
use App\Models\MsUpload;
use App\Models\EmployeType;
use App\Models\Position;
use DataTables;

class EmployeController extends Controller
{
    var $global;
    public function __construct()
    {
        $this->global['aktif'] = 'karyawan';
        $this->global['judul'] = 'Data Karyawan';
    }
    public function index(Request $request)
    {
        $app = array();
        $app['karyawan'] = Employe::leftJoin('aa_person', 'pid', '=', 'aa_person.id')
            ->leftJoin('rf_employe_type','code','=','aa_employe.employe_type')
            ->leftJoin('hr_position','hr_position.id','=','aa_employe.position_id')
            ->select('aa_employe.id','pid','aa_employe.nik', 'aa_person.name', 'aa_person.name_ar','hr_position.name as position','rf_employe_type.desc as tipe')
            ->orderBy('aa_person.name')
            ->paginate(config('paging'));
        $app['aktif'] = $this->global['aktif'];
        $app['judul'] = $this->global['judul'];

        return view('halaman.employee', $app);
    }

    public function new()
    {
        $app['aktif'] = $this->global['aktif'];
        $app['judul'] = "Tambah ".$this->global['judul'];
        $app['provinces'] = \Indonesia::allProvinces();
        $app['jobs'] = MsJobs::orderBy('name', 'desc')->get();

        return view('halaman.employe-new', $app);
    }

    public function show(Request $request)
    {
        $app = array();
        $app['aktif'] = $this->global['aktif'];
        $app['judul'] = 'Edit '.$this->global['judul'];
        $app['id'] = $request->id;
        $app['person'] = Person::where('id', $request->id)->first();
        $app['employe'] = Employe::where('pid',$request->id)->first();
        $app['couple'] = !empty($app['employe']['coupleid']) ? Person::where('id',$app['employe']['coupleid'])->first() : '';
        $app['files'] = MsUpload::where('pid',$request->id)->get();
        $alamat = Address::where('pid',$request->id)->where('type','person')->first();
        $app['alamat'] = (!empty($alamat)) ? $alamat : array('address'=>'','province'=>'','city'=>'','district'=>'','village'=>'','post_code'=>'','latitude'=>'' ,'longitude'=>'');
        $app['jobs'] = MsJobs::orderBy('name','desc')->get();
        $app['ayah'] = ($app['person']['ayah_id']!='') ? Person::where('id', $app['person']['ayah_id'])->first() : array();
        $app['ibu'] = ($app['person']['ibu_id']!='') ? Person::where('id',$app['person']['ibu_id'])->first() : array();
        $app['alamat_ayah'] = ($app['person']['ayah_id']!='') ? Address::where('pid',$app['ayah']['id'])->where('type','person')->first() : array();
        $app['provinces'] = \Indonesia::allProvinces();
        $app['city'] = (empty($alamat)||$alamat['province']=='0') ? array() : \Indonesia::findProvince($app['alamat']['province'], ['cities'])->cities->pluck('name', 'id');
        $app['district'] = (empty($alamat)||$alamat['city']=='0') ? array() : \Indonesia::findCity($app['alamat']['city'], ['districts'])->districts->pluck('name', 'id');
        $app['village'] = (empty($alamat)||$alamat['district']=='0') ? array() : \Indonesia::findDistrict($app['alamat']['district'], ['villages'])->villages->pluck('name', 'id');
        $app['type'] = EmployeType::get();
        $app['posisi'] = Position::orderBy('name')->get();
        return view('halaman.employe-edit', $app);
    }
    public function showdetail(Request $request)
    {
        $id = $request->id;

    }

    public function store(Request $request)
    {
        $app['aktif'] = $this->global['aktif'];
        $app['judul'] = "Tambah " . $this->global['judul'];
        $app['provinces'] = \Indonesia::allProvinces();
        $app['jobs'] = MsJobs::orderBy('name', 'desc')->get();

        return view('halaman.employe-new', $app);
    }

    public function save(Request $request)
    {
        $person = Person::create([
            'name' => $request->name,
            'name_ar' => $request->name_ar,
            'pob' => $request->pob,
            'dob' => $request->dob,
            'sex' => $request->sex,
            'religion' => $request->religion,
            'nik' => $request->nik,
            'kk' => $request->kk,
            'citizen' => $request->citizen,
            'last_education' => $request->last_education,
            'phone' => $request->phone,
            'hp' => $request->hp,
            'email' => $request->email,
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
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'cby' => auth()->user()->id,
            'uby' => '0'
        ]);

        $student = Employe::create([
            'pid' => $id,
            'nik' => $request->nip,
            'employe_type' => 1,
            'position_id' => 1,
            'npwp' => $request->npwp,
            'npwp_name' => $request->npwp_name,
            'marital_status' => $request->marital_status,
            'cby' => auth()->user()->id,
            'uby' => '0'
        ]);

        return redirect('karyawan/'.$id.'/edit')->with('success', 'Simpan data Berhasil');
    }

    public function update(Request $request)
    {
        $datas = array();
        parse_str($request->data, $datas);

        switch ($_GET['step']) {
            case '1':
                //EMPLOYE
                $employe['where']['id'] = $datas['employe_id'];
                $employe['where']['pid'] = $datas['pid'];
                $employe['data']['nik'] = $datas['nip'];
                $employe['data']['npwp'] = $datas['npwp'];
                $employe['data']['npwp_name'] = $datas['npwp_name'];
                $employe['data']['marital_status'] = $datas['marital_status'];
                $employe['data']['uby'] = auth()->user()->id;
                Employe::updateOrCreate($employe['where'],$employe['data']);

                // PERSON
                $person = Person::find($datas['pid']);
                $person->nik = $datas['nik'];
                $person->kk = $datas['kk'];
                $person->name = $datas['name'];
                $person->name_ar = $datas['name_ar'];
                $person->pob = $datas['pob'];
                $person->dob = $datas['dob'];
                $person->sex = $datas['sex'];
                $person->citizen = $datas['citizen'];
                $person->religion = $datas['religion'];
                $person->last_education = $datas['last_education'];
                $person->phone = $datas['phone'];
                $person->hp = $datas['hp'];
                $person->email = $datas['email'];
                // IBU
                if(!empty($datas['ibu_nama'])) {
                    $ibu_id = '';
                    if($person->ibu_id=='')
                    {
                        $ibu = new Person();
                        $ibu['name'] = $datas['ibu_nama'];
                        $ibu['sex'] = 'P';
                        $ibu->save();
                        $ibu_id = $ibu->id;
                    } else {
                        $dataibu = [];
                        $dataibu['name'] = $datas['ibu_nama'];
                        $dataibu['sex'] = 'P';
                        $ibu = Person::where('id',$person->ibu_id)->update($dataibu);
                        $ibu_id = $person->ibu_id;
                    }
                $person->ibu_id = $ibu_id;
                }
                $person->user_id = auth()->user()->id;
                $person->uby = auth()->user()->id;
                $person->save();

                //EMPLOYE
                $employe = Employe::where('id',$datas['employe_id'])->where('pid',$datas['pid'])->first();
                $employe->npwp = $datas['npwp'];
                $employe->npwp_name = $datas['npwp_name'];
                $employe->marital_status = $datas['marital_status'];
                // Suami/Istri
                if(isset($datas['couple_name'])) {
                    $couple_id = '';
                    if(!empty($employe->coupleid))
                    {
                        $couple = new Person();
                        $couple['name'] = $datas['couple_name'];
                        $couple['sex'] = isset($datas['couple_sex']) ? $datas['couple_sex'] : '';
                        $couple['job'] = ($datas['couple_job']!='') ? $datas['couple_job'] : '0';
                        $couple->save();
                        $couple_id = $couple->id;
                    } else {
                        $datacouple = [];
                        $datacouple['name'] = $datas['couple_name'];
                        $datacouple['sex'] = isset($datas['couple_sex']) ? $datas['couple_sex'] : '';
                        $datacouple['job'] = ($datas['couple_job']!='') ? $datas['couple_job'] : '0';

                        $couple = Person::where('id',$employe->coupleid)->update($datacouple);
                        $couple_id = $employe->coupleid;
                    }
                $employe->coupleid = $couple_id;
                }
                $employe->uby = auth()->user()->id;
                $employe->save();


                //ADDRESS
                Address::where('pid',$datas['pid'])
                    ->where('type','person')
                    ->update([
                        'address' => $datas['alamat'],
                        'province' => $datas['provinsi'],
                        'city' => $datas['kota'],
                        'district' => $datas['kecamatan'],
                        'village' => $datas['desa'],
                        'post_code' => $datas['post'],
                        'latitude' => $datas['latitude'],
                        'longitude' => $datas['longitude'],
                        'uby' => auth()->user()->id,
                    ]);

                echo 'Berhasil';
                break;
            case '2':
                // echo '<pre>';print_r($datas);die();
                // CARI DATA AYAH DAN IBU
                $person = Person::where('id',$datas['pid'])->first();
                $ayah_id = '';
                // AYAH
                if($person->ayah_id=='')
                {
                    $ayah = new Person();
                    $ayah['nik'] = $datas['ayah_nik'];
                    $ayah['name'] = $datas['ayah_nama'];
                    $ayah['sex'] = 'L';
                    $ayah['age'] = ($datas['ayah_age']!='') ? $datas['ayah_age'] : '0';
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
                    $dataayah['sex'] = 'L';
                    $dataayah['age'] = ($datas['ayah_age']!='') ? $datas['ayah_age'] : '0';
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
                    $ibu['sex'] = 'P';
                    $ibu['age'] = ($datas['ibu_age']!='') ? $datas['ibu_age'] : '0';
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
                    $dataibu['sex'] = 'P';
                    $dataibu['age'] = ($datas['ibu_age']!='') ? $datas['ibu_age'] : '0';
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

                // PERSON
                $person = Person::find($datas['pid']);
                $person->stay_with_parent = $datas['stay_with_parent'];
                $person->ayah_id = $ayah_id;
                $person->ibu_id = $ibu_id;
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
                $person->is_glasses = (!empty($datas['is_glassses'])) ? $datas['is_glasses'] : '0';
                $person->character = $datas['character'];
                $person->hobbies = $datas['hobbies'];
                $person->uby = auth()->user()->id;
                $person->save();

                // PPDB
                Ppdb::where('id',$datas['ppdb_id'])
                    ->where('pid',$datas['pid'])
                    ->update([
                        'process' => '3',
                    ]);

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
                Ppdb::where('id',$datas['ppdb_id'])
                    ->where('pid',$datas['pid'])
                    ->update([
                        'process' => '4',
                    ]);

                echo 'Berhasil';
                break;
            case '8':
                $employe = Employe::find($datas['employe_id']);
                $employe->employe_type = $datas['employe_type'];
                $employe->position_id = $datas['position_id'];
                $employe->employment_status = $datas['employment_status'];
                $employe->niy = $datas['niy'];
                $employe->nuptk = $datas['nuptk'];
                $employe->ptk_type = $datas['ptk_type'];
                $employe->decision_number = $datas['decision_number'];
                if($datas['decision_date']) {
                    $employe->decision_date = $datas['decision_date'];
                }
                $employe->decision_institution = $datas['decision_institution'];
                $employe->source_salary = $datas['source_salary'];
                $employe->is_active = (!isset($datas['is_active'])) ? '0' : '1';
                $employe->uby = auth()->user()->id;
                $employe->uon = date('Y-m-d H:i:s');
                $employe->save();

                $person = Person::find($datas['pid']);
                if($datas['received_date']) {
                    $person->received_date = $datas['received_date'];
                }
                if($datas['out_date']) {
                    $person->out_date = $datas['out_date'];
                }
                $person->save();

                echo 'Berhasil';
                break;
            default:
                # code...
                break;
        }
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        Person::where('id', $id)->delete();
        Employe::where('pid', $id)->delete();
        Address::where('pid', $id)->where('type', 'person')->delete();
        Sibling::where('pid',$id)->delete();
        Achievement::where('pid',$id)->delete();
        MedicalRecord::where('pid',$id)->delete();
        return redirect('karyawan')->with('success', 'Berhasil dihapus!');
    }
}
