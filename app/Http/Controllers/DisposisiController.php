<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pusat;
use App\Models\Disposisi;
use App\Models\Karyawan;
use App\Models\Karyawan_Disposisi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Keuangan;
use App\Models\Kantor;
use App\Models\Karyawan_Kantor;
use App\Models\Tipe_lumpsum;
use App\Models\Keuangan_tp;
use App\Models\Lokasi;
use App\Models\Fullboard;
use App\Models\Keuangan_pn;
use App\Models\Kategori;
use App\Models\Transportasi;
use App\Models\Penginapan;

class DisposisiController extends Controller
{
    public function __construct()
    {
        $this->Disposisi = new Disposisi();
    }

    public function index()
    {
        $items = Pusat::orderBy('created_at', 'DESC')->get();
        return view('/disposisi/index', [
            'items' => $items
        ]);
    }

    public function terima()
    {
        $items = Pusat::orderBy('created_at', 'DESC')->get();
        return view('/disposisi/riwayatterima', [
            'items' => $items
        ]);
    }

    public function edit($id)
    {
        $terima = Pusat::select('*')
            ->where('id', $id)
            ->get();

        return view('show', ['terima' => $terima]);
    }

    public function update(Request $request, $id)
    {

        $terima = DB::table('pusat')
            ->where('id', $id)
            ->update([
                'status_disposisi' => "Terima",
            ]);

        $users_id = Auth::user()->id;
        $tambah = Disposisi::updateOrCreate(
            [
                'pusat_id' => $id,
                'users_id' => $users_id
            ],
        );
        $disposisi = DB::getPdo()->lastInsertId();
        Karyawan_Disposisi::where('pusat_id', $id)
            ->update(['disposisi_id' =>  $disposisi]);

        Alert::success('Berhasil', 'Disposisi berhasil ditanggapi');
        return redirect('/disposisi');
    }

    public function show($id)
    {
        $karyawan = Karyawan::all();
        $pusat = Pusat::all();
        $itemss = Karyawan_Disposisi::select('karyawan_disposisi.id', 'karyawan_disposisi.disposisi_id', 'karyawan_disposisi.karyawan_id', 'karyawan.nama', 'pusat.id')

            ->join('karyawan', 'karyawan.id', '=', 'karyawan_disposisi.karyawan_id')
            ->join('pusat', 'pusat.id', '=', 'karyawan_disposisi.pusat_id')
            ->where('karyawan_disposisi.pusat_id', $id)
            ->get();

        $item = Pusat::with([
            'details'
        ])->findOrFail($id);

        $tangap = Disposisi::where('pusat_id', $id)->first();

        return view('disposisi/show', compact('karyawan', 'pusat', 'itemss'), [
            'item' => $item,
            'tangap' => $tangap
        ]);
    }

    public function destroy($id, $id2)
    {
        $kd = DB::table('karyawan_disposisi')
            ->join('karyawan', 'karyawan.id', '=', 'karyawan_disposisi.karyawan_id')
            ->join('pusat', 'pusat.id', '=', 'karyawan_disposisi.pusat_id')
            ->where('karyawan_disposisi.pusat_id', $id)
            ->where('karyawan_disposisi.karyawan_id', $id2)
            ->get();

        for ($i = 0; $i < count($kd); $i++) {
            DB::table('karyawan_disposisi')
                ->join('karyawan', 'karyawan.id', '=', 'karyawan_disposisi.karyawan_id')
                ->join('pusat', 'pusat.id', '=', 'karyawan_disposisi.pusat_id')
                ->where('karyawan_disposisi.pusat_id', $id)
                ->where('karyawan_disposisi.karyawan_id', $id2)
                ->delete();
        }
        Alert::success('Berhasil!', 'Karyawan berhasil dihapus!');
        return redirect()->back();
    }

    public function detail($id)
    {
        $kantor = Kantor::all();
        $tipeLump = Tipe_lumpsum::all();
        $pn = Penginapan::all();
        $transportasi = Transportasi::all();
        $lokasii = Lokasi::all();
        $board = Fullboard::all();
        $karyawan = Karyawan::all();
        $disposisi = Disposisi::all();

        $item2 = Pusat::select('pusat.id', 'lokasi.nama_kota', 'pusat.no_surat', 'pusat.judul_surat', 'pusat.tanggal_pergi', 'pusat.tanggal_pulang', 'pusat.lampiran_undangan')
            ->join('lokasi', 'lokasi.id', '=', 'pusat.lokasi_id')
            ->join('users', 'users.id', '=', 'pusat.users_id')
            ->where('pusat.id', $id)->first();

        $jmlh_data = Karyawan_Kantor::select(DB::raw('kantor_id, count(id) as total'))
            ->groupby('kantor_id')
            ->where('kantor_id', $id)
            ->get();

        $itemUang = Tipe_lumpsum::select('reff_tipe_lumpsum.id', 'reff_tipe_lumpsum.tipe_lumpsum', 'keuangan.tipe_penginapan_id')
            ->join('keuangan', 'keuangan.tipe_penginapan_id', '=', 'reff_tipe_lumpsum.id')
            ->where('tipe_penginapan_id', $id)->first();

        $itemss1 = Keuangan::select('keuangan.id', 'keuangan.hari', 'lokasi.besaran_lumpsum', 'keuangan.kantor_id', 'keuangan.tipe_penginapan_id', 'reff_tipe_lumpsum.jumlah', 'reff_tipe_lumpsum.tipe_lumpsum', 'lokasi.nama_kota', 'lokasi.besaran_lumpsum', 'keuangan.uang_transport', 'keuangan.uang_penginapan', 'keuangan.keterangan', 'pusat.id', 'pusat.tanggal_pergi', 'pusat.tanggal_pulang')
            ->join('pusat', 'pusat.id', '=', 'keuangan.pusat_id')
            ->join('lokasi', 'lokasi.id', '=', 'keuangan.id_lokasi')
            ->join('reff_tipe_lumpsum', 'reff_tipe_lumpsum.id', '=', 'keuangan.tipe_penginapan_id')
            ->where('keuangan.pusat_id', $id)
            ->get();

        $itemss2 = Keuangan::select('keuangan.id', 'keuangan.hari', 'lokasi.besaran_lumpsum', 'keuangan.kantor_id', 'keuangan.tipe_penginapan_id', 'reff_tipe_lumpsum.jumlah', 'reff_tipe_lumpsum.tipe_lumpsum', 'lokasi.nama_kota', 'lokasi.besaran_lumpsum', 'keuangan.uang_transport', 'keuangan.uang_penginapan', 'keuangan.keterangan', 'pusat.tanggal_pergi', 'pusat.tanggal_pulang')
            ->join('disposisi', 'keuangan.disposisi_id', '=', 'disposisi.id')
            ->join('pusat', 'pusat.id', '=', 'keuangan.pusat_id')
            ->join('lokasi', 'lokasi.id', '=', 'keuangan.id_lokasi')
            ->join('reff_tipe_lumpsum', 'reff_tipe_lumpsum.id', '=', 'keuangan.tipe_penginapan_id')
            ->where('keuangan.pusat_id', $id)
            ->get();

        $uang = Keuangan::all();
        $uang_tp = Keuangan_tp::select('Keuangan_tp.id', 'Keuangan_tp.uang', 'Keuangan_tp.transport_id', 'transportasi.jenis_transportasi')
            ->join('transportasi', 'transportasi.id', '=', 'keuangan_tp.transport_id')
            ->get();

        $uang_pn = Keuangan_pn::select('Keuangan_pn.id', 'Keuangan_pn.uang', 'Keuangan_pn.pn_id', 'penginapan.nama_penginapan')
            ->join('penginapan', 'penginapan.id', '=', 'Keuangan_pn.pn_id')
            ->get();

        $lokasi = Lokasi::all();
        $karyawan = Karyawan::all();
        $pusat = Pusat::all();
        $pn = Penginapan::all();
        $transportasi = Transportasi::all();
        $kategori = Kategori::all();

        $item = Disposisi::select('disposisi.id', 'lokasi.nama_kota', 'pusat.no_surat', 'pusat.judul_surat', 'pusat.tanggal_pergi', 'pusat.tanggal_pulang', 'pusat.lampiran_undangan', 'pusat.status_disposisi')
            ->join('pusat', 'pusat.id', '=', 'disposisi.pusat_id')
            ->join('lokasi', 'lokasi.id', '=', 'pusat.lokasi_id')
            ->where('disposisi.pusat_id', $id)->first();


        $jmlh_data = Karyawan_Disposisi::select(DB::raw('pusat_id, count(id) as total'))
            ->groupby('pusat_id')
            ->where('karyawan_disposisi.pusat_id', $id)
            ->get();

        $tangap = Keuangan::where('keuangan.pusat_id', $id)->first();

        $itemm = Disposisi::select('disposisi.id', 'pusat.lokasi_id', 'lokasi.nama_kota', 'pusat.no_surat', 'pusat.judul_surat', 'pusat.tanggal_pergi', 'pusat.tanggal_pulang', 'pusat.lampiran_undangan', 'pusat.status_disposisi')
            ->join('pusat', 'pusat.id', '=', 'disposisi.pusat_id')
            ->join('lokasi', 'lokasi.id', '=', 'pusat.lokasi_id')
            ->where('disposisi.pusat_id', $id)->first();

        $date1 = $item->tanggal_pergi;
        $date2 = $item->tanggal_pulang;
        $date1Timestamp = strtotime($date1);
        $date2Timestamp = strtotime($date2);
        $difference = $date2Timestamp - $date1Timestamp;
        $days = date('d', $difference) - 1;

        $data = Keuangan::select('keuangan.id', 'keuangan.pusat_id', 'lokasi.besaran_lumpsum', 'keuangan.uang_transport', 'keuangan.uang_penginapan')
            ->join('pusat', 'pusat.id', '=', 'keuangan.pusat_id')
            ->join('lokasi', 'lokasi.id', '=', 'pusat.lokasi_id')
            ->where('keuangan.pusat_id', $id)->first();

        $dataa = Keuangan::select('keuangan.id', 'keuangan.pusat_id', 'lokasi.besaran_lumpsum', 'keuangan.uang_transport', 'keuangan.uang_penginapan')
            ->join('pusat', 'pusat.id', '=', 'keuangan.pusat_id')
            ->join('lokasi', 'lokasi.id', '=', 'pusat.lokasi_id')
            ->where('keuangan.pusat_id', $id)
            ->get();

        return view('disposisi/detail',  compact(['pusat', 'item', 'itemm', 'item2', 'uang', 'board', 'uang_tp', 'uang_pn', 'itemss2', 'lokasii', 'itemUang', 'tangap', 'pn', 'tipeLump', 'itemss1', 'tangap', 'pn', 'data', 'dataa', 'days', 'pusat', 'transportasi', 'jmlh_data', 'kategori']));
    }
}
