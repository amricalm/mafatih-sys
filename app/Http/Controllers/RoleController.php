<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\MenuRole;
use App\Models\Menu;

class RoleController extends Controller
{
    var $global;
    public function __construct()
    {
        $this->global['aktif'] = 'konfigurasi';
        $this->global['judul'] = 'Peran';
    }
    public function index(Request $request)
    {
        $app['aktif'] = $this->global['aktif'];
        $app['judul'] = $this->global['judul'];
        $app['peran'] = Role::get();
        $app['menu'] = Menu::get();

        return view('halaman.peran', $app);
    }
    public function load(Request $request)
    {
        $id = $request->id;
        $menu = Role::where('id',$id)->first();
        $menurole = MenuRole::where('role_id',$id)->join('menu','menu.id','=','menu_id')->orderBy('urutan')->orderBy('menu_parent')->get();
        $menurole = collect($menurole);
        $utama = $menurole->where('menu_parent','0')->toArray();
        $text = '';
        $no = 1; $nod = 1;
        foreach($utama as $key=>$val)
        {
            $text .= '<tr>';
            $text .= '<td>'.$no.'</td>';
            $text .= '<td>'.$val['menu'].'</td>';
            $text .= '<td>#</td>';
            $text .= '</tr>';
            $no++; $nod = 1;
            $menumenu = $menurole->where('menu_parent',$val['id'])->toArray();
            foreach($menumenu as $key=>$val)
            {
                $text .= '<tr>';
                $text .= '<td> &nbsp; </td>';
                $text .= '<td> --- '.$val['menu'].'</td>';
                $text .= '<td><button type="button" class="btn btn-danger btn-sm" onclick="deletemenu('.$val['id'].')"><i class="fa fa-trash"></i></button></td>';
                $text .= '</tr>';
                $nod++;
            }
        }
        $array = array('peran'=>$menu,'detail'=>$text);
        echo json_encode($array);
    }
    public function update(Request $request)
    {
        $id = $request->id;
        $menuid = $request->menu;
        $menu = Menu::where('id',$menuid)->first();
        if($menu->menu_parent!='0')
        {
            $menurole = MenuRole::where('role_id',$id)->where('menu_id',$menu->menu_parent)->first();
            if(is_null($menurole))
            {
                MenuRole::create(['role_id'=>$id,'menu_id'=>$menu->menu_parent]);
            }
        }
        MenuRole::create(
            [
                'role_id' => $id,
                'menu_id' => $menuid,
            ]
        );
        echo 'Berhasil';
    }
    public function save(Request $request)
    {
        $datas = array();
        parse_str($request->data, $datas);

        Role::updateOrCreate(
            ['id'=>$datas['id']],
            [
                'name'=>$datas['name'],
                'desc'=>$datas['desc'],
            ]
        );
        echo 'Berhasil';
    }
    public function delete(Request $request)
    {
        $id = $request->id;
        Role::where('id',$id)->delete();
        echo 'Berhasil';
    }
    public function deletemenu(Request $request)
    {
        $roleId = $request->id;
        $menuId = $request->is;
        MenuRole::where('role_id',$roleId)->where('menu_id',$menuId)->delete();
        echo 'Berhasil';
    }
}
