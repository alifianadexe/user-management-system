<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stocks extends Model
{
    // use HasFactory;
    public function resources()
    {
        return $this->belongsTo('Resources');
    }
}
