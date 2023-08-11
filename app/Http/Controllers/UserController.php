<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Models\CourseClass;
use Illuminate\Support\Facades\Hash;
use App\Models\Employe;
use App\Models\Person;
use Illuminate\Http\Request;
use App\Models\RfModul;
use App\Models\UserModul;
use App\Models\MenuModul;
use App\Models\RfLevelClass;
use App\Models\Role;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    var $global;
    public function __construct()
    {
        $this->global['aktif'] = 'user';
        $this->global['judul'] = 'User';
    }
    public function index(Request $request)
    {
        $app['aktif'] = $this->global['aktif'];
        $app['judul'] = $this->global['judul'];
        $app['page'] = 'users';
        $app['roles'] = Role::where('id','!=','2')->get();
        $user = User::join('roles','role','=','roles.id','inner')
            ->where('email','!=','')
            ->select('users.id','roles.name as rolesname','users.name','email')
            ->orderBy('email')
            ->where('role','!=','2')
            ->get();
        $app['user'] = ($request->kat!='') ? collect($user)->where('rolesname',$request->kat) : collect($user);
        $app['karyawan'] = Employe::where('is_active','1')
            ->orderBy('name')
            ->join('aa_person','pid','=','aa_person.id')
            ->get();
        $app['kelas'] = CourseClass::get();
        $app['level'] = RfLevelClass::get();
        $app['modul'] = RfModul::get();
        $app['menu'] = MenuModul::join('menu','menu.id','=','menu_id')->get();

        return view('halaman.user', $app);
    }
    public function main(Request $request)
    {
        $app['aktif'] = $this->global['aktif'];
        $app['judul'] = $this->global['judul'];
        $app['roles'] = Role::get();
        return view('halaman.user-main', $app);
    }
    public function orang_tua(Request $request)
    {
        $app['aktif'] = $this->global['aktif'];
        $app['judul'] = $this->global['judul'];
        $app['page'] = 'orang-tua';
        $app['roles'] = Role::where('id','=','2')->get();
        $user = User::join('roles','role','=','roles.id','inner')
            ->where('email','!=','')
            ->select('users.id','roles.name as rolesname','users.name','email')
            ->orderBy('email')
            ->where('role','2')
            ->get();
        $app['user'] = collect($user);
        $app['siswa'] = Student::orderBy('name')
            ->join('aa_person','pid','=','aa_person.id')
            ->get();
        $app['kelas'] = CourseClass::get();
        $app['level'] = RfLevelClass::get();
        $app['modul'] = RfModul::get();
        $app['menu'] = MenuModul::join('menu','menu.id','=','menu_id')->get();

        return view('halaman.user', $app);
    }
    public function save(Request $request)
    {
        $datas = array();
        parse_str($request->data, $datas);
        $user = User::where('id',$datas['id'])->first();
        $datas['pid'] = (!isset($datas['pid']) || $datas['pid']=='') ? $user->pid : $datas['pid'];
        $name = Person::where('id',$datas['pid'])->first()->name;
        if($datas['password']) {
            $user = User::updateOrCreate(
                [   'pid' => $datas['pid']    ],
                [
                    'name' => $name,
                    'email' => $datas['email'],
                    'password' => Hash::make($datas['password']),
                    'role' => $datas['role'],
                ]);
        } else {
            $user = User::updateOrCreate(
                [   'pid' => $datas['pid']    ],
                [
                    'name' => $name,
                    'email' => $datas['email'],
                    'role' => $datas['role'],
                ]);
        }

        if(isset($datas['chk']))
        {
            $modul = UserModul::where('uid',$datas['id'])->delete();
            for($i=0;$i<count($datas['chk']);$i++)
            {
                UserModul::create(['uid'=>$datas['id'],'modul_id'=>$datas['chk'][$i]]);
            }
        }

        echo 'Berhasil';

    }
    public function show(Request $request)
    {
        $app = array();
        $app['menufooter'] = '0';
        $person = Person::where('id',$request->id)->first()->toArray();

        return view('mobile.halaman.home',$app);
    }
    public function delete(Request $request)
    {
        $id = $request->id;
        User::where('id',$id)->update(['email'=>'','password'=>'','pid'=>'0']);
        echo 'Berhasil';
    }
    public function load(Request $request)
    {
        $id = $request->id;
        $user = User::where('id',$id)->first();
        $modul = UserModul::where('uid',$id)->get();
        $array = ['user'=>$user,'modul'=>$modul];
        echo json_encode($array);
    }
    public function generate_from_student(Request $request)
    {
        $datas = array();
        parse_str($request->kls, $datas);
        $kelas = $datas['chk'];
        $allstudent = Student::join('aa_person','aa_person.id','=','aa_student.pid')
            ->join('ep_course_class_dtl','aa_student.id','=','ep_course_class_dtl.sid')
            ->where('ayid',config('id_active_academic_year'))
            ->whereIn('ccid',$kelas)
            ->select('aa_person.*','nis')->get();
        $calonuser = [];
        // $jumlah = 10;
        foreach($allstudent as $k=>$v)
        {
            User::updateOrCreate(
                ['pid'=>$v->id],
                ['name'=>$v->name,'email'=>trim($v->nis).'@msh.com','password'=>Hash::make($v->dob),'role'=>'2']
            );
            // $jumlah--;
            // if($jumlah==0)
            // {
            //     break;
            // }
        }
        echo 'Berhasil';
    }
    public function reset_password(Request $request)
    {
        $userid = $request->id;
        try {
            User::where('id',$userid)->update(['password'=>Hash::make('default123')]);
            echo 'Berhasil';
        } catch (\Throwable $th) {
            echo $th;
        }
    }
}
