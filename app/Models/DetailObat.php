<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class DetailObat extends Model
{
    use HasUlids;
    protected $guarded = ['id'];

    // Relasi Balik ke Induk
    public function recall()
    {
        return $this->morphOne(Recall::class, 'detail');
    }
}