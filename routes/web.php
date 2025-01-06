<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PenandatanganController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\FullboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\TransportasiController;
use App\Http\Controllers\PenginapanController;
use App\Http\Controllers\PusatController;
use App\Http\Controllers\KantorController;
use App\Http\Controllers\DisposisiController;
use App\Http\Controllers\SurattugaspController;
use App\Http\Controllers\SurattugaskController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\KeuangankController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\TanggapanController;
use App\Http\Controllers\SurattugasppController;
use App\Http\Controllers\SurattugaskkController;
use App\Http\Controllers\KKantorController;
use App\Http\Controllers\UangupController;


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

Route::get('/', function () {
    return view('/auth/login');
});
Route::get('/home', [HomeController::class, 'index']);  
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// profil
Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');


//hak akses untuk admin
Route::group(['middleware' => 'admin'], function() {
    //karyawan
Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan');
Route::get('/karyawan/create', [KaryawanController::class, 'create']);
Route::get('/karyawan/add', [KaryawanController::class, 'add']);
Route::post('/karyawan/insert', [KaryawanController::class, 'insert']);
Route::get('/karyawan/{id}/delete', [KaryawanController::class, 'destroy'])->name('karyawan.destroy');
Route::get('/karyawan/edit/{id}', [KaryawanController::class, 'edit']);
Route::post('/karyawan/update/{id}', [KaryawanController::class, 'update']);

//penandatangan
Route::get('/penandatangan', [PenandatanganController::class, 'index'])->name('penandatangan');
Route::get('/penandatangan/create', [PenandatanganController::class, 'create']);
Route::get('/penandatangan/add', [PenandatanganController::class, 'add']);
Route::post('/penandatangan/insert', [PenandatanganController::class, 'insert']);
Route::get('/penandatangan/{id}/delete', [PenandatanganController::class, 'destroy'])->name('penandatangan.destroy');
Route::get('/penandatangan/edit/{id}', [PenandatanganController::class, 'edit']);
Route::post('/penandatangan/update/{id}', [PenandatanganController::class, 'update']);

//jabatan
Route::get('/jabatan', [JabatanController::class, 'index'])->name('jabatan');
Route::get('/jabatan/create', [JabatanController::class, 'create']);
Route::get('/jabatan/add', [JabatanController::class, 'add']);
Route::post('/jabatan/insert', [JabatanController::class, 'insert']);
Route::get('/jabatan/{id}/delete', [JabatanController::class, 'destroy'])->name('jabatan.destroy');

//fullboard
Route::get('/fullboard', [FullboardController::class, 'index'])->name('fullboard');
Route::get('/fullboard/edit/{id}', [FullboardController::class, 'edit']);
Route::post('/fullboard/update/{id}', [FullboardController::class, 'update']);

//user
Route::get('/user', [UserController::class, 'index'])->name('user');
Route::get('/user/add', [UserController::class, 'add']);
Route::post('/user/insert', [UserController::class, 'insert']);
Route::get('/user/{id}/delete', [UserController::class, 'destroy'])->name('user.destroy');
Route::get('/user/edit/{id}', [UserController::class, 'edit']);
Route::post('/user/update/{id}', [UserController::class, 'update']);

//lokasi
Route::get('/lokasi', [LokasiController::class, 'index'])->name('lokasi');
Route::get('/lokasi/create', [LokasiController::class, 'create']);
Route::get('/lokasi/add', [LokasiController::class, 'add']);
Route::post('/lokasi/import_excel', [LokasiController::class, 'import_excel']);
Route::post('/lokasi/insert', [LokasiController::class, 'insert']);
Route::get('/lokasi/{id}/delete', [LokasiController::class, 'destroy'])->name('lokasi.destroy');
Route::get('/lokasi/edit/{id}', [LokasiController::class, 'edit']);
Route::post('/lokasi/update/{id}', [LokasiController::class, 'update']);

//transportasi
Route::get('/transportasi', [TransportasiController::class, 'index'])->name('transportasi');
Route::get('/transportasi/create', [TransportasiController::class, 'create']);
Route::get('/transportasi/add', [TransportasiController::class, 'add']);
Route::post('/transportasi/insert', [TransportasiController::class, 'insert']);
Route::get('/transportasi/{id}/delete', [TransportasiController::class, 'destroy'])->name('transportasi.destroy');
Route::get('/transportasi/edit/{id}', [TransportasiController::class, 'edit']);
Route::post('/transportasi/update/{id}', [TransportasiController::class, 'update']);

//penginapan
Route::get('/penginapan', [PenginapanController::class, 'index'])->name('penginapan');
Route::get('/penginapan/create', [PenginapanController::class, 'create']);
Route::get('/penginapan/add', [PenginapanController::class, 'add']);
Route::post('/penginapan/insert', [PenginapanController::class, 'insert']);
Route::get('/penginapan/{id}/delete', [PenginapanController::class, 'destroy'])->name('penginapan.destroy');
Route::get('/penginapan/edit/{id}', [PenginapanController::class, 'edit']);
Route::post('/penginapan/update/{id}', [PenginapanController::class, 'update']);

// pusat
Route::get('/pusat', [PusatController::class, 'index'])->name('pusat');
Route::get('/pusat/create', [PusatController::class, 'create']);
Route::get('/pusat/add', [PusatController::class, 'add']);
Route::post('/pusat/insert', [PusatController::class, 'insert']);
Route::get('/pusat/{id}/delete', [PusatController::class, 'destroy'])->name('pusat.destroy');
Route::get('/pusat/edit/{id}', [PusatController::class, 'edit']);
Route::post('/pusat/update/{id}', [PusatController::class, 'update']);
Route::get('/pusat/terima', [PusatController::class, 'terima'])->name('pusat/terima');
Route::get('/pusat/detail/{id}', [PusatController::class, 'detail'])->name('pusat.detail');

// kantor
Route::get('/kantor', [KantorController::class, 'index'])->name('kantor');
Route::post('/kantor/import_excel', [KKantorController::class, 'import_excel']);
Route::get('/kantor/create', [KantorController::class, 'create']);
Route::get('/kantor/add', [KantorController::class, 'add']);
Route::post('/kantor/insert', [KantorController::class, 'insert']);
Route::get('/kantor/{id}/delete', [KantorController::class, 'destroy'])->name('kantor.destroy');
Route::get('/kantor/edit/{id}', [KantorController::class, 'edit']);
Route::post('/kantor/update/{id}', [KantorController::class, 'update']);

// surattugasp
Route::get('/surat_tugaspp', [SurattugasppController::class, 'index'])->name('surattugaspp');
Route::get('/surat_tugaspp/cetak/{id}', [SurattugasppController::class, 'cetak']);
    
// surattugask
Route::get('/surat_tugaskk', [SurattugaskkController::class, 'index'])->name('surattugaskk');
Route::get('/surat_tugaskk/cetak/{id}', [SurattugaskkController::class, 'cetak']);


});


//hak akses untuk pimpinan
Route::group(['middleware' => 'pimpinan'], function() {
    // disposisi
Route::get('/disposisi', [DisposisiController::class, 'index'])->name('disposisi');
Route::get('/disposisi/show/{id}', [DisposisiController::class, 'show'])->name('show');
Route::post('/disposisi/store', [TanggapanController::class, 'store']);
Route::get('/disposisi/terima', [DisposisiController::class, 'terima'])->name('disposisi.terima');
Route::get('disposisi/edit/{id}', [DisposisiController::class, 'edit'])->name('disposisi.edit');
Route::post('/disposisi/update/{id}', [DisposisiController::class, 'update']);
Route::get('/disposisi/show/{id}/delete/{idkaryawan}', [DisposisiController::class, 'destroy'])->name('disposisi.show.destroy');
Route::get('/disposisi/detail/{id}', [DisposisiController::class, 'detail'])->name('disposisi.detail');
    //tanggapan
// Route::resource('tanggapan', 'TanggapanController');
Route::get('/tanggapan/show/{id}', [TanggapanController::class, 'show']);
Route::post('/tanggapan/store', [TanggapanController::class, 'store']);

});

//hak akses untuk hkt
Route::group(['middleware' => 'admin_hkt'], function() {
    // surattugasp
Route::get('/surat_tugasp', [SurattugaspController::class, 'index'])->name('surattugasp');
Route::get('/surat_tugasp/cetak/{id}', [SurattugaspController::class, 'cetak']);

// surattugask
Route::get('/surat_tugask', [SurattugaskController::class, 'index'])->name('surattugask');
Route::get('/surat_tugask/cetak/{id}', [SurattugaskController::class, 'cetak']);

});

//hak akses untuk keuangan
Route::group(['middleware' => 'admin_keuangan'], function() {

Route::get('/uangup', [UangupController::class, 'index'])->name('uangup');
Route::get('/uangup/create', [UangupController::class, 'create']);
Route::get('/uangup/add', [UangupController::class, 'add']);
Route::post('/uangup/insert', [UangupController::class, 'insert']);
Route::get('/uangup/{id}/delete', [UangupController::class, 'destroy'])->name('uangup.destroy');
Route::get('/uangup/edit/{id}', [UangupController::class, 'edit']);
Route::post('/uangup/update/{id}', [UangupController::class, 'update']);
Route::get('/uangup/exportPDF', [UangUpController::class, 'exportPDF'])->name('uangup.exportPDF');
Route::get('/uangup/reset', [UangupController::class,'resetData'])->name('uangup.reset');
Route::get('/uangup/print', [UangupController::class, 'print'])->name('uangup.print');



    // keuangan
Route::get('/keuangan', [KeuanganController::class, 'index'])->name('keuangan');
Route::get('/keuangan/show/{id}', [KeuanganController::class, 'show'])->name('keuangan.show');
Route::get('/keuangan/show2/{id}', [KeuanganController::class, 'show2'])->name('keuangan.show2');
Route::get('/keuangan/show/{id}/delete', [KeuanganController::class, 'destroy'])->name('keuangan.destroy');
Route::get('/keuangan/add/{id}', [KeuanganController::class, 'add'])->name('keuangan.add');
Route::post('/keuangan/store', [KeuanganController::class, 'store']);
Route::post('/keuangan/saveSubjumlah/{itemId}/{subjumlah}', [KeuanganController::class, 'saveSubjumlah'])->name('keuangan.saveSubjumlah');
Route::post('/keuangan/store2', [KeuanganController::class, 'store2']);
Route::get('/keuangan/cetak/{id}', [KeuanganController::class, 'cetak']);
Route::get('/keuangan/pdf', [KeuanganController::class, 'generatePDF'])->name('keuangan.pdf');
Route::get('/keuangan/riwayat', [KeuanganController::class, 'riwayat'])->name('keuangan.riwayat');
Route::get('/keuangan/edit/{id}', [KeuanganController::class, 'edit']);
Route::post('/keuangan/update/{id}', [KeuanganController::class, 'update']);
Route::post('/keuangan/updatestatus/{id}', [KeuanganController::class, 'updatestatus']);


// keuangank
Route::get('/keuangank', [KeuangankController::class, 'index'])->name('keuangank');
Route::get('/keuangank/edit/{id}', [KeuangankController::class, 'edit']);
Route::get('/keuangank/tampil/{id}', [KeuangankController::class, 'tampil'])->name('keuangank.tampil');
Route::get('/keuangank/show/{id}', [KeuangankController::class, 'show'])->name('keuangank.show');
Route::get('/keuangank/show/{id}/delete', [KeuangankController::class, 'destroy'])->name('keuangank.destroy');
Route::get('/keuangank/add/{id}', [KeuangankController::class, 'add'])->name('keuangank.add');
Route::post('/keuangank/store', [KeuangankController::class, 'store']);
Route::get('/keuangank/pdf', [KeuangankController::class, 'generatePDF'])->name('keuangank.pdf');
Route::post('/keuangank/saveSubjumlah/{itemId}/{subjumlah}', [KeuangankController::class, 'saveSubjumlah'])->name('keuangank.saveSubjumlah');
Route::get('/keuangank/cetak/{id}', [KeuangankController::class, 'cetak']);
Route::get('/keuangank/riwayat', [KeuangankController::class, 'riwayat'])->name('keuangank');
Route::get('/keuangank/show2/{id}', [KeuangankController::class, 'show2'])->name('keuangank.show2');
Route::post('/keuangank/update/{id}', [KeuangankController::class, 'update']);
Route::post('/keuangank/updatestatus/{id}', [KeuangankController::class, 'updatestatus']);
});