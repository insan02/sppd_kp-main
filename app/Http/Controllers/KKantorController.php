<?php

namespace App\Http\Controllers;

use App\Imports\KKantorImport;
use App\Models\Kantor;
use Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Karyawan_Kantor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KKantorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $file->move('file_kantor', $nama_file);

        // import data
        $data = new Kantor();

        Excel::import(new KKantorImport($data), public_path('/file_kantor/' . $nama_file));

        // notifikasi dengan session
        Session::flash('sukses', 'Data Kantor Berhasil Diimport!');

        // alihkan halaman kembali
        return redirect('/kantor');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Karyawan_Kantor  $karyawan_Kantor
     * @return \Illuminate\Http\Response
     */
    public function show(Karyawan_Kantor $karyawan_Kantor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Karyawan_Kantor  $karyawan_Kantor
     * @return \Illuminate\Http\Response
     */
    public function edit(Karyawan_Kantor $karyawan_Kantor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Karyawan_Kantor  $karyawan_Kantor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Karyawan_Kantor $karyawan_Kantor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Karyawan_Kantor  $karyawan_Kantor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Karyawan_Kantor $karyawan_Kantor)
    {
        //
    }
}
