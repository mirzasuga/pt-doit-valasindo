<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kuitansipenukaran extends Model
{
    protected $table = 'kuitansipenukaran';
    protected $primaryKey = 'no_kuitansi';
    protected $fillable = [
        'tanggal_cetak','jumlah_cetak'
    ];
    public $timestamps = false;

    function penukaran() {
        return $this->belongsTo(Penukaran::class,'tukar_id');
    }
    // function detilPenukaran() {
    //     return $this->penukaran->withPivot('amount','nominal_rupiah','rate');
    // }
}
