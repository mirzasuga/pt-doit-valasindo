<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kurs;
use App\Mitra;

class KursController extends Controller
{
    function getKursMitra($mitra_id) {
        $mitra = Mitra::find($mitra_id);
        
        $kurs_mitra = $mitra->kurs()->with('valas')->get();

        return response()->json(['kurs_mitra' => $kurs_mitra]);
    }
    function activateKursTo($mitra_id) {

    }
}
