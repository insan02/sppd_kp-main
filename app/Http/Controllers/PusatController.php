<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pusat;
use App\Models\Lokasi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Models\Disposisi;
use App\Models\Karyawan;
use App\Models\Karyawan_Disposisi;
use App\Models\Tanggapan;
use App\Models\Keuangan;
use App\Models\Kantor;
use App\Models\Karyawan_Kantor;
use App\Models\Tipe_lumpsum;
use App\Models\Keuangank;
use App\Models\Keuangan_tp;
use App\Models\Fullboard;
use App\Models\Keuangan_pn;
use App\Models\Kategori;
use App\Models\Jabatan;
use App\Models\Penandatangan;
use App\Models\Transportasi;
use App\Models\Penginapan;

class PusatController extends Controller
{
    public function __construct()
    {
        $this->Pusat = new Pusat();
    }

    public function index()
    {
        $data = [
            'pusat' => $this->Pusat->allData(),

        ];
        return view('pusat/index', $data);
    }

    public function terima()
    {
        $data = [
            'pusat' => $this->Pusat->allData(),

        ];
        return view('pusat/riwayatterima', $data);
    }

    public function add()
    {
        $lokasi = Lokasi::all();
        $users = User::all();
        return view('pusat/add_pusat', compact('lokasi', 'users'));
    }

    public function insert(Request $request)
    {
        $users_id = Auth::user()->id;
        $request->validate([
            'lokasi_id' => 'required',
            'no_surat' => 'required',
            'judul_surat' => 'required',
            'tanggal_pergi' => 'required',
            'tanggal_pulang' => 'required',
            'lampiran_undangan' => 'required | mimes:doc,docx,pdf,xls,xlxs | max:500',
        ], [
            'lokasi_id.required' => 'lokasi harus diisi!',
            'no_surat.required' => 'nomor surat harus diisi!',
            'judul_surat.required' => 'judul surat harus diisi!',
            'tanggal_pergi.required' => 'tanggal pergi harus diisi!',
            'tanggal_pulang.required' => 'tanggal pulang harus diisi!',
            'lampiran_undangan.required' => 'lampiran surat harus diisi!',
        ]);

        $file = Request()->lampiran_undangan;
        $fileName = Request()->no_surat . '.' . $file->extension();
        $file->move(public_path('lampiran_undangan'), $fileName);

        $data = [
            'users_id' => $users_id,
            'lokasi_id' => Request()->lokasi_id,
            'no_surat' => Request()->no_surat,
            'judul_surat' => Request()->judul_surat,
            'tanggal_pergi' => Request()->tanggal_pergi,
            'tanggal_pulang' => Request()->tanggal_pulang,
            'lampiran_undangan' => $fileName,
        ];

        $this->Pusat->addData($data);
        Alert::success('Berhasil!', 'Data undangan berhasil disimpan!');
        return redirect()->route('pusat');
    }
    public function destroy($id)
    {
        DB::table('pusat')->where('id', $id)->delete();
        Alert::success('Berhasil!', 'Data undangan berhasil dihapus!');
        return redirect('pusat');
    }

    public function edit($id)
    {
        $lokasi = Lokasi::all();
        $users = User::all();
        $pusat = DB::table('pusat')->find($id);
        return view('pusat/edit_pusat', compact('lokasi', 'users'), ['pusat' => $pusat]);
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
        $users_id = Auth::user()->id;
        if (Request()->lampiran_undangan <> "") {
            $file = Request()->lampiran_undangan;
            $fileName = Request()->no_surat . '.' . $file->extension();
            $file->move(public_path('lampiran_undangan'), $fileName);

            $affected = DB::table('pusat')
                ->where('id', $id)
                ->update([
                    'users_id' => $users_id,
                    'lokasi_id' => $request->lokasi_id,
                    'no_surat' => $request->no_surat,
                    'judul_surat' => $request->judul_surat,
                    'tanggal_pergi' => $request->tanggal_pergi,
                    'tanggal_pulang' => $request->tanggal_pulang,
                    'lampiran_undangan' => $fileName
                ]);

            Alert::success('Berhasil!', 'Data surat berhasil diupdate!');
        } else {
            $affected = DB::table('pusat')
                ->where('id', $id)
                ->update([
                    'users_id' => $users_id,
                    'lokasi_id' => $request->lokasi_id,
                    'no_surat' => $request->no_surat,
                    'judul_surat' => $request->judul_surat,
                    'tanggal_pergi' => $request->tanggal_pergi,
                    'tanggal_pulang' => $request->tanggal_pulang
                ]);

            Alert::success('Berhasil!', 'Data surat berhasil diupdate!');
        }

        // $status->update($data);    
        return redirect('/pusat');
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

        $itemss1 = Keuangan::select('keuangan.id', 'keuangan.hari', 'lokasi.besaran_lumpsum', 'keuangan.kantor_id', 'keuangan.tipe_penginapan_id', 'reff_tipe_lumpsum.jumlah', 'reff_tipe_lumpsum.tipe_lumpsum', 'lokasi.nama_kota', 'lokasi.besaran_lumpsum', 'keuangan.uang_transport', 'keuangan.uang_penginapan', 'keuangan.keterangan','pusat.id', 'pusat.tanggal_pergi', 'pusat.tanggal_pulang')
            ->join('pusat', 'pusat.id', '=', 'keuangan.pusat_id')
            ->join('lokasi', 'lokasi.id', '=', 'keuangan.id_lokasi')
            ->join('reff_tipe_lumpsum', 'reff_tipe_lumpsum.id', '=', 'keuangan.tipe_penginapan_id')
            ->where('pusat_id', $id)
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

        return view('pusat/detail',  compact(['pusat', 'item', 'itemm', 'item2', 'uang', 'board', 'uang_tp', 'uang_pn','itemss2' ,'lokasii', 'itemUang', 'tangap', 'pn', 'tipeLump', 'itemss1', 'tangap', 'pn', 'data', 'dataa', 'days', 'pusat', 'transportasi', 'jmlh_data', 'kategori']));
    }
}
