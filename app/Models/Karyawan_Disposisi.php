<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Karyawan_Disposisi extends Model
{
    protected $table = 'karyawan_disposisi';
    protected $primaryKey = 'id';
    protected $fillable = ['disposisi_id', 'karyawan_id', 'pusat_id'];
}
