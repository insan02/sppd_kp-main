<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Surattugasp extends Model
{
    use HasFactory;

    public function getCreatedAttribute()
    {
        return Carbon::parse($this->attributes['date'])
            ->translatedFormat('d f Y');
    }
}
