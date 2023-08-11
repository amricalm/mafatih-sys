<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MainDuties;
use App\Models\HrAttendance;
use App\Models\HrComponent;
use App\Models\HrComponentPosition;
use App\Models\Position;
use App\Models\Employe;
use App\Models\HrAttendanceDuty;
use App\SmartSystem\General;
use Illuminate\Support\Facades\DB;

class HrComponentController extends Controller
{
    var $app;
    public function __construct()
    {
        $this->app['aktif'] = 'komponenkinerja';
        $this->app['judul'] = "Komponen Kinerja Pegawai";
    }
    public function index(Request $request)
    {
        $app = array();
        $app['aktif'] = $this->app['aktif'];
        $app['judul'] = $this->app['judul'];
        $app['data'] = HrComponent::get();

        return view('halaman.hrcomponent', $app);
    }
    public function save(Request $request)
    {
        if($request->post())
        {
            $komponen = HrComponent::updateOrCreate(
                ['id'=>$request->id],
                [
                    'code' => $request->code,
                    'name'=>$request->name,
                    'desc'=>$request->desc,
                    // 'score' => $request->score,
                    'duration_min'=>$request->duration_min,
                    'is_mandatory' => $request->is_mandatory,
                    'is_overtime' => $request->is_overtime,

                ]
            );
            return redirect('komponenkinerja');
        }
    }
    public function show(Request $request)
    {
        $id = $request->id;
        $komponen = HrComponent::where('id',$id)->first();
        $komponen = json_encode($komponen);
        echo $komponen;
    }
    public function get(Request $request)
    {
        $id = $request->id;
        $komponen = HrAttendance::where('hr_attendance.id',$id)
            ->join('aa_person','pid','=','aa_person.id')
            ->select('hr_attendance.*','aa_person.name')
            ->first();
        $lokasi = \App\SmartSystem\General::log(array('ip'=>$komponen->ip,'nama_login'=>'','role_id'=>'','detail'=>''));
        $komponen['lokasi'] = $lokasi;
        $komponendetail = HrAttendanceDuty::where('attendance_id',$id)
            ->join('hr_component','hr_component.id','=','duty_id')
            ->select('hr_attendance_duty.*','hr_component.name')
            ->get();
        echo json_encode(array($komponen,$komponendetail));
    }
    public function saveone(Request $request)
    {
        $id = $request->id;
        $durasi_manual = $request->durasimanual;
        $komponen = HrAttendance::where('id',$id);
        $komponen->update(['duration_manual'=>$durasi_manual]);
        echo 'Berhasil';
    }
    public function delete(Request $request)
    {
        $id = $request->id;
        $hapus = HrComponent::where('id',$id)->delete();
        $hapusItemGroup = HrComponentPosition::where('component_id',$id)->delete();
        echo 'Berhasil';
    }
    public function group(Request $request)
    {
        $app = array();
        $app['aktif'] = 'pemetaankomponenkinerja';
        $app['judul'] = 'Penempatan Komponen Kinerja';
        $app['komponen'] = HrComponent::orderBy('name')->get();
        $app['posisi'] = Position::orderBy('name')->get();

        return view('halaman.hrcomponentposition', $app);
    }
    public function savegroup(Request $request)
    {
        $datas = array();
        parse_str($request->data, $datas);
        $is_mandatory = (!empty($datas['is_mandatory'])) ? '1' : '0';
        $is_overtime = (!empty($datas['is_overtime'])) ? '1' : '0';
        $save = HrComponentPosition::updateOrCreate(
            ['component_id'=>$datas['component_id'],'position_id'=>$request->position_id],
            ['duration_min'=>$datas['duration_min'],'is_mandatory'=>$is_mandatory,'is_overtime'=>$is_overtime,'cby'=>auth()->user()->id,'uby'=>auth()->user()->id]
        );
        echo 'Berhasil';
    }
    public function showgroup(Request $request)
    {
        $id = $request->id;
        $compos = HrComponentPosition::where('position_id',$id)
            ->join('hr_component as hrc','hrc.id','=','component_id')
            ->select('hr_component_position.*','hrc.name','hrc.desc','hrc.code')->get();
        foreach($compos as $ky=>$vl)
        {
            echo '<tr>';
            echo '<td>'.$vl->code.'</td>';
            echo '<td>'.$vl->name.'</td>';
            echo '<td>'.$vl->desc.'</td>';
            echo '<td>'.$vl->duration_min.'</td>';
            $checked = ($vl->is_mandatory=='1') ? 'checked="checked"' : '';
            // echo '<td>
            //     <label class="switch">
            //         <input type="checkbox" name="is_mandatory" id="is_mandatory" class="primary" value="1" '.$checked.' disabled="disabled">
            //         <span class="slider round"></span>
            //     </label>
            // </td>';
            $checked = ($vl->is_overtime=='1') ? 'checked="checked"' : '';
            echo '<td>
                <label class="switch">
                    <input type="checkbox" name="is_overtime" id="is_overtime" class="primary" value="1" '.$checked.' disabled="disabled">
                    <span class="slider round"></span>
                </label>
            </td>';
            echo '<td><button onclick="hapus('.$vl->id.')" class="btn btn-warning"><i class="fa fa-trash"></i></button></td>';
            echo '</tr>';
        }
    }
    public function deletegroup(Request $request)
    {
        $id = $request->id;
        $data = HrComponentPosition::where('id',$id)->first();
        $hapus = HrComponentPosition::where('id',$id)->delete();
        echo 'Berhasil|'.$data['position_id'];
    }
    public function showall(Request $request)
    {
        $all = array();
        $koleksi = Position::leftJoin('hr_component_position','position_id','=','hr_position.id')
            ->leftJoin('hr_component','component_id','=','hr_component.id')
            ->select('hr_position.name as position_name','hr_component.name as component_name','hr_component_position.duration_min','hr_component_position.is_mandatory','hr_component_position.is_overtime')
            ->get();
        $posisi = Position::get();
        $no = 0;
        foreach($posisi as $k=>$v)
        {
            $all[$no]['id'] = $v->id;
            $all[$no]['name'] = $v->name;
            $all[$no]['data'] = $koleksi->where('position_name',$v->name);
            $no++;
        }
        echo json_encode($all);
    }
    public function daftar(Request $request)
    {
        $app['karyawan'] = $request->karyawan;
        $app['beritaacara'] = $request->beritaacara;
        $app['aktif']   = 'kinerjapegawai';
        $app['judul']   = 'Daftar Kinerja Pegawai';
        $app['employe'] = Employe::join('aa_person','pid','=','aa_person.id')
            ->join('hr_position','position_id','=','hr_position.id','left outer')
            ->select('aa_person.*','hr_position.name as position_name','pid')
            ->where('is_active','1')
            ->orderBy('name')->get();
        $att = HrAttendance::orderBy('hr_attendance.con','desc')
            ->join('aa_person as aa','aa.id','=','pid')
            ->select('hr_attendance.*','name');
        $att = ($app['karyawan']!='') ? $att->where('pid',$app['karyawan']) : $att;
        $app['tgl_awal'] = $request->tgl_awal;
        $app['tgl_akhir'] = $request->tgl_akhir;
        if($request->tgl_awal!='')
        {
            $att = $att->whereRaw('DATE(entry_timestamp) BETWEEN "'.$request->tgl_awal.'" AND "'.$request->tgl_akhir.'"');
        }
        switch($app['beritaacara'])
        {
            case '1'||'2':
                if($app['beritaacara']=='1')
                {
                    $att = $att->whereRaw('notes is null');
                }
                else
                {
                    $att = $att->whereRaw('notes is not null');
                }
            break;
            default:
            break;
        }
        $app['hrAttendance'] = $att->paginate(10);
        $app['hrAttendances'] = $app['hrAttendance']->toArray();

        return view('halaman.kinerjapegawai',$app);
    }
    public function main_reportkinerja(Request $req)
    {
        $app['aktif']   = 'report-pegawai';
        $app['judul']   = 'Laporan Kinerja Pegawai';
        return view('halaman.report-kinerja-main',$app);
    }
    public function reportkinerja(Request $request)
    {
        $app['aktif']   = 'report-pegawai';
        $app['judul']   = 'Laporan Kinerja Pegawai';
        $app['karyawan'] = Employe::where('is_active','1')
            ->join('aa_person','pid','=','aa_person.id')
            ->join('hr_position','position_id','=','hr_position.id')
            ->select('aa_person.*','hr_position.name as position')
            ->orderBy('name')
            ->get()->toArray();
        $app['komponen'] = HrComponent::orderBy('name')->get();
        $datapegawai = collect($app['karyawan']);
        if($request->ajax())
        {
            $datas = array();
            parse_str($request->data, $datas);
            $alldata = HrAttendance::getAll($datas,$datapegawai);
            if(count($datas['component_id'])=='1'&&$datas['component_id'][0]=='0')
            {
                return view('halaman.report-kinerja-all',$alldata);
            }
            else
            {
                $alldata['jmhrow'] = count($datas['component_id']);
                return view('halaman.report-kinerja-all-v2',$alldata);
            }
            die();
        }
        return view('halaman.report-kinerja',$app);
    }
    public function reportkinerja_pekanan(Request $request)
    {
        $g =  new General();
        $app['aktif']   = 'report-pegawai';
        $app['judul']   = 'Laporan Kinerja Pegawai';
        $app['karyawan'] = Employe::where('is_active','1')
            ->join('hr_position','position_id','=','hr_position.id','left outer')
            ->select('aa_person.*','hr_position.name as position_name','pid')
            ->join('aa_person','pid','=','aa_person.id')
            ->where('aa_person.name','not like','%admin%')
            ->orderBy('name')->get()->toArray();
        $app['komponen'] = HrComponent::orderBy('name')->get();
        $app['bulan'] = $g->month('');
        $datapegawai = collect($app['karyawan']);
        if($request->ajax())
        {
            $datas = array();
            parse_str($request->data, $datas);
            if(count($datas['component_id'])=='1'&&$datas['component_id'][0]=='0')
            {
                $alldatas['jmhrow'] = count($datas['component_id']);
                $alldatas['data'] = HrAttendance::getAllPekanan($datas,$datapegawai);
                return view('halaman.report-kinerja-pekanan-rekap',$alldatas);
            }
            else
            {
                $alldatas['komponen'] = HrComponent::whereRaw('id IN ('.implode(',',$datas['component_id']).')')->get()->toArray();
                $alldatas['jmhrow'] = count($datas['component_id']);
                $alldatas['data'] = HrAttendance::getAllPekananKomponen($datas,$datapegawai);
                return view('halaman.report-kinerja-pekanan-rekap-v21',$alldatas);
            }
            die();
        }
        return view('halaman.report-kinerja-pekanan',$app);
    }
    public function approve(Request $request)
    {
        $id = $request->id;
        HrAttendance::updateOrCreate(
            ['id'=>$id],
            ['is_accepted'=>'1']
        );
        echo 'Berhasil';
    }
}
