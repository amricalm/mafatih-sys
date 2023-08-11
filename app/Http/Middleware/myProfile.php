<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\SmartSystem\General;
use App\Models\Student;
use App\Models\CourseClassDtl;
use App\Models\Homeroom;
use App\Models\BoardingGroup;
use App\Models\BayanatMapping;
use App\Models\MsUpload;

class myProfile
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
        $data['profil'] = General::getProfil();
        // $data['kelas'] = CourseClassDtl::getClassFromStudent($data['profil']['person']->id)[0];
        // $data['walikelas'] = Homeroom::getFromClass($data['kelas']['ccid']);
        // $fotowalikelas = MsUpload::where('pid',$data['walikelas']['id'])->where('desc','Foto Personal')->first();
        // $data['walikelas']['foto'] = (!is_null($fotowalikelas)) ? url('/').'/'.$fotowalikelas['original_file'] : url('assets').'/img/no-profile.png';
        // $data['pengasuhan'] = BoardingGroup::getFromBoarding($data['profil']['detail']->id);
        // $fotopengasuh = MsUpload::where('pid',$data['pengasuhan']['id'])->where('desc','Foto Personal')->first();
        // $data['pengasuhan']['foto'] = (!is_null($fotopengasuh)) ? url('/').'/'.$fotopengasuh['original_file'] : url('assets').'/img/no-profile.png';
        // $data['bayanat'] = collect(BayanatMapping::getFromPerson($data['profil']['person']->id))->first();
        // $fotombayanat = MsUpload::where('pid',$data['bayanat']['id'])->where('desc','Foto Personal')->first();
        // $data['bayanat']['foto'] = (!is_null($fotombayanat)) ? url('/').'/'.$fotombayanat['original_file'] : url('assets').'/img/no-profile.png';

        foreach($data as $k=>$v)
        {
            config([$k=>$v]);
        }
        return $next($request);
    }
}
