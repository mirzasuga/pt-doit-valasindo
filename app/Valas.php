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
    public function bbsv() {
        return $this->belongsToMany(Bbsv::class,'detil_bbsv','valas_id','bbsv_id');
    }
    public function mitra() {
        //return $this->hasManyThrough(Mitra::class,'')
    }

    public static function batchIncrementStok( $valas ) {
        foreach($valas as $item) {
            $valas = self::find($item['valas_id']);
            $valas->incrementStok($item['stok']);
        }
        return true;
    }

    public function incrementStok( $stok ) {
        $this->stok += $stok;
        if( $this->save() ) {
            return true;
        }
        return false;
    }
    public function decrementStok( $stok ) {
        $this->stok -= $stok;
        return $this->save();
    }
}
