<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jabatan;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class JabatanController extends Controller
{
    public function __construct()
    {
        $this->Jabatan = new Jabatan();
    }

    public function index()
    {
        $data = [
            'jabatan' => $this->Jabatan->allData(),

        ];
        return view('jabatan/index', $data);
    }

    public function add()
    {
        return view('jabatan/add_jabatan');
    }

    public function insert()
    {
        Request()->validate([
            'nama_jabatan' => 'required',
        ], [
            'nama_jabatan.required' => 'nama jabatan harus diisi!',
        ]);

        $data = [
            'nama_jabatan' => Request()->nama_jabatan,
        ];

        $this->Jabatan->addData($data);
        Alert::success('Berhasil!', 'Data jabatan berhasil disimpan!');
        return redirect()->route('jabatan');
    }
    public function destroy($id)
    {
        DB::table('jabatan')->where('id', $id)->delete();
        Alert::success('Berhasil!', 'Data jabatan berhasil dihapus!');
        return redirect('jabatan');
    }

    public function edit($id)
    {
        $jabatan = DB::table('jabatan')->find($id);
        return view('jabatan/edit_jabatan', ['jabatan' => $jabatan]);
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
        $affected = DB::table('jabatan')
            ->where('id', $id)
            ->update(['nama_jabatan' => $request->nama_jabatan]);

        Alert::success('Berhasil!', 'Data jabatan berhasil diupdate!');
        return redirect('/jabatan');
    }
}
