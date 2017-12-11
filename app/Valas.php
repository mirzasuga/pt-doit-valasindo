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
        'deskripsi'
    ];
    public $timestamps = false;

    public function search($q) {
        return $this->where('prefix','like',$q.'%')->get();
    }
}
