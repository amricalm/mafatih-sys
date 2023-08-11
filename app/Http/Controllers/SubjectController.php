<?php

namespace App\Http\Controllers;

use App\Models\CourseClass;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\CourseSubject;
use App\Models\CourseSubjectTeacher;
use App\Models\Employe;
use App\Models\RfLevelClass;
use DataTables;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $data = Subject::get();
        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn =
                        '<div class="dropdown">
                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                <a class="dropdown-item edit" href="javascript:void(0)" data-id="' . $row->id . '"><i class="fa fa-pencil"></i> Edit</a>
                                <a class="dropdown-item delete" href="javascript:void(0)" data-id="' . $row->id . '"><i class="fa fa-trash"></i> Hapus</a>
                            </div>
                        </div>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $app['aktif'] = 'matapelajaran';
        $app['judul'] = "Mata Pelajaran";

        return view('halaman.subject', $app);
    }

    public function store(Request $request)
    {
        Subject::updateOrCreate(
            ['id' => $request->id],
            ['name' => $request->name, 'name_ar' => $request->name_ar, 'name_en' => $request->name_en, 'cby' => auth()->user()->id, 'uby' => auth()->user()->id]
        );

        $arr = array('status' => 'true', 'msg' => 'Berhasil');
        return Response()->json($arr);
    }

    public function edit($id)
    {
        $data = Subject::find($id);
        return response()->json($data);
    }

    public function destroy($id)
    {
        Subject::find($id)->delete();

        $arr = array('status' => 'true', 'msg' => 'Berhasil');
        return Response()->json($arr);
    }

    public function mapping()
    {
        $app = array();
        $app['aktif'] = 'pemetaanpelajaran';
        $app['judul'] = "Pemetaan Mata Pelajaran";
        $app['kelas'] = CourseClass::get();
        $app['subject'] = Subject::orderBy('name')->get();
        $app['subjectclass'] = CourseSubject::join('ep_subject','subject_id','=','ep_subject.id')
            ->select('ep_course_subject.id','ep_subject.id as subject_id','ep_subject.name','level','tid')
            ->get();
        $app['level'] = RfLevelClass::get();
        $app['employee'] = Employe::leftjoin('aa_person as a', 'a.id', '=', 'pid')
            ->select('aa_employe.id', 'a.id as em.id', 'a.name')
            ->where('is_active','1')
            ->orderBy('name')
            ->get();
        return view('halaman.subject-mapping', $app);
    }
    public function showmapping(Request $req)
    {
        $text = '';
        $no = 1;
        $kelas = CourseClass::where('level',$req->id)->get();
        $tid = $req->ids;
        $subject = '';
        if(strpos($req->ids,'.')!==false)
        {
            $sep = explode('.',$req->ids);
            $tid = $sep[0];
            $subject = $sep[1];
        }
        $guru = Employe::where('is_active','1')
            ->join('aa_person','pid','=','aa_person.id')
            ->select('aa_employe.id','pid','name')
            ->orderBy('name')->get();
        $gurupelajaran = CourseSubjectTeacher::where('level',$req->id)
            ->where('ayid',config('id_active_academic_year'))
            ->where('tid',$tid)
            ->where('subject_id',$subject)
            ->get();
        foreach($kelas as $k=>$v)
        {
            $selected = '';
            $text .= '<tr>';
            $text .= '<td>'.$no.'</td>';
            $text .= '<td>'.$v->name.'</td>';
            $text .= '<input type="hidden" name="kelas[]" id="kelas" value="'.$v->id.'"/>';
            $text .= '<td><select name="pid[]" id="pid'.$no.'" class="select2 form-control form-control-sm">';
            $text .= '<option > - Pilih Salah Satu - </option>';
            foreach($guru as $kg=>$vg)
            {
                $selected = '';
                $testadaguru = $gurupelajaran->where('ccid',$v->id)->where('eid',$vg->pid)->toArray();
                if(count($testadaguru)!=0)
                {
                    $selected = 'selected="selected"';
                }
                $text .= '<option value="'.$vg->pid.'" '.$selected.'>'.$vg->name.'</option>';
            }
            $text .= '</select></td>';
            $text .= '<td></td>';
            $text .= '</tr>';
            $no++;
        }
        echo $text;
    }
    public function savemapping(Request $req)
    {
        if($req->ajax())
        {
            $datas = array();
            parse_str($req->data, $datas);
            CourseSubject::updateOrCreate(
                [
                    'level'=>$datas['level'],
                    'ayid'=>config('id_active_academic_year'),
                    'tid'=>$datas['semester'],
                    'subject_id'=>$datas['pelajaran'],
                ],
                [
                    'seq'=>$datas['urutan'],
                    'grade_pass'=>$datas['kkm'],
                    'week_duration'=>$datas['durasi'],
                    'cby'=>auth()->user()->id,
                    'uby'=>auth()->user()->id,
                ]
            );
            for($i=0;$i<count($datas['kelas']);$i++)
            {
                CourseSubjectTeacher::updateOrCreate(
                    [
                        'level'=>$datas['level'],
                        'ayid'=>config('id_active_academic_year'),
                        'tid'=>$datas['semester'],
                        'subject_id'=>$datas['pelajaran'],
                        'ayid'=>config('id_active_academic_year'),
                        'ccid'=>$datas['kelas'][$i],
                    ],
                    [
                        'eid'=>$datas['pid'][$i],
                        'cby'=>auth()->user()->id,
                        'uby'=>auth()->user()->id,
                    ]
                );
            }
            echo 'Berhasil';
        }
    }
    public function loadmapping(Request $req)
    {
        if(!$req->ajax())
        {
            die();
        }
        $level = $req->id;
        $tid = $req->ids;
        $subject = $req->subject;
        $pelajaran = CourseSubject::where('level',$level)
            ->select('ep_course_subject.id','seq','subject_id','name','level','tid','grade_pass','week_duration')
            ->join('ep_subject','subject_id','=','ep_subject.id')
            ->where('ayid',config('id_active_academic_year'))
            ->where('tid',$tid)
            ->orderBy('seq');
        $pelajaran = ($subject=='') ? $pelajaran->get() : $pelajaran->where('subject_id',$subject)->get();
        echo json_encode($pelajaran);
    }
    public function showmapping2(Request $req)
    {
        $html = '';
        $data = CourseSubject::where('level',$req->id)
            ->where('ayid',config('id_active_academic_year'))
            ->where('tid',$req->ids)
            ->join('ep_subject','subject_id','=','ep_subject.id')
            ->get();
        $kelas = CourseClass::where('level',$req->id)->get();
        $no = 1;
        foreach($data as $ky=>$vl)
        {
            $html .= '<tr id="row'.$vl->level.'_'.$vl->id.'">';
            $html .= '<td>'.$no.'</td>';
            $html .= '<td>'.$vl->name.'</td>';
            $html .= '<td id="grade'.$vl->level.'_'.$vl->id.'">'.$vl->grade_pass.'</td>';
            $html .= '<td id="duration'.$vl->level.'_'.$vl->id.'">'.$vl->week_duration.'</td>';
            $html .= '<td>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-sm btn-maroon" onclick="lihat('.$vl->level.','.$vl->subject_id.')"><i class="fa fa-chalkboard-teacher"></i></button>
                    <button type="button" class="btn btn-sm btn-danger" onclick="hapus('.$vl->level.','.$vl->subject_id.')"><i class="fa fa-trash"></i></button>
                </div>
            </td>';
            $html .= '</tr>';
            $no++;
        }
        if($html!='')
        {
            echo 'Berhasil|'.$html;
        }
    }
    public function savemapping2(Request $request)
    {
        $datas = array();
        parse_str($request->data, $datas);

        $id = $datas['level'];
        $tid = config('id_active_term');

        $subject = CourseSubject::updateOrCreate(
            ['level'=>$id,'subject_id'=>$datas['subject_id']],
            [
                'eid' => '0',
                'ayid' => config('id_active_academic_year'),
                'tid' => $tid,
                'grade_pass'=>$datas['grade_pass'],
                'week_duration'=>$datas['week_duration'],
                'cby'=>auth()->user()->id,
                'uby'=>auth()->user()->id
            ]
        );
        echo 'Berhasil';
    }
    public function getFromClass(Request $req)
    {
        $subject = CourseSubject::getFromClass(['id'=>$req->id]);
        $kelas = CourseClass::where('id',$req->id)->first()->toArray();
        if(auth()->user()->role=='3')
        {
            $pelajarankelas = CourseSubjectTeacher::join('ep_subject','subject_id','=','ep_subject.id')
                ->where('eid',auth()->user()->pid)
                ->where('ayid',config('id_active_academic_year'))
                ->where('tid',config('id_active_term'))
                ->where('ccid',$req->id)
                ->where('level',$kelas['level'])
                ->groupBy('subject_id')
                ->get();
            $pljrnngajar = array_keys(json_decode(json_encode($pelajarankelas->where('ccid',$req->id)->groupBy('subject_id')), true));
            $subject = collect($subject)->whereIn('id',$pljrnngajar);
            $subject = json_decode(json_encode($subject), true);
        }
        if (!empty($subject)) {
            echo json_encode($subject,true);
        }
    }
    public function loadmapping2(Request $request)
    {
        $level = $request->id;
        $subject_id  = $request->ids;
        $mapel = Subject::where('id',$subject_id)->first()->name;
        $kelas = CourseClass::where('level',$level)->get();
        $guru = Employe::where('employe_type','GRU')
            ->join('aa_person','pid','=','aa_person.id')
            ->select('aa_employe.id','aa_person.name')
            ->where('is_active','1')
            ->orderBy('aa_person.name')->get();
        $gurumapel = CourseSubjectTeacher::where('level',$level)
            ->where('subject_id',$subject_id)
            ->where('ayid',config('id_active_academic_year'))
            ->where('tid',config('id_active_term'))
            ->get();
        $html = '<h3>Untuk Pelajaran '.$mapel.' Level '.$level.'</h3>';
        $html .= '<div class="table-responsive"><table class="table table-stripped">';
        $html .= '<thead><tr><th>Kelas</th><th>Guru Mapel</th><th>#</th></tr></thead><tbody>';
        foreach($kelas as $key=>$val)
        {
            $html .= '<tr>';
            $html .= '<td>'.$val->name.'</td>';
            $html .= '<td><select class="form-control form-control-sm" name="eid" id="eid'.$level.'_'.$subject_id.'_'.$val->id.'" >';
            $html .= '<option value=""> - Pilih Salah Satu - </option>';
            foreach($guru as $ky=>$vl)
            {
                $selected = '';
                foreach($gurumapel as $kk=>$vv)
                {
                    if($vv['eid']==$vl->id && $val->id==$vv['ccid'])
                    {
                        $selected = 'selected="selected"';
                    }
                }
                $html .= '<option value="'.$vl->id.'" '.$selected.'>'.$vl->name.'</option>';
            }
            $html .= '</select></td>';
            $html .= '<td><button class="btn btn-sm btn-primary btnSimpanGuru" onclick="simpanguru('.$level.','.$subject_id.','.$val->id.')"><i class="fa fa-save"></i></button></td>';
            $html .= '</tr>';
        }
        $html .= '</table></div>';
        echo $html;
    }
    public function savedetailmapping(Request $request)
    {
        $id = $request->lvl;
        $tid = config('id_active_term');
        $ayid = config('id_active_academic_year');
        $subject = CourseSubjectTeacher::updateOrCreate(
            ['level'=>$id,'subject_id'=>$request->sbj,'ccid'=>$request->cc,'ayid'=>$ayid,'tid'=>$tid],
            [
                'eid' => $request->guru,
                'cby'=>auth()->user()->id,
                'uby'=>auth()->user()->id
            ]
        );
        echo 'Berhasil';
    }
    public function delmapping(Request $request)
    {
        if(!$request->ajax())
        {
            die();
        }
        $level = $request->id;
        $subject_id = $request->ids;
        $subject = CourseSubject::where('level',$level)->where('ayid',config('id_active_academic_year'))->where('tid',$request->ids)->where('subject_id',$request->sbj)->delete();
        $subjectteacher = CourseSubjectTeacher::where('level',$level)->where('ayid',config('id_active_academic_year'))->where('tid',$request->ids)->where('subject_id',$request->sbj)->delete();
        echo 'Berhasil';
    }
}
