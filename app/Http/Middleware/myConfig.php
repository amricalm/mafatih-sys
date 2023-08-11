<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\UserConfig;

class myConfig
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
        $userconfig = UserConfig::where('uid',auth()->user()->id)->whereRaw('date_change <= "'.date('Y-m-d').'"')->first();
        if(!is_null($userconfig))
        {
            $valueconfig = DB::table('aa_academic_year')->where('id', $userconfig['ayid'])->first()->name;
            ($userconfig['ayid']!='') ? config(['id_active_academic_year'=>$userconfig['ayid']]) : '';
            ($userconfig['ayid']!='') ? config(['active_academic_year'=>$valueconfig]) : '';

            $valueconfig = DB::table('rf_term')->where('id', $userconfig['tid'])->first()->desc;
            ($userconfig['tid']!='') ? config(['id_active_term'=>$userconfig['tid']]) : '';
            ($userconfig['tid']!='') ? config(['active_term'=>$valueconfig]) : '';
        }
        return $next($request);
    }
}
