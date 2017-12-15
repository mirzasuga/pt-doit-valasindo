<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PpsvMessage extends Model
{
    protected $table = 'ppsv_messages';
    protected $primaryKey = 'ppsv_m_id';
    protected $fillable = [
        'body',
        'viewed_at'
    ];

    function ppsv() {
        return $this->belongsTo(Ppsv::class,'ppsv_id');
    }
}
