<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Penukaran extends Model
{
    protected $table = 'penukaran';
    protected $primaryKey = 'tukar_id';
    protected $fillable = [
        'total_rupiah',
        'jenis_tukar',
    ];

    public function kurs() {
        return $this->belongsToMany(Kurs::class,'kurs_penukaran','tukar_id','kurs_id');
    }
    public function detilTukar() {
        return $this->kurs()->withPivot('amount','nominal_rupiah','rate');
    }
    public function valas() {
        return $this->hasManyThrough(Valas::class,Kurs::class,'kurs_id','valas_id');
    }
    public function teller() {
        return $this->belongsTo(User::class,'teller_id');
    }

    
}
