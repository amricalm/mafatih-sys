<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Student;
use App\Models\CourseClass;
use App\Models\CourseClassDtl;
use App\SmartSystem\General;
use Illuminate\Http\Request;
use App\Models\MsUpload;
use App\Models\Person;
use DataTables;

class AchievementController extends Controller
{
    var $menu;
    public function __construct()
    {
        $general = new General();
        $this->general = $general;
        $this->menu['aktif'] = 'prestasi';
        $this->menu['judul'] = 'Prestasi Santri';
    }
    public function index(Request $request)
    {
        $app = $this->menu;
        $app['santri'] = Student::join('aa_person','aa_person.id','=','pid')->orderBy('name')->get();
        $app['courseclass'] = CourseClass::select('id', 'name')->get();

        return view('halaman.achievement', $app);
    }
    public function show(Request $request)
    {
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
        $i = 1;
        foreach($qry as $ky=>$vl)
        {
            echo '<tr>';
            echo '<td>'.$i.'</td>';
            $tanggal = \App\SmartSystem\General::convertDate($vl->date);
            echo '<td>'.$tanggal.'</td>';
            echo '<td>'.$vl->nis.'<br/>'.$vl->santri.'</td>';
            echo '<td>'.$vl->name.'<br/>'.$vl->desc.'</td>';
            $file = ($vl->file!='') ? substr($vl->file,strlen($vl->file)-3,strlen($vl->file)) : '';
            $preview = ($vl->file!='') ? '<a href='.url($vl->file).' download><i class="fas fa-download"></i></a>' : '';
            echo '<td>'.$preview.'</td>';
            echo '<td class="text-right">
                    <button type="button" class="btn btn-warning btn-sm text-white" onclick="show('.$vl->id.')" id="btnEdit"><i class="fas fa-pen"></i> Edit</button>
                    <button type="button" class="btn btn-default btn-sm text-white" onclick="hapus('.$vl->id.')" id="btnDelete"><i class="fas fa-trash"></i> Hapus</button>
                    </td>';
            echo '</tr>';
            $i++;
        }
    }
    public function edit(Request $request)
    {
        $basic = Achievement::join('aa_person as mrd','pid','=','mrd.id')
            ->select('aa_achievement.id','aa_achievement.pid as pid','mrd.name as santri','aa_achievement.name','desc','date')
            ->find($request->id);

        echo json_encode($basic);
    }
    public function save(Request $request)
    {
        $datas = array();
        parse_str($request->data, $datas);
        $fileoriginal = '';
        $person = Person::where('id',$datas['pid'])->first()->toArray()['name'];

        if($request->file())
        {
            $fileModel = new MsUpload;
            $fileModel->pid = $datas['pid'];
            $fileModel->desc = 'Prestasi '.$person.' : '.$datas['desc'];
            $fileModel->cby = auth()->user()->id;
            $fileModel->uby = '0';

            $namafile = str_replace(' ','_',$request->file->getClientOriginalName());
            $filename = time().'_'.$namafile;
            $filepath = $request->file('file')->storeAs('',$filename,'upload');
            $fileoriginal = 'uploads/'.$filepath;

            $fileModel->url = $filepath;
            $fileModel->original_file = $fileoriginal;
            $fileModel->save();
        }

        $medic = new Achievement();
        $medic->pid = $datas['pid'];
        $medic->name = $datas['name'];
        $medic->date = $datas['date'];
        $medic->year = explode('-',$datas['date'])[0];
        $medic->desc = $datas['desc'];
        $medic->file = $fileoriginal;
        $medic->cby = auth()->user()->id;
        $medic->con = date('Y-m-d H:i:s');
        $medic->save();

        echo 'Berhasil';
    }
    public function update(Request $request)
    {
        $datas = array();
        parse_str($request->data, $datas);
        $subject = Achievement::where('id',$datas['eid'])
            ->update([
                'pid' => $datas['epid'],
                'name' => $datas['ename'],
                'date' => $datas['edate'],
                'desc' => $datas['edesc'],
                'uby' => auth()->user()->id,
            ]);

        echo 'Berhasil';
    }
    public function delete(Request $request)
    {
        Achievement::where('id',$request->id)->delete();
        echo 'Berhasil';
    }

    public function getFromClass(Request $req)
    {
        if(!empty($req->id)) {
            $student = CourseClassDtl::where('ccid', $req->id)
                    ->where('ayid',config('id_active_academic_year'))
                    ->leftjoin('aa_student as a', 'sid', '=', 'a.id')
                    ->join('aa_person as b', 'a.pid', '=', 'b.id')
                    ->select('b.id', 'a.nis', 'b.name', 'b.name_ar')
                    ->get();
        } else {
            $student = Student::join('aa_person','aa_person.id','=','pid')->orderBy('name')->get();
        }

        if (!empty($student)) {
            echo json_encode($student);
        }
    }
}
