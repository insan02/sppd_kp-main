<?php

namespace App\Http\Controllers;

use Carbon;
use Session;
use App\Models\User;
use App\Models\Kantor;
use App\Models\Lokasi;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Imports\KantorImport;
use App\Models\Karyawan_Kantor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controllers;
use App\Imports\KKantorImport;
use App\resources\views\kantor\Kantor1;
use RealRashid\SweetAlert\Facades\Alert;


class KantorController extends Controller
{

    public function __construct()
    {
        $this->Kantor = new Kantor();
    }

    public function index()
    {
        $kantors = Kantor::select('kantor.id', 'lokasi.nama_kota', 'users.role_user', 'kantor.judul_surat', 'kantor.tanggal_pergi', 'kantor.tanggal_pulang', 'kantor.lampiran_surat')
            ->join('lokasi', 'lokasi.id', '=', 'kantor.lokasi_id')
            ->join('users', 'users.id', '=', 'kantor.users_id')
            ->get();
        return view('kantor/index', compact('kantors'));
    }

    public function add()
    {
        $lokasi = Lokasi::all();
        $users = User::all();
        $karyawan = Karyawan::all();
        return view('kantor/add_kantor', compact('lokasi', 'users', 'karyawan'));
    }

    public function insert(Request $request)
    {
        $users_id = Auth::user()->id;
        $request->validate([
            'lokasi_id' => 'required',
            'judul_surat' => 'required',
            'tanggal_pergi' => 'required',
            'tanggal_pulang' => 'required',
            'lampiran_surat' => 'required | mimes:doc,docx,pdf,xls,xlsx | max:500',
        ], [
            'lokasi_id.required' => 'lokasi harus diisi!',
            'karyawan_id.required' => 'karyawan harus diisi!',
            'judul_surat.required' => 'judul surat harus diisi!',
            'tanggal_pergi.required' => 'tanggal pergi harus diisi!',
            'tanggal_pulang.required' => 'tanggal pulang harus diisi!',
            'lampiran_surat.required' => 'lampiran surat harus diisi!',
        ]);

        $file = Request()->lampiran_surat;
        $fileName = Request()->judul_surat . '.' . $file->extension();
        $file->move(public_path('lampiran_surat'), $fileName);

        $data = [
            'users_id' => $users_id,
            'lokasi_id' => Request()->lokasi_id,
            'judul_surat' => Request()->judul_surat,
            'tanggal_pergi' => Request()->tanggal_pergi,
            'tanggal_pulang' => Request()->tanggal_pulang,
            'lampiran_surat' => $fileName,
        ];
        $this->Kantor->addData($data);

        $kantor = DB::getPdo()->lastInsertId();
        for ($i = 0; $i < count($request->karyawan_id); $i++) {
            $karyawan_kantor = Karyawan_Kantor::create([
                'kantor_id' => $kantor,
                'karyawan_id' => Request()->karyawan_id[$i],
            ]);
        }
        Alert::success('Berhasil!', 'Data undangan berhasil disimpan!');
        return redirect()->route('kantor');
    }

    public function destroy($id)
    {
        DB::table('kantor')->where('id', $id)->delete();
        Alert::success('Berhasil!', 'Data undangan berhasil dihapus!');
        return redirect('kantor');
    }

    public function edit($id)
    {
        $lokasi = Lokasi::all();
        $users = User::all();
        $karyawan = Karyawan::all();
        $kantor = DB::table('kantor')->find($id);
        $karyawan_kantor = Karyawan_Kantor::select('karyawan_kantor.id', 'karyawan_kantor.kantor_id','karyawan.nama')
            ->join('karyawan', 'karyawan.id', '=', 'karyawan_kantor.karyawan_id')
            ->join('kantor', 'kantor.id', '=', 'karyawan_kantor.kantor_id')
            ->where('kantor_id', $id)
            ->get();

        return view('kantor/edit_kantor', compact('lokasi', 'users', 'karyawan', 'karyawan_kantor'), ['kantor' => $kantor]);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function import_excel(Request $request)
    {
        // validasi
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        // menangkap file excel
        $file = $request->file('file');

        // membuat nama file unik
        $nama_file = rand() . $file->getClientOriginalName();

        // upload ke folder file_kantor di dalam folder public
        $file->move('file_kantor', $nama_file);

        // import data
        Excel::import(new KKantorImport, public_path('/file_kantor/' . $nama_file));

        // notifikasi dengan session
        Session::flash('sukses', 'Data Kantor Berhasil Diimport!');

        // alihkan halaman kembali
        return redirect('/kantor');
    }

    public function update(Request $request, $id)
    {
        $users_id = Auth::user()->id;
        if (Request()->lampiran_surat <> "") {
            $file = Request()->lampiran_surat;
            $fileName = Request()->judul_surat . '.' . $file->extension();
            $file->move(public_path('lampiran_surat'), $fileName);

            $kantor = DB::getPdo()->lastInsertId();
            for ($i = 0; $i < count($request->karyawan_id); $i++) {
                $karyawan_kantor = Karyawan_Kantor::create([
                    'kantor_id' => $kantor,
                    'karyawan_id' => Request()->karyawan_id[$i],
                ]);
            }

            $affected = DB::table('kantor')
                ->where('id', $id)
                ->update([
                    'users_id' => $users_id,
                    'lokasi_id' => $request->lokasi_id,
                    'judul_surat' => $request->judul_surat,
                    'tanggal_pergi' => $request->tanggal_pergi,
                    'tanggal_pulang' => $request->tanggal_pulang,
                    'lampiran_surat' => $fileName
                ]);

            Alert::success('Berhasil!', 'Data surat berhasil diupdate!');
        } else {
            $affected = DB::table('kantor')
                ->where('id', $id)
                ->update([
                    'users_id' => $users_id,
                    'lokasi_id' => $request->lokasi_id,
                    'judul_surat' => $request->judul_surat,
                    'tanggal_pergi' => $request->tanggal_pergi,
                    'tanggal_pulang' => $request->tanggal_pulang
                ]);

            Alert::success('Berhasil!', 'Data surat berhasil diupdate!');
        }

        return redirect('/kantor');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
}
