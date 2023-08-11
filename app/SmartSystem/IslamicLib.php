<?php

namespace App\SmartSystem;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class IslamicLib extends Model
{
    public static function random_quran($param='',$layout='')
    {
        $request = Http::get('https://quran-api-id.vercel.app/random');
        $array = json_decode($request,true);
        $carinomorsurat = explode('/',$array['image']['secondary']);
        $surat = $carinomorsurat[5];

        $surat_in = Http::get('https://quran-api-id.vercel.app/surahs/'.$surat);
        $arraysurat = json_decode($surat_in,true);

        $surat_ar = Http::get('https://api.alquran.cloud/v1/surah/'.$surat);
        $arraysuratar = json_decode($surat_ar,true);

        $detail = '';
        if($layout=='')
        {
            if($param!='')
            {
                if($param=='id')
                {
                    $detail = $array['translation'].'(T.Q. '.$arraysurat['name'].' ['.$surat.']:'.$array['number']['inSurah'].')';
                }
                elseif($param=='ar')
                {
                    $detail = $array['arab'].'<br><small>('.$arraysuratar['data']['name'].': '.\App\SmartSystem\General::angka_arab($array['number']['inSurah']).')</small>';
                }
            }
            else
            {
                $detail = $array['arab']
                    .'<br>'
                    .str_replace('\n','',$array['translation'])
                    .'<br/>'
                    .'(T.Q. '.$arraysurat['name'].':'.$array['number']['inSurah'].')';
            }
        }
        elseif($layout=='jumbotron')
        {
            $detail .= '<div class="card">';
            $detail .= '<div class="row card-body">';
            $detail .= '<div class="col-md-6">';
            $detail .= '<p class="arabic text-right">';
            $detail .= $array['arab'];
            $detail .= '<br/><small>('.$arraysuratar['data']['name'].': '.\App\SmartSystem\General::angka_arab($array['number']['inSurah']).')</small>';
            $detail .= '</p>';
            $detail .= '</div>';
            $detail .= '<div class="col-md-6">';
            $detail .= '<p style="text-align:left;">'.$array['translation'].'';
            $detail .= '(T.Q.S. '.$arraysurat['name'].' ['.$surat.']:'.$array['number']['inSurah'].')</p>';
            $detail .= '</div>';
            $detail .= '</div></div>';
        }
        echo $detail;
    }
    public static function random_quran_old($param='',$layout='')
    {
        try {
            $request = Http::get('https://api.banghasan.com/quran/format/json/acak');
            $array = json_decode($request,true);
            if($array['status']=='ok')
            {
                $surat = $array['surat'];
                $detail = '';
                if($layout=='')
                {
                    if($param!='')
                    {
                        if($param=='id')
                        {
                            $detail = $array['acak'][$param]['teks'].'(T.Q. '.$surat['nama'].':'.$array['acak']['id']['ayat'].')';
                        }
                        elseif($param=='ar')
                        {
                            $detail = $array['acak'][$param]['teks'].'<br><small>('.$array['surat']['asma'].': '.\App\SmartSystem\General::angka_arab($array['acak']['id']['ayat']).')</small>';
                        }
                    }
                    else
                    {
                        $detail = $array['acak']['ar']['teks']
                            .'<br>'
                            .str_replace('\n','',$array['acak']['id']['teks'])
                            .'<br/>'
                            .'(T.Q. '.$surat['nama'].':'.$array['acak']['id']['ayat'].')';
                    }
                }
                elseif($layout=='jumbotron')
                {
                    $detail .= '<div class="card">';
                    $detail .= '<div class="row card-body">';
                    $detail .= '<div class="col-md-6">';
                    $detail .= '<p class="arabic text-right">';
                    $detail .= $array['acak']['ar']['teks'];
                    $detail .= '<br/><small>('.$array['surat']['asma'].': '.\App\SmartSystem\General::angka_arab($array['acak']['id']['ayat']).')</small>';
                    $detail .= '</p>';
                    $detail .= '</div>';
                    $detail .= '<div class="col-md-6">';
                    $detail .= '<p style="text-align:left;">'.$array['acak']['id']['teks'].'';
                    $detail .= '(T.Q.S. '.$surat['nama'].':'.$array['acak']['id']['ayat'].')</p>';
                    $detail .= '</div>';
                    $detail .= '</div></div>';
                }
                echo $detail;
            }
        } catch (\Throwable $th) {
            echo 'Error!<br>Detail : '.$th;
        }
    }
    public static function random_doa($param='')
    {
        try {
            $request = Http::get('https://doa-doa-api-ahmadramadhan.fly.dev/api/doa/v1/random');
            $array = json_decode($request,true);
            if($array)
            {
                $array = reset($array);
                echo '<h5>'.$array['doa'].' : </h5>';
                echo '<p class="text-right arabic">'.$array['ayat'].'</p>';
                echo '<p>'.$array['artinya'].'</p>';
            }
        } catch (\Throwable $th) {
            echo 'Error!<br>Detail : '.$th;
        }
    }
}
