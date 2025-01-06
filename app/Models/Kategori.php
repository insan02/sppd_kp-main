<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Kategori extends Model
{
    protected $table = 'kategori';

    public function allData()
    {
        return DB::table('kategori')->get();
    }
}
