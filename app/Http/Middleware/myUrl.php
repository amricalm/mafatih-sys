<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Redirect;

class myUrl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->user()->role != '1')
        {
            // $modul = Menu::getMenuFromModul();
            // $slugmodul = collect($modul)->pluck('slug')->toArray();
            // $role = Menu::getMenuFromRole();
            // $slugrole = collect($role)->pluck('slug')->toArray();
            // $array = array_merge($slugmodul,$slugrole);
            // $array = array_unique($array);
            // $halaman = $request->segment(1);
            // $arrayindex = [];
            // $no = 0;
            // foreach($array as $k=>$v)
            // {
            //     $arrayindex[$no] = $v;
            //     $no++;
            //     if(str_contains($v,'/')!==false)
            //     {
            //         $split = explode('/',$v);
            //         $arrayindex[$no] = $split[0];
            //         $no++;
            //     }
            // }
            // if(!in_array($halaman,$arrayindex))
            // {
            //     return Redirect::to(url()->previous());
            // }
        }
        return $next($request);
    }
}
