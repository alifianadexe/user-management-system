<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profit extends Model
{
    // use HasFactory;

    protected $fillable = [
        'transaction_id',
        'sell_price',
        'profit'
    ];
}