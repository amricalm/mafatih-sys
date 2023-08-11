<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public $timestamps = false;
    protected $table = "menu";
    protected $fillable = [
        'urutan','menu','slug','menu_parent','menu_level','menu_icon','menu_turunan','menu_top',
    ];

    public static function getMenuFromModul()
    {
        $modul = Menu::where('uid',auth()->user()->id)
            ->join('menu_modul','menu_id','=','menu.id')
            ->join('rf_modul','menu_modul.modul_id','=','rf_modul.id')
            ->join('users_modul','users_modul.modul_id','=','rf_modul.id')
            ->get()->toArray();
        return $modul;
    }
    public static function getMenuFromRole()
    {
        $menu = Menu::where('users.id',auth()->user()->id)
            ->join('menu_role','menu_id','=','menu.id')
            ->join('users','role','=','role_id')
            ->where('slug','!=','#')
            ->get()->toArray();
        return $menu;
    }
}
