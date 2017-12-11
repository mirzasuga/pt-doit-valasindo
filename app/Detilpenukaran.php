<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detilpenukaran extends Model
{
    protected $table = 'kurs_penukaran';
    protected $fillable = [
        'amount','nominal_rupiah'
    ];
}
