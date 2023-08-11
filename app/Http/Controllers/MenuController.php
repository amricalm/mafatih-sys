<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    var $global;
    public function __construct()
    {
        $this->global['aktif'] = 'konfigurasi';
        $this->global['judul'] = 'Menu-menu';
    }
    public function index(Request $request)
    {
        $app['aktif'] = $this->global['aktif'];
        $app['judul'] = $this->global['judul'];
        $app['menu'] = Menu::get();

        return view('halaman.menu', $app);
    }
    public function load(Request $request)
    {
        $id = $request->id;
        $menu = Menu::where('id',$id)->first();
        echo json_encode($menu);
    }
    public function save(Request $request)
    {
        $datas = array();
        parse_str($request->data, $datas);

        Menu::updateOrCreate(
            ['id'=>$datas['id']],
            [
                'urutan'=>$datas['urutan'],
                'menu'=>$datas['menu'],
                'slug' => $datas['slug'],
                'menu_parent'=>$datas['menu_parent'],
                'menu_level'=>$datas['menu_level'],
                'menu_icon'=>$datas['menu_icon'],
            ]
        );
        echo 'Berhasil';
    }
    public function delete(Request $request)
    {
        $id = $request->id;
        Menu::where('id',$id)->delete();
        echo 'Berhasil';
    }
}
