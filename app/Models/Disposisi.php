<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Disposisi extends Model
{
    protected $table = 'disposisi';
    protected $fillable = [
        'id',  'users_id', 'pusat_id',
    ];
    use HasFactory;
    public function addData($data)
    {
        DB::table('disposisi')->insert($data);
    }

    public function pusat()
    {
        return $this->hasOne(Pusat::class, 'id', 'id');
    }

    public function karyawan()
    {
        return $this->belongsToMany(Karyawan::class,  'karyawan_disposisi', 'disposisi_id', 'karyawan_id');
    }

    public function proses()
    {
        return $this->hasMany(Pusat::class, 'status_id', 'status_disposisi');
    }

    public function country()
    {
        return $this->hasOne(Pusat::class);
    }
}
