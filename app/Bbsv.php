<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bbsv extends Model
{
    protected $table = 'bbsv';
    protected $primaryKey = 'bbsv_id';
    protected $fillable = [
        'jumlah_valas',
        'jumlah_rupiah',
        'keterangan',
        'url_kuitansi',
        'tgl_bbsv'
    ];
    public $timestamps = false;

    function ppsv() {
        return $this->belongsTo(Ppsv::class,'ppsv_id');
    }

    function eventOnSimpan(Valas $valas, array $detilPpsv) {

    }
}
