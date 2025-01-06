<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use App\Models\Kantor;
use App\Models\Karyawan;
use App\Models\Karyawan_Kantor;
use App\Models\Tipe_lumpsum;
use App\Models\Keuangank;
use App\Models\Keuangan_tp;
use App\Models\Lokasi;
use App\Models\Uangup;
use App\Models\Fullboard;
use App\Models\Keuangan_pn;
use App\Models\Kategori;
use App\Models\Pusat;
use App\Models\Jabatan;
use App\Models\Disposisi;
use App\Models\Karyawan_Disposisi;
use App\Models\Penandatangan;
use App\Models\Transportasi;
use App\Models\Penginapan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Arr;
use Carbon\Carbon;
use PDF;
use Dompdf\Dompdf;
use Dompdf\Options;




class KeuanganController extends Controller
{
    public $idKeuangan;

    public function __construct()
    {
        $this->idKeuangan = new Keuangan();
    }

    public function index()
    {
        $lokasi = Lokasi::all();
        $karyawan = Karyawan::all();
        $pusat = Karyawan::all();

        $items = Disposisi::select('disposisi.id', 'lokasi.nama_kota', 'pusat.no_surat', 'pusat.judul_surat', 'pusat.tanggal_pergi', 'pusat.tanggal_pulang', 'pusat.lampiran_undangan', 'pusat.status_disposisi', 'pusat.status_keuangan')
            ->join('pusat', 'pusat.id', '=', 'disposisi.pusat_id')
            ->leftjoin('lokasi', 'lokasi.id', '=', 'pusat.lokasi_id')
            ->get();


        $itemss = Karyawan_Disposisi::select('karyawan_disposisi.id', 'karyawan_disposisi.disposisi_id', 'karyawan_disposisi.karyawan_id', 'karyawan.nama')
            ->join('disposisi', 'disposisi.id', '=', 'karyawan_disposisi.disposisi_id')
            ->join('karyawan', 'karyawan.id', '=', 'karyawan_disposisi.karyawan_id')
            ->get();

        $pusat = Pusat::all();

        return view('keuangan/index', compact('lokasi', 'karyawan', 'pusat', 'itemss'), ['items' => $items]);
    }

    public function riwayat(Request $request)
{
    $lokasi = Lokasi::all();
    $karyawan = Karyawan::all();
    $pusat = Pusat::all();
    $search = $request->input('search');
    

    // Ambil semua data kategori UP
    $uangup = Uangup::all();

    $items = Disposisi::select('disposisi.id', 'uangup.kategori_up', 'lokasi.nama_kota', 'pusat.no_surat', 'pusat.judul_surat', 'pusat.tanggal_pergi', 'pusat.tanggal_pulang', 'pusat.lampiran_undangan', 'pusat.status_disposisi', 'pusat.status_keuangan', 'keuangan.subjumlah')
        ->join('pusat', 'pusat.id', '=', 'disposisi.pusat_id')
        ->leftJoin('lokasi', 'lokasi.id', '=', 'pusat.lokasi_id')
        ->leftJoin('keuangan', 'keuangan.disposisi_id', '=', 'disposisi.id')
        ->leftJoin('uangup', 'uangup.id', '=', 'keuangan.kategori_up');
    
    $itemss = Karyawan_Disposisi::select('karyawan_disposisi.id', 'karyawan_disposisi.disposisi_id', 'karyawan_disposisi.karyawan_id', 'karyawan.nama')
        ->join('disposisi', 'disposisi.id', '=', 'karyawan_disposisi.disposisi_id')
        ->join('karyawan', 'karyawan.id', '=', 'karyawan_disposisi.karyawan_id')
        ->get();

    // Terapkan filter jika pencarian tidak kosong
    if (!empty($search)) {
        $items->where('uangup.kategori_up', 'like', '%' . $search . '%');
    }

    $items = $items->get();

    // Ambil semua kategori UP dari tabel keuangan
    $kategoriUP = $items->pluck('kategori_up')->unique();

    // Inisialisasi array totalPengeluaranPusat dengan kategori UP yang mungkin
    $totalPengeluaranPusat = [];
    foreach ($kategoriUP as $up) {
        $totalPengeluaranPusat[$up] = 0;
    }

    foreach ($items as $item) {
        $totalPengeluaranPusat[$item->kategori_up] += $item->subjumlah;
    }


    // Lewatkan variabel ke view
    return view('keuangan.riwayatproses', compact('lokasi', 'totalPengeluaranPusat', 'karyawan', 'pusat', 'uangup', 'items', 'itemss', 'search'));
}



    public function show($id)
    {
        $kantor = Kantor::all();
        $tipeLump = Tipe_lumpsum::all();
        $pn = Penginapan::all();
        $transportasi = Transportasi::all();
        $lokasii = Lokasi::all();
        $board = Fullboard::all();
        $uangup = Uangup::all();
        $karyawan = Karyawan::all();
        $disposisi = Disposisi::all();

        $item2 = Pusat::select('pusat.id', 'lokasi.nama_kota', 'pusat.judul_surat', 'pusat.tanggal_pergi', 'pusat.tanggal_pulang', 'pusat.lampiran_undangan')
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

        $itemss1 = Keuangan::select('keuangan.id', 'keuangan.hari', 'lokasi.besaran_lumpsum', 'keuangan.kantor_id', 'keuangan.tipe_penginapan_id', 'reff_tipe_lumpsum.jumlah', 'reff_tipe_lumpsum.tipe_lumpsum', 'lokasi.nama_kota', 'uangup.kategori_up', 'lokasi.besaran_lumpsum', 'keuangan.uang_transport', 'keuangan.uang_penginapan', 'keuangan.keterangan', 'pusat.tanggal_pergi', 'pusat.tanggal_pulang')
            ->join('disposisi', 'keuangan.disposisi_id', '=', 'disposisi.id')
            ->join('pusat', 'pusat.id', '=', 'keuangan.pusat_id')
            ->join('lokasi', 'lokasi.id', '=', 'keuangan.id_lokasi')
            ->join('uangup', 'uangup.id', '=', 'keuangan.kategori_up') 
            ->join('reff_tipe_lumpsum', 'reff_tipe_lumpsum.id', '=', 'keuangan.tipe_penginapan_id')
            ->where('disposisi_id', $id)
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
            ->where('disposisi.id', $id)->first();


        $jmlh_data = Karyawan_Disposisi::select(DB::raw('disposisi_id, count(id) as total'))
            ->groupby('disposisi_id')
            ->where('disposisi_id', $id)
            ->get();

        $tangap = Keuangan::where('disposisi_id', $id)->first();

        $itemm = Disposisi::select('disposisi.id', 'pusat.lokasi_id', 'lokasi.nama_kota', 'pusat.no_surat', 'pusat.judul_surat', 'pusat.tanggal_pergi', 'pusat.tanggal_pulang', 'pusat.lampiran_undangan', 'pusat.status_disposisi')
            ->join('pusat', 'pusat.id', '=', 'disposisi.pusat_id')
            ->join('lokasi', 'lokasi.id', '=', 'pusat.lokasi_id')
            ->where('disposisi.id', $id)->first();

        $date1 = $item->tanggal_pergi;
        $date2 = $item->tanggal_pulang;
        $date1Timestamp = strtotime($date1);
        $date2Timestamp = strtotime($date2);
        $difference = $date2Timestamp - $date1Timestamp;
        $days = date('d', $difference) - 1;

        $data = Keuangan::select('keuangan.id', 'keuangan.disposisi_id', 'lokasi.besaran_lumpsum', 'keuangan.uang_transport', 'keuangan.uang_penginapan')
            ->join('disposisi', 'keuangan.disposisi_id', 'disposisi.id')
            ->join('pusat', 'pusat.id', '=', 'disposisi.pusat_id')
            ->join('lokasi', 'lokasi.id', '=', 'pusat.lokasi_id')
            ->where('disposisi_id', $id)->first();

        $dataa = Keuangan::select('keuangan.id', 'keuangan.disposisi_id', 'lokasi.besaran_lumpsum', 'keuangan.uang_transport', 'keuangan.uang_penginapan')
            ->join('disposisi', 'keuangan.disposisi_id', 'disposisi.id')
            ->join('pusat', 'pusat.id', '=', 'disposisi.pusat_id')
            ->join('lokasi', 'lokasi.id', '=', 'pusat.lokasi_id')
            ->where('disposisi_id', $id)
            ->get();

        return view('keuangan/show',  compact(['pusat', 'item', 'itemm', 'item2', 'uang', 'board', 'uang_tp', 'uang_pn', 'lokasii', 'itemUang', 'tangap', 'pn', 'tipeLump', 'itemss1', 'tangap', 'pn', 'data', 'dataa', 'days', 'pusat', 'transportasi', 'jmlh_data', 'kategori', 'uangup']));
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
        $disposisi = Disposisi::all();

        $item2 = Pusat::select('pusat.id', 'lokasi.nama_kota', 'pusat.judul_surat', 'pusat.tanggal_pergi', 'pusat.tanggal_pulang', 'pusat.lampiran_undangan')
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

        $itemss1 = Keuangan::select('keuangan.id', 'keuangan.hari', 'lokasi.besaran_lumpsum', 'keuangan.kantor_id', 'keuangan.tipe_penginapan_id', 'reff_tipe_lumpsum.jumlah', 'reff_tipe_lumpsum.tipe_lumpsum', 'lokasi.nama_kota', 'lokasi.besaran_lumpsum', 'keuangan.uang_transport', 'keuangan.uang_penginapan', 'keuangan.keterangan', 'pusat.tanggal_pergi', 'pusat.tanggal_pulang')
            ->join('disposisi', 'keuangan.disposisi_id', '=', 'disposisi.id')
            ->join('pusat', 'pusat.id', '=', 'keuangan.pusat_id')
            ->join('lokasi', 'lokasi.id', '=', 'keuangan.id_lokasi')
            ->join('reff_tipe_lumpsum', 'reff_tipe_lumpsum.id', '=', 'keuangan.tipe_penginapan_id')
            ->where('disposisi_id', $id)
            ->get();

        $uang = Keuangan::all();
        $uang_tp = Keuangan_tp::select('Keuangan_tp.id', 'Keuangan_tp.uang', 'Keuangan_tp.transport_id', 'transportasi.jenis_transportasi')
            ->join('transportasi', 'transportasi.id', '=', 'keuangan_tp.transport_id')
            ->get();

        $uang_pn = Keuangan_pn::select('Keuangan_pn.id', 'Keuangan_pn.uang', 'Keuangan_pn.pn_id', 'penginapan.nama_penginapan')
            ->join('penginapan', 'penginapan.id', '=', 'Keuangan_pn.pn_id')
            ->get();

        $lokasi = Lokasi::all();
        $uangup = Uangup::all();
        $karyawan = Karyawan::all();
        $pusat = Pusat::all();
        $pn = Penginapan::all();
        $transportasi = Transportasi::all();
        $kategori = Kategori::all();

        $item = Disposisi::select('disposisi.id', 'lokasi.nama_kota', 'uangup.kategori_up','pusat.no_surat', 'pusat.judul_surat', 'pusat.tanggal_pergi', 'pusat.tanggal_pulang', 'pusat.lampiran_undangan', 'pusat.status_disposisi')
            ->join('pusat', 'pusat.id', '=', 'disposisi.pusat_id')
            ->join('lokasi', 'lokasi.id', '=', 'pusat.lokasi_id')
            ->join('keuangan', 'keuangan.disposisi_id', '=', 'disposisi.id')
            ->join('uangup', 'uangup.id', '=', 'keuangan.kategori_up') 
            ->where('disposisi.id', $id)->first();

        $jmlh_data = Karyawan_Disposisi::select(DB::raw('disposisi_id, count(id) as total'))
            ->groupby('disposisi_id')
            ->where('disposisi_id', $id)
            ->get();

        $tangap = Keuangan::where('disposisi_id', $id)->first();

        $date1 = $item->tanggal_pergi;
        $date2 = $item->tanggal_pulang;
        $date1Timestamp = strtotime($date1);
        $date2Timestamp = strtotime($date2);
        $difference = $date2Timestamp - $date1Timestamp;
        $days = date('d', $difference) - 1;

        $data = Keuangan::select('keuangan.id', 'keuangan.disposisi_id', 'lokasi.besaran_lumpsum', 'keuangan.uang_transport', 'keuangan.uang_penginapan')
            ->join('disposisi', 'keuangan.disposisi_id', 'disposisi.id')
            ->join('pusat', 'pusat.id', '=', 'disposisi.pusat_id')
            ->join('lokasi', 'lokasi.id', '=', 'pusat.lokasi_id')
            ->where('disposisi_id', $id)->first();

        $dataa = Keuangan::select('keuangan.id', 'keuangan.disposisi_id', 'lokasi.besaran_lumpsum', 'keuangan.uang_transport', 'keuangan.uang_penginapan')
            ->join('disposisi', 'keuangan.disposisi_id', 'disposisi.id')
            ->join('pusat', 'pusat.id', '=', 'disposisi.pusat_id')
            ->join('lokasi', 'lokasi.id', '=', 'pusat.lokasi_id')
            ->where('disposisi_id', $id)
            ->get();

        return view('keuangan/show2',  compact(['pusat', 'item', 'item2', 'uang', 'uangup','board', 'uang_tp', 'uang_pn', 'lokasii', 'itemUang', 'tangap', 'pn', 'tipeLump', 'itemss1', 'tangap', 'pn', 'data', 'dataa', 'days', 'pusat', 'transportasi', 'jmlh_data', 'kategori']));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    $pusatid = Disposisi::select('pusat_id')
        ->where('id', $request->disposisi_id)
        ->first();
    
    $id = $pusatid->pusat_id;
    $users_id = Auth::user()->id;

    $request->validate([
        'disposisi_id' => 'required',
        'tipe_penginapan_id' => 'required',
        'id_lokasi' => 'required',
        'kategori_up' => 'required',
        'keterangan' => 'required',
    ], [
        'disposisi_id.required' => 'judul surat harus diisi!',
        'tipe_penginapan_id.required' => 'tipe penginapan surat harus diisi!',
        'id_lokasi.required' => 'lokasi surat harus diisi!',
        'kategori_up.required' => 'kategori uang ip harus diisi!',
        'keterangan.required' => 'keterangan penginapan harus diisi!',
    ]);

    
    // Save data to Keuangan model
    $data = [
        'users_id' => $users_id,
        'disposisi_id' => $request->disposisi_id,
        'pusat_id' => $id,
        'tipe_penginapan_id' => $request->tipe_penginapan_id,
        'id_lokasi' => $request->id_lokasi,
        'kategori_up' => $request->kategori_up,
        'keterangan' => $request->keterangan,
    ];

    $this->idKeuangan->addData($data);
    $keuangan = DB::getPdo()->lastInsertId();

    // Save data to Keuangan_tp model
    for ($i = 0; $i < count($request->uang); $i++) {
        Keuangan_tp::create([
            'gabung_tp_id' => $keuangan,
            'uang' => $request->uang[$i],
            'transport_id' => $request->transport_id[$i],
        ]);
    }

    // Save data to Keuangan_pn model
    for ($j = 0; $j < count($request->uang1); $j++) {
        Keuangan_pn::create([
            'gabung_pn_id' => $keuangan,
            'uang' => $request->uang1[$j],
            'pn_id' => $request->penginapan_id[$j],
        ]);
    }

    
    return redirect()->route('keuangan.show', $id);
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

        // Tambahkan kondisi untuk menampilkan notifikasi jika sisa kurang dari subjumlah
        if ($sisaSetelahUpdate < $subjumlah) {

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

        //Set sesi untuk menandakan bahwa tombol 'Edit' dan 'Hapus' harus disembunyikan
        session()->put('editHapusButtonHidden_' . $itemId, true);

        Alert::success('Berhasil', 'Data Keuangan Berhasil Ditambahkan');
        return redirect()->back();
    }
}



    public function store2(Request $request)
    {
        DB::table('pusat')->where('id', $request->pusat_id)->update([
            'status_disposisi' => $request->status_disposisi,
        ]);

        if ($request->status_disposisi == 'Terima') {
            $users_id = Auth::user()->id;
            $request->validate([
                'pusat_id' => 'required',
            ], [
                'pusat_id.required' => 'lokasi harus diisi!',
                'karyawan_id.required' => 'karyawan harus diisi!',
            ]);

            $data = [
                'users_id' => $users_id,
                'pusat_id' => Request()->pusat_id,
            ];
            $this->Disposisi->addData($data);

            $disposisi = DB::getPdo()->lastInsertId();
            for ($i = 0; $i < count($request->karyawan_id); $i++) {
                $karyawan_disposisi = Karyawan_Disposisi::create([
                    'disposisi_id' => $disposisi,
                    'karyawan_id' => Request()->karyawan_id[$i],
                ]);
            }
        }
        Alert::success('Berhasil', 'Disposisi berhasil ditanggapi');
        return redirect('/disposisi');
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

        return redirect('keuangan');
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
        $disposisi = Disposisi::all();

        $item2 = Pusat::select('pusat.id', 'lokasi.nama_kota', 'pusat.judul_surat', 'pusat.tanggal_pergi', 'pusat.tanggal_pulang', 'pusat.lampiran_undangan')
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

        $itemss1 = Keuangan::select('keuangan.id', 'keuangan.hari', 'lokasi.besaran_lumpsum','keuangan.kantor_id', 'keuangan.tipe_penginapan_id', 'reff_tipe_lumpsum.jumlah', 'reff_tipe_lumpsum.tipe_lumpsum', 'lokasi.nama_kota', 'lokasi.besaran_lumpsum', 'keuangan.uang_transport', 'keuangan.uang_penginapan', 'keuangan.keterangan', 'pusat.tanggal_pergi', 'pusat.tanggal_pulang')
            ->join('disposisi', 'keuangan.disposisi_id', '=', 'disposisi.id')
            ->join('pusat', 'pusat.id', '=', 'keuangan.pusat_id')
            ->join('lokasi', 'lokasi.id', '=', 'keuangan.id_lokasi')
            ->join('reff_tipe_lumpsum', 'reff_tipe_lumpsum.id', '=', 'keuangan.tipe_penginapan_id')
            ->where('disposisi_id', $id)
            ->get();

        $itemss = Karyawan_Disposisi::select('karyawan_disposisi.id', 'karyawan_disposisi.disposisi_id', 'karyawan_disposisi.karyawan_id', 'karyawan.nama', 'karyawan.jabatan', 'karyawan.nip')
            ->join('disposisi', 'disposisi.id', '=', 'karyawan_disposisi.disposisi_id')
            ->join('karyawan', 'karyawan.id', '=', 'karyawan_disposisi.karyawan_id')
            ->where('disposisi_id', $request->id)
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
            ->where('disposisi.id', $id)->first();

        $itemss123 = Karyawan_Disposisi::select('karyawan_disposisi.id', 'karyawan_disposisi.disposisi_id', 'karyawan_disposisi.karyawan_id', 'karyawan.nama', 'karyawan.nip')
            ->join('disposisi', 'disposisi.id', '=', 'karyawan_disposisi.disposisi_id')
            ->join('karyawan', 'karyawan.id', '=', 'karyawan_disposisi.karyawan_id')
            ->get();

        $jmlh_data = Karyawan_Disposisi::select(DB::raw('disposisi_id, count(id) as total'))
            ->groupby('disposisi_id')
            ->where('disposisi_id', $id)
            ->get();

        $tangap = Keuangan::where('disposisi_id', $id)->first();

        $date1 = $item->tanggal_pergi;
        $date2 = $item->tanggal_pulang;
        $date1Timestamp = strtotime($date1);
        $date2Timestamp = strtotime($date2);
        $difference = $date2Timestamp - $date1Timestamp;
        $days = date('d', $difference) - 1;

        $data = Keuangan::select('keuangan.id', 'keuangan.disposisi_id', 'lokasi.besaran_lumpsum', 'keuangan.uang_transport', 'keuangan.uang_penginapan')
            ->join('disposisi', 'keuangan.disposisi_id', 'disposisi.id')
            ->join('pusat', 'pusat.id', '=', 'disposisi.pusat_id')
            ->join('lokasi', 'lokasi.id', '=', 'pusat.lokasi_id')
            ->where('disposisi_id', $id)->first();

        $dataa = Keuangan::select('keuangan.id', 'keuangan.disposisi_id', 'lokasi.besaran_lumpsum', 'keuangan.uang_transport', 'keuangan.uang_penginapan')
            ->join('disposisi', 'keuangan.disposisi_id', 'disposisi.id')
            ->join('pusat', 'pusat.id', '=', 'disposisi.pusat_id')
            ->join('lokasi', 'lokasi.id', '=', 'pusat.lokasi_id')
            ->where('disposisi_id', $id)
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

        $pdf = PDF::loadview('/keuangan/cetak_suratp', ['disposisi' => $disposisi], compact('today', 'itemss123', 'pusat', 'item', 'itemss', 'item2', 'uang', 'board', 'uang_tp', 'uang_pn', 'lokasii', 'itemUang', 'tangap', 'pn', 'tipeLump', 'itemss1', 'tangap', 'pn', 'data', 'dataa', 'days', 'pusat', 'transportasi', 'jmlh_data', 'kategori', 'bpp', 'ppk', 'bp'));
        return $pdf->stream();
    }

    public function generatePDF(Request $request)
{
    // Ambil nilai pencarian dari request
    $search = $request->input('search');

    // Query untuk mengambil data kategori UP
    $uangupQuery = Uangup::query();

    // Jika pencarian tidak dilakukan atau string pencarian kosong, ambil semua data
    if (!$search || empty($search)) {
        $uangup = $uangupQuery->get();
    } else {
        // Jika ada pencarian, filter berdasarkan kategori UP
        $uangup = $uangupQuery->where('kategori_up', '=', $search)->get();
    }

    // Query untuk mengambil data rincian pengeluaran dana
    $itemsQuery = Disposisi::select('disposisi.id', 'uangup.kategori_up', 'lokasi.nama_kota', 'pusat.no_surat', 'pusat.judul_surat', 'pusat.tanggal_pergi', 'pusat.tanggal_pulang', 'pusat.lampiran_undangan', 'pusat.status_disposisi', 'pusat.status_keuangan', 'keuangan.subjumlah')
        ->join('pusat', 'pusat.id', '=', 'disposisi.pusat_id')
        ->leftJoin('lokasi', 'lokasi.id', '=', 'pusat.lokasi_id')
        ->leftJoin('keuangan', 'keuangan.disposisi_id', '=', 'disposisi.id')
        ->leftJoin('uangup', 'uangup.id', '=', 'keuangan.kategori_up')
        ->where('keuangan.subjumlah', '!=', 0); // Filter subjumlah tidak sama dengan nol

    // Jika pencarian tidak dilakukan atau string pencarian kosong, ambil semua data
    if (!empty($search)) {
        $itemsQuery->where('uangup.kategori_up', '=', $search); // Filter berdasarkan pencarian
    }

    // Ambil hasil query
    $items = $itemsQuery->get();

    // Hitung total pengeluaran pusat untuk setiap kategori UP yang ditemukan
    $totalPengeluaranPusat = [];
    foreach ($uangup as $up) {
        // Hitung total pengeluaran pusat untuk kategori UP saat ini
        $totalPengeluaran = $items->where('kategori_up', $up->kategori_up)->sum('subjumlah');
        $totalPengeluaranPusat[$up->kategori_up] = $totalPengeluaran;
    }

    // Load view PDF
    $pdf = \PDF::loadView('keuangan.keuanganpdf', compact('uangup', 'items', 'search', 'totalPengeluaranPusat'));

    // Download PDF dengan nama laporan_keuangan.pdf
    return $pdf->download('laporan_keuangan.pdf');
}




    public function edit($id)
    {
        $karyawan = Karyawan::all();
        $tipeLump = Tipe_lumpsum::all();
        $pn = Penginapan::all();
        $transportasi = Transportasi::all();
        $lokasii = Lokasi::all();
        $uangup = Uangup::all();
        $board = Fullboard::all();
        $itemss1 = Keuangan::select('keuangan.id', 'keuangan.hari', 'lokasi.besaran_lumpsum', 'keuangan.kantor_id', 'keuangan.tipe_penginapan_id', 'reff_tipe_lumpsum.jumlah', 'reff_tipe_lumpsum.tipe_lumpsum', 'lokasi.nama_kota', 'lokasi.besaran_lumpsum', 'keuangan.uang_transport', 'keuangan.uang_penginapan', 'keuangan.keterangan', 'pusat.tanggal_pergi', 'pusat.tanggal_pulang')
            ->join('disposisi', 'keuangan.disposisi_id', '=', 'disposisi.id')
            ->join('pusat', 'pusat.id', '=', 'keuangan.pusat_id')
            ->join('lokasi', 'lokasi.id', '=', 'keuangan.id_lokasi')
            ->join('reff_tipe_lumpsum', 'reff_tipe_lumpsum.id', '=', 'keuangan.tipe_penginapan_id')
            ->where('disposisi_id', $id)
            ->get();
        $keuangankk = DB::table('keuangan')->find($id);
        $uang_tp = Keuangan_tp::select('Keuangan_tp.id', 'Keuangan_tp.uang', 'Keuangan_tp.transport_id', 'transportasi.jenis_transportasi')
            ->join('transportasi', 'transportasi.id', '=', 'keuangan_tp.transport_id')
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

        return view('keuangan/edit', compact('tipeLump', 'itemss1', 'karyawan', 'transportasi', 'pn', 'lokasii', 'uangup', 'board', 'keuangan_tp', 'keuangan_pn', 'uang_tp'), ['keuangan' => $keuangankk]);
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
    

    // Perbaiki update untuk tabel keuangan
    $affected = DB::table('keuangan')
        ->where('id', $id)
        ->update([
            'users_id' => $users_id,
            'tipe_penginapan_id' => $request->tipe_penginapan_id,
            'keterangan' => $request->keterangan,
            // Tambahkan kolom-kolom lain yang perlu diperbarui
        ]);

    // Tambahkan validasi data atau penanganan error jika diperlukan

    Alert::success('Berhasil!', 'Data keuangan berhasil diupdate!');
    return redirect('/keuangan');
}



    public function updatestatus(Request $request,$id)
    {
        $pusatid = Disposisi::select('pusat_id')
            ->where('id', $id)
            ->first();
        $id2 = $pusatid->pusat_id;

        Pusat::where('pusat.id', $id2)
            ->update(['status_keuangan' =>  "Terima"]);

        Alert::success('Berhasil', 'Data keuangan telah diarsipkan');
        return redirect()->route('keuangan.riwayat');;
    }
}
