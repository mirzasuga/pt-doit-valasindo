<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    protected $table = 'mitra';
    protected $primaryKey = 'mitra_id';
    protected $fillable = [
        'nama','telepon','fax','alamat','email'
    ];
    public $timestamps = false;

    function search($q) {
        return $this->where('nama','like','%'.$q.'%')->get();
    }
    public function kurs() {
        return $this->hasMany(Kurs::class,'mitra_id');
    }
    public function valas() {
        return $this->hasManyThrough(Valas::class,Kurs::class,'kurs_id','valas_id','mitra_id');
    }
}
