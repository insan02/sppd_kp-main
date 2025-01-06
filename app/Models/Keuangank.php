<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Keuangank extends Model
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

    public function kantor()
    {
        return $this->hasOne(Kantor::class, 'id', 'id');
    }

    public function kategori()
    {
        return $this->belongsTo('App\kategori');
    }

    // Dalam model Keuangan
public function uangup()
{
    return $this->belongsTo(Uangup::class, 'kategori_up', 'id');
}

}
