<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;
use App\Models\Penandatangan;
use App\Models\Karyawan;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class PenandatanganController extends Controller
{
    public function __construct()
    {
        $this->Penandatangan = new Penandatangan();
    }

    public function index()
    {
        $jabatan = Jabatan::all();
        $karyawan = Karyawan::all();

        $data = Penandatangan::select('penandatangan.id', 'jabatan.nama_jabatan', 'karyawan.nama')
            ->join('jabatan', 'jabatan.id', '=', 'penandatangan.jabatan_id')
            ->join('karyawan', 'karyawan.id', '=', 'penandatangan.karyawan_id')
            ->get();

        return view('penandatangan/index', compact('jabatan', 'karyawan'), ['data' => $data]);
    }

    public function add()
    {
        $karyawan = Karyawan::all();
        $jabatan = Jabatan::all();
        return view('penandatangan/add_penandatangan', compact('karyawan', 'jabatan'));
    }

    public function insert(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required',
            'jabatan_id' => 'required',
        ], [
            'karyawan_id.required' => 'karyawan harus diisi!',
            'jabatan_id.required' => 'jabatan harus diisi!',
        ]);

        $data = [
            'karyawan_id' => request()->karyawan_id,
            'jabatan_id' => request()->jabatan_id,
        ];

        $this->Penandatangan->addData($data);
        Alert::success('Berhasil!', 'Data penanda tangan berhasil disimpan!');
        return redirect()->route('penandatangan');
    }
    public function destroy($id)
    {
        DB::table('penandatangan')->where('id', $id)->delete();
        Alert::success('Berhasil!', 'Data penanda tangan berhasil dihapus!');
        return redirect('penandatangan');
    }

    public function edit($id)
    {
        $jabatan = Jabatan::all();
        $karyawan = Karyawan::all();
        $penandatangan = DB::table('penandatangan')->find($id);
        return view('penandatangan/edit_penandatangan', compact('jabatan', 'karyawan'), ['penandatangan' => $penandatangan]);
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
        $affected = DB::table('penandatangan')
            ->where('id', $id)
            ->update(['karyawan_id' => $request->karyawan_id]);

        Alert::success('Berhasil!', 'Data penanda tangan berhasil diupdate!');
        return redirect('/penandatangan');
    }
}
