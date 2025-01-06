<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pusat extends Model
{
    protected $table = 'pusat';

    public function allData()
    {
        return DB::table('pusat')
            ->select('pusat.id', 'lokasi.nama_kota', 'users.role_user', 'pusat.no_surat', 'pusat.judul_surat', 'pusat.tanggal_pergi', 'pusat.tanggal_pulang', 'pusat.lampiran_undangan', 'pusat.status_disposisi')
            ->leftJoin('lokasi', 'lokasi.id', '=', 'pusat.lokasi_id')
            ->leftJoin('users', 'users.id', '=', 'pusat.users_id')
            ->get();
    }

    public function addData($data)
    {
        DB::table('pusat')->insert($data);
    }

    public function lokasi()
    {
        return $this->belongsTo('App\Lokasi');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function details()
    {
        return $this->hasMany(Pusat::class, 'id', 'id');
    }

    public function tanggapans()
    {
        return $this->belongsTo(Pusat::class, 'id', 'id');
    }

    public function tanggapan()
    {
        return $this->hasOne(Tanggapan::class);
    }

    public function status()
    {
        return $this->belongsTo(Tanggapan::class, 'status_id', 'status_disposisi');
    }
}
