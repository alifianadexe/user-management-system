<?php

// app/Models/Kingdom.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Kingdom extends Authenticatable
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kingdom_id',
        'desc',
    ];
}

//class Kingdom extends Model
//{
    // ...
//}

