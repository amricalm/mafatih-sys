<?php

namespace App\Http\Controllers;

use App\Models\BoardingActivityGroup;
use App\Models\BoardingActivity;
use App\Models\BoardingActivityItem;
use App\Models\BoardingGrade;
use App\SmartSystem\General;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BoardingActivityGradeController extends Controller
{
    public function __construct()
    {
        $general = new General();
        $this->general = $general;
    }

    public function index()
    {
        $app['aktif'] = 'pemetaankegiatansantri';
        $app['judul'] = "Pemetaan Kegiatan Santri";
        $app['activityItem'] = BoardingActivityItem::getBoardingItem('');
        $app['data']  = BoardingGrade::join('aa_academic_year as a', 'ep_boarding_grade.ayid', '=', 'a.id')
            ->select('periode')
            ->where('a.id', config('id_active_academic_year'))
            ->where('tid', config('id_active_term'))
            ->whereNotNull('periode')
            ->groupBy('periode')
            ->get();

        return view('halaman.boarding-activity-grade', $app);
    }

    public function show($id)
    {
        $basic['periode'] = $id;
        $basic['detailItem'] = BoardingActivityItem::join('ep_boarding_grade AS b', 'ep_boarding_activity_item.id', '=', 'b.activity_id')
            ->select('b.id AS gradeId','periode','ep_boarding_activity_item.id', 'ep_boarding_activity_item.name as activity_name', 'b.id as idmemberItem', 'b.score_total as memberItem')
            ->where('periode', '=', $id)
            ->where('ayid', config('id_active_academic_year'))
            ->where('tid', config('id_active_term'))
            ->get();

        echo json_encode($basic);
    }

    public function save(Request $request)
    {
        foreach ($request->item as $key=>$item) {
            $score = $item ? $item : 0;
            $getBgPeriode = BoardingGrade::withTrashed()
                ->where('ayid',config('id_active_academic_year'))
                ->where('tid',config('id_active_term'))
                ->where('activity_id',$key)
                ->where('periode',date('Ym', strtotime($request->periode)))
                ->restore();
            if($getBgPeriode==0) {
                $bg = new BoardingGrade;
                $bg['ayid'] = config('id_active_academic_year');
                $bg['tid'] = config('id_active_term');
                $bg['activity_id'] = $key;
                $bg['periode'] = date('Ym', strtotime($request->periode));
                $bg['score_total'] = $score;
                $bg['cby'] = auth()->user()->id;
                $bg['uby'] = auth()->user()->id;
                $bg->save();
            } else {
                BoardingGrade::where('ayid',config('id_active_academic_year'))
                ->where('tid',config('id_active_term'))
                ->where('activity_id',$key)
                ->where('periode',date('Ym', strtotime($request->periode)))
                ->update(['score_total'=> $score, 'uby'=> auth()->user()->id]);
            }
        }
        echo 'Berhasil';
    }
    public function update(Request $request)
    {
        $periode = Carbon::parse($request->periode)->format('Ym');
        foreach ($request->item as $itemKey=>$itemVal) {
            foreach ($request->gradeId as $itemId=>$gradeId) {
                if($itemKey == $itemId)
                {
                    BoardingGrade::where([
                        ['id', $gradeId]
                    ])
                    ->update([
                        'periode' => $periode,
                        'score_total' => $itemVal ? $itemVal : 0,
                        'uby' => auth()->user()->id,
                    ]);
                }
            }
        }
        //soft delete item pengasuhan yang tidak terupdate
        if($periode != $request->old_periode)
        {
            BoardingGrade::where('periode', $request->old_periode)->delete();
        }

        echo 'Berhasil';
    }
    public function delete($id)
    {
        BoardingGrade::where('periode', $id)->delete();
        echo 'Berhasil';
    }
}
