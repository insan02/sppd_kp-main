<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Keuangan extends Model
{
    protected $table = 'keuangan';
    use HasFactory;
    protected $fillable = [
        'id', 'kantor_id', 'transportasi_id', 'penginapan_id', 'uang_transport', 'uang_penginapan','kategori_up',
    ];

    public function addData($data)
    {
        DB::table('keuangan')->insert($data);
    }

    public function utp()
    {
        return $this->hasMany(Keuangan_tp::class, 'gabung_tp_id');
    }

    public function upn()
    {
        return $this->hasMany(Keuangan_pn::class, 'gabung_pn_id');
    }

    public function disposisi()
    {
        return $this->hasOne(Disposisi::class, 'id', 'id');
    }

    // Dalam model Keuangan
public function uangup()
{
    return $this->belongsTo(Uangup::class, 'kategori_up', 'id');
}

    
}
