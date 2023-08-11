<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\Ppdb;
use App\Models\PpdbPayment;
use App\Models\User;
use Laravel\Ui\Presets\React;

class TripayController extends Controller
{
    public function ppdb(Request $request)
    {
        $app = array();
        $app['aktif'] = 'biaya-pendidikan';
        $app['judul'] = 'Pembayaran Uang Pendaftaran';
        $app['person'] = Person::where('id', $request->id)->first();
        $app['ppdb'] = Ppdb::where('pid',$app['person']['id'])->first();
        if($app['ppdb']['is_notif_complete']!='1')
        {
            Ppdb::where('pid',$app['person']['id'])
                ->update([
                    'is_notif_complete' => '1',
                ]);
            $details = [
                'tipe' => 'registrasi',
                'judul' => 'PPDB - EDUSIS',
                'yes' => [0,1],
            ];

            $admin = User::where('role','1')->first();

            \Mail::to($admin['email'])->send(new \App\Mail\Email($details));
            \Mail::to(auth()->user()->email)->send(new \App\Mail\Email($details));
        }

        //sementara
        $app['bills'] = array(
            '1'=>array('name'=>'Uang Pendaftaran','desc'=>'Uang Pendaftaran','amount'=>'10500'),
            '2'=>array('name'=>'Wakaf','desc'=>'Wakaf','amount'=>'15000'),
        );

        return view('halaman.daftar-bayar', $app);
    }
    public function prosesbayar(Request $request)
    {
        $app = array();
        $app['request'] = $request;
        $app['aktif'] = 'biaya-pendidikan';
        $app['judul'] = 'Pembayaran Uang Pendaftaran';
        $app['person'] = Person::where('id', $request->id)->first();
        $app['ppdb'] = Ppdb::where('pid',$app['person']['id'])->first();
        $app['inv'] = 'INV';
        //sementara
        $app['bills'] = array(
            '1'=>array('name'=>'Uang Pendaftaran','desc'=>'Uang Pendaftaran','amount'=>'10500'),
            '2'=>array('name'=>'Wakaf','desc'=>'Wakaf','amount'=>'15000'),
        );
        $app['cek'] = PpdbPayment::where('ppdb_id',$app['ppdb']['id'])->where('bill_id',$request->idbiaya)->first();
        $app['inv'] = PpdbPayment::latest()->first();
        $inv = (!empty($app['inv'])) ? $app['inv']['invoice_id'] : '0';
        $app['inv'] = 'INV'.sprintf("%04d",((int)substr($inv,3,strlen($inv))+1));
        $app['payment_channel'] = $this->getPaymentChannels('sandbox_');
        if(empty($app['cek']))
        {
            $app['cek'] = PpdbPayment::create([
                'ppdb_id' => $app['ppdb']['id'],
                'invoice_id' => $app['inv'],
                'bill_id' => $request->idbiaya,
                'name' => $app['bills'][$request->idbiaya]['name'],
                'desc' => $app['bills'][$request->idbiaya]['desc'],
                'amount' => $app['bills'][$request->idbiaya]['amount'],
                'status' => 'proses bayar',
                'cby' => auth()->user()->id,
                'uby' => '0',
            ]);
        }
        else
        {
            return redirect('ppdb/'.$app['cek']['invoice_id']."/prosesdetail/".$app['cek']['method']);
        }
        return view('halaman.daftar-bayarproses', $app);
    }
    public function prosesdetail(Request $request)
    {
        $app = array();
        $app['user'] = User::where('id',auth()->user()->id)->first();
        $app['cek'] = PpdbPayment::where('invoice_id',$request->id)
            ->join('aa_ppdb','ppdb_id','=','aa_ppdb.id')
            ->first();
        $key = env('TRIPAY_API_KEY');
        $amount = $app['cek']['amount'];
        $amount = substr($amount,0,strlen($amount)-3);

        $signature = $this->signature($request->id,$amount);

        $app['transaksi'] = array();
        if($app['cek']['ref_id'] == '')
        {
            $data = [
                'method'            => $request->kode,
                'merchant_ref'      => $request->id,
                'amount'            => $amount,
                'customer_name'     => auth()->user()->name,
                'customer_email'    => auth()->user()->email,
                'customer_phone'    => '0'.$app['user']['handphone'],
                'order_items'       => [
                    [
                        'sku'       => 'SKU'.$app['cek']['bill_id'],
                        'name'      => $app['cek']['name'],
                        'price'     => $amount,
                        'quantity'  => 1
                    ]
                ],
                'callback_url'      => url('tripay/callback/'.$request->id),
                'return_url'        => url('tripay/accept'),
                'expired_time'      => (time()+(24*60*60)), // 24 jam
                'signature'         => $signature,
            ];
            // dd($data);
            // $app['transaksi'] = $this->curl($key,env('TRIPAY_CREATE'),$data,'balik');
            // $app['transaksi'] = json_decode(json_encode($app['transaksi']), true);
            // if(!empty($app['transaksi']))
            // {
            //     PpdbPayment::where('invoice_id',$request->id)
            //         ->update([
            //             'ref_id'=>$app['transaksi']['data']['reference'],
            //             'method'=>$app['transaksi']['data']['payment_method'],
            //     ]);
            // }
            // else
            // {
            //     $app['transaksi'] = array('total_fee'=>'','amount'=>'');
            // }
            try {
                $app['transaksi'] = $this->curl($key,env('TRIPAY_CREATE'),$data,'balik');
                $app['transaksi'] = json_decode(json_encode($app['transaksi']), true);
                if(!empty($app['transaksi']))
                {
                    PpdbPayment::where('invoice_id',$request->id)
                        ->update([
                            'ref_id'=>$app['transaksi']['data']['reference'],
                            'method'=>$app['transaksi']['data']['payment_method'],
                    ]);
                }
                else
                {
                    $app['transaksi'] = array('total_fee'=>'','amount'=>'');
                }
            } catch (\Throwable $th) {
                dd('Masih Proses, karena '.$th->getMessage());
            }
        }
        else
        {
            $payload = ['reference' =>$app['cek']['ref_id']];
            $url = env('TRIPAY_DETAIL').'?'.http_build_query($payload);
            $app['transaksi'] = $this->curl($key,$url);
            $app['transaksi'] = json_decode(json_encode($app['transaksi']),true);
        }
        $app['request'] = $request;
        $app['aktif'] = 'biaya-pendidikan';
        $app['judul'] = 'Pembayaran Uang Pendaftaran';
        $app['ppdb'] = Ppdb::where('id',$app['cek']['ppdb_id'])->first();
        $app['person'] = Person::where('id',$app['ppdb']['pid'])->first();
        $app['inv'] = 'INV';
        //sementara
        $app['bills'] = array(
            '1'=>array('name'=>'Uang Pendaftaran','desc'=>'Uang Pendaftaran','amount'=>'10500'),
            '2'=>array('name'=>'Wakaf','desc'=>'Wakaf','amount'=>'15000'),
        );
        $app['payment_channel'] = $this->getPaymentChannels('sandbox_',$request->kode);
        return view('halaman.daftar-bayarproses', $app);
    }
    public function accept()
    {
        echo 'Terima kasih!';
    }
    public function signature($inv='',$amount='',$json='')
    {
        $key = env('TRIPAY_PRIVATE_KEY');
        $kode = env('TRIPAY_MERCHANT');
        $param = (!empty($json)) ? $json : $kode.$inv.$amount;
        $signature = hash_hmac('sha256', $param, $key);
        return $signature;
    }
    public function getPaymentChannels($tipe='',$kode='')
    {
        $apiKey = env('TRIPAY_API_KEY');
        $url = env('TRIPAY_URL_PAYMENT_CHANNEL');
        $url .= ($kode!='') ? '?'.http_build_query(['code'=>$kode]) : '';
        return $this->curl($apiKey,$url);
    }
    public function curl($key,$url,$data=array(),$respon='')
    {
        $curl = curl_init();
        $param = array(
            CURLOPT_FRESH_CONNECT     => true,
            CURLOPT_URL               => $url,
            CURLOPT_RETURNTRANSFER    => true,
            CURLOPT_HEADER            => false,
            CURLOPT_HTTPHEADER        => array(
                "Authorization: Bearer " . $key
            ),
            CURLOPT_FAILONERROR       => false
        );
        if(!empty($data))
        {
            $param += array(
                CURLOPT_POST              => true,
                CURLOPT_POSTFIELDS        => http_build_query($data)
            );
        }
        curl_setopt_array($curl,$param);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        $databalik = ($respon=='') ? json_decode($response)->data : json_decode($response);
        return $response ? $databalik : $err;
    }

    public function callback(Request $request)
    {
        $callbackSignature = $request->server('HTTP_X_CALLBACK_SIGNATURE') ?? '';
        $json = $request->getContent();
        $data = json_decode($json);
        $signature = $this->signature('','',$json);

        if( $callbackSignature !== $signature ) {
            return "Invalid Signature";
        }

        $event = $request->server('HTTP_X_CALLBACK_EVENT');

        if( $event == 'payment_status' )
        {
            $merchantRef = $data->merchant_ref;
            $order = PpdbPayment::where('invoice_id',$merchantRef)
                ->where('status','UNPAID')
                ->first();
            if(!$order)
            {
                return 'Invoice tidak ditemukan atau Sudah dibayar!';
            }
            if(intval($data->total_amount) !== intval($order->amount))
            {
                return 'Salah nominal!';
            }
            switch ($data->status) {
                case 'PAID':
                    $order->update(['status'=>'PAID']);
                    break;
                case 'EXPIRED':
                    $order->update(['status'=>'CANCELED']);
                    break;
                case 'FAILED':
                    $order->update(['status'=>'CANCELED']);
                default:
                    # code...
                    break;
            }
            return response()->json(['success'=>true]);
        }
        return "No action was taken";
    }
}
