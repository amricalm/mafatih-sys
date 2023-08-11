<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\RfSchoolType;
use Illuminate\Http\Request;
use App\Models\School;
use DataTables;

class SchoolController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = School::latest()->get();
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

        $app['judul'] = "Sekolah";

        return view('halaman.school', $app);
    }

    public function show(Request $request)
    {
        $app['aktif'] = 'sekolah';
        $app['judul'] = 'Profil Sekolah';
        $app['type'] = RfSchoolType::get();
        $app['sekolah'] = School::find(config('id_active_school'))->first();
        $alamat = Address::where(['type' => 'school', 'pid' => config('id_active_school')]);
        $app['alamat'] = ($alamat->count() > 0) ? $alamat->first() : array('province' => '', 'city' => '', 'district' => '', 'village' => '', 'post_code' => '');
        $app['provinces'] = \Indonesia::allProvinces();
        $app['city'] = ($alamat->count() <= 0) ? array() : \Indonesia::findProvince($app['alamat']['province'], ['cities'])->cities->pluck('name', 'id');
        $app['district'] = ($alamat->count() <= 0) ? array() : \Indonesia::findCity($app['alamat']['city'], ['districts'])->districts->pluck('name', 'id');
        $app['village'] = ($alamat->count() <= 0) ? array() : \Indonesia::findDistrict($app['alamat']['district'], ['villages'])->villages->pluck('name', 'id');
        return view('halaman.school-edit', $app);
    }
    public function save(Request $request)
    {
        School::where('id', $request->id)
            ->update([
                'nss' => $request->nss,
                'name' => $request->name,
                'year' => $request->year,
                'school_type_id' => $request->school_type_id,
                'accreditation' => $request->accreditation,
                'phone' => $request->phone,
                'email' => $request->email,
                'surface_area' => $request->surface_area,
                'building_area' => $request->building_area,
                'land_status' => $request->land_status,
                'uby' => auth()->user()->id,
            ]);

        $address = Address::where(['pid' => $request->id, 'type' => 'school']);
        if ($address->exists()) {
            Address::where(['pid' => $request->id, 'type' => 'school'])
                ->update([
                    'address' => $request->alamat,
                    'province' => $request->provinsi,
                    'city' => $request->kota,
                    'district' => $request->kecamatan,
                    'village' => $request->desa,
                    'post_code' => $request->post,
                    'uby' => auth()->user()->id,
                ]);
        } else {
            Address::create([
                'pid' => $request->id,
                'type' => 'school',
                'address' => $request->alamat,
                'province' => $request->provinsi,
                'city' => $request->kota,
                'district' => $request->kecamatan,
                'village' => $request->desa,
                'post_code' => $request->post,
                'cby' => auth()->user()->id,
            ]);
        }

        return redirect('sekolah')->with('success', 'Simpan Data Berhasil');
    }

    public function store(Request $request)
    {
        School::updateOrCreate(
            ['id' => $request->id],
            ['institution_id' => 1, 'name' => $request->name, 'school_type_id' => 1, 'cby' => 1, 'uby' => 1]
        );

        $arr = array('status' => 'true', 'msg' => 'Berhasil');
        return Response()->json($arr);
    }

    public function edit($id)
    {
        $data = School::find($id);
        return response()->json($data);
    }

    public function destroy($id)
    {
        School::find($id)->delete();

        $arr = array('status' => 'true', 'msg' => 'Berhasil');
        return Response()->json($arr);
    }
}
