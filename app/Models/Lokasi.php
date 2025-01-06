<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Lokasi extends Model
{
    protected $table = 'lokasi';
    protected $fillable = ['Provinsi', 'nama_kota', 'besaran_lumpsum'];

    public function pusat()
    {
        return $this->hasMany(pusat::class, 'id', 'id');
    }

    public function allData()
    {
        return DB::table('lokasi')->get();
    }

    public function addData($data)
    {
        DB::table('lokasi')->insert($data);
    }
}
