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
        return $this->where('nama','like',$q.'%')->get();
    }
    public function kurses() {
        return $this->hasMany(Kurs::class,'mitra_id');
    }
}
