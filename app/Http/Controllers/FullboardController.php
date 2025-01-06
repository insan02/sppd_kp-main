<?php

namespace App\Http\Controllers;

use App\Models\Fullboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class FullboardController extends Controller
{
    public function __construct()
    {
        $this->Fullboard = new Fullboard();
    }

    public function index()
    {
        $data = [
            'fullboard' => $this->Fullboard->allData(),

        ];
        return view('fullboard/index', $data);
    }

    public function insert()
    {
        Request()->validate([
            'jumlah' => 'required',
        ], [
            'jumlah.required' => 'jumlah uang fullboard harus diisi!',
        ]);

        $data = [
            'jumlah' => Request()->jumlah,
        ];

        $this->Fullboard->addData($data);
        Alert::success('Berhasil!', 'Data fullboard berhasil disimpan!');
        return redirect()->route('fullboard');
    }

    public function edit($id)
    {
        $fullboard = DB::table('fullboard')->find($id);
        return view('fullboard/edit_fullboard', ['fullboard' => $fullboard]);
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
        $affected = DB::table('fullboard')
            ->where('id', $id)
            ->update(['jumlah' => $request->jumlah]);

        Alert::success('Berhasil!', 'Data fullboard berhasil diupdate!');
        return redirect('/fullboard');
    }
}
