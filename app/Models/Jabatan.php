<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Jabatan extends Model
{
    use HasFactory;
    protected $table = 'jabatan';
    public function jabatan()
    {
        return $this->hasOne(User::class, 'id', 'id');
    }

    public function allData()
    {
        return DB::table('jabatan')->get();
    }

    public function addData($data)
    {
        DB::table('jabatan')->insert($data);
    }
}
