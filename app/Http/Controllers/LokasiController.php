<?php

namespace App\Http\Controllers;

use Session;
use App\Imports\LokasiImport;
use Illuminate\Http\Request;
use App\Models\Lokasi;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;

class LokasiController extends Controller
{
    public $Lokasi;
    public function __construct()
    {
        $this->Lokasi = new Lokasi();
    }

    public function index()
    {
        $data = [
            'lokasi' => $this->Lokasi->allData(),

        ];
        return view('lokasi/index', $data);
    }

    public function add()
    {
        return view('lokasi/add_lokasi');
    }

    public function insert()
    {
        Request()->validate([
            'Provinsi' => 'required',
            'nama_kota' => 'required',
            'besaran_lumpsum' => 'required',
        ], [
            'Provinsi.required' => 'nama provinsi harus diisi!',
            'nama_kota.required' => 'nama kota harus diisi!',
            'besaran_lumpsum.required' => 'besaran lumpsum harus diisi!',
        ]);

        $data = [
            'Provinsi' => Request()->Provinsi,
            'nama_kota' => Request()->nama_kota,
            'besaran_lumpsum' => Request()->besaran_lumpsum,
        ];

        $this->Lokasi->addData($data);
        Alert::success('Berhasil!', 'Data lokasi berhasil disimpan!');
        return redirect()->route('lokasi');
    }

    public function destroy($id)
    {
        DB::table('lokasi')->where('id', $id)->delete();
        Alert::success('Berhasil!', 'Data lokasi berhasil dihapus!');
        return redirect('lokasi');
    }

    public function edit($id)
    {
        $lokasi = DB::table('lokasi')->find($id);
        return view('lokasi/edit_lokasi', ['lokasi' => $lokasi]);
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
        $affected = DB::table('lokasi')
            ->where('id', $id)
            ->update([
                'Provinsi' => $request->Provinsi,
                'nama_kota' => $request->nama_kota,
                'besaran_lumpsum' => $request->besaran_lumpsum
            ]);

        Alert::success('Berhasil!', 'Data lokasi berhasil diupdate!');
        return redirect('/lokasi');
    }

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
        $file->move('file_lokasi', $nama_file);

        // import data
        Excel::import(new LokasiImport, public_path('/file_lokasi/' . $nama_file));

        // notifikasi dengan session
        Session::flash('sukses', 'Data Lokasi Berhasil Diimport!');

        // alihkan halaman kembali
        return redirect('/lokasi');
    }
}
