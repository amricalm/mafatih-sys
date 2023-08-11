<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

$route = Request()->getHttpHost();
if ($route != 'dev.mahadsyarafulharamain.sch.id') {
	debugbar()->enable();
	config(['app.debug' => true]);
	ini_set('display_errors', 'On');
} else {
	debugbar()->disable();
	config(['app.debug' => false]);
	ini_set('display_errors', 'Off');
}

Route::get('/', function () {
	return (!Auth::check()) ? Redirect::route('login') : Redirect::route('home');
});
Route::get('ppdb-online', function () {
	return view('welcome');
});
Route::get('password/{teks}', function ($teks) {
	echo Hash::make($teks);
});
Route::any('daftar-ulang/{noreg?}', 'App\Http\Controllers\StudentController@daftar_ulang');

Auth::routes();

Route::post('callback', 'App\Http\Controllers\TripayController@callback');

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('config');
Route::post('home/hp', 'App\Http\Controllers\HomeController@hp');
Route::get('/registrasi', 'App\Http\Controllers\RegistrasiController@index')->name('registrasi');
Route::get('/pembayaran', 'App\Http\Controllers\RegistrasiController@pembayaran')->name('pembayaran');
Route::get('/pembayaran/{payID}/periksa', 'App\Http\Controllers\RegistrasiController@checkout')->name('checkout');

//convert masehi to hijr
Route::get('masehi2hijriah/{thn}/{bln}/{tgl}', 'App\Http\Controllers\HomeController@convert_to_hijr');

Route::get('kirimemail', 'App\Http\Controllers\KirimEmailController@send')->name('kirimemail');

// Wilayah Indonesia
Route::get('prov', 'App\Http\Controllers\WilayahController@provinces')->name('prov');
Route::get('kota', 'App\Http\Controllers\WilayahController@cities')->name('kota');
Route::get('kec', 'App\Http\Controllers\WilayahController@districts')->name('kec');
Route::get('desa', 'App\Http\Controllers\WilayahController@villages')->name('desa');

Route::get('/calendar', function () {
	$app = array();
	$app['judul'] = 'Kalender';
	return view('halaman.calendar', $app);
});

Route::get('/clear-cache', function () {
	$configCache = Artisan::call('config:cache');
	$clearCache = Artisan::call('cache:clear');
	$routeCache = Artisan::call('route:clear');
	$viewCache = Artisan::call('view:clear');
	echo 'Berhasil';
});

Route::get('terbilang/{nomor}',function($nomor){
    echo \App\SmartSystem\General::terbilang_ar($nomor);
});

Route::get('error/{id}',function($id){
    return abort($id, 'custom error');
});

Route::get('selisih-tanggal/{tgl_dari}/{tgl_sampai}',function($tgl_dari, $tgl_sampai){
    $tgl1 = new DateTime($tgl_dari);
    $tgl2 = new DateTime($tgl_sampai);
    $jarak = $tgl2->diff($tgl1);
    echo '<pre>';
    print_r($jarak);
    echo '</pre>';
    echo 'Jumlah Menit = '.(($jarak->h*60)+$jarak->i);
});

Route::get('remedial/{type}',function($type){
    $ayid = config('id_active_academic_year');
    $tid = config('id_active_term');
	$ass = new \App\Models\Assessment();
    $remed = $ass->getRemedial($ayid,$tid,$type);
    $no = 0;
    $file = "remedial.xls" ;
    header('Content-Disposition: attachment; filename=' . $file );
    echo '<table><thead>';
    echo '<tr><td>No.</td><td>Kelas</td><td>Nama</td><td>Mata Pelajaran</td><td>Nilai</td></tr></thead>';
    echo '<tbody>';
    for($i=0;$i<count($remed);$i++)
    {
        echo '<tr>';
        echo '<td>'.($i+1).'</td>';
        echo '<td>'.$remed[$i]['namakelas'].'</td>';
        echo '<td>'.$remed[$i]['name'].'</td>';
        echo '<td>'.$remed[$i]['namamapel'].'</td>';
        echo '<td>'.number_format($remed[$i]['val'],2,',','.').'</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
});

Route::get('download_raport/{tipe}/{pid}/{token}','App\Http\Controllers\StudentController@print_raport');

//Callback API Tripay
Route::post('tripay/callback', 'App\Http\Controllers\TripayController@callback');
Route::post('tripay/accept', 'App\Http\Controllers\TripayController@accept');

Route::any('cari-siswa','App\Http\Controllers\StudentController@search');

Route::group(['middleware' => ['auth','config','ururl']], function () {
	// Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('user', 'App\Http\Controllers\UserController@main')->name('user');
    Route::get('user/users','App\Http\Controllers\UserController@index');
    Route::get('user/orang-tua','App\Http\Controllers\UserController@orang_tua');
	Route::get('user/baru', 'App\Http\Controllers\UserController@new')->name('user.baru');
	Route::post('user/simpan', 'App\Http\Controllers\UserController@save')->name('user.simpan');
	Route::post('user/load', 'App\Http\Controllers\UserController@load');
	Route::post('user/hapus', 'App\Http\Controllers\UserController@delete');
	Route::post('user/generate', 'App\Http\Controllers\UserController@generate_from_student');
	Route::post('user/reset-password', 'App\Http\Controllers\UserController@reset_password');

	Route::get('profil', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::get('profil/{id}', 'App\Http\Controllers\UserController@show');
	Route::get('profile', 'App\Http\Controllers\ProfileController@edit')->name('profile.edit');
	Route::put('profile', 'App\Http\Controllers\ProfileController@update')->name('profile.update');
	Route::post('profile', 'App\Http\Controllers\ProfileController@password')->name('profile.password');

	// Route::resource('sekolah', 'App\Http\Controllers\SchoolController');
	/**
	 * Sekolah
	 */
	Route::get('sekolah', 'App\Http\Controllers\SchoolController@show')->name('sekolah');
	Route::post('sekolah', 'App\Http\Controllers\SchoolController@save')->name('sekolah.simpan');

	/**
	 * Siswa
	 */
	Route::any('cari-siswa/{text?}', 'App\Http\Controllers\StudentController@search');
	Route::get('siswa', 'App\Http\Controllers\StudentController@index')->name('siswa');
	Route::get('siswa/baru', 'App\Http\Controllers\StudentController@new')->name('siswa.baru');
	Route::post('siswa/simpan', 'App\Http\Controllers\StudentController@save')->name('siswa.simpan');
	Route::get('siswa/{id}/edit', 'App\Http\Controllers\StudentController@show')->name('siswa.edit');
	Route::get('siswa/{id}/view', 'App\Http\Controllers\StudentController@view');
    Route::get('siswa/{id}/show', 'App\Http\Controllers\StudentController@getOne');
	Route::get('siswa/{id}/hapus', 'App\Http\Controllers\StudentController@delete');
	Route::post('siswa', 'App\Http\Controllers\StudentController@update')->name('siswa.update');
	Route::post('siswa/{table}', 'App\Http\Controllers\StudentController@getData')->name('siswa.getdata');
	Route::get('siswa/{id}/hapus/{table}', 'App\Http\Controllers\StudentController@hapus');
	Route::get('siswa/{id}/hapusfile/{tipe}', 'App\Http\Controllers\StudentController@hapusfile');
	Route::get('siswa/export', 'App\Http\Controllers\ExportController@headerSiswa');

	/*
		     * Karyawan
	*/
	Route::get('karyawan', 'App\Http\Controllers\EmployeController@index')->name('karyawan');
	Route::get('karyawan/baru', 'App\Http\Controllers\EmployeController@new')->name('karyawan.baru');
	Route::post('karyawan/simpan', 'App\Http\Controllers\EmployeController@save')->name('karyawan.simpan');
	Route::get('karyawan/{id}/edit', 'App\Http\Controllers\EmployeController@show')->name('karyawan.edit');
	Route::get('karyawan/{id}/hapus', 'App\Http\Controllers\EmployeController@delete');
	Route::post('karyawan', 'App\Http\Controllers\EmployeController@update')->name('karyawan.update');
	Route::post('karyawan/{table}', 'App\Http\Controllers\EmployeController@getData')->name('karyawan.getdata');
	Route::get('karyawan/{id}/hapus/{table}', 'App\Http\Controllers\EmployeController@hapus');
	Route::get('karyawan/{id}/hapusfile/{tipe}', 'App\Http\Controllers\EmployeController@hapusfile');

    /**
     * Tahun Ajaran
     */
	Route::resource('tahunajaran', 'App\Http\Controllers\AcademicYearController');
    Route::get('tahunajar/detail/{id}/edit','App\Http\Controllers\AcademicYearController@loadDetail');
    Route::post('tahunajar/detail/simpandetail','App\Http\Controllers\AcademicYearController@saveDetail');

	/**
	 * DIKNAS
	 */
    Route::get('diknas','App\Http\Controllers\DiknasController@index');
    Route::get('diknas/matapelajaran','App\Http\Controllers\DiknasController@subject');
    Route::post('diknas/matapelajaran/load','App\Http\Controllers\DiknasController@show_subject');
	Route::get('diknas/matapelajaran/{id}/edit', 'App\Http\Controllers\DiknasController@edit_subject');
    Route::post('diknas/matapelajaran/save','App\Http\Controllers\DiknasController@save_subject');
    Route::post('diknas/matapelajaran/hapus','App\Http\Controllers\DiknasController@delete_subject');
    Route::get('diknas/pemetaan','App\Http\Controllers\DiknasController@mapping');
    Route::post('diknas/pemetaan/load','App\Http\Controllers\DiknasController@show_mapping');
	Route::get('diknas/pemetaan/{id}/edit', 'App\Http\Controllers\DiknasController@edit_mapping');
    Route::post('diknas/pemetaan/save','App\Http\Controllers\DiknasController@save_mapping');
    Route::post('diknas/pemetaan/hapus','App\Http\Controllers\DiknasController@delete_mapping');
    Route::any('diknas/kompetensi','App\Http\Controllers\DiknasController@kompetensi');
	Route::post('diknas/kompetensi/exec', 'App\Http\Controllers\DiknasController@kompetensi_exec');
	Route::get('diknas/{id}/export/{subject}/{isi?}', 'App\Http\Controllers\ExportController@kompetensidasar');

    /**
	 * Mata Pelajaran
	 */
	Route::resource('matapelajaran', 'App\Http\Controllers\SubjectController');
	Route::get('muatanpelajaran', 'App\Http\Controllers\SubjectBasicController@index');
	Route::get('muatanpelajaran/{id}/edit', 'App\Http\Controllers\SubjectBasicController@show');
	Route::post('muatanpelajaran/simpan', 'App\Http\Controllers\SubjectBasicController@save');
	Route::post('muatanpelajaran/update', 'App\Http\Controllers\SubjectBasicController@update');
	Route::get('muatanpelajaran/{id}/hapus', 'App\Http\Controllers\SubjectBasicController@delete');
	Route::post('muatanpelajaran/copy', 'App\Http\Controllers\SubjectBasicController@copy');

	// MAPPING
	Route::get('pemetaanpelajaran', 'App\Http\Controllers\SubjectController@mapping');
	Route::post('pemetaanpelajaran/hapus', 'App\Http\Controllers\SubjectController@delmapping');
	Route::get('pemetaanpelajaran/{id}/edit/{ids?}', 'App\Http\Controllers\SubjectController@showmapping');
	Route::post('pemetaanpelajaran/simpan', 'App\Http\Controllers\SubjectController@savemapping');
	Route::post('pemetaanpelajaran/{id}/darikelas', 'App\Http\Controllers\SubjectController@getFromClass');
	Route::post('pemetaanpelajaran/load', 'App\Http\Controllers\SubjectController@loadmapping');
	Route::post('pemetaanpelajaran/simpandetail', 'App\Http\Controllers\SubjectController@savedetailmapping');

	//Grup Kegiatan Santri
	Route::get('grup-kegiatansantri', 'App\Http\Controllers\BoardingActivityGroupController@index');
	Route::get('grup-kegiatansantri/{id}/edit', 'App\Http\Controllers\BoardingActivityGroupController@show');
	Route::post('grup-kegiatansantri/simpan', 'App\Http\Controllers\BoardingActivityGroupController@save');
	Route::post('grup-kegiatansantri/update', 'App\Http\Controllers\BoardingActivityGroupController@update');
	Route::get('grup-kegiatansantri/{id}/hapus', 'App\Http\Controllers\BoardingActivityGroupController@delete');

	//Kegiatan Santri
	Route::get('kegiatansantri/{id}/edit', 'App\Http\Controllers\BoardingActivityGroupController@showActivity');
	Route::post('kegiatansantri/simpan', 'App\Http\Controllers\BoardingActivityGroupController@saveActivity');
	Route::post('kegiatansantri/update', 'App\Http\Controllers\BoardingActivityGroupController@updateActivity');
	Route::get('kegiatansantri/{id}/hapus', 'App\Http\Controllers\BoardingActivityGroupController@deleteActivity');

	//Rincian Kegiatan Santri
	Route::get('item-kegiatansantri/{id}/edit', 'App\Http\Controllers\BoardingActivityGroupController@showActivityItem');
	Route::post('item-kegiatansantri/simpan', 'App\Http\Controllers\BoardingActivityGroupController@saveActivityItem');
	Route::post('item-kegiatansantri/update', 'App\Http\Controllers\BoardingActivityGroupController@updateActivityItem');
	Route::get('item-kegiatansantri/{id}/hapus', 'App\Http\Controllers\BoardingActivityGroupController@deleteActivityItem');

	//Pemetaan Kegiatan Santri
	Route::get('pemetaankegiatansantri', 'App\Http\Controllers\BoardingActivityGradeController@index');
	Route::get('pemetaankegiatansantri/{id}/edit', 'App\Http\Controllers\BoardingActivityGradeController@show');
	Route::post('pemetaankegiatansantri/simpan', 'App\Http\Controllers\BoardingActivityGradeController@save');
	Route::post('pemetaankegiatansantri/update', 'App\Http\Controllers\BoardingActivityGradeController@update');
	Route::get('pemetaankegiatansantri/{id}/hapus', 'App\Http\Controllers\BoardingActivityGradeController@delete');

    /**
	 * Alumni
	 */
	Route::get('alumni', 'App\Http\Controllers\StudentPassedController@group');
	Route::get('alumni/{id}/show', 'App\Http\Controllers\StudentPassedController@showgroup');
	Route::post('alumni/export', 'App\Http\Controllers\ExportController@alumni');
	Route::get('alumni-proses', 'App\Http\Controllers\StudentPassedController@studyGroup')->name('studentpassed');
	Route::post('alumni-proses/diluar', 'App\Http\Controllers\StudentPassedController@outsideStudyGroup')->name('passed');
	Route::post('alumni-proses/didalam', 'App\Http\Controllers\StudentPassedController@insideStudyGroup')->name('inclass');
	Route::post('alumni-proses/simpan', 'App\Http\Controllers\StudentPassedController@studyGroupExec')->name('studentpassed.exec');

    /**
	 * Mutasi
	 */
	Route::get('mutasi', 'App\Http\Controllers\StudentMutationController@group');
	Route::get('mutasi/{id}/show', 'App\Http\Controllers\StudentMutationController@showgroup');
	Route::post('mutasi/export', 'App\Http\Controllers\ExportController@mutasi');
	Route::get('mutasi-proses', 'App\Http\Controllers\StudentMutationController@studyGroup')->name('studentmutation');
	Route::get('mutasi-proses/{id}/desc', 'App\Http\Controllers\StudentMutationController@studyMutationDesc')->name('studentmutationdesc');
	Route::post('mutasi-proses/eksekusi', 'App\Http\Controllers\StudentMutationController@studyMutationExec')->name('studentmutationexec');
	Route::post('mutasi-proses/diluar', 'App\Http\Controllers\StudentMutationController@outsideStudyGroup')->name('outside.mutation');
	Route::post('mutasi-proses/didalam', 'App\Http\Controllers\StudentMutationController@insideStudyGroup')->name('inclass.mutation');
	Route::post('mutasi-proses/simpan', 'App\Http\Controllers\StudentMutationController@studyGroupExec')->name('studentmutation.exec');

	/**
	 * Riwayat Kesehatan
	 */
	Route::get('medical-record', 'App\Http\Controllers\MedicalRecordController@index');
	Route::get('medical-record/{id}/edit', 'App\Http\Controllers\MedicalRecordController@show');
	Route::post('medical-record/simpan', 'App\Http\Controllers\MedicalRecordController@save');
	Route::post('medical-record/update', 'App\Http\Controllers\MedicalRecordController@update');
	Route::get('medical-record/{id}/hapus', 'App\Http\Controllers\MedicalRecordController@delete');

	/**
	 * Prestasi
	 */
	Route::get('prestasi', 'App\Http\Controllers\AchievementController@index');
	Route::get('prestasi/show', 'App\Http\Controllers\AchievementController@show');
	Route::get('prestasi/{id}/edit', 'App\Http\Controllers\AchievementController@edit');
	Route::post('prestasi/simpan', 'App\Http\Controllers\AchievementController@save');
	Route::post('prestasi/update', 'App\Http\Controllers\AchievementController@update');
	Route::get('prestasi/{id}/hapus', 'App\Http\Controllers\AchievementController@delete');
	Route::post('prestasi/{id}/darikelas', 'App\Http\Controllers\AchievementController@getFromClass');
	Route::post('prestasi/export', 'App\Http\Controllers\ExportController@prestasi');

	/**
	 * Pelanggaran
	 */
	Route::get('pelanggaran', 'App\Http\Controllers\PunishmentController@index');
	Route::get('pelanggaran/{id}/show', 'App\Http\Controllers\PunishmentController@show');
	Route::get('pelanggaran/{id}/edit', 'App\Http\Controllers\PunishmentController@edit');
	Route::post('pelanggaran/simpan', 'App\Http\Controllers\PunishmentController@save');
	Route::post('pelanggaran/update', 'App\Http\Controllers\PunishmentController@update');
	Route::get('pelanggaran/{id}/hapus', 'App\Http\Controllers\PunishmentController@delete');
	Route::post('pelanggaran/export', 'App\Http\Controllers\ExportController@pelanggaran');

	/**
	 * Prestasi
	 */
	Route::get('konseling', 'App\Http\Controllers\CounsellingController@index');
	Route::get('konseling/{id}/show', 'App\Http\Controllers\CounsellingController@show');
	Route::get('konseling/{id}/edit', 'App\Http\Controllers\CounsellingController@edit');
	Route::post('konseling/simpan', 'App\Http\Controllers\CounsellingController@save');
	Route::post('konseling/update', 'App\Http\Controllers\CounsellingController@update');
	Route::get('konseling/{id}/hapus', 'App\Http\Controllers\CounsellingController@delete');
	Route::post('konseling/export', 'App\Http\Controllers\ExportController@konseling');

	/**
	 * Karyawan
	 */
	Route::get('karyawan', 'App\Http\Controllers\EmployeController@index')->name('employe');
	Route::get('karyawan/baru', 'App\Http\Controllers\EmployeController@new')->name('employe.baru');
	Route::post('karyawan/simpan', 'App\Http\Controllers\EmployeController@save')->name('employe.simpan');
	Route::get('karyawan/{id}/edit', 'App\Http\Controllers\EmployeController@show')->name('employe.edit');
	Route::get('karyawan/{id}/detail', 'App\Http\Controllers\EmployeController@showdetail')->name('employe.detail');
	Route::get('karyawan/{id}/hapus', 'App\Http\Controllers\EmployeController@delete');
	Route::post('karyawan', 'App\Http\Controllers\EmployeController@update')->name('employe.update');

	Route::resource('kelas', 'App\Http\Controllers\CourseClassController');
	Route::get('kelas/{id}/lihat', 'App\Http\Controllers\CourseClassController@lihat');

	Route::get('kepala-sekolah', 'App\Http\Controllers\PrincipalController@index');
	Route::post('kepala-sekolah/simpan', 'App\Http\Controllers\PrincipalController@save');
	Route::get('kepala-sekolah/{id}/edit', 'App\Http\Controllers\PrincipalController@show');

	Route::get('walikelas', 'App\Http\Controllers\HomeroomController@index')->name('homeroom');
	Route::get('walikelas/daftar', 'App\Http\Controllers\HomeroomController@list')->name('homeroom.list');
	Route::get('walikelas/{id}/edit', 'App\Http\Controllers\HomeroomController@show')->name('homeroom.edit');
	Route::post('walikelas', 'App\Http\Controllers\HomeroomController@update')->name('homeroom.update');

	Route::get('rombel', 'App\Http\Controllers\CourseClassController@studyGroup')->name('studygroup');
	Route::post('rombel/diluar', 'App\Http\Controllers\CourseClassController@outsideStudyGroup')->name('outside.studygroup');
	Route::post('rombel/didalam', 'App\Http\Controllers\CourseClassController@insideStudyGroup')->name('inside.studygroup');
	Route::post('rombel/simpan', 'App\Http\Controllers\CourseClassController@studyGroupExec')->name('studygroup.exec');
	Route::get('rombel/{id}/export/{subject}/{isi?}', 'App\Http\Controllers\ExportController@rombel');

	Route::get('rombel-pengasuhan', 'App\Http\Controllers\BoardingGroupController@boardingGroup')->name('boardinggroup');
	Route::post('rombel-pengasuhan/diluar', 'App\Http\Controllers\BoardingGroupController@outsideBoardingGroup')->name('outside.boardinggroup');
	Route::post('rombel-pengasuhan/didalam', 'App\Http\Controllers\BoardingGroupController@insideBoardingGroup')->name('inside.boardinggroup');
	Route::post('rombel-pengasuhan/simpan', 'App\Http\Controllers\BoardingGroupController@boardingGroupExec')->name('boardinggroup.exec');
	Route::get('rombel-pengasuhan/{id}/export/{periode}', 'App\Http\Controllers\ExportController@rombelPengasuhan');
	Route::get('rombel-pengasuhan/{id}/export', 'App\Http\Controllers\ExportController@rombelPengasuhanPerSemester');
	Route::get('rombel-pengasuhan/{id}/export-catatan', 'App\Http\Controllers\ExportController@catatanRombelPengasuhanPerSemester');
	Route::get('rombel-pengasuhan/{id}/export-pelanggaran', 'App\Http\Controllers\ExportController@pelanggaranRombelPengasuhan');

	/**
	 * Tupoksi
	 */
	Route::resource('tupoksi', 'App\Http\Controllers\MainDutiesController');
	Route::get('tupoksi', ['as' => 'tupoksi.filter', 'uses' => 'App\Http\Controllers\MainDutiesController@filter']);

	Route::get('home/gettupoksi', 'App\Http\Controllers\HomeController@gettupoksi');
	Route::get('home/getrealisasi', 'App\Http\Controllers\HomeController@getrealisasi');
	Route::post('home/simpantupoksi', 'App\Http\Controllers\HomeController@savetupoksi');
	Route::post('home/simpantupoksikeluar', 'App\Http\Controllers\HomeController@savetupoksikeluar');
	Route::post('home/beritaacaraabsen/{id}', 'App\Http\Controllers\HomeController@AttendanceNotes');
	Route::post('home/saveberitaacara/{id}', 'App\Http\Controllers\HomeController@saveAttendanceNotes');
	Route::post('home/simpanterlambat', 'App\Http\Controllers\HomeController@saveLateTupoksi');
	Route::get('home/rekap-absen', 'App\Http\Controllers\HomeController@rekapabsen');
	Route::get('home/hapusabsen/{id}', 'App\Http\Controllers\HomeController@deleteabsen');

	//Komponen Kinerja
	Route::get('komponenkinerja', 'App\Http\Controllers\HrComponentController@index');
	Route::post('komponenkinerja/save', 'App\Http\Controllers\HrComponentController@save');
	Route::get('komponenkinerja/{id}/show', 'App\Http\Controllers\HrComponentController@show');
	Route::get('komponenkinerja/{id}/delete', 'App\Http\Controllers\HrComponentController@delete');
	Route::get('pemetaankomponenkinerja', 'App\Http\Controllers\HrComponentController@group');
	Route::post('pemetaankomponenkinerja/save', 'App\Http\Controllers\HrComponentController@savegroup');
	Route::get('pemetaankomponenkinerja/{id}/show', 'App\Http\Controllers\HrComponentController@showgroup');
	Route::get('pemetaankomponenkinerja/{id}/delete', 'App\Http\Controllers\HrComponentController@deletegroup');
	Route::get('pemetaankomponenkinerja/showall', 'App\Http\Controllers\HrComponentController@showall');

	//Position
	Route::get('posisi', 'App\Http\Controllers\PositionController@index');
	Route::get('posisi/{id}/edit', 'App\Http\Controllers\PositionController@show');
	Route::post('posisi/simpan', 'App\Http\Controllers\PositionController@save');
	Route::post('posisi/update', 'App\Http\Controllers\PositionController@update');
	Route::get('posisi/{id}/hapus', 'App\Http\Controllers\PositionController@delete');

	Route::any('kinerjapegawai', 'App\Http\Controllers\HrComponentController@daftar');
	Route::any('report-pegawai', 'App\Http\Controllers\HrComponentController@main_reportkinerja');
	Route::any('report-pegawai-harian', 'App\Http\Controllers\HrComponentController@reportkinerja');
	Route::any('report-pegawai-bulanan', 'App\Http\Controllers\HrComponentController@reportkinerja_pekanan');
	Route::post('report-pegawai-harian/export', 'App\Http\Controllers\ExportController@kinerja');
	Route::post('report-pegawai-bulanan/export', 'App\Http\Controllers\ExportController@kinerja_bulanan');
	Route::any('kinerjapegawai/approve/{id}', 'App\Http\Controllers\HrComponentController@approve');
	Route::get('kinerjapegawai/get/{id}', 'App\Http\Controllers\HrComponentController@get');
	Route::post('kinerjapegawai/save/{id}', 'App\Http\Controllers\HrComponentController@saveone');

	// Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);

	Route::any('inputnilai', 'App\Http\Controllers\AssessmentController@index');
    // Route::get('exportnilai/{kelas}/{mapel}','App\Http\Controllers\')
	Route::post('inputnilai/simpan', 'App\Http\Controllers\AssessmentController@save');
	Route::post('inputnilai/excel', 'App\Http\Controllers\AssessmentController@saveexcel');
	Route::post('cekpublikasi', 'App\Http\Controllers\AssessmentController@checkpublishraport');
	Route::any('prosesnilai', 'App\Http\Controllers\AssessmentController@process');
	Route::any('prosessekarang', 'App\Http\Controllers\AssessmentController@processing_v2');
	Route::any('prosessekarang/quran', 'App\Http\Controllers\AssessmentController@processing_alquran');
	Route::any('prosessekarangpengasuhan', 'App\Http\Controllers\AssessmentController@processingBoarding');
	Route::any('prosessekarang/diknas', 'App\Http\Controllers\AssessmentController@processing_diknas');

	Route::any('inputpengasuhan', 'App\Http\Controllers\BoardingAssessmentController@index');
	Route::post('inputnilai-pengasuhan/simpan', 'App\Http\Controllers\BoardingAssessmentController@save');
	Route::post('pemetaanpengasuhan/{id}/darikelas', 'App\Http\Controllers\BoardingAssessmentController@getFromBoardingClass');

	Route::any('inputpengasuhanpersemester/modul', 'App\Http\Controllers\BoardingAssessmentPerSemesterController@modul');
	Route::any('inputpengasuhanpersemester', 'App\Http\Controllers\BoardingAssessmentPerSemesterController@index');
	Route::post('inputpengasuhanpersemester/simpan', 'App\Http\Controllers\BoardingAssessmentPerSemesterController@save');
	Route::any('catatan-pengasuhan', 'App\Http\Controllers\BoardingAssessmentPerSemesterController@notes');
	Route::post('catatan-pengasuhan/simpan', 'App\Http\Controllers\BoardingAssessmentPerSemesterController@savenotes');

	Route::any('inputlain', 'App\Http\Controllers\AssessmentController@absen');
	Route::any('inputlain/simpan', 'App\Http\Controllers\AssessmentController@saveother');

	/**
	 * Untuk Orang Tua
	 */

	Route::get('ppdb/setting', 'App\Http\Controllers\RegistrasiController@setting');
	Route::post('ppdb/gantireg', 'App\Http\Controllers\HomeController@changeReg');
    Route::get('ppdb/setting/{id}/edit','App\Http\Controllers\RegistrasiController@edit_setting');
	Route::post('ppdb/setting/simpan', 'App\Http\Controllers\RegistrasiController@savesetting');
	Route::post('ppdb/setting/aktif', 'App\Http\Controllers\RegistrasiController@set_active');
	Route::post('ppdb/setting/hapus', 'App\Http\Controllers\RegistrasiController@delsetting');
	Route::post('ppdb/setting/get', 'App\Http\Controllers\RegistrasiController@getsetting');
	Route::post('ppdb/setting/getitem', 'App\Http\Controllers\RegistrasiController@getitemsetting');
	Route::post('ppdb/setting/tambahitem', 'App\Http\Controllers\RegistrasiController@additemsetting');
	Route::post('ppdb/setting/hapusitem', 'App\Http\Controllers\RegistrasiController@delitemsetting');

	Route::get('ppdb', 'App\Http\Controllers\RegistrasiController@setting')->name('ppdb');
	Route::post('ppdb/simpan', 'App\Http\Controllers\RegistrasiController@simpan')->name('ppdb.simpan');
	Route::get('ppdb/{id}/edit', 'App\Http\Controllers\RegistrasiController@show')->name('ppdb.edit');
	Route::get('ppdb/{id}/hapus', 'App\Http\Controllers\RegistrasiController@delete');
	Route::post('ppdb', 'App\Http\Controllers\RegistrasiController@update')->name('ppdb.update');
	Route::post('ppdb/{table}', 'App\Http\Controllers\RegistrasiController@getData')->name('ppdb.getdata');
	Route::get('ppdb/{id}/hapus/{table}', 'App\Http\Controllers\RegistrasiController@hapus');
	Route::get('ppdb/{id}/hapusfile/{tipe}', 'App\Http\Controllers\RegistrasiController@hapusfile');

	Route::get('ppdb/{id}/pembayaran', 'App\Http\Controllers\TripayController@ppdb');
	Route::get('ppdb/{id}/prosesbayar/{idbiaya}', 'App\Http\Controllers\TripayController@prosesbayar');
	Route::get('ppdb/{id}/prosesdetail/{kode}', 'App\Http\Controllers\TripayController@prosesdetail');
	Route::get('ppdb/{id}/bayardetail/{kode}', 'App\Http\Controllers\TripayController@bayardetail');

	//testemail
	Route::get('ppdb/email/{t}', 'App\Http\Controllers\RegistrasiController@lihatemail');

	/**
	 * Upload
	 */
	Route::post('upload', 'App\Http\Controllers\MsUploadController@upload')->name('upload');
	Route::post('uploadsiswa', 'App\Http\Controllers\MsUploadController@uploadsiswa')->name('uploadsiswa');
	Route::post('uploadnilai', 'App\Http\Controllers\MsUploadController@uploadnilai')->name('uploadnilai');
	Route::post('uploadnilailainnya', 'App\Http\Controllers\MsUploadController@uploadnilailainnya')->name('uploadnilailainnya');
	Route::post('uploadnilaibayanat', 'App\Http\Controllers\MsUploadController@uploadnilaibayanat')->name('uploadnilaibayanat');
	Route::post('uploadnilaipengasuhan', 'App\Http\Controllers\MsUploadController@uploadnilaiPengasuhan')->name('uploadnilaipengasuhan');
	Route::post('uploadnilaipengasuhanpersemester', 'App\Http\Controllers\MsUploadController@uploadnilaipengasuhanpersemester')->name('uploadnilaipengasuhanpersemester');
	Route::post('uploadcatatanpengasuhanpersemester', 'App\Http\Controllers\MsUploadController@uploadcatatanpengasuhanpersemester')->name('uploadcatatanpengasuhanpersemester');
	Route::post('uploadpelanggaran', 'App\Http\Controllers\MsUploadController@uploadpelanggaran')->name('uploadpelanggaran');
	Route::post('uploadkompetensidasar', 'App\Http\Controllers\MsUploadController@uploadkompetensidasar')->name('uploadkompetensidasar');

	/**
	 * Biaya Pembayaran
	 */
	Route::get('biaya-pendidikan', 'App\Http\Controllers\BillController@index');

	/**
	 * Person
	 */
	Route::resource('person', 'App\Http\Controllers\PersonController');

	/**
	 * Raport
	 */
	Route::any('raport', 'App\Http\Controllers\RaportController@index');
	Route::any('raport/modul', 'App\Http\Controllers\RaportController@modules');
	Route::any('raport-pengasuhan', 'App\Http\Controllers\RaportController@boarding');
	Route::any('raport/{pid}/{id}/print', 'App\Http\Controllers\RaportController@print');
	Route::any('raport/{pid}/3/print', 'App\Http\Controllers\RaportController@print_diknas');
	Route::any('raport/{pid}/{id}/print/{pdf}', 'App\Http\Controllers\RaportController@print');
    Route::any('raport-rekap','App\Http\Controllers\RaportController@rekap');
    Route::any('raport-rekap-uts','App\Http\Controllers\RaportController@rekap_uts');
	Route::get('raport-rekap-uts/{id}/export', 'App\Http\Controllers\ExportController@rekap_uts');
    Route::any('raport-rekap-uas','App\Http\Controllers\RaportController@rekap_uas');
	Route::get('raport-rekap-uas/{id}/export', 'App\Http\Controllers\ExportController@rekap_uas');
    Route::any('raport-rekap-total','App\Http\Controllers\RaportController@rekap_total');
	Route::get('raport-rekap-total/{id}/export', 'App\Http\Controllers\ExportController@rekap_total');
    Route::any('raport-rekap-pengasuhan','App\Http\Controllers\RaportController@rekap_pengasuhan');
	Route::get('raport-rekap-pengasuhan/{id}/export', 'App\Http\Controllers\ExportController@rekap_pengasuhan');
    Route::get('rekap-mahmul','App\Http\Controllers\RaportController@mahmul');
    Route::post('rekap-mahmul-exec','App\Http\Controllers\AssessmentController@mahmul_exec');
    Route::any('cek-mahmul','App\Http\Controllers\AssessmentController@cekmahmul');
    Route::get('rekap-tarakumi','App\Http\Controllers\RaportController@tarakumi');
    Route::get('rekap-rangking','App\Http\Controllers\RaportController@rangking');
    Route::get('rekap-alquran','App\Http\Controllers\RaportController@rekap_alquran');
    Route::get('rekap-idhafiyah','App\Http\Controllers\RaportController@rekap_idhafiyah');
    Route::get('rekap-diknas','App\Http\Controllers\RaportController@rekap_diknas');

	/**
	 * Konfigurasi
	 */
	Route::any('konfigurasi', 'App\Http\Controllers\ConfigController@index');
	Route::any('konfigurasi/yayasan', 'App\Http\Controllers\ConfigController@yayasan');
	Route::any('konfigurasi/pihakketiga', 'App\Http\Controllers\ConfigController@thirdparty');
	Route::any('konfigurasi/data', 'App\Http\Controllers\ConfigController@paging');
	Route::any('konfigurasi/logo', 'App\Http\Controllers\ConfigController@logo');
	Route::post('konfigurasi/savelogo', 'App\Http\Controllers\ConfigController@savelogo');
	Route::any('konfigurasi/modul', 'App\Http\Controllers\ModulController@index');
	Route::any('konfigurasi/menu', 'App\Http\Controllers\MenuController@index');
	Route::any('konfigurasi/peran', 'App\Http\Controllers\RoleController@index');
	Route::any('konfigurasi/notif-android', 'App\Http\Controllers\HomeController@notif');
	Route::post('konfigurasi/notif-android/simpan', 'App\Http\Controllers\HomeController@notif_exec');
	Route::post('konfigurasi/notif-android/kirim', 'App\Http\Controllers\HomeController@notif_exec');

	//MODUL
	Route::post('modul/{id}/edit', 'App\Http\Controllers\ModulController@load');
	Route::post('modul/simpan', 'App\Http\Controllers\ModulController@save');
	Route::post('modul/{id}/detail', 'App\Http\Controllers\ModulController@loaddetail');
	Route::post('modul/{id}/hapus', 'App\Http\Controllers\ModulController@delete');
	Route::post('modul/simpandetail', 'App\Http\Controllers\ModulController@savedetail');
	Route::post('modul/hapusdetail', 'App\Http\Controllers\ModulController@deletedetail');
	Route::post('modul/pindahdetail', 'App\Http\Controllers\ModulController@movedetail');

	// MENU
	Route::post('menu/simpan', 'App\Http\Controllers\MenuController@save');
	Route::post('menu/{id}/load', 'App\Http\Controllers\MenuController@load');
	Route::post('menu/{id}/hapus', 'App\Http\Controllers\MenuController@delete');

	// PERAN
	Route::post('peran/simpan', 'App\Http\Controllers\RoleController@save');
	Route::post('peran/{id}/load', 'App\Http\Controllers\RoleController@load');
	Route::post('peran/{id}/update', 'App\Http\Controllers\RoleController@update');
	Route::post('peran/{id}/hapus', 'App\Http\Controllers\RoleController@delete');
	Route::post('peran/{id}/hapusmenu/{is}', 'App\Http\Controllers\RoleController@deletemenu');

	//Ganti Sesi Tahun Ajar & Semester
	Route::post('home/gantisemester', 'App\Http\Controllers\HomeController@switchTerm');

	//Bayanat Quran
	Route::get('bayanat-quran', 'App\Http\Controllers\BayanatQuranController@index');

	//Bayanat Quran >> Halaqah
	Route::get('bayanat-quran/halaqah', 'App\Http\Controllers\BayanatQuranController@halaqah');
	Route::post('bayanat-quran/halaqah/simpan', 'App\Http\Controllers\BayanatQuranController@save');
	Route::get('bayanat-quran/halaqah/{id}/edit', 'App\Http\Controllers\BayanatQuranController@show');
	Route::get('bayanat-quran/halaqah/{id}/hapus', 'App\Http\Controllers\BayanatQuranController@delete');
	Route::get('bayanat-quran/halaqah/export/{guru}/{kelas}', 'App\Http\Controllers\ExportController@rombel_bayanat');

	//Bayanat Quran >> Komponen Nilai
	Route::get('bayanat-quran/komponen-nilai', 'App\Http\Controllers\BayanatQuranController@weight');
	Route::any('bayanat-quran/komponen-nilai/exec', 'App\Http\Controllers\BayanatQuranController@weight_exec');

	//Bayanat Quran >> Pembagian Halaqah
	Route::get('bayanat-quran/pembagian-halaqah', 'App\Http\Controllers\BayanatQuranController@mapping');
	Route::any('bayanat-quran/pembagian-halaqah/exec', 'App\Http\Controllers\BayanatQuranController@mapping_exec');

	//Bayanat Quran >> Level
	Route::get('bayanat-quran/level', 'App\Http\Controllers\BayanatQuranController@level');
	Route::any('bayanat-quran/level/exec', 'App\Http\Controllers\BayanatQuranController@level_exec');

	//Bayanat Quran >> Penilaian
	Route::any('bayanat-quran/penilaian', 'App\Http\Controllers\BayanatQuranController@assessment');
	Route::post('bayanat-quran/penilaian/simpan', 'App\Http\Controllers\BayanatQuranController@assessment_exec');

	Route::get('testmpdf', 'App\Http\Controllers\RaportController@test');

    // Daftar File dan Download file
    Route::get('lihat-file','App\Http\Controllers\MsUploadController@lihat_file');
    Route::get('download/{id}','App\Http\Controllers\MsUploadController@download_file');
    Route::get('notifikasi/{id?}','App\Http\Controllers\HomeController@notifikasi');
});

Route::group(['middleware' => ['auth','profil']], function () {
	/**
	 * Dashboard Ortu
	 */
	Route::get('mobile/home', 'App\Http\Controllers\Mobile\HomeController@input_tahfidz');
	Route::post('mobile/home', 'App\Http\Controllers\Mobile\HomeController@tahfidz_exec')->name('tahfidz.exec');
	Route::get('mobile/profil', 'App\Http\Controllers\Mobile\HomeController@profil');
	Route::get('mobile/nilai-akademik', 'App\Http\Controllers\Mobile\HomeController@akademik');
	Route::get('mobile/nilai-alquran', 'App\Http\Controllers\Mobile\HomeController@alquran');
	Route::get('mobile/nilai-pengasuhan', 'App\Http\Controllers\Mobile\HomeController@pengasuhan');
	Route::get('mobile/pencapaian-diri', 'App\Http\Controllers\Mobile\HomeController@pencapaian');
	Route::get('mobile/nilai-diknas', 'App\Http\Controllers\Mobile\HomeController@diknas');
	Route::get('mobile/notifikasi/{id?}', 'App\Http\Controllers\Mobile\HomeController@notifikasi');

});
