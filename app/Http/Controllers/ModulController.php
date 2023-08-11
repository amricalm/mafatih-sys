<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RfModul;
use App\Models\Menu;
use App\Models\MenuModul;
use Illuminate\Support\Facades\DB;

class ModulController extends Controller
{
    var $global;
    public function __construct()
    {
        $this->global['aktif'] = 'konfigurasi';
        $this->global['judul'] = 'Pembagian menu berdasarkan Modul';
    }
    public function index(Request $request)
    {
        $app['aktif'] = $this->global['aktif'];
        $app['judul'] = $this->global['judul'];
        $app['menus'] = collect(Menu::get());
        $app['menu'] = RfModul::get();
        $app['modul'] = MenuModul::join('menu','menu_id','=','menu.id')
            ->join('rf_modul','modul_id','=','rf_modul.id')
            ->orderBy('seq')
            ->get();

        return view('halaman.modul', $app);
    }
    public function save(Request $request)
    {
        $datas = array();
        parse_str($request->data, $datas);

        RfModul::updateOrCreate(
            ['id'=>$datas['id']],
            ['name'=>$datas['name'],'desc'=>$datas['desc']]
        );

        echo 'Berhasil';
    }
    public function load(Request $request)
    {
        $id = $request->id;
        $modul = RfModul::where('id',$id)->first();
        echo json_encode($modul);
    }
    public function delete(Request $request)
    {
        $id = $request->id;
        MenuModul::where('modul_id',$id)->delete();
        RfModul::where('id',$id)->delete();
        echo 'Berhasil';
    }
    public function loaddetail(Request $request)
    {
        $id = $request->id;
        $modul = RfModul::where('id',$id)->first();
        $array = ['header'=>$modul];
        $detail = MenuModul::where('modul_id',$id)
            ->join('rf_modul','modul_id','=','rf_modul.id')
            ->join('menu','menu_id','=','menu.id')
            ->orderBy('seq')
            ->get();
        $array['detail'] = $detail;
        echo json_encode($array);
    }
    public function savedetail(Request $request)
    {
        $datas = array();
        parse_str($request->data, $datas);
        $array['menu_id'] = $datas['idmenu'];
        $array['modul_id'] = $datas['idheader'];
        $max = MenuModul::where('modul_id',$array['modul_id'])->selectRaw('max(seq) as max')->first()['max'];
        $array['seq'] = ($max=='') ? 1 : $max+1;
        MenuModul::insert($array);
        echo 'Berhasil';
    }
    public function deletedetail(Request $request)
    {
        $datas = array();
        parse_str($request->data, $datas);

        $menu_id = $request->menu_id;
        $modul_id = $request->modul_id;
        MenuModul::where('menu_id',$menu_id)
            ->where('modul_id',$modul_id)
            ->delete();

        echo 'Berhasil';
    }
    public function movedetail(Request $req)
    {
        MenuModul::where('menu_id',$req->menu_id)
            ->where('modul_id',$req->modul_id)
            ->update(['seq'=>$req->seq]);

        echo 'Berhasil';
    }
}
