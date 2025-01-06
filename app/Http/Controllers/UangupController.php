<?php

namespace App\Http\Controllers;

use Session;
use App\Imports\UangupImport;
use Illuminate\Http\Request;
use App\Models\Uangup;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class UangupController extends Controller
{
    public $Uangup;
    public function __construct()
    {
        $this->Uangup = new Uangup();
    }

    public function index()
{
    // Ambil data UP dari database
    $uangup = $this->Uangup->allData();
    $totalJumlahUp = $uangup->sum('jumlahup');
    $totalPengeluaran = $uangup->sum('pengeluaran');
    $totalSisa = $uangup->sum('sisa');
    $totalMasuk = $uangup->sum('totalMasuk');

    // Ambil data terakhir dari kategori up tertentu yang total masuknya sama dengan sisa
    $lastUangup = Uangup::where('totalMasuk', '=', DB::raw('sisa'))->orderBy('id', 'desc')->first();

    // Collect data for chart
    $labelsForChart = [];
    $totalMasukForChart = [];
    $totalPengeluaranForChart = [];

    foreach ($uangup as $up) {
        $labelsForChart[] = $up->kategori_up; // Collecting UP categories as x-axis labels
        $totalMasukForChart[] = $up->totalMasuk; // Collecting total income data for each entry
        $totalPengeluaranForChart[] = $up->pengeluaran; // Collecting total expenditure data for each entry
    }

    $data = [
        'uangup' => $uangup,
        'totalJumlahUp' => $totalJumlahUp,
        'totalMasuk' => $totalMasuk,
        'totalPengeluaran' => $totalPengeluaran,
        'totalSisa' => $totalSisa,
        'labelsForChart' => $labelsForChart,
        'totalMasukForChart' => $totalMasukForChart,
        'totalPengeluaranForChart' => $totalPengeluaranForChart,
        'lastUangup' => $lastUangup, // Data terakhir yang total masuknya sama dengan sisa
    ];

    return view('uangup.index', $data);
}




    public function add()
    {
        return view('uangup/add_uangup');
    }

    public function insert(Request $request)
{
    request()->validate([
        'tanggal' => 'required',
        'kategori_up' => 'required',
        'jumlahup' => 'required|numeric',
    ], [
        'tanggal.required' => 'Tanggal harus diisi!',
        'kategori_up.required' => 'Kategori harus diisi!',
        'jumlahup.required' => 'Jumlah harus diisi dan berupa angka!',
    ]);

    // Periksa apakah kategori_up sudah ada sebelumnya
    $existingCategory = Uangup::where('kategori_up', $request->kategori_up)->exists();
    if ($existingCategory) {
        return redirect()->back()->withInput()->withErrors(['kategori_up' => 'Kategori sudah ada.']);
    }

    // Simpan data uang UP
    $uangUp = new Uangup;
    $uangUp->tanggal = $request->tanggal;
    $uangUp->kategori_up = $request->kategori_up;
    $uangUp->jumlahup = $request->jumlahup;

    // Hitung dan update nilai sisa
    $lastData = Uangup::latest()->first();

    if ($lastData) {
        $sisaSebelumnya = $lastData->sisa;
    } else {
        $sisaSebelumnya = 0;
    }

    $jumlahMasukBaru = $request->jumlahup;
    $sisaBaru = $sisaSebelumnya + $jumlahMasukBaru;
    $uangUp->sisa = $sisaBaru;

    // Tetapkan total masuk sama dengan total sisa
    $uangUp->totalMasuk = $sisaBaru;

    // Simpan data
    $uangUp->save();

    Alert::success('Berhasil!', 'Data uang up berhasil disimpan!');
    return redirect()->route('uangup');
}



public function destroy($id)
{
    $uangup = Uangup::findOrFail($id);
    
    // Memeriksa apakah totalMasuk dari data tersebut sama dengan sisaBaru
    if ($uangup->totalMasuk === $uangup->sisa) {
        $uangup->delete();
        Alert::success('Berhasil!', 'Data uang up berhasil dihapus!');
    } else {
        Alert::error('Gagal!', 'Data uang up tidak dapat dihapus karena totalMasuk tidak sama dengan sisaBaru!');
    }

    return redirect('uangup');
}

    public function edit($id)
    {
        $uangup = DB::table('uangup')->find($id);
        return view('uangup/edit_uangup', ['uangup' => $uangup]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
{
    // Ambil data uangup berdasarkan ID
    $uangup = Uangup::findOrFail($id);

    // Simpan nilai jumlahup sebelum update
    $jumlahupSebelumnya = $uangup->jumlahup;

    // Lakukan proses validasi data yang diterima dari form
    $request->validate([
        'tanggal' => 'required',
        'kategori_up' => 'required',
        'jumlahup' => 'required|numeric', // Menambahkan aturan numeric
    ], [
        'jumlahup.numeric' => 'Jumlah harus berupa angka!',
    ]);

    // Periksa apakah kategori_up sudah ada sebelumnya
    $existingCategory = Uangup::where('kategori_up', $request->kategori_up)->exists();
    if ($existingCategory) {
        return redirect()->back()->withInput()->withErrors(['kategori_up' => 'Kategori sudah ada.']);
    }

    // Hitung selisih jumlahup baru dengan jumlahup sebelumnya
    $selisihJumlahup = $request->jumlahup - $jumlahupSebelumnya;

    // Hitung dan update nilai sisa
    $sisaBaru = $uangup->sisa + $selisihJumlahup;

    // Update data uangup
    $uangup->update([
        'tanggal' => $request->tanggal,
        'kategori_up' => $request->kategori_up,
        'jumlahup' => $request->jumlahup,
        'totalMasuk' => $sisaBaru, // Update totalMasuk dengan nilai sisaBaru
        'sisa' => $sisaBaru, // Update nilai sisa
    ]);

    // Tampilkan pesan sukses
    Alert::success('Berhasil!', 'Data uang up berhasil diupdate!');

    // Redirect ke halaman index
    return redirect('/uangup');
}

public function resetData()
{
    // Hapus semua data UP
    Uangup::truncate();

    // Redirect ke halaman yang sesuai setelah penghapusan
    return redirect()->route('uangup.index')->with('success', 'Semua data UP berhasil dihapus.');
}




}
