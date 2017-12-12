<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Valas extends Model
{
    protected $primaryKey = 'valas_id';
    protected $table = 'valas';
    protected $fillable = [
        'nama_valas',
        'prefix',
        'deskripsi',
        'stok'
    ];
    public $timestamps = false;

    public function search($q) {
        return $this->where('prefix','like',$q.'%')->get();
    }
    public function kurses() {
        return $this->hasMany(Kurs::class,'valas_id');
    }
    public function activeKurs() {
        return $this->kurses()->where('is_active',1)->first();
    }
    public function mitra() {
        //return $this->hasManyThrough(Mitra::class,'')
    }
}
