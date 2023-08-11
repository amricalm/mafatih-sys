<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\RfLevelClass;
use App\Models\SubjectBasic;
use App\Models\Subject;
use App\Models\SubjectBasicDetail;
use Illuminate\Http\Request;
use DataTables;

class SubjectBasicController extends Controller
{
    public function index(Request $request)
    {
        $app = array();
        $app['subject'] = Subject::orderBy('name')->get();
        $app['basic']  = SubjectBasic::where('ep_subject_basic.ayid', config('id_active_academic_year'))->get();
        $idbasic = $app['basic']->pluck('id');
        $app['data'] = SubjectBasicDetail::whereIn('subject_basic_id',$idbasic)
            ->join('ep_subject','subject_id','=','ep_subject.id')
            ->join('ep_subject_basic','subject_basic_id','=','ep_subject_basic.id')
            ->select('ep_subject_basic.id','ep_subject_basic.name_group','ep_subject.name as member','ep_subject.name_en as member_en','ep_subject.name_ar as member_ar')
            ->get();
        $app['level'] = RfLevelClass::get();

        $app['aktif'] = 'muatanpelajaran';
        $app['judul'] = "Grup Mata Pelajaran";

        return view('halaman.subjectbasic', $app);
    }
    public function show(Request $request)
    {
        $basic = SubjectBasic::where('id',$request->id)->first();
        $basic['detail'] = SubjectBasicDetail::where('subject_basic_id',$request->id)
            ->join('ep_subject','subject_id','=','ep_subject.id')
            ->join('ep_subject_basic','subject_basic_id','=','ep_subject_basic.id')
            ->select('ep_subject.id as idmember','ep_subject_basic.name_group','ep_subject.name as member')
            ->get();
        echo json_encode($basic);
    }
    public function save(Request $request)
    {
        $datas = array();
        parse_str($request->data, $datas);

        $subject = new SubjectBasic();
        $subject->ayid = config('id_active_academic_year');
        $subject->level = $datas['level'];
        $subject->name_group = $datas['name_group'];
        $subject->name_group_ar = $datas['name_group_ar'];
        $subject->cby = auth()->user()->id;
        $subject->uby = 0;
        $subject->save();

        $id = $subject->id;

        foreach($datas['subjectbasic'] as $item)
        {
            $detail = SubjectBasicDetail::create([
                'subject_basic_id' => $id,
                'subject_id' => $item,
                'cby' => auth()->user()->id,
                'uby' => 0,
            ]);
        }
        echo 'Berhasil';
    }
    public function copy(Request $request)
    {
        $prevAy = AcademicYear::getPrevAcademicYear(config('id_active_academic_year'));
        $prevSubjectBasic = SubjectBasic::where('ayid', $prevAy[0]->id)
                            ->get();
        foreach($prevSubjectBasic as $rows) {
            $subject = new SubjectBasic();
            $subject->ayid = config('id_active_academic_year');
            $subject->name_group = $rows->name_group;
            $subject->name_group_ar = $rows->name_group_ar;
            $subject->cby = auth()->user()->id;
            $subject->uby = 0;
            $subject->save();

            $id = $subject->id;
            $prevSubjectBasicDtl = SubjectBasicDetail::select('subject_id')
                                    ->join('ep_subject_basic','subject_basic_id','=','ep_subject_basic.id')
                                    ->where('subject_basic_id', $rows->id)
                                    ->where('ayid', $prevAy[0]->id)
                                    ->get();
            foreach($prevSubjectBasicDtl as $item)
            {
                $detail = SubjectBasicDetail::create([
                    'subject_basic_id' => $id,
                    'subject_id' => $item->subject_id,
                    'cby' => auth()->user()->id,
                    'uby' => 0,
                ]);
            }
        }

        $arr = array('status' => 'true', 'msg' => 'Berhasil');
        return Response()->json($arr);
    }
    public function update(Request $request)
    {
        $datas = array();
        parse_str($request->data, $datas);
        $subject = SubjectBasic::where('id',$datas['id'])
            ->update([
                'level' => $datas['level'],
                'name_group' => $datas['name_group'],
                'name_group_ar' => $datas['name_group_ar'],
                'uby' => auth()->user()->id,
            ]);

        SubjectBasicDetail::where('subject_basic_id',$datas['id'])->delete();

        foreach($datas['subjectbasic'] as $item)
        {
            $detail = SubjectBasicDetail::create([
                'subject_basic_id' => $datas['id'],
                'subject_id' => $item,
                'cby' => auth()->user()->id,
                'uby' => 0,
            ]);
        }
        echo 'Berhasil';
    }
    public function delete(Request $request)
    {
        SubjectBasicDetail::where('subject_basic_id',$request->id)->delete();
        SubjectBasic::where('id',$request->id)->delete();
        echo 'Berhasil';
    }
}
