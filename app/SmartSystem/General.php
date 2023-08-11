<?php

namespace App\SmartSystem;

use App\Models\AcademicYear;
use App\Models\Employe;
use Illuminate\Database\Eloquent\Model;
use App\Models\MenuRole;
use App\Models\MsConfig;
use App\Models\School;
use App\Models\Person;
use App\Models\User;
use App\Models\Student;
use App\Models\MsUpload;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\SmartSystem\IslamicLib;
use Stichoza\GoogleTranslate\GoogleTranslate;

class General extends Model
{
    public static function start()
    {
        $config = MsConfig::where('aktif', 1)->get()->toArray();
        foreach ($config as $key => $val) {
            $keyconfig = $val['config_name'];
            $valueconfig = $val['config_value'];
            if ($val['config_name'] == 'active_school') {
                config(['id_active_school' => $valueconfig]);
                $valueconfig = School::find($valueconfig)->first()->name;
            }
            if ($val['config_name'] == 'active_academic_year') {
                config(['id_active_academic_year' => $valueconfig]);
                $valueconfig = DB::table('aa_academic_year')->where('id', $valueconfig)->first()->name;
            }
            if ($val['config_name'] == 'active_term') {
                config(['id_active_term' => $valueconfig]);
                $valueconfig = DB::table('rf_term')->where('id', $valueconfig)->first()->desc;
            }
            config([$keyconfig => $valueconfig]);
        }
    }
    public static function getProfil()
    {
        $person = Person::where('id',auth()->user()->pid)->first();
        $student = Student::where('pid',auth()->user()->pid)->first();
        $profil['person'] = (is_null($person)) ? array() : $person;
        $profil['student'] = (is_null($student)) ? array() : $student;
        $profil['user'] = User::where('id',auth()->user()->id)->first();
        $profil['detail'] = ($profil['user']->role=='2')
            ? Student::where('pid',auth()->user()->pid)->first()
            : Employe::where('pid',auth()->user()->pid)->first();
        $profil['files'] = MsUpload::where('pid',auth()->user()->pid)->get();
        $fotoprofil = $profil['files']->where('desc','Foto Personal')->toArray();
        $fotoprofil = reset($fotoprofil);
        $profil['foto'] = (!isset($fotoprofil['original_file']))
            ? url('assets').'/img/no-profile.png'
            : url('/').'/'.$fotoprofil['original_file'];
        return $profil;
    }
    public static function menu_sidebar()
    {
        $role = auth()->user()->role;
        $menu = MenuRole::where('role_id',$role)
            ->where('menu_parent','0')
            ->where('is_publish','1')
            ->join('menu','menu_id','=','id')
            ->orderBy('urutan')
            ->get();
        return $menu;
    }
    public static function menu_dropdown($id)
    {
        $role = auth()->user()->role;
        $menu = MenuRole::where('menu_parent',$id)
            ->where('role_id',$role)
            ->join('menu','menu_id','=','id')
            ->orderBy('urutan')
            ->get();
        return $menu;
    }
    public function cek_role($menu)
    {
        $role = auth()->user->role;
        $menu = MenuRole::where('role_id',$role)
            ->where('slug',$menu)
            ->join('menu','menu_id','=','id')
            ->first();
        return (count($menu)>0) ? true : false;
    }
    public static function angka_arab($angkalatin)
    {
        if($angkalatin=='')
        {
            $angkalatin = '0';
        }
        $arabic = array(
            0 => '٠',
            1 => '١',
            2 => '٢',
            3 => '٣',
            4 => '٤',
            5 => '٥',
            6 => '٦',
            7 => '٧',
            8 => '٨',
            9 => '٩',
            '.' => ',',
        );
        $pecah = str_split($angkalatin);
        $hasil = '';
        for($i=0;$i<count($pecah);$i++)
        {
            $hasil .= $arabic[$pecah[$i]];
        }
        return $hasil;
    }
    public static function pilihan($pilih)
    {
        $pilihan = array();
        switch ($pilih) {
            case 'sempurna':
                $pilihan = array('Sempurna','Tidak Sempurna');
                break;
            case 'aktif':
                $pilihan = array('Aktif','Tidak Aktif');
                break;
            case 'bagus':
                $pilihan = array('Terbaik','Bagus Sekali','Bagus','Cukup');
                break;
            case 'syarat':
                $pilihan = array('Memenuhi Syarat','Tidak Memenuhi Syarat');
                break;
            case 'berhasil' :
                $pilihan = array('Lulus','Lulus dengan Syarat','Gagal');
                break;
            default:
                break;
        }
        return $pilihan;
    }
    public static function pilihan_ar($pilih)
    {
        switch ($pilih) {
            case 'Sempurna':
                return 'تم';
                break;
            case 'Tidak Sempurna':
                return 'لم يتم';
                break;
            case 'Aktif' :
                return 'فعّال';
                break;
            case 'Tidak Aktif' :
                return 'غير فعّال';
                break;
            case 'Lulus' :
                return 'ناجح ';
                break;
            case 'Lulus dengan Syarat' :
                return 'ناجح مع الإشراف';
                break;
            case 'Gagal' :
                return 'راسب';
                break;
            case 'Memenuhi Syarat' :
                return 'مؤهّل';
                break;
            case 'Tidak Memenuhi Syarat' :
                return 'غير مؤهّل';
                break;
            default:
                # code...
                break;
        }
    }
    public static function hasil_kelulusan($nilai)
    {
        if($nilai >= 60)
        {
            return 'ناجح';
        }
        elseif($nilai >= 55)
        {
            return 'ناجح مع الإشراف';
        }
        else
        {
            return 'راسب';
        }
    }
    public static function predikat($nilai)
    {
        if($nilai >= 90)
        {
            return 'ممتاز';
        }
        elseif($nilai >= 80)
        {
            return 'جيد جدا';
        }
        elseif($nilai >= 70)
        {
            return 'جيد';
        }
        elseif($nilai >= 60)
        {
            return 'مقبول';
        }
        elseif($nilai >= 57)
        {
            return 'إشراف';
        }
        elseif($nilai >= 55)
        {
            return 'ضعيف';
        }
        else
        {
            return 'إشراف تفوق';
        }
    }
    public function predikatDiknas($na)
    {
        $predikat = '';
        if($na > 90) {
            $predikat = 'A';
        } elseif($na > 80) {
            $predikat = 'B';
        } elseif($na > 70) {
            $predikat = 'C';
        } elseif($na < 71) {
            $predikat = 'D';
        } elseif($na == 0) {
            $predikat = '';
        }
        return $predikat;
    }
    public function numbertolongPredikatDiknas($na)
    {
        $predikat = '';
        if($na > 90) {
            $predikat = 'Baik Sekali';
        } elseif($na > 80) {
            $predikat = 'Baik';
        } elseif($na > 70) {
            $predikat = 'Cukup';
        } elseif($na < 71) {
            $predikat = 'Kurang';
        } elseif($na == 0) {
            $predikat = '';
        }
        return $predikat;
    }
    public static function mulok($pilih)
    {
        switch ($pilih) {
            case 0:
                return 'Kelompok A (Umum)';
                break;
            case 1:
                return 'Kelompok B (Umum)';
                break;
            case 2:
                return 'Muatan Lokal';
                break;
           default:
                # code...
                break;
        }
    }
    public static function shorttolongPredikatDiknas($na)
    {
        $predikat = '';
        if($na=='A+' || $na=='A' || $na=='A-') {
            $predikat = 'Baik Sekali';
        } elseif($na=='B+' || $na=='B' || $na=='B-') {
            $predikat = 'Baik';
        } elseif($na=='C+' || $na=='C' || $na=='C-') {
            $predikat = 'Cukup';
        } elseif($na=='D+' || $na=='D' || $na=='D-') {
            $predikat = 'Kurang';
        } else {
            $predikat = '';
        }
        return $predikat;
    }
    public static function getRealIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
    public static function log($param)
    {
        $curl = curl_init();
        $ip = (isset($param['ip'])) ? $param['ip'] : \App\SmartSystem\General::getRealIpAddr();
        if($ip!='127.0.0.1')
        {
            curl_setopt_array($curl, array(
                // CURLOPT_URL => "https://freegeoip.app/json/" . $ip,
                // CURLOPT_URL => "https://ipapi.co/".$ip."/json/",
                CURLOPT_URL => 'http://ip-api.com/json/'.$ip.'?fields=66846719',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "accept: application/json",
                    "content-type: application/json",
                ),
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            if ($err) {

            } else {
                $datatemp = json_decode($response,true);
                $response = $datatemp;
                $data['ip'] = $response['query'];
                $data['country_code'] = $response['countryCode'];
                $data['country_name'] = $response['country'];
                $data['region_code'] = $response['region'];
                $data['region_name'] = $response['regionName'];
                $data['city'] = $response['city'];
                $data['time_zone'] = $response['timezone'];
                $data['latitude'] = $response['lat'];
                $data['longitude'] = $response['lon'];
                $data['org'] = $response['isp'];
                $data['timestamp'] = date('Y-m-d H:i:s');
                $data['nama_login'] = $param['nama_login'];
                $data['role_id'] = $param['role_id'];
                $data['detail'] = $param['detail'];
            }
        }
        else
        {
            $data['ip'] = '127.0.0.1';
            $data['country_code'] = '';
            $data['country_name'] = '';
            $data['region_code'] = '';
            $data['region_name'] = '';
            $data['city'] = '';
            $data['time_zone'] = '';
            $data['latitude'] = '';
            $data['longitude'] = '';
            $data['org'] = '';
            $data['timestamp'] = date('Y-m-d H:i:s');
            $data['nama_login'] = $param['nama_login'];
            $data['role_id'] = $param['role_id'];
            $data['detail'] = $param['detail'];
        }
        return $data;
    }

    public static function month($month='')
    {
        $bulan = array(
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        );
        return ($month=='') ? $bulan : $bulan[$month];
    }

    public function month_in_arab($month)
    {
        $bulan = array(
            '01' => 'يَنَايِرُ',
            '02' => 'فَبْرَايِرُ',
            '03' => 'مَارِسْ',
            '04' => 'أَبْرِيْل',
            '05' => 'مَايُوْ',
            '06' => 'يُوْنِيُو',
            '07' => 'يُوُلِيُوْ',
            '08' => 'أَغُسْطُسْ',
            '09' => 'سِبْتِمْبِرْ',
            '10' => 'أُكْتُوْبِر',
            '11' => 'نُفَمْبِر',
            '12' => 'دِيْسَمْبِرْ'
        );
        return ($month=='') ? $bulan : $bulan[$month];
    }

    public function month_arab($month)
    {
        $bulan = array(
            '1' => 'مُحَرَّم',
            '2' => 'صَفَر',
            '3' => 'رَبِيْعُ الأَوَّل',
            '4' => 'رَبِيعُ الأٰخِر',
            '5' => 'جَمَادِى الأَوَّل',
            '6' => 'جَمَادِى الأٰخِر',
            '7' => 'رَجَب',
            '8' => 'شَعْبَان',
            '9' => 'رَمَضَان',
            '10' => 'شَوَّال',
            '11' => 'ذُوْالقَاعِدَة',
            '12' => 'ذُوْالحِجَّة'
        );
        return ($month=='') ? $bulan : $bulan[$month];
    }
    public function month_text_arab($text)
    {
        $array = array(
            'Muhharram' => '1',
            'Safar' => '2',
            'Rabiul awal' => '3',
            'Rabiul akhir' => '4',
            'Jumadil awal' => '5',
            'Jumadil akhir' => '6',
            'Rajab' => '7',
            'Sya ban' => '8',
            'Ramadhan' => '9',
            'Syawal' => '10',
            'Dzulkaidah' => '11',
            'Dzulhijjah' => '12',
        );
        $hasil = $this->month_arab($array[$text]);
        return $hasil;
    }

    public static function periode($periode) {
        $insertion = "-";
        $index = 4;
        $result = substr_replace($periode, $insertion, $index, 0);
        $tgls = explode('-',$result);
        $tgl = static::month($tgls[1]).' '.$tgls[0];

        return $tgl;
    }
    public static function convertDate($date)
    {
        $date = explode('-',$date);
        $year = $date[0];
        $month = $date[1];
        $day = $date[2];
        return $day.' '.static::month($month).' '.$year;
    }
    public static function convertDateShort($date)
    {
        $date = explode('-',$date);
        $year = $date[0];
        $month = $date[1];
        $day = $date[2];
        return $day.'/'.$month.'/'.substr($year,2,2);
    }
    public static function cekmenu($uid)
    {
        $menu = \App\Models\UserModul::where('uid',$uid)
            ->join('menu_modul','menu_modul.modul_id','=','users_modul.modul_id')
            ->join('menu','menu_id','=','menu.id')
            ->get();
        return collect($menu);
    }
    public function convertToArabic($thn,$bln,$tgl,$sp)
    {
        $thn = $this->angka_arab($thn);
        $bln = $this->month_in_arab($bln);
        $tgl = $this->angka_arab($tgl);

        return $tgl.$sp.$bln.$sp.$thn;
    }
    public function convertToHijriah2($thn,$bln,$tgl,$sp,$param='')
    {
        $tglblnthn = $tgl.'-'.$bln.'-'.$thn;
        $url = "https://masehi-ke-hijriyah.p.rapidapi.com/?tanggal=".$tglblnthn;

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: masehi-ke-hijriyah.p.rapidapi.com",
                "X-RapidAPI-Key: 9lNkmjGjHhCdgNvnepfOPMKKFfjcUXI4"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $response = trim($response,'[]');
            $a = json_decode($response,true);

            $thn = $a['tahun_hijriyah'];
            $bln = $a['bulan_hijriyah'];
            $tgl = $a['tanggal_hijriyah'];

            // tahun
            $athn = str_split($thn);
            $thn = '';
            for($ai=0;$ai<count($athn);$ai++)
            {
                $thn .= $this->angka_arab($athn[$ai]);
            }

            //bulan
            $bln = $this->month_text_arab($bln);

            //tanggal
            $atgl = str_split(ltrim($tgl,'0'));
            $tgl = '';
            for($ai=0;$ai<count($atgl);$ai++)
            {
                $tgl .= $this->angka_arab($atgl[$ai]);
            }

            $sp = ($sp=='') ? ' ' : $sp;
            return ($param!='') ? $a[$param] : $tgl.$sp.$bln.$sp.$thn;
        }
    }

    public function convertToHijriah($thn,$bln,$tgl,$sp,$param='')
    {
        $date = $thn.'-'.$bln.'-'.$tgl;
        $gregorianDate = \App\Services\DateConverter::GregorianToHijri($date);
        $tanggalhijriah = explode('-',$gregorianDate);
        $a = array(
                'tahun_hijriyah'=>$tanggalhijriah[0],
                'bulan_hijriyah'=>$tanggalhijriah[1],
                'tanggal_hijriyah'=>$tanggalhijriah[2]
            );

        // Tahun
        $thn = $tanggalhijriah[0];
        $athn = str_split($thn);
        $thn = '';
        for($ai=0;$ai<count($athn);$ai++)
        {
            $thn .= $this->angka_arab($athn[$ai]);
        }

        //bulan
        $bln = $tanggalhijriah[1];
        $bln = $this->month_arab((int)$bln);

        //tanggal
        $tgl = $tanggalhijriah[2];
        $atgl = str_split(ltrim($tgl,'0'));
        $tgl = '';
        for($ai=0;$ai<count($atgl);$ai++)
        {
            $tgl .= $this->angka_arab($atgl[$ai]);
        }

        $sp = ($sp=='') ? ' ' : $sp;
        return ($param!='') ? $a[$param] : $tgl.$sp.$bln.$sp.$thn;
    }

    public static function ustadz($sex)
    {
        $return = '';
        if($sex=='L')
        {
            $return = 'الأستاذ';
        }
        elseif($sex=='P')
        {
            $return = 'الأستاذة';
        } else {
            $return ='';
        }
        return $return;
    }

    public static function getGenderAr($sex,$extra='')
    {
        $return = '';
        if($sex=='L')
        {
            $return = ($extra!='') ? 'المشرف' : 'مشرف';
        }
        else
        {
            $return = ($extra!='') ? 'المشرفة' : 'مشرفة';
        }
        return $return;
    }

    public static function santri($sex)
    {
        $return = '';
        if($sex=='L')
        {
            $return = 'الطالب';
        }
        else
        {
            $return = 'الطالبة';
        }
        return $return;
    }

    public static function terbilang($x)
    {
        $angka = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];

        if ($x < 12)
            return " " . $angka[$x];
        elseif ($x < 20)
            return \App\SmartSystem\General::terbilang($x - 10) . " belas";
        elseif ($x < 100)
            return \App\SmartSystem\General::terbilang($x / 10) . " puluh" . \App\SmartSystem\General::terbilang($x % 10);
        elseif ($x < 200)
            return "seratus" . \App\SmartSystem\General::terbilang($x - 100);
        elseif ($x < 1000)
            return \App\SmartSystem\General::terbilang($x / 100) . " ratus" . \App\SmartSystem\General::terbilang($x % 100);
        elseif ($x < 2000)
            return "seribu" . \App\SmartSystem\General::terbilang($x - 1000);
        elseif ($x < 1000000)
            return \App\SmartSystem\General::terbilang($x / 1000) . " ribu" . \App\SmartSystem\General::terbilang($x % 1000);
        elseif ($x < 1000000000)
            return \App\SmartSystem\General::terbilang($x / 1000000) . " juta" . \App\SmartSystem\General::terbilang($x % 1000000);
    }

    public static function terbilang_ar($angka)
    {
        $obj = new \ArPHP\I18N\Arabic();
        $obj->setNumberFeminine(1);
        $obj->setNumberFormat(1);
        echo str_replace('مئة','مائة',$obj->int2str($angka));
    }

    public static function random_quran($param='',$layout='')
    {
        $lib = new IslamicLib;
        echo $lib::random_quran($param,$layout);
    }
    public static function random_doa($param='')
    {
        $lib = new IslamicLib;
        echo $lib::random_doa($param);
    }

    public static function translate($text)
    {
        $tr = new GoogleTranslate('ar');
        $tr->setSource('in');
        return $tr->translate($text);
    }
}
