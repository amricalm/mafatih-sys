<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AcademicYear;
use App\Models\MsUpload;
use App\Models\Address;
use App\Models\School;
use App\Models\MsConfig;
use App\Models\Sibling;
use App\Models\Person;
use App\Models\MsJobs;
use App\Models\Ppdb;
use App\Models\Achievement;
use App\Models\MedicalRecord;
use App\Models\PpdbPayment;
use App\Models\User;
use Faker\Provider\Medical;
use Illuminate\Support\Facades\File;
use Laravel\Ui\Presets\React;

class RegistrasiController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index()
    {
        return view('halaman.registrasi');
    }
    public function pembayaran()
    {
        return view('halaman.pembayaran');
    }
    public function checkout($payID)
    {
        $tripay = new TripayController();
        $app['channels'] = $tripay->getPaymentChannels();

        return view('halaman.checkout', $app);
    }
    public function daftar()
    {
        $app = array();
        $tahunajarppdb = MsConfig::where('config_name', 'id_thn_ajar_ppdb')->first();
        $tahunajarppdb = explode(',', $tahunajarppdb['config_value']);
        $app['tahunajar'] = AcademicYear::whereIn('id', $tahunajarppdb)->get();
        $app['sekolah'] = School::get();
        $app['aktif'] = 'ppdb';
        $app['judul'] = "Formulir Pendaftaran";
        $app['provinces'] = \Indonesia::allProvinces();
        $app['jobs'] = MsJobs::orderBy('name','desc')->get();
        return view('halaman.daftar', $app);
    }
    public function simpan(Request $request)
    {
        $person = Person::create([
            'nik' => $request->nik,
            'kk' => $request->kk,
            'name' => $request->name,
            'nickname' => $request->nickname,
            'name_ar' => $request->name_ar,
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

        $ppdb = Ppdb::create([
            'pid' => $id,
            'nisn' => $request->nisn,
            'school_id' => $request->school_id,
            'academic_year_id' => $request->academic_year_id,
            'process' => '1',
            'cby' => auth()->user()->id,
            'uby' => '0'
        ]);


        $noregis = date("YmdHis").$request->sekolah.'0'.$request->tahunajar;
        $details = [
            'tipe' => 'registrasi',
            'judul' => 'PPDB - EDUSIS',
            'yes' => [0],
            'noregis' => $noregis,
        ];
        Ppdb::where('id',$ppdb->id)->update(['registration_id'=>$noregis]);

        $admin = User::where('role','1')->first();

        \Mail::to($admin['email'])->send(new \App\Mail\Email($details));
        \Mail::to(auth()->user()->email)->send(new \App\Mail\Email($details));

        return redirect('ppdb/'.$id.'/edit')->with('success', 'Tambah app Berhasil');
    }
    public function show(Request $request)
    {
        $app = array();
        $tahunajarppdb = MsConfig::where('config_name', 'id_thn_ajar_ppdb')->first();
        $tahunajarppdb = explode(',', $tahunajarppdb['config_value']);
        $sekolah = MsConfig::where('config_name','active_school')->first();
        $app['tahunajar'] = AcademicYear::whereIn('id', $tahunajarppdb)->get();
        $app['aktif'] = 'ppdb';
        $app['judul'] = 'Edit Profil Siswa/Calon Siswa';
        $app['sekolah'] = School::get();
        $app['person'] = Person::where('id', $request->id)->first();
        $app['files'] = MsUpload::where('pid',$request->id)->get();
        $app['alamat'] = Address::where('pid',$request->id)->where('type','person')->first();
        $app['ppdb'] = Ppdb::where('pid',$app['person']['id'])->where('type','person')->first();
        $app['jobs'] = MsJobs::orderBy('name','desc')->get();
        $app['ayah'] = ($app['person']['ayah_id']!='') ? Person::where('id', $app['person']['ayah_id'])->first() : array();
        $app['ibu'] = ($app['person']['ibu_id']!='') ? Person::where('id',$app['person']['ibu_id'])->first() : array();
        $app['alamat_ayah'] = ($app['person']['ayah_id']!='') ? Address::where('pid',$app['ayah']['id'])->where('type','person')->first() : array();
        $app['provinces'] = \Indonesia::allProvinces();
        $app['city'] = (empty($app['alamat'])) ? array() : \Indonesia::findProvince($app['alamat']['province'], ['cities'])->cities->pluck('name', 'id');
        $app['district'] = (empty($app['alamat'])) ? array() : \Indonesia::findCity($app['alamat']['city'], ['districts'])->districts->pluck('name', 'id');
        $app['village'] = (empty($app['alamat'])) ? array() : \Indonesia::findDistrict($app['alamat']['district'], ['villages'])->villages->pluck('name', 'id');

        return view('halaman.daftar-edit', $app);
    }
    public function delete(Request $request)
    {
        $id = $request->id;
        $ppdb = Ppdb::where('pid',$id)->first();
        Person::where('id',$id)->delete();
        Ppdb::where('pid',$id)->delete();
        PpdbPayment::where('ppdb_id',$ppdb->id)->delete();
        Address::where('pid',$id)->where('type','person')->delete();
        Sibling::where('pid',$id)->delete();
        Achievement::where('pid',$id)->delete();
        MedicalRecord::where('pid',$id)->delete();
        return redirect('home');
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
                $person->pob = $datas['pob'];
                $person->dob = $datas['dob'];
                $person->sex = $datas['sex'];
                $person->son_order = $datas['son_order'];
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

                // PPDB
                Ppdb::where('id',$datas['ppdb_id'])
                    ->where('pid',$datas['pid'])
                    ->update([
                        'nisn' => $datas['nisn'],
                        'process' => '1',
                    ]);


                // ALAMAT
                $alamat = Address::updateOrCreate(
                    ['pid'=>$datas['pid'],'type'=>'person'],
                    [
                        'address'=>$datas['alamat'],'province'=>$datas['provinsi'],
                        'city'=>$datas['kota'],'district'=>$datas['kecamatan'],
                        'village'=>$datas['desa'],'post_code'=>$datas['post'],
                        'uby'=>auth()->user()->id,
                    ]
                );
                // Address::where('pid',$datas['pid'])
                //     ->where('type','person')
                //     ->update([
                //         'address' => $datas['alamat'],
                //         'province' => $datas['provinsi'],
                //         'city' => $datas['kota'],
                //         'district' => $datas['kecamatan'],
                //         'village' => $datas['desa'],
                //         'post_code' => $datas['post'],
                //         'uby' => auth()->user()->id,
                //     ]);

                echo 'Berhasil';
                break;
            case '2':
                // echo '<pre>';print_r($datas);die();
                // CARI DATA AYAH DAN IBU
                $person = Person::where('id',$datas['pid'])->first();
                $ayah_id = '';
                $ibu_id = '';
                // AYAH
                if($person->ayah_id=='')
                {
                    $ayah = Person::create([
                        'name' => $datas['ayah_nama'],
                        'sex' => 'L',
                        'age' => $datas['ayah_age'],
                        'last_education' => $datas['ayah_last_education'],
                        'job' => $datas['ayah_job'],
                        'income' => $datas['ayah_income'],
                        'languages' => $datas['ayah_languages'],
                        'citizen' => $datas['ayah_citizen'],
                        'cby' => auth()->user()->id,
                        'uby' => '0'
                    ]);
                    $ayah_id = $ayah->id;
                }
                else
                {
                    $ayah = Person::where('id',$person->ayah_id)
                        ->update([
                            'name' => $datas['ayah_nama'],
                            'sex' => 'L',
                            'age' => $datas['ayah_age'],
                            'last_education' => $datas['ayah_last_education'],
                            'job' => $datas['ayah_job'],
                            'income' => $datas['ayah_income'],
                            'languages' => $datas['ayah_languages'],
                            'citizen' => $datas['ayah_citizen'],
                            'uby' => auth()->user()->id,
                        ]);
                    $ayah_id = $person->ayah_id;
                }

                // IBU
                if($person->ibu_id=='')
                {
                    $ibu = Person::create([
                        'name' => $datas['ibu_nama'],
                        'sex' => 'P',
                        'age' => $datas['ibu_age'],
                        'last_education' => $datas['ibu_last_education'],
                        'job' => $datas['ibu_job'],
                        'income' => $datas['ibu_income'],
                        'languages' => $datas['ibu_languages'],
                        'citizen' => $datas['ibu_citizen'],
                        'cby' => auth()->user()->id,
                        'uby' => '0'
                    ]);
                    $ibu_id = $ibu->id;
                }
                else
                {
                    $ibu = Person::where('id',$person->ibu_id)
                        ->update([
                            'name' => $datas['ibu_nama'],
                            'sex' => 'P',
                            'age' => $datas['ibu_age'],
                            'last_education' => $datas['ibu_last_education'],
                            'job' => $datas['ibu_job'],
                            'income' => $datas['ibu_income'],
                            'languages' => $datas['ibu_languages'],
                            'citizen' => $datas['ibu_citizen'],
                            'uby' => auth()->user()->id,
                        ]);
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

                // PPDB
                Ppdb::where('id',$datas['ppdb_id'])
                    ->where('pid',$datas['pid'])
                    ->update([
                        'process' => '2',
                    ]);

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
    public function lihatemail(Request $request)
    {
        $data = [
            'name' => 'test',
            'email' => 'tset',
            'password' => 'teweqr',
            'yes' => [0]
        ];
        switch ($request->t) {
            case 'template':
                return view('email.registrasi',$data);
                break;
            case 'baru' :
                return view('email.ppdb',$data);
                break;
            default:
                # code...
                break;
        }
    }
}
