<?php

namespace App\Http\Controllers;

use App\Models\Kantor;
use App\Models\Karyawan;
use App\Models\Karyawan_Kantor;
use App\Models\Keuangan;
use App\Models\Tipe_lumpsum;
use App\Models\Keuangank;
use App\Models\Keuangan_tp;
use App\Models\Uangup;
use App\Models\Lokasi;
use App\Models\Fullboard;
use App\Models\Jabatan;
use App\Models\Penandatangan;
use App\Models\Keuangan_pn;
use App\Models\Transportasi;
use App\Models\Penginapan;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use PDF;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;

class KeuangankController extends Controller
{
    public $idKeuangan;

    public function __construct()
    {
        $this->idKeuangan = new Keuangan();
    }

    public function index()
    {
        $items = Kantor::select('kantor.id', 'lokasi.nama_kota', 'kantor.judul_surat', 'kantor.tanggal_pergi', 'kantor.tanggal_pulang', 'kantor.lampiran_surat', 'kantor.status_keuangan')
            ->leftjoin('lokasi', 'lokasi.id', '=', 'kantor.lokasi_id')
            ->join('users', 'users.id', '=', 'kantor.users_id')
            ->get();

        return view('/keuangank/index', compact('items'));
    }

    public function riwayat(Request $request)
{
    $uangup = Uangup::all();
    $search = $request->input('search'); // Mendapatkan nilai pencarian dari permintaan HTTP

    // Ambil semua data kategori UP
    $uangup = Uangup::all();
    $items = Kantor::select(
            'kantor.id',
            'uangup.kategori_up',
            'lokasi.nama_kota',
            'kantor.judul_surat',
            'kantor.tanggal_pergi',
            'kantor.tanggal_pulang',
            'kantor.lampiran_surat',
            'kantor.status_keuangan',
            'keuangan.subjumlah'
        )
        ->join('users', 'users.id', '=', 'kantor.users_id')
        ->leftJoin('lokasi', 'lokasi.id', '=', 'kantor.lokasi_id')
        ->leftJoin('keuangan', 'keuangan.kantor_id', '=', 'kantor.id')
        ->leftJoin('uangup', 'uangup.id', '=', 'keuangan.kategori_up')
        ->with('uangup');

    // Terapkan filter jika pencarian tidak kosong
    if (!empty($search)) {
        $items->where('uangup.kategori_up', 'like', '%' . $search . '%');
    }

    $items = $items->get();

    // Ambil semua kategori UP dari tabel keuangan
    $kategoriUP = $items->pluck('kategori_up')->unique();

    // Inisialisasi array totalPengeluaranKantor dengan kategori UP yang mungkin
    $totalPengeluaranKantor = [];
    foreach ($kategoriUP as $up) {
        $totalPengeluaranKantor[$up] = 0;
    }

    foreach ($items as $item) {
        $totalPengeluaranKantor[$item->kategori_up] += $item->subjumlah;
    }

    return view('/keuangank/riwayatproses', compact('items', 'totalPengeluaranKantor','uangup', 'search')); // Mengirimkan nilai pencarian ke tampilan
}





    public function tampil($id)
    {
        $item = Kantor::select('kantor.id', 'lokasi.nama_kota', 'kantor.judul_surat', 'kantor.tanggal_pergi', 'kantor.tanggal_pulang', 'kantor.lampiran_surat')
            ->join('lokasi', 'lokasi.id', '=', 'kantor.lokasi_id')
            ->join('users', 'users.id', '=', 'kantor.users_id')
            ->where('kantor.id', $id)->first();

        $tangap = Keuangan::where('kantor_id', $id)->first();

        return view('keuangank/tampil',  compact(['item', 'tangap']));
    }

    public function show($id)
    {
        $kantor = Kantor::all();
        $tipeLump = Tipe_lumpsum::all();
        $pn = Penginapan::all();
        $transportasi = Transportasi::all();
        $lokasii = Lokasi::all();
        $uangup = Uangup::all();
        $board = Fullboard::all();
        $karyawan = Karyawan::all();
        $item = Kantor::select('kantor.id', 'lokasi.nama_kota', 'kantor.judul_surat', 'kantor.tanggal_pergi', 'kantor.tanggal_pulang', 'kantor.lampiran_surat')
            ->join('lokasi', 'lokasi.id', '=', 'kantor.lokasi_id')
            ->join('users', 'users.id', '=', 'kantor.users_id')
            ->where('kantor.id', $id)->first();

        $jmlh_data = Karyawan_Kantor::select(DB::raw('kantor_id, count(id) as total'))
            ->groupby('kantor_id')
            ->where('kantor_id', $id)
            ->get();

        $itemUang = Tipe_lumpsum::select('reff_tipe_lumpsum.id', 'reff_tipe_lumpsum.tipe_lumpsum', 'keuangan.tipe_penginapan_id')
            ->join('keuangan', 'keuangan.tipe_penginapan_id', '=', 'reff_tipe_lumpsum.id')
            ->where('tipe_penginapan_id', $id)->first();

        $tangap = Keuangan::where('kantor_id', $id)->first();

        $date1 = $item->tanggal_pergi;
        $date2 = $item->tanggal_pulang;
        $date1Timestamp = strtotime($date1);
        $date2Timestamp = strtotime($date2);
        $difference = $date2Timestamp - $date1Timestamp;
        $days = date('d', $difference) - 1;

        $items = Keuangan::select('keuangan.id', 'keuangan.kantor_id', 'keuangan.tipe_penginapan_id', 'lokasi.besaran_lumpsum', 'keuangan.uang_transport')
            ->join('kantor', 'keuangan.kantor_id', 'kantor.id')
            ->join('lokasi', 'lokasi.id', '=', 'kantor.lokasi_id')->where('kantor.id', $id)
            ->join('reff_tipe_lumpsum', 'reff_tipe_lumpsum.id', '=', 'keuangan.tipe_penginapan_id')
            ->where('kantor_id', $id)->first();

        $itemss = Keuangan::select('keuangan.id', 'keuangan.hari', 'keuangan_tp.uang', 'keuangan_tp.transport_id', 'lokasi.besaran_lumpsum', 'keuangan.kantor_id', 'keuangan.tipe_penginapan_id', 'reff_tipe_lumpsum.jumlah', 'reff_tipe_lumpsum.tipe_lumpsum', 'lokasi.nama_kota', 'lokasi.besaran_lumpsum', 'keuangan.uang_transport', 'keuangan.uang_penginapan', 'keuangan.keterangan')
            ->join('kantor', 'keuangan.kantor_id', 'kantor.id')
            ->join('lokasi', 'lokasi.id', '=', 'keuangan.id_lokasi')
            ->join('reff_tipe_lumpsum', 'reff_tipe_lumpsum.id', '=', 'keuangan.tipe_penginapan_id')
            ->join('keuangan_tp', 'keuangan_tp.gabung_tp_id', '=', 'keuangan.id')
            ->where('kantor_id', $id)
            ->get();

        $itemss1 = Keuangan::select('keuangan.id', 'keuangan.hari', 'uangup.kategori_up','lokasi.besaran_lumpsum', 'keuangan.kantor_id', 'keuangan.tipe_penginapan_id', 'reff_tipe_lumpsum.jumlah', 'reff_tipe_lumpsum.tipe_lumpsum', 'lokasi.nama_kota', 'lokasi.besaran_lumpsum', 'keuangan.uang_transport', 'keuangan.uang_penginapan', 'keuangan.keterangan', 'kantor.tanggal_pergi', 'kantor.tanggal_pulang')
            ->join('kantor', 'keuangan.kantor_id', 'kantor.id')
            ->join('lokasi', 'lokasi.id', '=', 'keuangan.id_lokasi')
            ->join('uangup', 'uangup.id', '=', 'keuangan.kategori_up') 
            ->join('reff_tipe_lumpsum', 'reff_tipe_lumpsum.id', '=', 'keuangan.tipe_penginapan_id')
            ->where('kantor_id', $id)
            ->get();

        $uang = Keuangan::all();
        $uang_tp = Keuangan_tp::select('Keuangan_tp.id', 'Keuangan_tp.uang', 'Keuangan_tp.transport_id', 'transportasi.jenis_transportasi')
            ->join('transportasi', 'transportasi.id', '=', 'keuangan_tp.transport_id')
            ->get();

        $uang_pn = Keuangan_pn::select('Keuangan_pn.id', 'Keuangan_pn.uang', 'Keuangan_pn.pn_id', 'penginapan.nama_penginapan')
            ->join('penginapan', 'penginapan.id', '=', 'Keuangan_pn.pn_id')
            ->get();

        return view('keuangank/show',  compact(['item', 'uang', 'uangup','board', 'uang_tp', 'uang_pn', 'lokasii', 'itemUang', 'tangap', 'pn', 'tipeLump', 'items', 'itemss', 'itemss1', 'days', 'kantor', 'transportasi', 'jmlh_data']));
    }

    public function show2($id)
    {
        $kantor = Kantor::all();
        $tipeLump = Tipe_lumpsum::all();
        $pn = Penginapan::all();
        $transportasi = Transportasi::all();
        $lokasii = Lokasi::all();
        $board = Fullboard::all();
        $karyawan = Karyawan::all();
        $uangup = Uangup::all();
        $item = Kantor::select('kantor.id', 'lokasi.nama_kota', 'uangup.kategori_up','kantor.judul_surat', 'kantor.tanggal_pergi', 'kantor.tanggal_pulang', 'kantor.lampiran_surat')
            ->join('lokasi', 'lokasi.id', '=', 'kantor.lokasi_id')
            ->join('users', 'users.id', '=', 'kantor.users_id')
            ->join('keuangan', 'keuangan.kantor_id', '=', 'kantor.id') // Perubahan: Sesuaikan dengan kunci asing pada tabel 'keuangan'
            ->join('uangup', 'uangup.id', '=', 'keuangan.kategori_up')
            ->where('kantor.id', $id)->first();

        $jmlh_data = Karyawan_Kantor::select(DB::raw('kantor_id, count(id) as total'))
            ->groupby('kantor_id')
            ->where('kantor_id', $id)
            ->get();

        $itemUang = Tipe_lumpsum::select('reff_tipe_lumpsum.id', 'reff_tipe_lumpsum.tipe_lumpsum', 'keuangan.tipe_penginapan_id')
            ->join('keuangan', 'keuangan.tipe_penginapan_id', '=', 'reff_tipe_lumpsum.id')
            ->where('tipe_penginapan_id', $id)->first();

        $tangap = Keuangan::where('kantor_id', $id)->first();

        $date1 = $item->tanggal_pergi;
        $date2 = $item->tanggal_pulang;
        $date1Timestamp = strtotime($date1);
        $date2Timestamp = strtotime($date2);
        $difference = $date2Timestamp - $date1Timestamp;
        $days = date('d', $difference) - 1;

        $items = Keuangan::select('keuangan.id', 'keuangan.kantor_id', 'keuangan.tipe_penginapan_id', 'lokasi.besaran_lumpsum', 'keuangan.uang_transport')
            ->join('kantor', 'keuangan.kantor_id', 'kantor.id')
            ->join('lokasi', 'lokasi.id', '=', 'kantor.lokasi_id')->where('kantor.id', $id)
            ->join('reff_tipe_lumpsum', 'reff_tipe_lumpsum.id', '=', 'keuangan.tipe_penginapan_id')
            ->where('kantor_id', $id)->first();

        $itemss = Keuangan::select('keuangan.id', 'keuangan.hari', 'keuangan_tp.uang', 'keuangan_tp.transport_id', 'lokasi.besaran_lumpsum', 'keuangan.kantor_id', 'keuangan.tipe_penginapan_id', 'reff_tipe_lumpsum.jumlah', 'reff_tipe_lumpsum.tipe_lumpsum', 'lokasi.nama_kota', 'lokasi.besaran_lumpsum', 'keuangan.uang_transport', 'keuangan.uang_penginapan', 'keuangan.keterangan')
            ->join('kantor', 'keuangan.kantor_id', 'kantor.id')
            ->join('lokasi', 'lokasi.id', '=', 'keuangan.id_lokasi')
            ->join('reff_tipe_lumpsum', 'reff_tipe_lumpsum.id', '=', 'keuangan.tipe_penginapan_id')
            ->join('keuangan_tp', 'keuangan_tp.gabung_tp_id', '=', 'keuangan.id')
            ->where('kantor_id', $id)
            ->get();

        $itemss1 = Keuangan::select('keuangan.id', 'keuangan.hari', 'lokasi.besaran_lumpsum', 'keuangan.kantor_id', 'keuangan.tipe_penginapan_id', 'reff_tipe_lumpsum.jumlah', 'reff_tipe_lumpsum.tipe_lumpsum', 'lokasi.nama_kota', 'lokasi.besaran_lumpsum', 'keuangan.uang_transport', 'keuangan.uang_penginapan', 'keuangan.keterangan', 'kantor.tanggal_pergi', 'kantor.tanggal_pulang')
            ->join('kantor', 'keuangan.kantor_id', 'kantor.id')
            ->join('lokasi', 'lokasi.id', '=', 'keuangan.id_lokasi')
            ->join('reff_tipe_lumpsum', 'reff_tipe_lumpsum.id', '=', 'keuangan.tipe_penginapan_id')
            ->where('kantor_id', $id)
            ->get();

        $uang = Keuangan::all();
        $uang_tp = Keuangan_tp::select('Keuangan_tp.id', 'Keuangan_tp.uang', 'Keuangan_tp.transport_id', 'transportasi.jenis_transportasi')
            ->join('transportasi', 'transportasi.id', '=', 'keuangan_tp.transport_id')
            ->get();

        $uang_pn = Keuangan_pn::select('Keuangan_pn.id', 'Keuangan_pn.uang', 'Keuangan_pn.pn_id', 'penginapan.nama_penginapan')
            ->join('penginapan', 'penginapan.id', '=', 'Keuangan_pn.pn_id')
            ->get();

        return view('keuangank/show2',  compact(['item', 'uang', 'board', 'uang_tp', 'uang_pn', 'lokasii', 'itemUang', 'tangap', 'pn', 'tipeLump', 'items', 'itemss', 'itemss1', 'days', 'kantor', 'transportasi', 'jmlh_data']));
    }

    public function add($id)
    {
        $kantor = Kantor::all();
        $transportasi = Transportasi::all();
        $penginapan = Penginapan::all();
        return view('keuangank/add', compact('kantor', 'transportasi', 'penginapan'));
    }

    public function edit($id)
    {
        $karyawan = Karyawan::all();
        $tipeLump = Tipe_lumpsum::all();
        $pn = Penginapan::all();
        $transportasi = Transportasi::all();
        $lokasii = Lokasi::all();
        $board = Fullboard::all();
        $itemss1 = Keuangan::select('keuangan.id', 'keuangan.hari', 'lokasi.besaran_lumpsum', 'keuangan.kantor_id', 'keuangan.tipe_penginapan_id', 'reff_tipe_lumpsum.jumlah', 'reff_tipe_lumpsum.tipe_lumpsum', 'lokasi.nama_kota', 'lokasi.besaran_lumpsum', 'keuangan.uang_transport', 'keuangan.uang_penginapan', 'keuangan.keterangan', 'kantor.tanggal_pergi', 'kantor.tanggal_pulang')
            ->join('kantor', 'keuangan.kantor_id', 'kantor.id')
            ->join('lokasi', 'lokasi.id', '=', 'keuangan.id_lokasi')
            ->join('reff_tipe_lumpsum', 'reff_tipe_lumpsum.id', '=', 'keuangan.tipe_penginapan_id')
            ->where('kantor_id', $id)
            ->get();

        $keuangan_tp = DB::table('keuangan_tp')
            ->join('keuangan', 'keuangan_tp.gabung_tp_id', '=', 'keuangan.id')
            ->select('keuangan_tp.*')
            ->where('gabung_tp_id', $id)
            ->get();

        $keuangan_pn = DB::table('keuangan_pn')
            ->join('keuangan', 'keuangan_pn.gabung_pn_id', '=', 'keuangan.id')
            ->select('keuangan_pn.*')
            ->where('gabung_pn_id', $id)
            ->get();

        $keuangankk = DB::table('keuangan')->find($id);
        return view('keuangank/edit', compact('tipeLump', 'itemss1', 'karyawan', 'keuangan_pn', 'keuangan_tp', 'transportasi', 'pn', 'lokasii', 'board'), ['keuangan' => $keuangankk]);
    }

    public function update(Request $request, $id)
    {
        $users_id = Auth::user()->id;

        // Perbaiki update untuk tabel keuangan_tp
        $affected1 = DB::table('keuangan_tp')
        ->where('gabung_tp_id', $id)
        ->update([
            'transport_id' => $request->transport_id,
            'uang' => $request->uang_transport, // Ubah nama input menjadi 'uang_transport'
        ]);


        // Perbaiki update untuk tabel keuangan_pn
        $affected2 = DB::table('keuangan_pn')
        ->where('gabung_pn_id', $id)
        ->update([
            'pn_id' => $request->penginapan_id,
            'uang' => $request->uang_penginapan, // Ubah nama input menjadi 'uang_penginapan'
        ]);

        $affected = DB::table('keuangan')
            ->where('id', $id)
            ->update([
                'users_id' => $users_id,
                'tipe_penginapan_id' => $request->tipe_penginapan_id,
                'keterangan' => $request->keterangan
            ]);

        Alert::success('Berhasil!', 'Data keuangan berhasil diupdate!');
        return redirect('/keuangank');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $users_id = Auth::user()->id;
        $request->validate([
            'kantor_id' => 'required',
            'tipe_penginapan_id' => 'required',
            'id_lokasi' => 'required',
            'kategori_up' => 'required',
            'keterangan' => 'required',
        ], [
            'kantor_id.required' => 'judul surat harus diisi!',
            'tipe_penginapan_id.required' => 'tipe penginapan surat harus diisi!',
            'id_lokasi.required' => 'lokasi surat harus diisi!',
            'kategori_up.required' => 'kategori uang ip harus diisi!',
            'keterangan.required' => 'keterangan penginapan harus diisi!',
        ]);

        $data = [
            'users_id' => $users_id,
            'kantor_id' => $request->kantor_id,
            'tipe_penginapan_id' => $request->tipe_penginapan_id,
            'id_lokasi' => $request->id_lokasi,
            'kategori_up' => $request->kategori_up,
            'keterangan' => $request->keterangan,
        ];

        $this->idKeuangan->addData($data);
        $id = $request->kantor_id;
        $keuangan = DB::getPdo()->lastInsertId();

        for ($i = 0; $i < count($request->uang); $i++) {
            $uang_tp = Keuangan_tp::create([
                'gabung_tp_id' => $keuangan,
                'uang' => Request()->uang[$i],
                'transport_id' => Request()->transport_id[$i],
            ]);
        }

        for ($j = 0; $j < count($request->uang1); $j++) {
            $uang_pn = Keuangan_pn::create([
                'gabung_pn_id' => $keuangan,
                'uang' => Request()->uang1[$j],
                'pn_id' => Request()->penginapan_id[$j],
            ]);
        }

        
        return redirect()->route('keuangank.show', $id);
    }

    public function saveSubjumlah($itemId, $subjumlah)
{
    // Ambil data keuangan dari database berdasarkan $itemId
    $keuangan = Keuangan::findOrFail($itemId);

    // Update kolom subjumlah dengan nilai $subjumlah yang diberikan
    $keuangan->subjumlah = $subjumlah;

    // Simpan perubahan ke database
    $keuangan->save();

    // Perbarui kolom 'sisa' pada tabel 'uangup' berdasarkan kategori_up
    $kategoriUp = $keuangan->kategori_up;

    // Ambil record terakhir yang sesuai dengan kategori_up
    $latestRecord = Uangup::where('id', $kategoriUp)->latest()->first();

    if ($latestRecord) {
        // Hitung nilai baru untuk 'sisa' setelah dikurangkan $subjumlah
        $sisaSetelahUpdate = max(0, $latestRecord->sisa - $subjumlah);

        // Pastikan bahwa notifikasi hanya muncul jika sisa kurang dari nol
        if ($sisaSetelahUpdate < 0) {
            // Notifikasi: Dana tersedia tidak mencukupi
            Alert::error('Gagal', 'Dana Tersedia Tidak Mencukupi');
            return redirect()->back();
        }

        // Tambahkan nilai subjumlah ke kolom pengeluaran pada record terakhir
        $latestRecord->pengeluaran += $subjumlah;

        // Simpan perubahan ke database
        $latestRecord->save();

        // Perbarui kolom 'sisa' menggunakan metode update
        Uangup::where('id', $latestRecord->id)->update(['sisa' => $sisaSetelahUpdate]);

        // Set sesi untuk menandakan bahwa tombol 'Cek' seharusnya disembunyikan
        session()->put('cekButtonHidden_' . $itemId, true);

        // Set sesi untuk menandakan bahwa tombol 'Edit' dan 'Hapus' harus disembunyikan
        session()->put('editHapusButtonHidden_' . $itemId, true);

        Alert::success('Berhasil', 'Data Keuangan Berhasil Ditambahkan');
        return redirect()->back();
    }
}


    public function cetak(Request $request, $id)
    {
        $today = Carbon::now()->isoFormat('D MMMM Y');
        $kantor = Kantor::all();
        $tipeLump = Tipe_lumpsum::all();
        $pn = Penginapan::all();
        $transportasi = Transportasi::all();
        $lokasii = Lokasi::all();
        $board = Fullboard::all();
        $karyawan = Karyawan::all();
        $item = Kantor::select('kantor.id', 'lokasi.nama_kota', 'kantor.judul_surat', 'kantor.tanggal_pergi', 'kantor.tanggal_pulang', 'kantor.lampiran_surat')
            ->join('lokasi', 'lokasi.id', '=', 'kantor.lokasi_id')
            ->join('users', 'users.id', '=', 'kantor.users_id')
            ->where('kantor.id', $id)->first();

        $jmlh_data = Karyawan_Kantor::select(DB::raw('kantor_id, count(id) as total'))
            ->groupby('kantor_id')
            ->where('kantor_id', $id)
            ->get();

        $itemUang = Tipe_lumpsum::select('reff_tipe_lumpsum.id', 'reff_tipe_lumpsum.tipe_lumpsum', 'keuangan.tipe_penginapan_id')
            ->join('keuangan', 'keuangan.tipe_penginapan_id', '=', 'reff_tipe_lumpsum.id')
            ->where('tipe_penginapan_id', $id)->first();

        $tangap = Keuangan::where('kantor_id', $id)->first();

        $date1 = $item->tanggal_pergi;
        $date2 = $item->tanggal_pulang;
        $date1Timestamp = strtotime($date1);
        $date2Timestamp = strtotime($date2);
        $difference = $date2Timestamp - $date1Timestamp;
        $days = date('d', $difference) - 1;

        $items = Keuangan::select('keuangan.id', 'keuangan.kantor_id', 'keuangan.tipe_penginapan_id', 'lokasi.besaran_lumpsum', 'keuangan.uang_transport')
            ->join('kantor', 'keuangan.kantor_id', 'kantor.id')
            ->join('lokasi', 'lokasi.id', '=', 'kantor.lokasi_id')->where('kantor.id', $id)
            ->join('reff_tipe_lumpsum', 'reff_tipe_lumpsum.id', '=', 'keuangan.tipe_penginapan_id')
            ->where('kantor_id', $id)->first();

        $itemss = Keuangan::select('keuangan.id', 'keuangan.hari', 'keuangan_tp.uang', 'keuangan_tp.transport_id', 'lokasi.besaran_lumpsum', 'keuangan.kantor_id', 'keuangan.tipe_penginapan_id', 'reff_tipe_lumpsum.jumlah', 'reff_tipe_lumpsum.tipe_lumpsum', 'lokasi.nama_kota', 'lokasi.besaran_lumpsum', 'keuangan.uang_transport', 'keuangan.uang_penginapan', 'keuangan.keterangan')
            ->join('kantor', 'keuangan.kantor_id', 'kantor.id')
            ->join('lokasi', 'lokasi.id', '=', 'keuangan.id_lokasi')
            ->join('reff_tipe_lumpsum', 'reff_tipe_lumpsum.id', '=', 'keuangan.tipe_penginapan_id')
            ->join('keuangan_tp', 'keuangan_tp.gabung_tp_id', '=', 'keuangan.id')
            ->where('kantor_id', $id)
            ->get();

        $itemss1 = Keuangan::select('keuangan.id', 'keuangan.hari', 'lokasi.besaran_lumpsum', 'keuangan.kantor_id', 'keuangan.tipe_penginapan_id', 'reff_tipe_lumpsum.jumlah', 'reff_tipe_lumpsum.tipe_lumpsum', 'lokasi.nama_kota', 'lokasi.besaran_lumpsum', 'keuangan.uang_transport', 'keuangan.uang_penginapan', 'keuangan.keterangan', 'kantor.tanggal_pergi', 'kantor.tanggal_pulang')
            ->join('kantor', 'keuangan.kantor_id', 'kantor.id')
            ->join('lokasi', 'lokasi.id', '=', 'keuangan.id_lokasi')
            ->join('reff_tipe_lumpsum', 'reff_tipe_lumpsum.id', '=', 'keuangan.tipe_penginapan_id')
            ->where('kantor_id', $id)
            ->get();

        $uang = Keuangan::all();
        $uang_tp = Keuangan_tp::select('Keuangan_tp.id', 'Keuangan_tp.uang', 'Keuangan_tp.transport_id', 'transportasi.jenis_transportasi')
            ->join('transportasi', 'transportasi.id', '=', 'keuangan_tp.transport_id')
            ->get();

        $uang_pn = Keuangan_pn::select('Keuangan_pn.id', 'Keuangan_pn.uang', 'Keuangan_pn.pn_id', 'penginapan.nama_penginapan')
            ->join('penginapan', 'penginapan.id', '=', 'Keuangan_pn.pn_id')
            ->get();

        $itemssss = Karyawan_Kantor::select('karyawan_kantor.id', 'karyawan_kantor.kantor_id', 'karyawan_kantor.karyawan_id', 'karyawan.nama', 'karyawan.jabatan', 'karyawan.nip')
            ->join('kantor', 'kantor.id', '=', 'karyawan_kantor.kantor_id')
            ->join('karyawan', 'karyawan.id', '=', 'karyawan_kantor.karyawan_id')
            ->where('kantor_id', $request->id)
            ->get();

        $karyawan = Karyawan::all();
        $jabatan = Jabatan::all();
        $penandatangan = Penandatangan::all();

        $bpp = Penandatangan::select('penandatangan.id', 'penandatangan.karyawan_id', 'penandatangan.jabatan_id', 'karyawan.nama', 'karyawan.nip')
            ->join('karyawan', 'karyawan.id', '=', 'penandatangan.karyawan_id')
            ->where('penandatangan.id', 1)
            ->get();

        $ppk = Penandatangan::select('penandatangan.id', 'penandatangan.karyawan_id', 'penandatangan.jabatan_id', 'karyawan.nama', 'karyawan.nip')
            ->join('karyawan', 'karyawan.id', '=', 'penandatangan.karyawan_id')
            ->where('penandatangan.id', 2)
            ->get();

        $bp = Penandatangan::select('penandatangan.id', 'penandatangan.karyawan_id', 'penandatangan.jabatan_id', 'karyawan.nama', 'karyawan.nip')
            ->join('karyawan', 'karyawan.id', '=', 'penandatangan.karyawan_id')
            ->where('penandatangan.id', 3)
            ->get();

        $pdf = PDF::loadview('/keuangank/cetak_suratk', ['kantor' => $kantor], compact('today','item', 'itemssss', 'uang', 'board', 'uang_tp', 'uang_pn', 'lokasii', 'itemUang', 'tangap', 'pn', 'tipeLump', 'items', 'itemss', 'itemss1', 'days', 'kantor', 'transportasi', 'jmlh_data', 'bpp', 'ppk', 'bp'));
        return $pdf->stream();
    }

    public function generatePDF(Request $request)
{
    $search = $request->input('search');

    // Ambil semua data kategori UP
    $uangupQuery = Uangup::query();

    // Jika pencarian tidak dilakukan atau string pencarian kosong, ambil semua data
    if (!$search || empty($search)) {
        $uangup = $uangupQuery->get();
    } else {
        // Jika ada pencarian, filter berdasarkan kategori UP
        $uangup = $uangupQuery->where('kategori_up', '=', $search)->get();
    }

    $items = Kantor::select(
            'kantor.id',
            'uangup.kategori_up',
            'lokasi.nama_kota',
            'kantor.judul_surat',
            'kantor.tanggal_pergi',
            'kantor.tanggal_pulang',
            'kantor.lampiran_surat',
            'kantor.status_keuangan',
            'keuangan.subjumlah'
        )
        ->join('users', 'users.id', '=', 'kantor.users_id')
        ->leftJoin('lokasi', 'lokasi.id', '=', 'kantor.lokasi_id')
        ->leftJoin('keuangan', 'keuangan.kantor_id', '=', 'kantor.id')
        ->leftJoin('uangup', 'uangup.id', '=', 'keuangan.kategori_up')
        ->with('uangup')
        ->where('keuangan.subjumlah', '!=', 0);

    // Terapkan filter jika pencarian tidak kosong
    if (!empty($search)) {
        $items->where('uangup.kategori_up', '=', $search);
    }

    $items = $items->get();

    // Hitung total pengeluaran kantor untuk setiap kategori UP yang ditemukan
    $totalPengeluaranKantor = [];
    foreach ($uangup as $up) {
        // Hitung total pengeluaran kantor untuk kategori UP saat ini
        $totalPengeluaran = $items->where('kategori_up', $up->kategori_up)->sum('subjumlah');
        $totalPengeluaranKantor[$up->kategori_up] = $totalPengeluaran;
    }

    // Load view PDF
    $pdf = \PDF::loadView('keuangank.keuangankpdf', compact('uangup', 'items', 'search', 'totalPengeluaranKantor'));

    // Download PDF dengan nama laporan_keuangan.pdf
    return $pdf->download('laporan_keuangan.pdf');
}



    public function destroy($id)
    {
        $keuangan_tp = DB::table('keuangan_tp')
            ->join('keuangan', 'keuangan_tp.gabung_tp_id', '=', 'keuangan.id')
            ->select('keuangan_tp.*')
            ->where('gabung_tp_id', $id)
            ->get();

        for ($i = 0; $i < count($keuangan_tp); $i++) {
            DB::table('keuangan_tp')
                ->join('keuangan', 'keuangan_tp.gabung_tp_id', '=', 'keuangan.id')
                ->select('keuangan_tp.*')
                ->where('gabung_tp_id', $id)
                ->delete();
        }

        $keuangan_pn = DB::table('keuangan_pn')
            ->join('keuangan', 'keuangan_pn.gabung_pn_id', '=', 'keuangan.id')
            ->select('keuangan_pn.*')
            ->where('gabung_pn_id', $id)
            ->get();

        for ($i = 0; $i < count($keuangan_pn); $i++) {
            DB::table('keuangan_pn')
                ->join('keuangan', 'keuangan_pn.gabung_pn_id', '=', 'keuangan.id')
                ->select('keuangan_pn.*')
                ->where('gabung_pn_id', $id)
                ->delete();
        }
        $kantor = DB::table('kantor')->find($id);

        DB::table('keuangan')->where('id', $id)->delete();
        Alert::success('Berhasil!', 'Data keuangan berhasil dihapus!');
        return redirect('keuangank');
    }

    public function updatestatus(Request $request, $id)
    {
        $terima = DB::table('kantor')
            ->where('id', $id)
            ->update([
                'status_keuangan' => "Terima",
            ]);

        Alert::success('Berhasil', 'Data keuangan telah diarsipkan');
        return redirect('/keuangank/riwayat');
    }

}
