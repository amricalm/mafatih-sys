<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
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
use App\Models\FinCost;
use App\Models\FinCostSchool;
use App\Models\MedicalRecord;
use App\Models\PpdbPayment;
use App\Models\User;
use App\Models\Student;
use App\Models\PpdbCost;
use App\Models\PpdbSet;
use App\Models\UsersData;
// use App\Models\FinPayment;
// use App\Models\FinPaymentDetail;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class RegistrasiController extends Controller
{
    var $global;
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->global['aktif'] = 'ppdb';
        $this->global['judul'] = 'Penerimaan Peserta Didik Baru';
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
        // $tahunajarppdb = MsConfig::where('config_name', 'id_thn_ajar_ppdb')->first();
        // $tahunajarppdb = explode(',', $tahunajarppdb['config_value']);
        $ayidppdb = PpdbSet::where('is_publish','1')->first();
        $tahunajarppdb = $ayidppdb['ayid'];
        $app['tahunajar'] = AcademicYear::where('id', $tahunajarppdb)->get();
        $datasekolah = (auth()->user()->role=='3') ? UsersData::where('uid',auth()->user()->id)->get()->toArray() : [];
        $app['sekolah'] = (empty($datasekolah)) ? School::get() : School::whereIn('id',collect($datasekolah)->pluck('sid'))->get();
        $app['aktif'] = $this->global['aktif'];
        $app['judul'] = $this->global['judul']." - Formulir Pendaftaran";
        $app['provinces'] = \Indonesia::allProvinces();
        $app['jobs'] = MsJobs::orderBy('name','desc')->get();
        $app['ppdbset'] = $ayidppdb;
        return view('halaman.daftar', $app);
    }
    public function simpan(Request $request)
    {
        $ppdbset = PpdbSet::where('is_publish','1')->first();
        if($ppdbset->count()<0)
        {
            return abort(404)->with('error','Pendaftaran ditutup');
        }
        $idppdb = $ppdbset->id;
        $year = explode('-',$ppdbset->url);
        $tahun = '';
        foreach($year as $k=>$v) { $tahun .= substr($v,2,2); }
        $getall = Ppdb::where('id_ppdb',$ppdbset->id)->where('school_id',$request->school_id)->count();
        $getall = Ppdb::where('id_ppdb',$ppdbset->id)
            ->where('school_id',$request->school_id)
            ->selectRaw('max(RIGHT(registration_id,4) * 1) as registration_id')
            ->first();
        $maxreg = (!is_null($getall)) ? $getall['registration_id'] : 0;
        $sekolah = School::where('aa_school.institution_id',$request->school_id)
            ->join('rf_school_type','school_type_id','=','rf_school_type.id')->first();
        $schooltype = $sekolah['desc'];
        $noregis = 'PPDB'.$tahun.$schooltype.str_pad((string)($maxreg+1),4,"0", STR_PAD_LEFT);
        $person = Person::create([
            'name' => $request->name,
            'nickname' => $request->nickname,
            'pob' => $request->pob,
            'dob' => $request->dob,
            'sex' => $request->sex,
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
        $information_from = (is_null($request->information_from)) ? array() : $request->information_from;
        $dataarray = [
            'id_ppdb' => $idppdb,
            'pid' => $id,
            'registration_id' => $noregis,
            'school_id' => $request->school_id,
            'academic_year_id' => $request->academic_year_id,
            'previous_school' => $request->previous_school,
            'address_previous_school' => $request->address_previous_school,
            'father_temp' => $request->father_temp,
            'mother_temp' => $request->mother_temp,
            'father_job_temp' => $request->father_job_temp,
            'mother_job_temp' => $request->mother_job_temp,
            'whatsapp' => $request->whatsapp,
            'email' => $request->email,
            'information_from' => implode(', ',$information_from),
            'process' => '1',
            'cby' => auth()->user()->id,
            'uby' => '0'
        ];
        $dataarray += (isset($request->nisn)) ? ['nisn' => $request->nisn] : [];
        $ppdb = Ppdb::create($dataarray);

        //KIRIM EMAIL
        if($request->email!='')
        {
            $details = [
                'tipe' => 'registrasi',
                'judul' => 'Registrasi PPDB - '.config('app.name'),
                'yes' => [0,1],
                'noregis' => $noregis,
            ];
            \Mail::to($request->email)->send(new \App\Mail\Email($details));
        }
        return redirect('ppdb/'.$id.'/edit')->with('success', 'Tambah registrasi Berhasil');

    }
    public function show(Request $request)
    {
        $app = array();
        $app['aktif'] = $this->global['aktif'];
        $app['judul'] = $this->global['judul']." - Edit Profil Siswa/Calon Siswa";
        $sekolah = MsConfig::where('config_name','active_school')->first();
        $ayidppdb = PpdbSet::where('is_publish','1')->first();
        $tahunajarppdb = $ayidppdb['ayid'];
        $app['tahunajar'] = AcademicYear::where('id', $tahunajarppdb)->get();
        $app['ppdb'] = Ppdb::where('pid',$request->id)->first();
        $app['sekolah'] = School::get();
        $app['person'] = Person::where('id', $app['ppdb']['pid'])->first();
        $app['files'] = MsUpload::where('pid',$app['ppdb']['pid'])->get();
        $app['alamat'] = Address::where('pid',$app['ppdb']['pid'])->where('type','person')->first();
        $app['alamat'] = (!empty($app['alamat'])) ? $app['alamat'] : array('address'=>'','province'=>'','city'=>'','district'=>'','village'=>'','post_code'=>'');
        $app['alamat'] = (object) $app['alamat'];
        $app['ayah'] = (!empty($app['person']['ayah_id'])) ? Person::where('id', $app['person']['ayah_id'])->first() : array();
        $app['ibu'] = (!empty($app['person']['ibu_id'])) ? Person::where('id',$app['person']['ibu_id'])->first() : array();
        $app['provinces'] = \Indonesia::allProvinces();
        $app['city'] = (empty($app['alamat']->province) || $app['alamat']->province=='0') ? array() : \Indonesia::findProvince($app['alamat']->province, ['cities'])->cities->pluck('name', 'id');
        $app['district'] = (empty($app['alamat']->city) || $app['alamat']->city=='0') ? array() : \Indonesia::findCity($app['alamat']->city, ['districts'])->districts->pluck('name', 'id');
        $app['village'] = (empty($app['alamat']->district) || $app['alamat']->district=='0') ? array() : \Indonesia::findDistrict($app['alamat']->district, ['villages'])->villages->pluck('name', 'id');
        $app['foto'] = MsUpload::where('pid',$app['ppdb']['pid'])->where('desc','Foto Personal')->first();
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
        return back();
    }
    public function update(Request $request)
    {
        $person = Person::updateOrCreate(
            ['id'=>$request->person_id],
            [
                'name' => $request->name,
                'nickname' => $request->nickname,
                'pob' => $request->pob,
                'dob' => $request->dob,
                'sex' => $request->sex,
                'user_id' => auth()->user()->id,
                'cby' => auth()->user()->id,
                'uby' => auth()->user()->id
            ]);

        $alamat = Address::updateOrCreate(
            ['pid'=>$request->person_id,'type'=>'person'],
            [
                'address' => $request->alamat,
                'province' => $request->provinsi,
                'city' => $request->kota,
                'district' => $request->kecamatan,
                'village' => $request->desa,
                'post_code' => $request->post,
                'cby' => auth()->user()->id,
                'uby' => auth()->user()->id
            ]);
        $ppdb = Ppdb::where('id',$request->ppdb_id);
        if($ppdb->count()>0)
        {
            $ppdb->update([
                'nisn' => $request->nisn,
                'is_boarding' => $request->is_boarding,
                'father_temp' => $request->father_temp,
                'mother_temp' => $request->mother_temp,
                'father_job_temp' => $request->father_job_temp,
                'mother_job_temp' => $request->mother_job_temp,
                'whatsapp' => $request->whatsapp,
                'email' => $request->email,
                'information_from' => $request->information_from,
                'uby' => auth()->user()->id
            ]);
        }
        return redirect('/home')->with('success', 'Update registrasi Berhasil');
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
    public function diterima(Request $request)
    {
        $is_accepted = '0';
        if(!is_null($request->id) && $request->id!='0')
        {
            $is_accepted = 1;
            $student = Student::updateOrCreate(
                ['pid'=>$request->id],
                [
                    'nis' => $request->nis,
                    'nisn' => $request->nisn,
                    'cby' => auth()->user()->id,
                    'uby' => '0'
                ]);
        }
        Ppdb::where('pid',$request->id)
            ->update([
                'is_accepted' => $is_accepted,
        ]);
        echo 'Berhasil';
    }
    public function lulus(Request $request)
    {
        // $is_granted = '0';
        // if(!is_null($request->chk) && $request->chk!='0')
        // {
        //     $is_granted = 1;
        //     $student = Student::updateOrCreate(
        //         ['pid'=>$request->id],
        //         [
        //             'nis' => $request->nis,
        //             'nisn' => $request->nisn,
        //             'cby' => auth()->user()->id,
        //             'uby' => '0'
        //         ]);
        // }
        $lulus = Ppdb::where('pid',$request->id)->first();
        $granted = 0;
        if($lulus->is_granted=='0')
        {
            $granted = '1';
        }
        Ppdb::where('pid',$request->id)
            ->update([
                'is_granted' => $granted,
        ]);
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
    public function setting(Request $request)
    {
        $app = array();
        $app['aktif'] = $this->global['aktif'].'/setting';
        $app['judul'] = 'Setting PPDB';
        $app['ppdbset'] = PpdbSet::select('aa_ppdb_set.*','aa_academic_year.name as ayname')
            ->join('aa_academic_year','ayid','=','aa_academic_year.id')->get();
        $app['tahunajar'] = AcademicYear::get();
        return view('halaman.registrasi-main-setting',$app);
    }
    public function set_active(Request $request)
    {
        $id = $request->id;
        PpdbSet::query()->update(['is_publish'=>'0']);
        $ppdb = PpdbSet::where('id',$id)
            ->update(['is_publish'=>'1']);
        echo 'Berhasil';
    }
    public function edit_setting(Request $request)
    {
        $id = $request->id;
        $app = array(['mendaftar'=>array(),'lulus'=>array(),'all'=>array()]);
        // $udata = UsersData::where('uid',auth()->user()->id)->first();
        $app['aktif'] = $this->global['aktif'].'/setting';
        $app['judul'] = 'Setting '.$this->global['judul'];
        $app['ppdbset'] = PpdbSet::where('id',$id)->first();
        $app['ay'] = AcademicYear::get();
        $app['school'] = School::get();
        $app['sekolah'] = $request->sekolah;
        // $app['biayadaftarulang'] = FinCost::where('type','3')->get();
        $app['all'] = Ppdb::getall($id);
        if(auth()->user()->role=='3')
        {
            $app['all'] = collect($app['all'])->where('school_id',$udata->sid);
            $app['all'] = json_decode(json_encode($app['all']), true);
            $app['mendaftar'] = 0;
            $app['lulus'] = 0;
            foreach($app['all'] as $k=>$v)
            {
                $app['mendaftar'] += 1;
                if($v['is_granted']=='1')
                {
                    $app['lulus'] += 1;
                }
            }
        }
        else
        {
            $app['all'] = json_decode(json_encode(collect($app['all'])), true);
            $app['mendaftar'] = 0;
            $app['lulus'] = 0;
            foreach($app['all'] as $k=>$v)
            {
                $app['mendaftar'] += 1;
                if($v['is_granted']=='1')
                {
                    $app['lulus'] += 1;
                }
            }
        }
        if($request->sekolah!='')
        {
            $app['sekolah'] = $request->sekolah;
            $app['all'] = ($request->sekolah!='0') ? collect($app['all'])->where('school_id',$request->sekolah) : collect($app['all']);
            $app['all'] = json_decode(json_encode($app['all']), true);
            $app['mendaftar'] = 0;
            $app['lulus'] = 0;
            foreach($app['all'] as $k=>$v)
            {
                $app['mendaftar'] += 1;
                if($v['is_granted']=='1')
                {
                    $app['lulus'] += 1;
                }
            }
        }
        return view('halaman.registrasi-setting',$app);
    }
    public function savesetting(Request $request)
    {
        if($request->ajax())
        {
            $datas = array();
            parse_str($request->data, $datas);
            $thajar = AcademicYear::where('id',$datas['ayid'])->first();
            if(!isset($datas['name']))
            {
                $datas['name'] = 'PPDB '.$thajar->name;
                $datas['desc'] = 'Penerimaan Peserta Didik Baru Tahun Ajaran '.$thajar->name;
                unset($datas['id']);
            }
            $ppdbset = PpdbSet::updateOrCreate(
                ['ayid'=>$datas['ayid']],
                [
                    'url'=>(isset($datas['url'])) ? $datas['url'] : str_replace('/','-',$thajar->name),
                    'name'=>$datas['name'],
                    'desc'=>$datas['desc'],
                    'start_date'=>$datas['start_date'],
                    'end_date'=>$datas['end_date'],
                    'uby'=>auth()->user()->id,
                    'uon'=>date('Y-m-d H:i:s')
                ]
            );
            echo 'Berhasil|'.$ppdbset->id;
        }
        else
        {
            echo 'not authorize';
        }
    }
    public function getsetting(Request $request)
    {
        if($request->ajax())
        {
            $id = $request->id;
            $PpdbSet = PpdbSet::where('id',$id)->first();
            $PpdbSet['cost'] = PpdbCost::where('ppdb_id',$PpdbSet['id'])
                ->join('fin_cost','cost_id','=','fin_cost.id')
                ->select('aa_ppdb_cost.id','fin_cost.name','aa_ppdb_cost.amount','cost_id')
                ->get();
            $PpdbSet['allcost'] = FinCost::where('is_active','1')->get();
            echo json_encode($PpdbSet);
        }
        else
        {
            echo 'not authorize';
        }
    }
    public function getitemsetting(Request $request)
    {
        if($request->ajax())
        {
            $ppdb_id = $request->id;
            $PpdbSet = PpdbCost::where('ppdb_id',$ppdb_id)
                ->join('fin_cost','cost_id','=','fin_cost.id')
                ->get();
            echo json_encode($PpdbSet);
        }
        else
        {
            echo 'not authorize';
        }
    }
    public function delsetting(Request $request)
    {
        if($request->ajax())
        {
            $id = $request->id;
            PpdbCost::where('ppdb_id',$id)->delete();
            PpdbSet::where('id',$id)->delete();
            echo 'Berhasil';
        }
        else
        {
            echo 'not authorize';
        }
    }
    public function delitemsetting(Request $request)
    {
        if($request->ajax())
        {
            $ppdb_id = $request->id;
            $cost_id = $request->ids;
            PpdbCost::where('ppdb_id',$ppdb_id)->where('cost_id',$cost_id)->delete();
            echo 'Berhasil';
        }
        else
        {
            echo 'not authorize';
        }
    }
    public function additemsetting(Request $request)
    {
        if($request->ajax())
        {
            $datas = array();
            parse_str($request->data, $datas);
            $ppdbset = PpdbCost::updateOrCreate(
                ['ppdb_id'=>$request->id,'cost_id'=>$datas['pilihitem']],
                ['amount'=>$datas['jumlahitem']]
            );
            echo 'Berhasil|'.$request->id;
        }
        else
        {
            echo 'not authorize';
        }
    }
    public function goto(Request $request)
    {
        $url = $request->url;
        $app = array();
        $ppdb = PpdbSet::where('url',$url)->first();
        if(!empty($ppdb))
        {
            $app['header'] = $ppdb->header;
            $app['body'] = $ppdb->body;
            $app['footer'] = $ppdb->footer;
            $app['title'] = $ppdb->name;
            $app['desc'] = $ppdb->desc;
            return view('ppdb',$app);
        }
        else
        {
            abort(404);
        }
    }
    public function getSchoolNISN(Request $request)
    {
        $id = $request->id;
        $sekolah = School::where('institution_id',$id)->first()->is_nisn_mandatory;
        echo $sekolah;
    }
    public function card(Request $request)
    {
        $noregis = $request->id;
        echo $noregis;
    }
    public function bayar(Request $request)
    {
        $payment = PpdbPayment::where('invoice_id',$request->inv)
            ->update(
                [
                    'pay_cash' => $request->bayar,
                    'pay_date' => $request->tgl,
                    'return' => $request->kembalian,
                    'status' => 'LUNAS',
                ]);

        echo 'Berhasil';
    }
    public function list(Request $request)
    {
        $page = 'dashboard';
        $data = array();
        $data['pengumuman'] = '';
        $data['aktif'] = 'list_siswa';
        $data['judul'] = 'Daftar ';
        $data['sekolah'] = School::get();
        $page = 'halaman.student-ortu';
        $data['student'] = Person::where('user_id',auth()->user()->id)
            ->select('aa_ppdb.id as ppdb_id','aa_person.name','aa_school.name as nameschool','aa_ppdb.registration_id','aa_student.nis','aa_ppdb.is_granted','aa_person.id','aa_academic_year.name as thnajar')
            ->join('aa_ppdb','aa_ppdb.pid','=','aa_person.id')
            ->leftJoin('aa_academic_year','aa_academic_year.id','=','aa_ppdb.academic_year_id')
            ->leftJoin('aa_school','school_id','=','aa_school.id')
            ->leftJoin('aa_student','aa_student.pid','=','aa_person.id')
            ->orderBy('aa_person.con','desc')
            ->paginate(config('paging'));
        $data['payment'] = PpdbPayment::get();
        $data['user'] = User::where('id',auth()->user()->id)->first();
        return view($page,$data);
    }
    public function cekpembayaran(Request $request)
    {
        $data = array();
        $student = Person::where('user_id',auth()->user()->id)
            ->select('aa_ppdb.id as ppdb_id','aa_person.name','aa_school.name as nameschool','aa_ppdb.registration_id','aa_student.nis','aa_ppdb.is_granted','aa_person.id')
            ->join('aa_ppdb','aa_ppdb.pid','=','aa_person.id')
            ->leftJoin('aa_school','school_id','=','aa_school.id')
            ->leftJoin('aa_student','aa_student.pid','=','aa_person.id')
            ->orderBy('aa_person.con','desc')
            ->where('aa_person.id',$request->id)->first();
        $pembayaran = PpdbPayment::where('ppdb_id','=',$student->ppdb_id)
            ->join('fin_cost','fin_cost.id','=','bill_id')
            ->get();
        if(empty($pembayaran))
        {
            echo 'Belum ada data';
            die();
        }
        $no = 1;
        foreach($pembayaran as $key=>$val)
        {
            echo '<tr>';
            echo '<td>'.$no.'</td>';
            echo '<td>'.$val['pay_date'].'</td>';
            echo '<td>'.$val['name'].'</td>';
            echo '<td>'.number_format($val['amount'],0,',','.').'</td>';
            echo '<td>'.$val['status'].'</td>';
            echo '</tr>';
            $no++;
        }
    }
    /**
        * Laporan PPDB
        */
    public function report(Request $request)
    {
        $data = array();
        $data['aktif'] = 'ppdb/laporan';
        $data['judul'] = 'Laporan PPDB';

        return view('halaman.daftar-laporan', $data);
    }

    public function reportCandidate(Request $request)
    {
        $data = array();
        $data['aktif'] = 'ppdb/laporan';
        $data['judul'] = 'Laporan PPDB >> Calon Siswa';
        $datasekolah = UsersData::where('uid',auth()->user()->id)->get()->pluck('sid');
        $data['sekolah'] = (auth()->user()->role=='3') ? School::whereIn('id',$datasekolah)->get() : School::get();
        $data['siswa'] = array();
        $data['pilihsekolah'] = $request->pilihsekolah;
        if($request->post()){
            $idppdb = PpdbSet::where('is_publish','1')->first()->id;
            $data['siswa'] = Ppdb::where('id_ppdb',$idppdb)
                ->join('aa_person as p','aa_ppdb.pid','=','p.id')
                ->join('aa_address as d','aa_ppdb.pid','=','d.pid')
                ->join('aa_school','school_id','=','aa_school.id')
                ->leftJoin('id_provinces as pr','d.province','=','pr.code')
                ->leftJoin('id_cities as c','d.city','=','c.code')
                ->leftJoin('id_districts as di','d.district','=','di.code')
                ->leftJoin('id_villages as v','d.village','=','v.code')
                ->select('registration_id','p.name','previous_school','address','whatsapp','aa_school.name as school_name','is_granted','aa_ppdb.nisn','father_temp','mother_temp','information_from','father_job_temp','mother_job_temp','dob','sex','pob','address','pr.name as provincename','c.name as cityname','di.name as districtname','v.name as villagename','post_code');
            $data['siswa'] = ($data['pilihsekolah']!='0') ? $data['siswa']->where('school_id',$request->pilihsekolah)->get() : $data['siswa']->get();
        }

        return view('halaman.daftar-laporan-kandidat', $data);
    }
    public function reportPayment(Request $request)
    {
        $data = array();
        $data['aktif'] = 'ppdb/laporan';
        $data['judul'] = 'Laporan PPDB >> Pembayaran';
        $datasekolah = UsersData::where('uid',auth()->user()->id)->get()->pluck('sid');
        $data['sekolah'] = (auth()->user()->role=='3') ? School::whereIn('id',$datasekolah)->get() : School::get();
        $data['pembayaran'] = array();
        $data['pilihsekolah'] = $request->pilihsekolah;
        $data['tgl_awal'] = $request->tgl_awal;
        $data['tgl_akhir'] = $request->tgl_akhir;
        if($request->post()){
            $idppdb = PpdbSet::where('is_publish','1')->first()->id;
            $data['pembayaran'] = PpdbPayment::whereRaw('IF(ISNULL(pay_date), DATE(aa_ppdb_payment.con) BETWEEN "'.$data['tgl_awal'].'" AND "'.$data['tgl_akhir'].'", pay_date BETWEEN "'.$data['tgl_awal'].'" AND "'.$data['tgl_akhir'].'")')
                ->where('status','LUNAS')
                ->where('id_ppdb',$idppdb)
                ->join('aa_ppdb','aa_ppdb.id','=','aa_ppdb_payment.ppdb_id')
                ->join('aa_person','aa_person.id','=','aa_ppdb.pid')
                ->join('aa_school','school_id','=','aa_school.id')
                ->selectRaw('aa_person.name as nama, aa_ppdb.registration_id, IF(ISNULL(pay_date), DATE(aa_ppdb_payment.con),pay_date) paydate, aa_ppdb_payment.name, invoice_id, method, amount, aa_school.name as school_name');
            $data['pembayaran'] = ($data['pilihsekolah']!='0') ? $data['pembayaran']->where('school_id',$request->pilihsekolah)->get() : $data['pembayaran']->get();

        }

        return view('halaman.daftar-laporan-pembayaran',$data);
    }
    public function reportPaymentTabular(Request $request)
    {
        $data = array();
        $data['aktif'] = 'ppdb/laporan';
        $data['judul'] = 'Laporan PPDB >> Pembayaran Tabular';
        $datasekolah = UsersData::where('uid',auth()->user()->id)->get()->pluck('sid');
        $data['sekolah'] = (auth()->user()->role=='3') ? School::whereIn('id',$datasekolah)->get() : School::get();
        $data['pembayaran'] = array();
        $data['pembayarandetail'] = array();
        $data['cost'] = FinCost::where('type','3')->get();
        $data['pilihsekolah'] = $request->pilihsekolah;
        $data['tgl_awal'] = $request->tgl_awal;
        $data['tgl_akhir'] = $request->tgl_akhir;
        if($request->post()){
            $data['pembayaran'] = FinPayment::orderBy('payment_date')
                ->join('aa_person','pid','=','aa_person.id')
                ->join('aa_school','sid','=','aa_school.id')
                ->select('aa_person.*','aa_school.name as school_name','invoice_id','amount','payment_date','method','channel','desc','fin_payment.id as hdr');
            $data['pembayaran'] = ($data['tgl_awal']==$data['tgl_akhir'])
                ? $data['pembayaran']->whereRaw('DATE(payment_date)="'.$data['tgl_awal'].'"')
                : $data['pembayaran']->whereRaw('DATE(payment_date) BETWEEN "'.$data['tgl_awal'].'" AND "'.$data['tgl_akhir'].'"');
            $data['pembayaran'] = ($data['pilihsekolah']=='0')
                ? $data['pembayaran']->get()
                : $data['pembayaran']->where('sid',$data['pilihsekolah'])->get();
            $data['pembayarandetail'] = FinPaymentDetail::get();
        }

        return view('halaman.daftar-laporan-pembayaran-tabular',$data);
    }
    public function getDataFromId(Request $request)
    {
        $id = $request->id;
        if ($request->type == 'tagihan') {
            $data = Ppdb::where('pid', $id)
                ->join('aa_person', 'pid', '=', 'aa_person.id')
                ->join('aa_school', 'school_id', '=', 'aa_school.id')
                ->join('rf_school_type', 'school_type_id', '=', 'rf_school_type.id')
                ->select('registration_id', 'aa_person.name as nama', 'aa_school.name as namasekolah', 'aa_school.id as idsekolah', 'level')
                ->first();
            $idsekolah = $data->idsekolah;
            $level = $data->level;
            $biayasekolah = FinCostSchool::where('sid', $idsekolah)
                ->join('fin_cost', 'fin_cost.id', '=', 'cost_id')
                ->whereRaw('type like "%3%"')
                ->where('level','1')
                ->where('ayid', config('id_active_academic_year'))
                ->select('fin_cost_school.id', 'fin_cost.name', 'fin_cost_school.amount','cost_id')
                ->get();
            $diabayar = FinPayment::where('pid',$id)->get();
            $datadetail = array();
            $i = 0;
            foreach($diabayar as $k=>$v)
            {
                $detail = FinPaymentDetail::where('hdr_id',$v->id)->get();
                foreach($detail as $dk=>$dv)
                {
                    $datadetail[$i]['cost_id'] = $dv->cost_id;
                    $datadetail[$i]['amount'] = $dv->amount;
                    $i++;
                }
            }
            $textbiaya = '';
            foreach ($biayasekolah as $ky => $vl) {
                $amount = $vl->amount;
                for($j=0;$j<count($datadetail);$j++)
                {
                    if($datadetail[$j]['cost_id']==$vl->cost_id)
                    {
                        $amount = $amount - $datadetail[$j]['amount'];
                    }
                }

                $textbiaya .= '<tr>';
                $textbiaya .= '<td width="10%">';
                $textbiaya .= '<input type="checkbox" id="check'.$vl->cost_id.'" name="check'.$vl->cost_id.'" onchange="pilihbiaya('.$vl->cost_id.','."'".number_format($amount,0,',','')."'".')" >';
                $textbiaya .= '<input type="hidden" name="default'.$vl->cost_id.'" id="default'.$vl->cost_id.'" value="'.number_format($amount,0,',','').'">';
                $textbiaya .= '<input type="hidden" name="subtotal'.$vl->cost_id.'" id="subtotal'.$vl->cost_id.'" value="'.number_format($amount,0,',','').'">';
                $textbiaya .= '</td>';
                $textbiaya .= '<td>' . $vl->name . '</td>';
                $textbiaya .= '<td style="text-align:right;" id="tdsubtotal'.$vl->cost_id.'">' . number_format($amount, 0, ',', '.') . '</td>';
                // $textbiaya .= '<td style="text-align:right;"><input type="number" name="diskon[]" id="diskon'.$vl->cost_id.'" value="0" class="form-control form-control-sm text-right" onblur="fnblur('.$vl->cost_id.')"/></td>';
                $textbiaya .= '<td style="text-align:right;"><input type="number" onblur="manual('.$vl->cost_id.')" name="truesubtotal[]" id="truesubtotal'.$vl->cost_id.'" class="form-control form-control-sm text-right subtotal" value="0"></td>';
                $textbiaya .= '</tr>';
            }
            echo $textbiaya;
        }
        elseif($request->type == 'riwayat')
        {
            $data = array();
            $i = 0;
            $riwayat = FinPayment::where('pid',$id)->get();
            $orang = Person::where('aa_person.id',$id)
                ->join('aa_ppdb','aa_ppdb.pid','=','aa_person.id')
                ->first();
            foreach($riwayat as $kk=>$vv)
            {
                // DB::enableQueryLog();
                $datadetail = FinPaymentDetail::where('hdr_id',$vv->id)
                    ->join('fin_cost','fin_cost.id','=','cost_id')
                    ->select('cost_id','name','amount')
                    ->get();
                $costschool = FinCostSchool::where('ayid',config('id_active_academic_year'))
                    ->where('sid',$orang->school_id)
                    ->where('type','3')
                    ->join('fin_cost','fin_cost.id','=','cost_id')
                    ->get()->toArray();
                // echo '<pre>';print_r($costschool);die();
                foreach($datadetail as $dk=>$dv)
                {
                    $tunggakan = 0;
                    for($aa=0;$aa<count($costschool);$aa++)
                    {
                        if($costschool[$aa]['cost_id'] == $dv->cost_id)
                        {
                            $tunggakan = $costschool[$aa]['amount'];
                        }
                    }
                    $data[$i]['invoice'] = $vv->invoice_id;
                    $data[$i]['tgl'] = $vv->payment_date;
                    $data[$i]['komponen'] = $dv->name;
                    $data[$i]['tunggakan'] = $tunggakan;
                    $data[$i]['jumlahbayar'] = $dv->amount;
                    $i++;
                }
            }
            $datacollect = collect($data);
            $datac = array_keys($datacollect->groupBy('invoice')->toArray());
            for($i=0;$i<count($datac);$i++)
            {
                $satudata = $datacollect->where('invoice',$datac[$i])->first();
                $semuadata = $datacollect->where('invoice',$datac[$i])->toArray();
                echo '<tr>';
                echo '<td><a href="'.url('daftarulang/'.$datac[$i].'/kwitansi').'" target="_blank">'.$datac[$i].'</a></td>';
                echo '<td>'.date('Y-m-d',strtotime($satudata['tgl'])).'</td>';
                echo '<td>';
                $n=0;
                foreach($semuadata as $kkk=>$vvv)
                {
                    if($vvv['jumlahbayar']!='0')
                    {
                        echo ($n!=0) ? '<br>' : '';
                        echo $vvv['komponen'];
                        $n++;
                    }
                }
                echo '<br><b>TOTAL :</b>';
                echo '</td>';
                echo '<td style="text-align:right;">';
                $n=0; $tunggakan = 0;
                foreach($semuadata as $kkk=>$vvv)
                {
                    if($vvv['jumlahbayar']!='0')
                    {
                        echo ($n!=0) ? '<br>' : '';
                        echo number_format($vvv['tunggakan'],0,',','.');
                        $tunggakan += $vvv['tunggakan'];
                        $n++;
                    }
                }
                echo '<br><b>==========</b>';
                echo '</td>';
                echo '<td style="text-align:right;">';
                $n=0; $jumlahbayar = 0;
                foreach($semuadata as $kkk=>$vvv)
                {
                    if($vvv['jumlahbayar']!='0')
                    {
                        echo ($n!=0) ? '<br>' : '';
                        echo number_format($vvv['jumlahbayar'],0,',','.');
                        $jumlahbayar += $vvv['jumlahbayar'];
                        $n++;
                    }
                }
                echo '<br><b>'.number_format($jumlahbayar,0,',','.').'</b>';
                echo '</td>';
                echo '<td><a href="javascript:printlagi('."'".$datac[$i]."'".')" class="btn btn-sm btn-danger"><i class="fas fa-print"></i></a></td>';
                echo '</tr>';
            }
        }
        else
        {
            $data = array();
            $data = Person::where('aa_person.id',$id)
                ->join('aa_ppdb','pid','=','aa_person.id')
                ->join('aa_school','school_id','=','aa_school.id')
                ->select('aa_person.name as nama','aa_school.name as namasekolah','is_accepted')
                ->first();
            echo '<table class="table table-striped"><tr>';
            echo '<td>Sekolah : </td><td>'.$data['namasekolah'].'</td>';
            echo '</tr><tr>';
            echo '<td>Nama Siswa : </td><td>'.$data['nama'].'</td>';
            echo '</tr></table>';
            echo '|^|'.$data['is_accepted'];
            $siswa = Student::where('aa_student.pid',$id)->first();
            if(!is_null($siswa))
            {
                echo '|^|';
                echo $siswa->nis.','.$siswa->nisn;
            }
        }
    }
    public function registrationpayment(Request $request)
    {
        $datas = array();
        parse_str($request->data, $datas);
        $id = $request->id;
        $orang = Person::where('aa_person.id',$id)
            ->join('aa_ppdb','pid','=','aa_person.id')
            ->first();
        $jmhbaris = FinPayment::whereRaw('YEAR(payment_date) = '.date('Y'))->get();
        $app['jmhbaris'] = count($jmhbaris)+1;
        $app['inv'] = 'INV'.date('ymd').str_pad($app['jmhbaris'],4,"0", STR_PAD_LEFT);
        $simpan = new FinPayment;
        $simpan->ayid = config('id_active_academic_year');
        $simpan->sid = $orang->school_id;
        $simpan->pid = $id;
        $simpan->method = $datas['method'];
        $simpan->channel = $datas['transfer'];
        $simpan->invoice_id = $app['inv'];
        $simpan->payment_date = $datas['tgl'];
        $simpan->desc = $datas['desc'];
        $simpan->amount = $datas['amounttotal'];
        $simpan->cby = auth()->user()->id;
        $simpan->save();

        $datadetail = array();
        $detail = explode(',',$datas['payment_item']);
        $detailh = explode(',',$datas['payment_amount']);
        $j = 0;
        for($i=0;$i<count($detailh);$i++)
        {
            if($detailh[$i]!='0')
            {
                $datadetail[$j]['ayid'] = config('id_active_academic_year');
                $datadetail[$j]['sid'] = $orang->school_id;
                $datadetail[$j]['pid'] = $id;
                $datadetail[$j]['hdr_id'] = $simpan->id;
                $datadetail[$j]['cost_id'] = $detail[$i];
                $datadetail[$j]['seq'] = $j;
                $datadetail[$j]['date_payment'] = $datas['tgl'];
                $datadetail[$j]['amount'] = $detailh[$i];
                $j++;
            }
        }
        $sekolah = School::where('id',$orang->school_id)->first();
        $simpandetail = FinPaymentDetail::insert($datadetail);
        $text = 'Berhasil|^|';
        $array = array(
            str_pad(strtoupper($sekolah->name),80,' ',STR_PAD_BOTH),
            str_pad('BUKTI PEMBAYARAN',80,' ',STR_PAD_BOTH),
            str_pad('',80,'='),
            str_pad('Invoice : '.$app['inv'],40,' ').str_pad('Tanggal : '.$datas['tgl'],40,' ',STR_PAD_LEFT),
            str_pad('Nama Lengkap : '.$orang->name,40,' ').str_pad('Pembayaran via : '.$datas['method'],40,' ',STR_PAD_LEFT),
            str_pad('Keterangan : '.$datas['desc'],40,' ').str_pad('Transfer via : '.(($datas['transfer']!='0')?$datas['transfer']:'-'),40,' ',STR_PAD_LEFT),
            str_pad('',80,'='),
            'ITEM : ',
        );
        $cost = collect(FinCost::whereIn('id',explode(',',$datas['payment_item']))->get()->toArray());
        for($i=0;$i<count($datadetail);$i++)
        {
            $nama = $cost->where('id',$datadetail[$i]['cost_id'])->toArray();
            $nama = reset($nama);
            $nama = $nama['name'];
            $nama = str_pad($nama,40,' ');
            $amount = str_pad(number_format($datadetail[$i]['amount'],0,',','.'),40,' ',STR_PAD_LEFT);
            $array[count($array)] = $nama.$amount;
        }
        $array[count($array)] = str_pad('',80,'-');
        $array[count($array)] = str_pad('TOTAL : ',40,' ').str_pad(number_format($datas['amounttotal'],0,',','.'),40,' ',STR_PAD_LEFT);
        $baristerakhir = 32-(count($array)+6);
        for($j=0;$j<$baristerakhir;$j++)
        {
            $array[count($array)] = '';
        }
        $array[count($array)] = str_pad('Petugas',40,' ',STR_PAD_BOTH).str_pad('Yang Menyerahkan',40,' ',STR_PAD_BOTH);
        $array[count($array)] = '';
        $array[count($array)] = '';
        $array[count($array)] = '';
        $array[count($array)] = str_pad(auth()->user()->name,40,' ',STR_PAD_BOTH).str_pad('',40,' ');
        $array[count($array)] = str_pad(str_pad('',strlen(auth()->user()->name),'-',STR_PAD_BOTH),40,'-',STR_PAD_BOTH).str_pad(str_pad('',20,'-',STR_PAD_BOTH),40,' ',STR_PAD_BOTH);
        $array[count($array)] = ' ';
        echo $text.json_encode($array);
    }
    public function registrationPaymentPrint(Request $request)
    {
        $inv = $request->id;
        $bayar = FinPayment::where('invoice_id',$inv)
            ->join('aa_school','fin_payment.sid','=','aa_school.id')
            ->join('aa_person','fin_payment.pid','=','aa_person.id')
            ->select('aa_person.*','aa_school.name as school_name','fin_payment.*','fin_payment.id as hdr_id')
            ->first();
        $bayarc = collect($bayar);
        $bayarc['detail'] = FinPaymentDetail::where('hdr_id',$bayarc['hdr_id'])
            ->join('fin_cost','cost_id','=','fin_cost.id')
            ->get()->toArray();
        $this->print_dotmatrix($bayarc);
    }

    function print_dotmatrix($data)
    {
        $text = '';
        $namasekolah = $data['school_name'];
        $inv = $data['invoice_id'];
        $tgl = $data['payment_date'];
        $nama = $data['name'];
        $method = $data['method'];
        $transfer = $data['channel'];
        $desc = $data['desc'];
        $amounttot = number_format($data['amount'], 0, ',', '.');
        $array = array(
            str_pad(strtoupper($namasekolah), 80, ' ', STR_PAD_BOTH),
            str_pad('BUKTI PEMBAYARAN', 80, ' ', STR_PAD_BOTH),
            str_pad('', 80, '='),
            str_pad('Invoice : ' . $inv, 40, ' ') . str_pad('Tanggal : ' . $tgl, 40, ' ', STR_PAD_LEFT),
            str_pad('Nama Lengkap : ' . $nama, 40, ' ') . str_pad('Pembayaran via : ' . $method, 40, ' ', STR_PAD_LEFT),
            str_pad('Keterangan : ' . $desc, 40, ' ') . str_pad('Transfer via : ' . (($transfer != '0') ? $transfer : '-'), 40, ' ', STR_PAD_LEFT),
            str_pad('', 80, '='),
            'ITEM : ',
        );
        $detail = $data['detail'];
        for ($i = 0; $i < count($detail); $i++) {
            if($detail[$i]['amount']=='0')
            {
                continue;
            }
            $nama = $detail[$i]['name'];
            $nama = str_pad($nama, 40, ' ');
            $amount = str_pad(number_format($detail[$i]['amount'], 0, ',', '.'), 40, ' ', STR_PAD_LEFT);
            $array[count($array)] = $nama . $amount;
        }
        $array[count($array)] = str_pad('', 80, '-');
        $array[count($array)] = str_pad('TOTAL : ', 40, ' ') . str_pad((string)$amounttot, 40, ' ', STR_PAD_LEFT);
        $baristerakhir = 32 - (count($array) + 6);
        for ($j = 0; $j < $baristerakhir; $j++) {
            $array[count($array)] = '';
        }
        $array[count($array)] = str_pad('Petugas', 40, ' ', STR_PAD_BOTH) . str_pad('Yang Menyerahkan', 40, ' ', STR_PAD_BOTH);
        $array[count($array)] = '';
        $array[count($array)] = '';
        $array[count($array)] = '';
        $array[count($array)] = str_pad(auth()->user()->name, 40, ' ', STR_PAD_BOTH) . str_pad('', 40, ' ');
        $array[count($array)] = str_pad(str_pad('', strlen(auth()->user()->name)+5, '-', STR_PAD_BOTH), 40, ' ', STR_PAD_BOTH) . str_pad(str_pad('', 20, '-', STR_PAD_BOTH), 40, ' ', STR_PAD_BOTH);
        $array[count($array)] = ' ';
        echo $text . json_encode($array);
    }
}
