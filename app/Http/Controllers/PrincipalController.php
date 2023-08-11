<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use App\Models\Person;
use App\Models\SignedPosition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrincipalController extends Controller {
	public function __construct() {
        $this->middleware(['auth']);
		$this->menu['aktif'] = 'walikelas';
		$this->menu['judul'] = 'Kepala Sekolah';
	}
	public function index(Request $request) {
		$app = $this->menu;
		$app['signed']  = SignedPosition::where('ayid', config('id_active_academic_year'))->get();
        if(!empty($app['signed'])) {
            foreach ($app['signed'] as $row) {
                if($row['principal']!=0) {
                    $principal = Person::select('aa_employe.id','name')
                    ->join('aa_employe','aa_person.id','=','aa_employe.pid')
                    ->rightJoin('ep_signed_position','aa_employe.id','=', DB::raw("'".$row['principal']."'"))
                    ->where('ayid', config('id_active_academic_year'))
                    ->first();
                    $app['principal'] = $principal;
                }

                if($row['studentaffair']!=0) {
                    $studentaffair = Person::select('aa_employe.id','name')
                    ->join('aa_employe','aa_person.id','=','aa_employe.pid')
                    ->rightJoin('ep_signed_position','aa_employe.id','=', DB::raw("'".$row['studentaffair']."'"))
                    ->where('ayid', config('id_active_academic_year'))
                    ->first();
                    $app['studentaffair'] = $studentaffair;
                }

                if($row['curriculum']!=0) {
                    $curriculum = Person::select('aa_employe.id','name')
                    ->join('aa_employe','aa_person.id','=','aa_employe.pid')
                    ->rightJoin('ep_signed_position','aa_employe.id','=', DB::raw("'".$row['curriculum']."'"))
                    ->where('ayid', config('id_active_academic_year'))
                    ->first();
                    $app['curriculum'] = $curriculum;
                }

                if($row['housemaster_male']!=0) {
                    $housemaster_male = Person::select('aa_employe.id','name')
                    ->join('aa_employe','aa_person.id','=','aa_employe.pid')
                    ->rightJoin('ep_signed_position','aa_employe.id','=', DB::raw("'".$row['housemaster_male']."'"))
                    ->where('ayid', config('id_active_academic_year'))
                    ->first();
                    $app['housemaster_male'] = $housemaster_male;
                }

                if($row['housemaster_female']!=0) {
                    $housemaster_female = Person::select('aa_employe.id','name')
                    ->join('aa_employe','aa_person.id','=','aa_employe.pid')
                    ->rightJoin('ep_signed_position','aa_employe.id','=', DB::raw("'".$row['housemaster_female']."'"))
                    ->where('ayid', config('id_active_academic_year'))
                    ->first();
                    $app['housemaster_female'] = $housemaster_female;
                }
            }
        }
        $app['employe'] = Employe::where('is_active','1')
                            ->join('aa_person', 'pid', '=', 'aa_person.id')
                            ->select('aa_employe.id', 'name')
                            ->orderBy('name')
                            ->get();
		return view('halaman.principal', $app);
	}
    public function show(Request $request) {
		$id = $request->id;
		$ada = SignedPosition::where('id', $id)->first();
		echo json_encode($ada, true);
	}
	public function save(Request $request) {
		$datas = array();
		parse_str($request->data, $datas);
		$ayid = config('id_active_academic_year');
		$principal = $datas['principal'];
		$curriculum = $datas['curriculum'];
		$studentaffair = $datas['studentaffair'];
		$housemaster_male = $datas['housemaster_male'];
		$housemaster_female = $datas['housemaster_female'];
		if ($datas['id'] != '') {
			$cek = SignedPosition::where('id', $datas['id'])->first();
			$cek->principal     = $principal;
			$cek->curriculum    = $curriculum;
			$cek->studentaffair = $studentaffair;
			$cek->housemaster_male   = $housemaster_male;
			$cek->housemaster_female   = $housemaster_female;
			$cek->uby           = auth()->user()->id;
			$cek->save();
		} else {
			$data = new SignedPosition;
			$data->ayid          = $ayid;
			$data->principal     = $principal;
			$data->curriculum    = $curriculum;
			$data->studentaffair = $studentaffair;
			$data->housemaster_male   = $housemaster_male;
			$data->housemaster_female   = $housemaster_female;
			$data->cby = auth()->user()->id;
			$data->save();
		}
		echo 'Berhasil';
	}
}
