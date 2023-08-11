<?php

namespace App\Http\Controllers;

use App\Models\MsUpload;
use Illuminate\Http\Request;
use App\Imports\AllImport;
use App\Imports\NilaiPengasuhanImport;
use App\Imports\NilaiPengasuhanPerSemesterImport;
use App\Imports\CatatanPengasuhanPerSemesterImport;
use App\Imports\CatatanPelanggaran;
use App\Imports\KompetensiDasar;
use App\Imports\StudentImport;
use App\Imports\NilaiBayanat;
use App\Imports\NilaiLainnya;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class MsUploadController extends Controller
{
    public function upload(Request $request)
    {
        $ext = $request->file('file')->getClientOriginalExtension();
        if($ext!='png'&&$ext!='jpg'&&$ext!='jpeg'&&$ext!='gif')
        {
            echo 'File harus gambar (jpg, gif, png)!';
            die();
        }
        // $request->file->validate([
        //     'file'=>'required|mimes:jpeg,gif,jpg,png|max:2048',
        // ]);

        if($request->file())
        {

            $fileModel = new MsUpload;
            $fileModel->pid = $request->pid;
            $fileModel->desc = $request->desc;
            $fileModel->cby = auth()->user()->id;
            $fileModel->uby = '0';

            $filename = time().'_'.$request->file->getClientOriginalName();
            $filepath = $request->file('file')->storeAs('',$filename,'upload');

            $fileModel->url = $filepath;
            $fileModel->original_file = 'uploads/'.$filepath;
            $fileModel->save();

            echo 'Berhasil|'.$request->file->extension().'|'.$fileModel->original_file.'|'.$request->desc;
        }
    }
    public function uploadnilai(Request $request)
    {
        $ext = $request->file('file')->getClientOriginalExtension();
        if($ext!='xls'&&$ext!='xlsx')
        {
            echo 'File harus file excel (xls/xlsx)!';
            die();
        }

        $fileModel = new MsUpload;
        $fileModel->pid = (auth()->user()->pid!='') ? auth()->user()->pid : auth()->user()->id;
        $fileModel->desc = 'Import Nilai';
        $fileModel->cby = auth()->user()->id;
        $fileModel->uby = '0';

        if($request->file())
        {
            $filename = time().'_'.$request->file->getClientOriginalName();
            $filepath = $request->file('file')->storeAs('',$filename,'upload');
            $fileModel->url = $filepath;
            $fileModel->original_file = 'uploads/'.$filepath;
            $fileModel->save();

            $import = Excel::import(new AllImport, $fileModel->original_file);

            // echo 'Berhasil|'.$request->file->extension().'|'.$fileModel->original_file;
        }
    }
    public function uploadnilailainnya(Request $request)
    {
        $ext = $request->file('file')->getClientOriginalExtension();
        if($ext!='xls'&&$ext!='xlsx')
        {
            echo 'File harus file excel (xls/xlsx)!';
            die();
        }

        $fileModel = new MsUpload;
        $fileModel->pid = (auth()->user()->pid!='') ? auth()->user()->pid : auth()->user()->id;
        $fileModel->desc = 'Import Nilai';
        $fileModel->cby = auth()->user()->id;
        $fileModel->uby = '0';

        if($request->file())
        {
            $filename = time().'_'.$request->file->getClientOriginalName();
            $filepath = $request->file('file')->storeAs('',$filename,'upload');
            $fileModel->url = $filepath;
            $fileModel->original_file = 'uploads/'.$filepath;
            $fileModel->save();

            $import = Excel::import(new NilaiLainnya, $fileModel->original_file);

            // echo 'Berhasil|'.$request->file->extension().'|'.$fileModel->original_file;
        }
    }
    public function uploadnilaiPengasuhan(Request $request)
    {
        $ext = $request->file('file')->getClientOriginalExtension();
        if($ext!='xls'&&$ext!='xlsx')
        {
            echo 'File harus file excel (xls/xlsx)!';
            die();
        }

        $fileModel = new MsUpload;
        $fileModel->pid = (auth()->user()->pid!='') ? auth()->user()->pid : auth()->user()->id;
        $fileModel->desc = 'Import Nilai Pengasuhan';
        $fileModel->cby = auth()->user()->id;
        $fileModel->uby = '0';

        if($request->file())
        {
            $filename = time().'_'.$request->file->getClientOriginalName();
            $filepath = $request->file('file')->storeAs('',$filename,'upload');
            $fileModel->url = $filepath;
            $fileModel->original_file = 'uploads/'.$filepath;
            $fileModel->save();

            $import = Excel::import(new NilaiPengasuhanImport, $fileModel->original_file);
        }
    }

    public function uploadnilaiPengasuhanPerSemester(Request $request)
    {
        $ext = $request->file('file')->getClientOriginalExtension();
        if($ext!='xls'&&$ext!='xlsx')
        {
            echo 'File harus file excel (xls/xlsx)!';
            die();
        }

        $fileModel = new MsUpload;
        $fileModel->pid = (auth()->user()->pid!='') ? auth()->user()->pid : auth()->user()->id;
        $fileModel->desc = 'Import Nilai Pengasuhan Per Semester';
        $fileModel->cby = auth()->user()->id;
        $fileModel->uby = '0';

        if($request->file())
        {
            $filename = time().'_'.$request->file->getClientOriginalName();
            $filepath = $request->file('file')->storeAs('',$filename,'upload');
            $fileModel->url = $filepath;
            $fileModel->original_file = 'uploads/'.$filepath;
            $fileModel->save();

            $import = Excel::import(new NilaiPengasuhanPerSemesterImport, $fileModel->original_file);
        }
    }
    public function uploadcatatanPengasuhanPerSemester(Request $request)
    {
        $ext = $request->file('file')->getClientOriginalExtension();
        if($ext!='xls'&&$ext!='xlsx')
        {
            echo 'File harus file excel (xls/xlsx)!';
            die();
        }

        $fileModel = new MsUpload;
        $fileModel->pid = (auth()->user()->pid!='') ? auth()->user()->pid : auth()->user()->id;
        $fileModel->desc = 'Import Catatan Pengasuhan Per Semester';
        $fileModel->cby = auth()->user()->id;
        $fileModel->uby = '0';

        if($request->file())
        {
            $filename = time().'_'.$request->file->getClientOriginalName();
            $filepath = $request->file('file')->storeAs('',$filename,'upload');
            $fileModel->url = $filepath;
            $fileModel->original_file = 'uploads/'.$filepath;
            $fileModel->save();

            $import = Excel::import(new CatatanPengasuhanPerSemesterImport, $fileModel->original_file);
        }
    }
    public function uploadpelanggaran(Request $request)
    {
        $ext = $request->file('file')->getClientOriginalExtension();
        if($ext!='xls'&&$ext!='xlsx')
        {
            echo 'File harus file excel (xls/xlsx)!';
            die();
        }

        $fileModel = new MsUpload;
        $fileModel->pid = (auth()->user()->pid!='') ? auth()->user()->pid : auth()->user()->id;
        $fileModel->desc = 'Import Catatan Pelanggaran';
        $fileModel->cby = auth()->user()->id;
        $fileModel->uby = '0';

        if($request->file())
        {
            $filename = time().'_'.$request->file->getClientOriginalName();
            $filepath = $request->file('file')->storeAs('',$filename,'upload');
            $fileModel->url = $filepath;
            $fileModel->original_file = 'uploads/'.$filepath;
            $fileModel->save();

            $import = Excel::import(new CatatanPelanggaran, $fileModel->original_file);
        }
    }
    public function uploadsiswa(Request $request)
    {
        $ext = $request->file('file')->getClientOriginalExtension();
        if($ext!='xls'&&$ext!='xlsx')
        {
            echo 'File harus file excel (xls/xlsx)!';
            die();
        }

        $fileModel = new MsUpload;
        $fileModel->pid = (auth()->user()->pid!='') ? auth()->user()->pid : auth()->user()->id;
        $fileModel->desc = 'Import Siswa';
        $fileModel->cby = auth()->user()->id;
        $fileModel->uby = '0';

        if($request->file())
        {
            $filename = time().'_'.$request->file->getClientOriginalName();
            $filepath = $request->file('file')->storeAs('',$filename,'upload');
            $fileModel->url = $filepath;
            $fileModel->original_file = 'uploads/'.$filepath;
            $fileModel->save();

            $import = Excel::import(new StudentImport, $fileModel->original_file);
        }
    }
    public function uploadnilaibayanat(Request $request)
    {
        $ext = $request->file('file')->getClientOriginalExtension();
        if($ext!='xls'&&$ext!='xlsx')
        {
            echo 'File harus file excel (xls/xlsx)!';
            die();
        }

        $fileModel = new MsUpload;
        $fileModel->pid = (auth()->user()->pid!='') ? auth()->user()->pid : auth()->user()->id;
        $fileModel->desc = 'Import Nilai Bayanat Quran';
        $fileModel->cby = auth()->user()->id;
        $fileModel->uby = '0';

        if($request->file())
        {
            $filename = time().'_'.$request->file->getClientOriginalName();
            $filepath = $request->file('file')->storeAs('',$filename,'upload');
            $fileModel->url = $filepath;
            $fileModel->original_file = 'uploads/'.$filepath;
            $fileModel->save();

            $import = Excel::import(new NilaiBayanat, $fileModel->original_file);
        }
    }
    public function uploadkompetensidasar(Request $request)
    {
        $ext = $request->file('file')->getClientOriginalExtension();
        if($ext!='xls'&&$ext!='xlsx')
        {
            echo 'File harus file excel (xls)!';
            die();
        }

        $fileModel = new MsUpload;
        $fileModel->pid = (auth()->user()->pid!='') ? auth()->user()->pid : auth()->user()->id;
        $fileModel->desc = 'Import Kompetensi Dasar';
        $fileModel->cby = auth()->user()->id;
        $fileModel->uby = '0';

        if($request->file())
        {
            $filename = time().'_'.$request->file->getClientOriginalName();
            $filepath = $request->file('file')->storeAs('',$filename,'upload');
            $fileModel->url = $filepath;
            $fileModel->original_file = 'uploads/'.$filepath;
            $fileModel->save();

            $import = Excel::import(new KompetensiDasar, $fileModel->original_file);

            // echo 'Berhasil|'.$request->file->extension().'|'.$fileModel->original_file;
        }
    }
    public function lihat_file(Request $request)
    {
        $app['aktif'] = '';
        $app['judul'] = "Daftar File";
        $id = (auth()->user()->pid!='') ? auth()->user()->pid : auth()->user()->id;
        $app['get'] = MsUpload::where('cby',auth()->user()->id)
            ->orderBy('con','desc')
            ->get();

        return view('halaman.lihat_file', $app);
    }
    public function download_file(Request $request)
    {
        $file = MsUpload::where('id',$request->id)->first();
        $file_path = public_path($file->original_file);
        $file = Storage::disk('public')->get($file_path);
        // return (new Response($file, 200));
        return response()->download($file_path);
        // return Storage::download($file_path);
    }
}
