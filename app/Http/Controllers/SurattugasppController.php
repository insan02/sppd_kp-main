<?php

namespace App\Http\Controllers;

use App\Models\Kantor;
use App\Models\Lokasi;
use App\Models\Karyawan;
use App\Models\Disposisi;
use App\Models\Karyawan_Disposisi;
use Illuminate\Support\Facades\DB;
use App\Models\Penandatangan;
use PDF;
use Carbon\Carbon;

use Illuminate\Http\Request;

class SurattugasppController extends Controller
{
    public function index()
    {
        $lokasi = Lokasi::all();
        $karyawan = Karyawan::all();
        $pusat = Karyawan::all();

        $items = Disposisi::select('disposisi.id', 'lokasi.nama_kota', 'pusat.no_surat', 'pusat.judul_surat', 'pusat.tanggal_pergi', 'pusat.tanggal_pulang', 'pusat.lampiran_undangan', 'pusat.status_disposisi')
            ->join('pusat', 'pusat.id', '=', 'disposisi.pusat_id')
            ->join('lokasi', 'lokasi.id', '=', 'pusat.lokasi_id')
            ->get();

        $itemss = Karyawan_Disposisi::select('karyawan_disposisi.id', 'karyawan_disposisi.disposisi_id', 'karyawan_disposisi.karyawan_id', 'karyawan.nama')
            ->join('disposisi', 'disposisi.id', '=', 'karyawan_disposisi.disposisi_id')
            ->join('karyawan', 'karyawan.id', '=', 'karyawan_disposisi.karyawan_id')
            ->get();

        return view('/surat_tugaspp/index', compact('lokasi', 'karyawan', 'pusat', 'itemss'), ['items' => $items]);
    }
    public function cetak(Request $request)
    {
        $today = Carbon::now()->isoFormat('D MMMM Y');
        $disposisi = DB::table('disposisi')
            ->join('pusat', 'pusat.id', '=', 'disposisi.pusat_id')
            ->join('lokasi', 'lokasi.id', '=', 'pusat.lokasi_id')
            ->where('disposisi.id', $request->id)
            ->select('disposisi.id', 'lokasi.nama_kota', 'pusat.no_surat', 'pusat.judul_surat', 'pusat.tanggal_pergi', 'pusat.tanggal_pulang', 'pusat.lampiran_undangan', 'pusat.status_disposisi')
            ->get();

        $itemss = Karyawan_Disposisi::select('karyawan_disposisi.id', 'karyawan_disposisi.disposisi_id', 'karyawan_disposisi.karyawan_id', 'karyawan.nama', 'karyawan.jabatan')
            ->join('disposisi', 'disposisi.id', '=', 'karyawan_disposisi.disposisi_id')
            ->join('karyawan', 'karyawan.id', '=', 'karyawan_disposisi.karyawan_id')
            ->where('disposisi_id', $request->id)
            ->get();

        $pimpinan = Penandatangan::select('penandatangan.id', 'penandatangan.karyawan_id', 'penandatangan.jabatan_id', 'karyawan.nama', 'karyawan.nip')
            ->join('karyawan', 'karyawan.id', '=', 'penandatangan.karyawan_id')
            ->where('penandatangan.id', 4)
            ->get();

        $pdf = PDF::loadview('/surat_tugaspp/cetak_suratpp', ['disposisi' => $disposisi], compact('today','itemss', 'pimpinan'));
        return $pdf->stream();
    }
}
