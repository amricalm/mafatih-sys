<?php

namespace App\Http\Controllers;

use App\Models\CourseClass;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Employe;
use App\Models\BoardingActivityItem;
use App\Models\BoardingGrade;
use App\Models\BoardingGradeDtl;
use App\Models\BoardingGroup;
use App\Models\Homeroom;
use App\Models\User;

class BoardingAssessmentController extends Controller
{
    public function index(Request $req)
    {
        $app = array();
        $app['aktif'] = 'inputpengasuhan';
        $app['judul'] = 'Input Nilai Pengasuhan';
        $app['activity'] = array();
        $app['cekmusyrif'] = User::where('pid',auth()->user()->pid)->where('role','1')->exists();
        $app['employe'] = BoardingGroup::getMsPerAyid('');
        if(auth()->user()->role=='3')
        {
            $app['employe'] = BoardingGroup::getMsPerAyid(auth()->user()->pid);
            if($app['employe']) {
                $app['cekmusyrif'] = true;
            }
        }
        $app['kelas'] = CourseClass::get();
        $app['grade'] = array();
        $app['student'] = array();

        $app['periode'] = BoardingGrade::join('aa_academic_year as a', 'ep_boarding_grade.ayid', '=', 'a.id')
                    ->select('periode')
                    ->where('a.id', config('id_active_academic_year'))
                    ->where('tid',config('id_active_term'))
                    ->whereNotNull('periode')
                    ->groupBy('periode')
                    ->get();
        $app['req'] = $req;
        if ($req->post())
        {
            if($req->class) {
                $app['student'] = BoardingGroup::where('eid',$req->class)
                                    ->where('ayid',config('id_active_academic_year'))
                                    ->join('aa_student as a','sid','=','a.id')
                                    ->join('aa_person as b','a.pid','=','b.id')
                                    ->select('a.id','a.nis', 'b.name','b.name_ar')
                                    ->orderBy('a.nis', 'ASC')
                                    ->get();
            }

            if($req->periode&&!empty($req->student)) {
            $app['activity']= BoardingActivityItem::getBoardingGradeDtl($req->student, $req->periode);
            $app['periode'] = BoardingGrade::join('aa_academic_year as a', 'ep_boarding_grade.ayid', '=', 'a.id')
                        ->select('periode')
                        ->where('a.id', config('id_active_academic_year'))
                        ->where('tid',config('id_active_term'))
                        ->whereNotNull('periode')
                        ->groupBy('periode')
                        ->get();
            }
        }

        return view('halaman.boardingassessment', $app);
    }

    public function save(Request $request)
    {
        $datas = array();
        parse_str($request->data, $datas);
        $result = '';
        $arr = array();
        $i = 0;
        foreach($datas['val'] as $k=>$v)
        {
            $gradeid = BoardingGrade::where('ayid',config('id_active_academic_year'))
                    ->where('periode',$datas['periode_id'])
                    ->where('activity_id',$k);
            if($gradeid->exists()) {
                $id = $gradeid->pluck('id')->toArray();
            }
            $arr[$i]['bgid']       = isset($id) ? $id[0] : 0;
            $arr[$i]['sid']        = $datas['student_id'];
            $arr[$i]['ayid']       = config('id_active_academic_year');
            $arr[$i]['tid']        = config('id_active_term');
            $arr[$i]['score']      = is_numeric($v) ? $v : 0;
            $arr[$i]['remission']  = is_numeric($datas['rem'][$k]) ? $datas['rem'][$k] : 0;
            $arr[$i]['target']     = $datas['target'][$k];
            $i++;
        }
        
        foreach ($arr as $key => $val) {
            if($val['bgid']!=0) {
                $setbgid    = $val['bgid'];
                $setayid    = $val['ayid'];
                $settid    = $val['tid'];
                $setsid    = $val['sid'];
                $totalScore     = $val['score'] + $val['remission'];
                $setscore       = ($totalScore <= $val['target']) ? $val['score'] : NULL;
                $setremission   = ($totalScore <= $val['target']) ? $val['remission'] : NULL;

                $getBgDtl = BoardingGradeDtl::where('bgid',$setbgid)
                            ->where('sid',$setsid)
                            ->where('ayid',$setayid)
                            ->where('tid',$settid);
                
                if($getBgDtl->exists()) {
                    if(isset($setscore)) {
                        $setbgDtl = $getBgDtl->update(['score'=>$setscore,'remission'=>$setremission]);
                    }
                } else {
                    $bgDtl = new BoardingGradeDtl;
                    $bgDtl->bgid   = $setbgid;
                    $bgDtl->sid    = $setsid;
                    $bgDtl->ayid   = $setayid;
                    $bgDtl->tid    = $settid;
                    $bgDtl->score  = $setscore;
                    $bgDtl->remission  = $setremission;
                    $bgDtl->cby = auth()->user()->id;
                    $bgDtl->uby = auth()->user()->id;
                    $bgDtl->save();
                }

                //jika ada total score yang melebihi target
                if(is_null($setscore)) {
                    $result = 'LebihDariTarget';
                }
            }
        }
        $result = $result=='' ? 'Berhasil' : $result;
        echo $result;
    }

    public function getFromBoardingClass(Request $req)
    {
        $student = BoardingGroup::where('eid', $req->id)
            ->where('ayid',config('id_active_academic_year'))
            ->leftjoin('aa_student as a', 'sid', '=', 'a.id')
            ->join('aa_person as b', 'a.pid', '=', 'b.id')
            ->select('a.id', 'a.nis', 'b.name', 'b.name_ar')
            ->get();

        if (!empty($student)) {
            echo json_encode($student);
        }
    }
}
