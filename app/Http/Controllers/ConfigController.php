<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Models\MsConfig;
use App\Models\RfTerm;
use App\Models\School;
use App\Models\Position;
use App\Models\RfSchoolType;
use Illuminate\Http\UploadedFile;

class ConfigController extends Controller
{
    var $global;
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->global['aktif'] = 'konfigurasi';
        $this->global['judul'] = 'Konfigurasi';
    }
    public function index(Request $request)
    {
        $app['aktif'] = $this->global['aktif'];
        $app['judul'] = $this->global['judul'];
        $app['student'] = array();
        if($request->post())
        {
            $datas = array();
            parse_str($request->data, $datas);
            switch ($datas['type']) {
                case 'tripay':
                    unset($datas['type']);
                    foreach($datas as $k=>$v)
                    {
                        MsConfig::updateOrCreate(
                            ['config_name'=>'tripay_'.$k],
                            ['config_value'=>$datas[$k]]
                        );
                    }
                    \App\SmartSystem\General::start();
                    echo 'Berhasil';
                    die();
                    break;

                case 'recaptcha':
                    MsConfig::updateOrCreate(
                        ['config_name'=>'recaptcha_sitekey'],
                        ['config_value'=>$datas['sitekey']]
                    );
                    MsConfig::updateOrCreate(
                        ['config_name'=>'recaptcha_secretkey'],
                        ['config_value'=>$datas['secretkey']]
                    );
                    \App\SmartSystem\General::start();
                    echo 'Berhasil';
                    die();
                    break;

                case 'onesignal':
                    MsConfig::updateOrCreate(
                        ['config_name'=>'onesignal_appid'],
                        ['config_value'=>$datas['appid']]
                    );
                    MsConfig::updateOrCreate(
                        ['config_name'=>'onesignal_apikey'],
                        ['config_value'=>$datas['sitekey']]
                    );
                    \App\SmartSystem\General::start();
                    echo 'Berhasil';
                    die();
                    break;
                case 'global':
                    unset($datas['type']);
                    foreach($datas as $k=>$v)
                    {
                        MsConfig::updateOrCreate(
                            ['config_name'=>$k],
                            ['config_value'=>$datas[$k]]
                        );
                    }
                    \App\SmartSystem\General::start();
                    echo 'Berhasil';
                    die();
                    break;

                case 'number':
                    MsConfig::updateOrCreate(
                        ['config_name'=>'paging'],
                        ['config_value'=>$datas['paging']]
                    );
                    \App\SmartSystem\General::start();
                    echo 'Berhasil';
                    die();
                    break;

                case 'diknas':
                        unset($datas['type']);
                        foreach($datas as $key=>$val)
                        {
                            foreach($val as $k=>$v) {
                                RfSchoolType::where('id',$k)->update(['name'=>$v]);
                            }
                        }
                        \App\SmartSystem\General::start();
                        echo 'Berhasil';
                        die();
                        break;

                default:
                    # code...
                    break;
            }
        }

        return view('halaman.configuration', $app);
    }
    public function thirdparty()
    {
        $app['aktif'] = $this->global['aktif'];
        $app['judul'] = $this->global['judul'];
        return view('halaman.configuration-thirdparty', $app);
    }
    public function yayasan()
    {
        $app['aktif'] = $this->global['aktif'];
        $app['judul'] = $this->global['judul'];
        $app['school'] = School::get();
        $app['ac_year'] = AcademicYear::orderBy('name')->get();
        $app['term'] = RfTerm::get();
        $app['posisi'] = Position::get();
        $app['config'] = MsConfig::get();
        $app['school_type'] = RfSchoolType::whereIn('id',[2,3])->get();
        return view('halaman.configuration-yayasan', $app);
    }
    public function paging()
    {
        $app['aktif'] = $this->global['aktif'];
        $app['judul'] = $this->global['judul'];
        return view('halaman.configuration-paging', $app);
    }
    public function logo()
    {
        $app['aktif'] = $this->global['aktif'];
        $app['judul'] = $this->global['judul'];
        return view('halaman.configuration-logo', $app);
    }
    public function savelogo(Request $request)
    {
        if($request->hasFile('logo'))
        {
            $filename = time().'_'.$request->logo->getClientOriginalName();
            $filepath = $request->file('logo')->storeAs('',$filename,'upload');

            MsConfig::updateOrCreate(
                ['config_name'=>'logo_lembaga'],
                ['config_value'=>$filepath]
            );

        }
        else
        {
            MsConfig::updateOrCreate(
                ['config_name'=>'logo_lembaga'],
                ['config_value'=>'']
            );
        }
        \App\SmartSystem\General::start();
        return redirect('/konfigurasi/logo');
    }
}
