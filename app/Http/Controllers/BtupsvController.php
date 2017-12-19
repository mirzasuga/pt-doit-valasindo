<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Btupsv;
use Auth;
class BtupsvController extends Controller
{
    function __construct() {
        $this->middleware('auth');
    }
    function index() {
        return view('btupsv.index');
    }
    function store(Request $request) {
        $btupsv = new Btupsv;
        $teller_id = Auth::user()->user_id;
        $btupsv->total_terima   = $request->total_terima;
        $btupsv->keperluan      = $request->keperluan;
        $btupsv->tgl_btupsv     = date('Y-m-d');
        
        $btupsv->teller()->associate($teller_id);
        $btupsv->receiver()->associate($request->receiver_id);
        $btupsv->ppsv()->associate($request->ppsv_id);
        if( $btupsv->save() ) {
            return response()->json([
                'status'    => 200,
                'message'   => 'Berhasil menyimpan BTUPSV',
                'data'      => $request->all(),
                'last_insert'   => $btupsv->btupsv_id,
            ]);
        }
    }
    function cetak($btupsv_id) {
        return view('btupsv.cetak');
    }
}
