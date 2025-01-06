<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Penginapan extends Model
{
    protected $table = 'penginapan';

    public function allData()
    {
        return DB::table('penginapan')->get();
    }

    public function addData($data)
    {
        DB::table('penginapan')->insert($data);
    }
}
