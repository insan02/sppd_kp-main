<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transportasi extends Model
{
    protected $table = 'transportasi';

    public function allData()
    {
        return DB::table('transportasi')->get();
    }

    public function addData($data)
    {
        DB::table('transportasi')->insert($data);
    }
}
