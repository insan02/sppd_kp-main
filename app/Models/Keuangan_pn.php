<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Keuangan_pn extends Model
{
    protected $table = 'keuangan_pn';
    use HasFactory;
    protected $fillable = [
        'id', 'gabung_pn_id', 'pn_id', 'uang',
    ];

    public function addData($data)
    {
        DB::table('keuangan_tp')->insert($data);
    }
}
