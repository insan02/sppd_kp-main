<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Pusat;
use App\Models\Kantor;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $karyawan = Karyawan::count();
        $undangan = Pusat::select('status_disposisi')->where('status_disposisi', 'Pending')->count();
        $undangann = Pusat::select('status_disposisi')->where('status_disposisi', 'Terima')->count();
        $kantor = Kantor::count();
        return view('home', compact('karyawan', 'undangan', 'undangann', 'kantor'));
    }
}
