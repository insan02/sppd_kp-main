<?php

namespace App\Http\Controllers;

use App\Models\Pusat;
use App\Models\Disposisi;
use App\Models\Tanggapan;
use App\Models\Karyawan;
use App\Models\Karyawan_Disposisi;
use App\Models\Karyawan_Disposisi2;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class TanggapanController extends Controller
{
    public function __construct()
    {
        $this->Disposisi = new Disposisi();
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $karyawan = Karyawan::all();
        $users = User::all();
        $pusat = Pusat::all();
        $item = Pusat::with([
            'details'
        ])->findOrFail($id);
        $it = Pusat::select('pusat.id')
            ->where('pusat.id', $id)->first();

        return view('tanggapan/add', [
            'item' => $item
        ], compact('karyawan', 'users', 'pusat', 'it'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pusat_id = Request()->pusat_id;
        $users_id = Auth::user()->id;

        for ($i = 0; $i < count($request->karyawan_id); $i++) {
            $karyawan_disposisi = Karyawan_Disposisi::create([
                'pusat_id' => $pusat_id,
                'karyawan_id' => Request()->karyawan_id[$i],
            ]);
        }

        Alert::success('Berhasil', 'Karyawan berhasil ditambahkan');
        return redirect()->route('show', [$pusat_id]);
    }
}
