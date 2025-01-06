<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class KategoriController extends Controller
{
    public function __construct()
    {
        $this->Kategori = new Kategori();
    }
}
