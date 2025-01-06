<?php

namespace App\Http\Controllers;

use App\Models\Kantor;
use App\Models\Lokasi;
use App\Models\Karyawan;
use Illuminate\Support\Facades\DB;
use PDF;
use Illuminate\Http\Request;
use App\Models\Penandatangan;
use App\Models\Karyawan_Kantor;
use Carbon\Carbon;

class SurattugaskkController extends Controller
{
    public function index()
    {
        $items = Kantor::select('kantor.id', 'lokasi.nama_kota', 'kantor.judul_surat', 'kantor.tanggal_pergi', 'kantor.tanggal_pulang', 'kantor.lampiran_surat')
            ->join('lokasi', 'lokasi.id', '=', 'kantor.lokasi_id')
            ->join('users', 'users.id', '=', 'kantor.users_id')
            ->get();

        return view('/surat_tugaskk/index', compact('items'));
    }
    public function cetak(Request $request)
    {
        $today = Carbon::now()->isoFormat('D MMMM Y');
        $kantor = DB::table('kantor')
            ->join('lokasi', 'lokasi.id', '=', 'kantor.lokasi_id')
            ->join('users', 'users.id', '=', 'kantor.users_id')
            ->where('kantor.id', $request->id)
            ->select('kantor.tanggal_pergi', 'kantor.tanggal_pulang', 'lokasi.nama_kota')
            ->get();

        $itemss = Karyawan_Kantor::select('karyawan_kantor.id', 'karyawan_kantor.kantor_id', 'karyawan_kantor.karyawan_id', 'karyawan.nama', 'karyawan.jabatan')
            ->join('kantor', 'kantor.id', '=', 'karyawan_kantor.kantor_id')
            ->join('karyawan', 'karyawan.id', '=', 'karyawan_kantor.karyawan_id')
            ->where('kantor_id', $request->id)
            ->get();

        $pimpinan = Penandatangan::select('penandatangan.id', 'penandatangan.karyawan_id', 'penandatangan.jabatan_id', 'karyawan.nama', 'karyawan.nip')
            ->join('karyawan', 'karyawan.id', '=', 'penandatangan.karyawan_id')
            ->where('penandatangan.id', 4)
            ->get();

        $pdf = PDF::loadview('/surat_tugaskk/cetak_suratkk', ['kantor' => $kantor], compact('today','itemss', 'pimpinan'));
        return $pdf->stream();
    }
}
