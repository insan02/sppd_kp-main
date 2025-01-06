<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Surattugaspp extends Model
{
    use HasFactory;

    public function getCreatedAttribute()
    {
        return Carbon::parse($this->attributes['created'])
            ->translatedFormat('d f Y');
    }
}
