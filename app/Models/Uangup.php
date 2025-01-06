<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Uangup extends Model
{
    protected $table = 'uangup';
    protected $fillable = ['tanggal', 'kategori_up', 'jumlahup', 'pengeluaran', 'sisa','totalMasuk'];
    

    public function allData()
    {
        return DB::table('uangup')->get();
    }

    public function addData($data)
    {
        DB::table('uangup')->insert($data);
    }

    public function cumulativeSum()
{
    return $this->sum('jumlahup');
}

public function kantor()
    {
        return $this->hasMany(Kantor::class, 'kategori_up', 'id'); // Adjust the foreign key if necessary
    }
}
