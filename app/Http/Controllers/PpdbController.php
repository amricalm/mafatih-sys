<?php

namespace App\Http\Controllers;

use App\Models\Ppdb;
use Illuminate\Http\Request;

class PpdbController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ppdb  $ppdb
     * @return \Illuminate\Http\Response
     */
    // public function show(Ppdb $ppdb)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ppdb  $ppdb
     * @return \Illuminate\Http\Response
     */
    public function edit(Ppdb $ppdb)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ppdb  $ppdb
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ppdb $ppdb)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ppdb  $ppdb
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ppdb $ppdb)
    {
        //
    }

    // public function show($id)
    // {
    //     $app['aktif'] = 'siswa';
    //     $app['judul'] = 'Edit Siswa';
    //     $app['siswa'] = Student::find($id);
    //     $app['person'] = Person::find($app['siswa']['pid']);
    //     $app['jobs'] = MsJobs::orderBy('name','desc')->get();
    //     $alamat = Address::where(['type'=>'person','pid'=>$app['person']['id']]);
    //     $app['alamat'] = ($alamat->count()>0) ? $alamat->first() : array('province'=>'','city'=>'','district'=>'','village'=>'','post_code'=>'');
    //     $app['provinces'] = \Indonesia::allProvinces();
    //     $app['city'] = ($alamat->count() <= 0) ? array() : \Indonesia::findProvince($app['alamat']['province'], ['cities'])->cities->pluck('name', 'id');
    //     $app['district'] = ($alamat->count() <= 0) ? array() : \Indonesia::findCity($app['alamat']['city'], ['districts'])->districts->pluck('name', 'id');
    //     $app['village'] = ($alamat->count() <= 0) ? array() : \Indonesia::findDistrict($app['alamat']['district'], ['villages'])->villages->pluck('name', 'id');
    //     return view('halaman.student-edit', $app);
    // }
}
