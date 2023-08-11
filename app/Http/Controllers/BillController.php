<?php

namespace App\Http\Controllers;

use App\Models\PpdbPayment;
use Illuminate\Http\Request;
use DataTables;

class BillController extends Controller
{
    public function index(Request $request)
    {
        $app = array();
        $app['data'] = PpdbPayment::where('aa_ppdb_payment.cby',auth()->user()->id)
            ->join('aa_ppdb','ppdb_id','=','aa_ppdb.id','left outer')
            ->join('aa_person','pid','=','aa_person.id','left outer')
            ->select('aa_person.name','invoice_id','aa_ppdb_payment.name as bill','amount','status','method')
            ->get();
        if ($request->ajax()) {
            return Datatables::of($app['data'])
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn =
                        '<div class="dropdown">
                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                <a class="dropdown-item edit" href="javascript:lihattagihan('.'"'.$row->id.'"'.')" data-id="' . $row->id . '"><i class="fa fa-search"></i> Lihat</a>
                            </div>
                        </div>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        //sementara
        $app['bills'] = array(
            '1'=>array('name'=>'Uang Pendaftaran','desc'=>'Uang Pendaftaran','amount'=>'10500'),
            '2'=>array('name'=>'Wakaf','desc'=>'Wakaf','amount'=>'15000'),
        );
        $app['aktif'] = 'biaya-pendidikan';
        $app['judul'] = "Biaya Pendidikan";

        return view('halaman.bills', $app);
    }
}
