<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Person;
use App\Models\Ppdb;
use App\Models\User;
use App\Models\UserConfig;
use App\Models\CourseClass;
use App\Models\HrAttendance;
use App\Models\HrAttendanceDuty;
use App\Models\Employe;
use App\Models\HrComponent;
use App\Models\HrComponentPosition;
use App\Models\MainDuties;
use App\Models\Log;
use App\Models\MenuModul;
use App\Models\RfModul;
use App\Models\MsNotif;
use App\SmartSystem\General;
use App\SmartSystem\OneSignalLibrary;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $path = str_replace('/', '', $request->getPathInfo());
        $modul = RfModul::get();
        $menumodul = MenuModul::join('menu','menu_id','=','menu.id')->get();
        $data = array();
        $data['modul'] = $modul;
        $data['menu'] = $menumodul;
        switch ($path) {
            case 'home':
                $page = 'dashboard';
                $data['pengumuman'] = '';
                $data['aktif'] = 'home';
                $data['judul'] = 'Dashboard';
                $data['person'] = array();
                $data['course'] = CourseClass::orderBy('name')->get();
                if(auth()->user()->role=='2')
                {
                    // $cekmobile = strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile');
                    // $cekwv = strpos($_SERVER['HTTP_USER_AGENT'],'wv');
                    // if ($cekmobile !== false && $cekwv !== false)
                    // {
                        return Redirect('mobile/home');
                    // }
                    // else
                    // {
                    //     $data['profil'] = General::getProfil();
                    //     $data['user'] = $data['profil']['user'];
                    //     $page = 'dashboard-ortu';
                    // }
                }
                elseif(auth()->user()->role=='3')
                {
                    $moduluser = \App\SmartSystem\General::cekmenu(auth()->user()->id);
                    $data['moduluser'] = array_keys($moduluser->groupBy('modul_id')->all());
                    $page = 'dashboard-guru';
                    $data['person'] = Person::where('id',auth()->user()->pid)->first();
                    $data['user'] = User::where('id',auth()->user()->id)->first();
                    $data['hrAttendance'] = HrAttendance::where('pid',auth()->user()->pid)
                        // ->join('hr_attendance_duty','attendance_id','=','hr_attendance.id')
                        // ->join('hr_component','duty_id','=','hr_component.id')
                        ->orderBy('hr_attendance.con','desc')
                        ->paginate(10);
                    $data['tupoksi'] = HrComponent::getPerPerson(auth()->user()->pid);
                }
                return view($page,$data);
                break;
            default:
                $view = 'halaman.' . $path;
                if (view()->exists($view)) {
                    return view('halaman.' . $path);
                } else {
                    return abort(404);
                }
                break;
        }
    }
    public function tambahsiswa()
    {
        return view('halaman.tambah-siswa');
    }
    public function panduanortu()
    {
        return view('halaman.panduan-ortu');
    }
    public function hp(Request $request)
    {
        $hp = $request->hp;
        User::where('email',auth()->user()->email)
            ->update([
                'handphone' => $hp,
            ]);
        echo 'Berhasil';
    }
    public function gettupoksi(Request $request)
    {
        $employe = Employe::where('pid',auth()->user()->pid)->first();
        $tupoksi = HrComponentPosition::where('position_id',$employe->position_id)
            ->join('hr_component as hc','hc.id','=','component_id')
            ->select('hc.id','hr_component_position.is_overtime','name','desc')->get();
        foreach($tupoksi as $v=>$k)
        {
            echo '<tr>';
            echo '<td><input type="checkbox" name="chk[]" id="chk'.$k->id.'" value="'.$k->id.'"></td>';
            $lembur = ($k->is_overtime=='1') ? '<span class="badge badge-warning">Lembur</span>' : '';
            echo '<td ><label for="chk'.$k->id.'">'.wordwrap($k->desc,50,"<br>\n").' '.$lembur.'</label></td>';
            echo '</tr>';
        }
    }
    public function getrealisasi(Request $request)
    {
        $id = $request->id;
        $employe = Employe::where('pid',auth()->user()->pid)->first();
        $tupoksiterpilih = HrAttendanceDuty::where('attendance_id',$id)
            ->join('hr_component','duty_id','=','hr_component.id')
            ->select('hr_component.*')
            ->get();
        $hrattendance = HrAttendance::where('id',$id)->first();
        foreach($tupoksiterpilih as $v=>$k)
        {
            echo '<tr>';
            $done = '<input type="checkbox" name="chk[]" id="chk'.$k->id.'" value="'.$k->id.'">';
            $done = '<label class="switch">
                        <input type="checkbox" name="chk[]" id="chk'.$k->id.'" class="primary" value="'.$k->id.'">
                        <span class="slider round"></span>
                    </label>';
            $nama = '<div class="row">
                    <div class="col-md-6 col-sm-12"><label for="chk'.$k->id.'">'.wordwrap($k->desc,30,"<br>\n").'</label></div>
                    <div class="col-md-6 col-sm-12"><input type="hidden" name="id[]" value="'.$k->id.'"><input type="number" class="form-control" name="is_done[]" id="is_done'.$k->id.'" value="0" onKeyPress="if(this.value.length==3) return false;"></div>
                </div>';
            echo '<td colspan="2">'.$nama.'</td>';
            echo '</tr>';
        }
    }
    public function savetupoksi(Request $request)
    {
        $datas = array();
        parse_str($request->data, $datas);

        $datas['entry_timestamp'] = $datas['timestamp'];
        $datas['pid'] = auth()->user()->pid;
        $datas['ip'] = request()->ip();
        $attendance = HrAttendance::create([
            'entry_timestamp' => $datas['timestamp'],
            'pid' => auth()->user()->pid,
            'ip' => request()->ip(),
            'cby' => auth()->user()->id,
        ]);

        $id = $attendance->id;
        $duty = [];
        for($i=0;$i<count($datas['chk']);$i++)
        {
            $duty[] = ['attendance_id'=>$id,'duty_id'=>$datas['chk'][$i]];
        }
        $duty = HrAttendanceDuty::insert($duty);

        //LOG
        $log['ip'] = request()->ip();
        $log['nama_login'] = auth()->user()->email;
        $log['role_id'] = auth()->user()->role;
        $log['detail'] = auth()->user()->name.' absen.';

        $savelog = \App\SmartSystem\General::log($log);
        Log::create($log);

        echo 'Berhasil';
    }
    public function savetupoksikeluar(Request $request)
    {
        $datas = array();
        parse_str($request->data, $datas);
        $datas['exit_timestamp'] = $datas['timestampkeluar'];
        $attd = HrAttendance::where('id',$datas['attendance_id'])->first();
        $datas['pid'] = auth()->user()->pid;
        $datas['ip'] = request()->ip();
        // Hitung Durasi Manual, takut kosong
        $tgl1 = strtotime($attd['entry_timestamp']);
        $tgl2 = strtotime($datas['exit_timestamp']);
        $jarak = $tgl2 - $tgl1;
        $datas['duration'] = ($datas['duration']=='0'||$datas['duration']=='') ? (int)($jarak/60) : $datas['duration'];
        $attendance = HrAttendance::where('id',$datas['attendance_id'])
            ->update([
                'exit_timestamp' => $datas['exit_timestamp'],
                'duration' => $datas['duration'],
                'duration_manual' => $datas['durationmanual'],
                'pid' => auth()->user()->pid,
                'ip' => request()->ip(),
                'cby' => auth()->user()->id,
        ]);
        for($i=0;$i<count($datas['id']);$i++)
        {
            HrAttendanceDuty::where('attendance_id',$datas['attendance_id'])
                ->where('duty_id',$datas['id'][$i])
                ->update(['is_done'=>$datas['is_done'][$i]]);
        }

        //LOG
        $log['ip'] = request()->ip();
        $log['nama_login'] = auth()->user()->email;
        $log['role_id'] = auth()->user()->role;
        $log['detail'] = auth()->user()->name.' keluar.';
        $savelog = \App\SmartSystem\General::log($log);
        Log::create($log);

        echo 'Berhasil';
    }
    public function deleteabsen(Request $request)
    {
        if($request->ajax())
        {
            $id = $request->id;
            HrAttendance::where('id',$id)->delete();
            HrAttendanceDuty::where('attendance_id',$id)->delete();
            echo 'Berhasil';
        }
    }
    public function AttendanceReport(Request $request)
    {
        $id = $request->id;
    }
    public function rekapabsen(Request $request)
    {
        $id = auth()->user()->id;
        $app['judul'] = 'Rekap Absen';
        // $app['absen'] = HrAttendance::where('')
    }
    public function AttendanceNotes(Request $request)
    {
        $id = $request->id;
        $data['header'] = HrAttendance::where('id',$id)->first();
        $data['detail'] = HrAttendanceDuty::where('attendance_id',$id)
            ->join('hr_component','duty_id','=','hr_component.id')->get();
        echo json_encode($data);
    }
    public function saveAttendanceNotes(Request $request)
    {
        $datas = array();
        parse_str($request->data, $datas);
        $entry = HrAttendance::where('id',$datas['idAbsen'])
            ->selectRaw('date(entry_timestamp) as tgl,entry_timestamp as waktu')->first();
        $compare = round((strtotime($entry['tgl'].' '.$datas['exit_manual']) - strtotime($entry['waktu'])) / 60);
        HrAttendance::where('id',$datas['idAbsen'])
            ->update([
                'exit_manual' => $entry['tgl'].' '.$datas['exit_manual'],
                'duration' => $compare,
                'duration_manual' => $datas['duration_manual'],
                'notes' => $datas['notes'],
                'uby' => auth()->user()->id,
            ]);
        $no = 0;
        $detail = array();
        foreach($datas['id_ba'] as $k=>$v)
        {
            $detail[$no] = array(
                'duty_id'=>$v,
                'duration'=>$datas['is_done_ba'][$no],
            );
            $detail[$no]['is_done'] = ($datas['is_done_ba'][$no]!=0&&$datas['is_done_ba'][$no]!='') ? '1' : '';
            HrAttendanceDuty::updateOrCreate(
                ['attendance_id'=>$datas['idAbsen'],'duty_id'=>$detail[$no]['duty_id']],
                ['is_done'=>$detail[$no]['duration']]
            );
            $no++;
        }
        echo 'Berhasil';
    }
    public function saveLateTupoksi(Request $request)
    {
        $datas = array();
        parse_str($request->data, $datas);
        $paramip = array('nama_login'=>auth()->user()->name,'role_id'=>auth()->user()->role,'detail'=>'absen manual');
        $selisih = strtotime($datas['exit_timestamp']) - strtotime($datas['entry_timestamp']);
        $durasi = round(abs($selisih) / 60,2);
        $datas['ip'] = \App\SmartSystem\General::log($paramip);
        $header = HrAttendance::create([
            'entry_timestamp' => $datas['entry_timestamp'],
            'exit_manual' => $datas['exit_timestamp'],
            'duration' => $durasi,
            'duration_manual' => $datas['duration_manual'],
            'notes' => $datas['n_notes'],
            'ip' => $datas['ip']['ip'],
            'pid' => auth()->user()->pid,
            'cby' => auth()->user()->pid,
        ]);
        $header_id = $header->id;
        for($i=0;$i<count($datas['is_chk_done']);$i++)
        {
            if($datas['is_chk_done'][$i]!='0')
            {
                HrAttendanceDuty::create([
                    'attendance_id' => $header_id,
                    'duty_id' => $datas['idchk'][$i],
                    'is_done' => $datas['is_chk_done'][$i],
                ]);
            }
        }
        echo 'Berhasil';
    }
    public function convert_to_hijr(Request $request)
    {
        $tgl = $request->tgl;
        $bln = $request->bln;
        $thn = $request->thn;
        $separator = '';

        $g = new General;
        echo $g->convertToHijriah($thn,$bln,$tgl,$separator);
    }
    public function switchTerm(Request $request)
    {
        $datas = array();
        parse_str($request->data, $datas);
        if($datas['tahunajar']=='reset')
        {
            UserConfig::where('uid',auth()->user()->id)->delete();
        }
        else
        {
            $userconfig = UserConfig::where('uid',auth()->user()->id);
            if($userconfig->exists())
            {
                $userconfig->update([
                    'ayid' => $datas['tahunajar'],
                    'tid' => $datas['semester'],
                    'date_change' => date('Y-m-d'),
                ]);
            }
            else
            {
                $crf = new UserConfig;
                $crf->uid = auth()->user()->id;
                $crf->ayid = $datas['tahunajar'];
                $crf->tid = $datas['semester'];
                $crf->date_change = date('Y-m-d');
                $crf->save();
            }
        }
        echo 'Berhasil';
    }
    public function notif(Request $request)
    {
        $app['aktif'] = 'konfigurasi';
        $app['judul'] = "Notifikasi Android";
        $app['notif'] = MsNotif::orderBy('notif_datetime','desc')->paginate(config('paging'));

        return view('halaman.configuration-notif', $app);
    }
    public function notif_exec(Request $request)
    {
        $datas = array();
        parse_str($request->data, $datas);

        if ($request->ajax()) {
            $pesan = MsNotif::count();
            $array['nama'] = 'Pesan '.($pesan+1).' via EDUSISAPP';
            $array['judul'] = $datas['title'];
            $array['konten'] = $datas['message'];
            $array['url'] = $datas['url'];
            //Kirim onesignal
            $onesignal = OneSignalLibrary::sendMessage($array);
            $array_onesignal = json_decode($onesignal,true);

            //Simpan Database
            $notif = new MsNotif;
            $notif->notif_title = $array['judul'];
            $notif->notif_message = $array['konten'];
            $notif->notif_url = $array['url'];
            $notif->notif_datetime = date('Y-m-d H:i:s');
            $notif->notif_respond = $onesignal;
            $notif->id_respond = $array_onesignal['id'];
            $notif->con = date('Y-m-d H:i:s');
            $notif->cby = auth()->user()->id;
            $notif->save();
            echo 'Berhasil';
        }
    }
    public function notifikasi(Request $request)
    {
        $id = $request->id;
        $app['aktif'] = '#';
        $app['judul'] = "Notifikasi Android";
        $app['notif'] = MsNotif::orderBy('notif_datetime','desc')->paginate(config('paging'));

        return view('halaman.notifikasi', $app);
    }
}
