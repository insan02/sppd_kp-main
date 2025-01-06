<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Penandatangan extends Model
{
    use HasFactory;
    protected $table = 'penandatangan';
    public function penandatangan()
    {
        return $this->hasOne(User::class, 'id', 'id');
    }

    public function allData()
    {
        return DB::table('penandatangan')
            ->select('penandatangan.id', 'karyawan.nama', 'jabatan.id')
            ->Join('karyawan', 'karyawan.id', '=', 'penandatangan.karyawan_id')
            ->Join('jabatan', 'jabatan.id', '=', 'penandatangan.jabatan_id')
            ->get();
    }

    public function addData($data)
    {
        DB::table('penandatangan')->insert($data);
    }

    public function karyawan()
    {
        return $this->belongsTo('App\Karyawan');
    }

    public function jabatan()
    {
        return $this->belongsTo('App\Jabatan');
    }
}
