<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class Kantor extends Model
{
    protected $table = 'kantor';
    protected $fillable = ['id', 'lokasi_id', 'users_id', 'judul_surat', 'tanggal_pergi', 'tanggal_pulang', 'lampiran_surat', 'status_keuangan'];

    public function addData($data)
    {
        DB::table('kantor')->insert($data);
    }

    public function lokasi()
    {
        return $this->belongsTo('App\Lokasi');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function karyawan()
    {
        return $this->belongsToMany(Karyawan::class,  'karyawan_kantor', 'kantor_id', 'karyawan_id');
    }
    public function details()
    {
        return $this->hasMany(Kantor::class, 'id', 'id');
    }
    public function tanggal()
    {
        return Carbon::parse($this->attributes['tanggal_pergi'])
            ->translatedFormat('d F Y');
    }
    public function keuangan()
{
    return $this->hasOne(Keuangan::class, 'kantor_id', 'id');
}

public function uangup()
{
    return $this->hasOneThrough(Uangup::class, Keuangan::class, 'kantor_id', 'id', 'id', 'kategori_up');
}

}
