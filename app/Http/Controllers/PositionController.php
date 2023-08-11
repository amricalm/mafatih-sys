<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Position;

class PositionController extends Controller
{
    public function index()
    {
        $app['aktif'] = 'posisi';
        $app['judul'] = "Posisi";
        $app['position'] = Position::get();

        return view('halaman.position', $app);
    }

    public function show($id)
    {
        $data = Position::where('id', '=', $id)->first();

        echo json_encode($data);
    }

    public function save(Request $request)
    {
        $grade = new Position();
        $grade->name = $request->name;
        $grade->name_ar = ($request->name_ar!='') ? $request->name_ar : ' ';
        $grade->cby = auth()->user()->id;
        $grade->uby = 0;
        $grade->save();

        echo 'Berhasil';
    }
    public function update(Request $request)
    {
        Position::where('id', $request->id)
            ->update([
                'name' => $request->name,
                'name_ar' => ($request->name_ar!='') ? $request->name_ar : ' ',
                'uby' => auth()->user()->id
            ]);
        echo 'Berhasil';
    }
    public function delete($id)
    {
        Position::where('id', $id)->delete();
        echo 'Berhasil';
    }
}
