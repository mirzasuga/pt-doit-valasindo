<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Ppsv;
use App\Mitra;
use App\Valas;

class PpsvController extends Controller
{
    function __construct() {
        $this->middleware('auth');
    }
    /**
     * ========================================
     *                 VIEWS
     * ========================================
     */
    function index() {
        return view('ppsv.index');
    }
    function approvals() {
        return view('ppsv.approval');
    }



    /**
     * ========================================
     *          STORING DATABASE
     * ========================================
     */
    function store(Request $request) {
        $user  = Auth::user();
        $mitra = Mitra::find($request->mitra_id);

        $ppsv = new Ppsv;
        $ppsv->keterangan           = $request->keterangan;
        $ppsv->total_rupiah         = $request->total_rupiah;
        $ppsv->tgl_permintaan       = date('Y-m-d H:i:s');
        $ppsv->processed_at         = null;
        $ppsv->viewed_at            = null;
        $ppsv->stafPembelian()->associate($user);
        $ppsv->mitra()->associate($mitra);
        if( $ppsv->save() ) {
            foreach($request->kurs_ppsv as $kurs) {
                $ppsv->detilPpsv()->attach( $kurs['kurs_id'], [
                    'amount'            => $kurs['amount'],
                    'rate'              => $kurs['rate'],
                    'nominal_rupiah'    => $kurs['rupiah'],
                ]);
            }
            return response()->json([
                'status' => 200,
                'message' => 'Berhasil',
                'data' => $request->all()
            ]);
        }
        return response()->json([
            'message' => 'gagal'
        ]);
    }
    function approve(Request $request) {

        $ppsv = Ppsv::find($request->ppsv_id);
        // EVENT Ketika approve send email ke user yg meminta permintaan
        if( $ppsv->approve() ) {
            return response()->json([
                'status'    => 200,
                'message'   => 'Berhasil melakukan approval'
            ]);
        }
        return response()->json([
            'status'    => 500,
            'message'   => 'Terjadi kesalahan saat melakukan approval'
        ]);

    }
    function reject($ppsv_id) {
        
    }
    
    /**
     * ========================================
     *          GETTERS
     * ========================================
     */
    function all($status) {
        $ppsv = Ppsv::status($status)
        ->with(
            'detilPpsv',
            'mitra',
            'stafPembelian'
        )->get();
        return response()->json([
            'approvals' => $ppsv
        ]);
    }
    function detil($ppsv_id) {

    }
    
    
}
