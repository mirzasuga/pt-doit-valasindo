<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kurs extends Model
{
    protected $table = 'kurs';
    protected $fillable = [
        'modal_jual',
        'modal_beli',
        'jual',
        'beli',
        'selisih',
        'is_active',
        'created_at',
        'updated_at'
    ];
    protected $primaryKey = 'kurs_id';

    public function mitra() {
        return $this->belongsTo(Mitra::class,'mitra_id');
    }
    public function valas() {
        return $this->belongsTo(Valas::class,'valas_id');
    }
    public function penukaran() {
        return $this->belongsToMany(Penukaran::class,'kurs_penukaran','tukar_id','kurs_id');
    }
    public function activeKurs() {

    }
}
