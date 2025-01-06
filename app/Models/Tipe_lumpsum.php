<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tipe_lumpsum extends Model
{
    protected $table = 'reff_tipe_lumpsum';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tipe_lumpsum', 'biaya',
    ];

    public function allData()
    {
        return DB::table('reff_tipe_lumpsum')->get();
    }

    public function addData($data)
    {
        DB::table('reff_tipe_lumpsum')->insert($data);
    }
}
