<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Karyawan_Kantor extends Model
{
    protected $table = 'karyawan_kantor';
    protected $primaryKey = 'id';
    protected $fillable = ['kantor_id', 'karyawan_id'];
}
