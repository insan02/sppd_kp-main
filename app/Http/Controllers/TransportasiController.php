<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transportasi;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class TransportasiController extends Controller
{
    public function __construct()
    {
        $this->Transportasi = new Transportasi();
    }

    public function index()
    {
        $data = [
            'transportasi' => $this->Transportasi->allData(),

        ];
        return view('transportasi/index', $data);
    }

    public function add()
    {
        return view('transportasi/add_transportasi');
    }

    public function insert()
    {
        Request()->validate([
            'jenis_transportasi' => 'required',
        ], [
            'jenis_transportasi.required' => 'jenis transportasi harus diisi!',
        ]);

        $data = [
            'jenis_transportasi' => Request()->jenis_transportasi,
        ];

        $this->Transportasi->addData($data);
        Alert::success('Berhasil!', 'Data transportasi berhasil disimpan!');
        return redirect()->route('transportasi');
    }

    public function destroy($id)
    {
        DB::table('transportasi')->where('id', $id)->delete();
        Alert::success('Berhasil!', 'Data transportasi berhasil dihapus!');
        return redirect('transportasi');
    }

    public function edit($id)
    {
        $transportasi = DB::table('transportasi')->find($id);
        return view('transportasi/edit_transportasi', ['transportasi' => $transportasi]);
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
        $affected = DB::table('transportasi')
            ->where('id', $id)
            ->update(['jenis_transportasi' => $request->jenis_transportasi]);

        Alert::success('Berhasil!', 'Data transportasi berhasil diupdate!');
        return redirect('/transportasi');
    }
}
