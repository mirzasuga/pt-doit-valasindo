<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ppsv extends Model
{
    protected $table = 'ppsv';
    protected $primaryKey = 'ppsv_id';
    protected $fillable = [
        'tgl_permintaan',
        'keterangan',
        'status',
        'processed_at',
        'viewed_at'
    ];
    protected $casts = [
        'status' => 'string'
    ];
    protected $dates = [
        'tgl_permintaan'
    ];
    public $timestamps = false;

    function mitra() {
        return $this->belongsTo(Mitra::class,'mitra_id');
    }
    function ppsvMessage() {
        return $this->hasOne(PpsvMessage::class,'ppsv_id');
    }
    function detilPpsv() {
        return $this->belongsToMany(Kurs::class,'kurs_ppsv','ppsv_id','kurs_id')->withPivot('amount','nominal_rupiah','rate')->with('valas');
    }
    // function valas() {
    //     return $this->hasManyThrough(Kurs::class,)
    // }
    
    function detilPermintaan() {
        return $this->kurs()->withPivot('amount','nominal_rupiah','rate');
    }
    function stafPembelian() {
        return $this->belongsTo(User::class,'who_request','user_id');
    }
    

/**
 * ==========
 * SETTER
 * ==========
 */
function getStatusAttribute($status) {
    switch ($status) {
        case 'U':
            return (String) 'Menuggu Persetujuan';
            break;
        case 'A':
            return (String) 'Disetujui';
            break;
        case 'R':
            return (String) 'Ditolak';
            break;
    }
}
/**
 * =========
 *  SCOPE
 * =========
 */
    function scopeStatus($query,$param) {
        if($param === 'all') {
            return $query;
        }
        return $query->where('status',$param);
    }
    function scopeTanggal($query,$param) {
        if($param === '0000-00-00') {
            return $query;
        }
        return $query->where('tgl_permintaan','like','%'.$param.'%');
    }
}
