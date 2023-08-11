<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\BoardingActivityGroup;
use App\Models\BoardingActivity;
use App\Models\BoardingActivityItem;
use App\Models\BoardingActivityNonActive;
use Illuminate\Http\Request;
use DataTables;

class BoardingActivityGroupController extends Controller
{
    public function index(Request $request)
    {
        $app['subject'] = BoardingActivity::orderBy(DB::raw('ISNULL(seq), seq'), 'ASC')->get();
        $app['activityItem'] = BoardingActivityItem::orderBy(DB::raw('ISNULL(seq), seq'), 'ASC')->get();
        $app['group']   = BoardingActivityGroup::orderBy(DB::raw('ISNULL(seq), seq'), 'ASC')->get();
        $app['data']    = BoardingActivity::rightJoin('ep_boarding_activity_group', 'ep_boarding_activity_group.id', '=', 'ep_boarding_activity.group_id')
            ->select('ep_boarding_activity_group.name as name_group', 'ep_boarding_activity_group.name_ar as name_group_ar', 'ep_boarding_activity.name_ar as member', 'ep_boarding_activity.id as member_id', 'ep_boarding_activity.seq as member_seq','type')
            ->orderBy(DB::raw('ISNULL(ep_boarding_activity.seq), ep_boarding_activity.seq'), 'ASC')
            ->get();
        $app['dataItem']    = BoardingActivityItem::select('ep_boarding_activity.id as activity_id', 'ep_boarding_activity.name as activity_name', 'ep_boarding_activity.name_ar as activity_name_ar', 'ep_boarding_activity_item.name as member', 'ep_boarding_activity_item.id as member_id', 'ep_boarding_activity_item.seq as member_seq','non.id AS non_active')
            ->rightJoin('ep_boarding_activity', 'ep_boarding_activity_item.activity_id', '=', 'ep_boarding_activity.id')
            ->leftJoin('ep_boarding_activity_nonactive AS non', function($join)
            {
                $join->on('non.ayid','=',DB::raw(config('id_active_academic_year')));
                $join->on('non.tid','=',DB::raw(config('id_active_term')));
                $join->on('ep_boarding_activity_item.id','=','non.activity_id');
                $join->on('non.desc','=',DB::raw("'ITEM'"));
            })
            ->orderBy(DB::raw('ISNULL(ep_boarding_activity_item.seq), ep_boarding_activity_item.seq'), 'ASC')
            ->get();

        $app['aktif'] = 'grup-kegiatansantri';
        $app['judul'] = "Kegiatan Santri";

        return view('halaman.boarding-activity-group', $app);
    }
    public function show(Request $request)
    {
        $basic = BoardingActivityGroup::where('id', $request->id)->first();
        $basic['detail'] = BoardingActivityGroup::leftjoin('ep_boarding_activity as b', 'ep_boarding_activity_group.id', '=', 'b.group_id')
            ->select('ep_boarding_activity_group.id', 'ep_boarding_activity_group.name as name_group', 'ep_boarding_activity_group.name_ar as name_group_ar', 'b.id as idmember', 'b.name as member', 'type','ep_boarding_activity_group.seq')
            ->where('ep_boarding_activity_group.id', '=', $request->id)
            ->get();

        echo json_encode($basic);
    }
    public function save(Request $request)
    {
        $subject = new BoardingActivityGroup();
        $subject->name = $request->name_group;
        $subject->name_ar = $request->name_group_ar;
        $subject->seq = $request->seq;
        $subject->cby = auth()->user()->id;
        $subject->uby = 0;
        $subject->save();

        $id = $subject->id;
        if($request->subjectbasic) {
            foreach ($request->subjectbasic as $item) {
                BoardingActivity::where('id', $item)
                    ->update([
                        'group_id' => $id,
                        'uby' => auth()->user()->id,
                    ]);
            }
        }
        echo 'Berhasil';
    }
    public function update(Request $request)
    {
        BoardingActivityGroup::where('id', $request->id)
            ->update([
                'name' => $request->name_group,
                'name_ar' => $request->name_group_ar,
                'seq' => $request->seq,
                'uby' => auth()->user()->id,
            ]);

        BoardingActivity::where('group_id', $request->id)->update(['group_id' => NULL]);

        foreach ($request->subjectbasic as $item) {
            BoardingActivity::where('id', $item)
                ->update([
                    'group_id' => $request->id,
                    'uby' => auth()->user()->id,
                ]);
        }
        echo 'Berhasil';
    }
    public function delete($id)
    {
        BoardingActivityGroup::where('id', $id)->delete();
        echo 'Berhasil';
    }

    //Kegiatan Santri
    public function showActivity(Request $request)
    {
        $basic = BoardingActivity::where('id', $request->id)->first();
        $basic['detailItem'] = BoardingActivity::leftjoin('ep_boarding_activity_item as b', 'ep_boarding_activity.id', '=', 'b.activity_id')
            ->select('ep_boarding_activity.id', 'ep_boarding_activity.name as activity_name', 'ep_boarding_activity.name_ar as activity_name_ar', 'b.id as idmemberItem', 'b.name as memberItem','type')
            ->where('ep_boarding_activity.id', '=', $request->id)
            ->orderBy(DB::raw('ISNULL(ep_boarding_activity.seq), ep_boarding_activity.seq'), 'ASC')
            ->get();

        echo json_encode($basic);
    }
    public function saveActivity(Request $request)
    {
        $activity = new BoardingActivity();
        $activity->name = $request->activity_name;
        $activity->name_ar = $request->activity_name_ar;
        $activity->type = !empty($request->item) ? $request->item : '';
        $activity->cby = auth()->user()->id;
        $activity->uby = 0;
        $activity->save();

        $id = $activity->id;

        if(!empty($request->subjectbasic)) {
            foreach ($request->subjectbasic as $item) {
                BoardingActivityItem::where('id', $item)
                    ->update([
                        'activity_id' => $id,
                        'uby' => auth()->user()->id,
                    ]);
            }
        }
        echo 'Berhasil';
    }
    public function updateActivity(Request $request)
    {
        BoardingActivity::where('id', $request->id)
            ->update([
                'name' => $request->activity_name,
                'name_ar' => $request->activity_name_ar,
                'type' => $request->itemEdit,
                'uby' => auth()->user()->id,
            ]);

        BoardingActivityItem::where('activity_id', $request->id)->update(['activity_id' => NULL]);
        if(!empty($request->activityitem)) {
            foreach ($request->activityitem as $item) {
                BoardingActivityItem::where('id', $item)
                    ->update([
                        'activity_id' => $request->id,
                        'uby' => auth()->user()->id,
                    ]);
            }
        }
        echo 'Berhasil';
    }
    public function deleteActivity($id)
    {
        BoardingActivity::where('id', $id)->delete();
        echo 'Berhasil';
    }

    //Rincian Kegiatan Santri
    public function showActivityItem(Request $request)
    {
        $basic = BoardingActivityItem::selectRaw('ep_boarding_activity_item.*, non.id AS non_active')
                    ->leftJoin('ep_boarding_activity_nonactive AS non', function($join)
                    {
                        $join->on('ayid','=',DB::raw(config('id_active_academic_year')));
                        $join->on('tid','=',DB::raw(config('id_active_term')));
                        $join->on('ep_boarding_activity_item.id','=','non.activity_id');
                        $join->on('non.desc','=',DB::raw("'ITEM'"));
                    })
        ->where('ep_boarding_activity_item.id', $request->id)
        ->first();

        echo json_encode($basic);
    }
    public function saveActivityItem(Request $request)
    {
        $activity = new BoardingActivityItem();
        $activity->name = $request->item_name;
        $activity->name_ar = $request->item_name_ar;
        $activity->seq = $request->item_seq;
        $activity->cby = auth()->user()->id;
        $activity->uby = 0;
        $activity->save();

        echo 'Berhasil';
    }
    public function updateActivityItem(Request $request)
    {
        if($request->aktif) {
            BoardingActivityNonActive::updateOrCreate(
                [
                    'ayid' => config('id_active_academic_year'),
                    'tid' => config('id_active_term'),
                    'activity_id' => $request->id,
                    'desc' => "ITEM",
                ],
                [
                    'cby' => auth()->user()->id,
                    'uby' => auth()->user()->id,
                ]
            );
        } else {
            BoardingActivityNonActive::where('ayid', config('id_active_academic_year'))
            ->where('tid', config('id_active_term'))
            ->where('activity_id', $request->id)
            ->where('desc', "ITEM")
            ->delete();
        }
        BoardingActivityItem::where('id', $request->id)
            ->update([
                'name' => $request->item_name,
                'name_ar' => $request->item_name_ar,
                'seq' => $request->item_seq,
                'uby' => auth()->user()->id,
            ]);

        echo 'Berhasil';
    }
    public function deleteActivityItem($id)
    {
        BoardingActivityItem::where('id', $id)->delete();
        echo 'Berhasil';
    }
}
