<?php

namespace App\Http\Controllers;

use App\Models\Punishment;
use App\Models\Student;
use App\Models\CourseClass;
use App\Models\CourseClassDtl;
use App\Models\Employe;
use App\SmartSystem\General;
use Illuminate\Http\Request;
use DataTables;

class PunishmentController extends Controller
{
    var $menu;
    public function __construct()
    {
        $general = new General();
        $this->general = $general;
        $this->menu['aktif'] = 'pelanggaran';
        $this->menu['judul'] = 'Pelanggaran Santri';
    }
    public function index(Request $request)
    {
        $app = $this->menu;
        $app['riwayat'] = Punishment::join('aa_person as mrd','pid','=','mrd.id')
            ->join('aa_student as st','st.pid','=','mrd.id')
            ->select('ep_punishment.id','nis','mrd.name as santri','ep_punishment.name','desc','date')
            ->paginate(config('paging'));
        $app['santri'] = Student::join('aa_person','aa_person.id','=','pid')->orderBy('name')->get();
        $app['courseclass'] = CourseClass::select('id', 'name')->get();
        $app['employe'] = '';
		if (auth()->user()->role == '3') {
            $app['employe'] = Employe::where('pid',auth()->user()->pid)->first();
        }

        return view('halaman.punishment', $app);
    }
    public function show(Request $request)
    {
        $query = Punishment::join('aa_person as mrd', 'pid', '=', 'mrd.id')
            ->join('aa_student as st','st.pid','=','mrd.id')
            ->leftJoin('ep_course_class_dtl as ccd','ccd.sid','=','st.id')
            ->join('ep_course_class as cc','cc.id','=','ccd.ccid')
            ->select('ep_punishment.id','nis','mrd.name as santri','ep_punishment.name','desc','date')
            ->where('ayid', config('id_active_academic_year'));

        if($request->id != 'undefined') {
            $query->where('cc.id', $request->id);
        }
        $qry = $query->get();
        $i = 1;
        foreach($qry as $ky=>$vl)
        {
            echo '<tr>';
            echo '<td>'.$i.'</td>';
            echo '<td>'.$this->general::convertDate($vl->date).'</td>';
            echo '<td>'.$vl->nis.'</td>';
            echo '<td>'.$vl->santri.'</td>';
            echo '<td>'.$vl->name.' > <br/>'.$vl->desc.'</td>';
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
        $basic = Punishment::join('aa_person as mrd','pid','=','mrd.id')
            ->select('ep_punishment.id','ep_punishment.pid as pid','mrd.name as santri','ep_punishment.name','ep_punishment.level','desc','date')
            ->find($request->id);

        echo json_encode($basic);
    }
    public function save(Request $request)
    {
        $datas = array();
        parse_str($request->data, $datas);

        $medic = new Punishment();
        $medic->pid = $datas['pid'];
        $medic->name = $datas['name'];
        $medic->date = $datas['date'];
        $medic->year = explode('-',$datas['date'])[0];
        $medic->level = $datas['level'];
        $medic->desc = $datas['desc'];
        $medic->cby = auth()->user()->id;
        $medic->con = date('Y-m-d H:i:s');
        $medic->save();

        echo 'Berhasil';
    }
    public function update(Request $request)
    {
        $datas = array();
        parse_str($request->data, $datas);
        $subject = Punishment::where('id',$datas['eid'])
            ->update([
                'pid' => $datas['epid'],
                'name' => $datas['ename'],
                'date' => $datas['edate'],
                'level' => $datas['elevel'],
                'desc' => $datas['edesc'],
                'uby' => auth()->user()->id,
            ]);

        echo 'Berhasil';
    }
    public function delete(Request $request)
    {
        Punishment::where('id',$request->id)->delete();
        echo 'Berhasil';
    }
}
