<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Btupsv extends Model
{
    protected $table = 'btupsv';
    protected $primaryKey = 'btupsv_id';
    protected $fillable = [
        'total_terima',
        'keperluan',
        'tgl_btupsv'
    ];
    public $timestamps = false;

    function teller() {
        return $this->belongsTo(User::class,'teller_id');
    }
    function receiver() {
        return $this->belongsTo(User::class,'receiver_id');
    }
    function ppsv() {
        return $this->belongsTo(Ppsv::class,'ppsv_id');
    }
}
