<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ppsv extends Model
{
    protected $table = 'ppsv';
    protected $fillable = [
        'tgl_permintaan',
        'keterangan',
        'status',
        'processed_at',
        'viewed_at'
    ];
    public $timestamps = false;

    function mitra() {
        return $this->belongsTo(Mitra::class,'mitra_id');
    }
}
