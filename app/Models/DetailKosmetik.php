<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class DetailKosmetik extends Model
{
    use HasUlids;
    protected $guarded = ['id'];

    public function recall()
    {
        return $this->morphOne(Recall::class, 'detail');
    }
}