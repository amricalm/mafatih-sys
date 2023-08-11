<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Student;
use App\Models\Employe;
use Illuminate\Http\Request;
use DataTables;

class MedicalRecordController extends Controller
{
    var $general;
    public function __construct()
    {
        $this->general['aktif'] = 'medical-record';
        $this->general['judul'] = 'Riwayat Kesehatan';
    }
    public function index(Request $request)
    {
        $app = $this->general;
        $app['riwayat'] = MedicalRecord::join('aa_person as mrd','pid','=','mrd.id')
            ->leftJoin('aa_person as gr','handle_by','=','gr.id')
            ->select('aa_medical_record.id','mrd.name as santri','aa_medical_record.name','desc','date','handle','gr.name as guru','is_finish')
            ->paginate(config('paging'));
        $app['santri'] = Student::join('aa_person','aa_person.id','=','pid')->orderBy('name')->get();
        $app['guru'] = Employe::where('is_active','1')->join('aa_person','aa_person.id','=','pid')->orderBy('name')->get();

        return view('halaman.medicalrecord', $app);
    }
    public function show(Request $request)
    {
        $basic = MedicalRecord::join('aa_person as mrd','pid','=','mrd.id')
            ->leftJoin('aa_person as gr','handle_by','=','gr.id')
            ->select('aa_medical_record.id','mrd.id as pid','mrd.name as santri','aa_medical_record.name','desc','date','handle','gr.id as guruid','gr.name as guru','is_finish')
            ->find($request->id);

        echo json_encode($basic);
    }
    public function save(Request $request)
    {
        $datas = array();
        parse_str($request->data, $datas);
        $handle_by = !empty($datas['handle_by']) ? $datas['handle_by'] : 0;
        $is_finish = !empty($datas['is_finish']) ? $datas['is_finish'] : 0;

        $medic = new MedicalRecord();
        $medic->pid = $datas['pid'];
        $medic->name = $datas['name'];
        $medic->date = $datas['date'];
        $medic->year = explode('-',$datas['date'])[0];
        $medic->desc = $datas['desc'];
        $medic->handle = $datas['handle'];
        $medic->handle_by = $handle_by;
        $medic->is_finish = $is_finish;
        $medic->cby = auth()->user()->id;
        $medic->con = date('Y-m-d H:i:s');
        $medic->save();

        echo 'Berhasil';
    }
    public function update(Request $request)
    {
        $datas = array();
        parse_str($request->data, $datas);

        $handle_by = !empty($datas['ehandle_by']) ? $datas['ehandle_by'] : 0;
        $is_finish = !empty($datas['eis_finish']) ? $datas['eis_finish'] : 0;
        $subject = MedicalRecord::where('id',$datas['eid'])
            ->update([
                'name' => $datas['ename'],
                'date' => $datas['edate'],
                'desc' => $datas['edesc'],
                'handle' => $datas['ehandle'],
                'handle_by' => $handle_by,
                'is_finish' => $is_finish,
                'uby' => auth()->user()->id,
            ]);

        echo 'Berhasil';
    }
    public function delete(Request $request)
    {
        MedicalRecord::where('id',$request->id)->delete();
        echo 'Berhasil';
    }
}
