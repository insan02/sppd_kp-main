<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Keuangan_tp extends Model
{
    protected $table = 'keuangan_tp';
    use HasFactory;
    protected $fillable = [
        'id', 'gabung_tp_id', 'transport_id', 'uang',
    ];

    public function addData($data)
    {
        DB::table('keuangan_tp')->insert($data);
    }
}
