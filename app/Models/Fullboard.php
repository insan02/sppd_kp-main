<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Fullboard extends Model
{
    use HasFactory;
    protected $table = 'fullboard';
    public function fullboard()
    {
        return $this->hasOne(User::class, 'id', 'id');
    }

    public function allData()
    {
        return DB::table('fullboard')->get();
    }

    public function addData($data)
    {
        DB::table('fullboard')->insert($data);
    }
}
