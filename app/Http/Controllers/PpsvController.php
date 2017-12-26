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
    function statusPermintaan() {
        return view('ppsv.status');
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
        $ppsv->total_rupiah         = str_replace('.','',$request->total_rupiah);
        $ppsv->tgl_permintaan       = date('Y-m-d H:i:s');
        $ppsv->processed_at         = null;
        $ppsv->viewed_at            = null;
        $ppsv->stafPembelian()->associate($user);
        $ppsv->mitra()->associate($mitra);
        if( $ppsv->save() ) {
            foreach($request->kurs_ppsv as $kurs) {
                $ppsv->detilPpsv()->attach( $kurs['kurs_id'], [
                    'amount'            => str_replace('.','',$kurs['amount']),
                    'rate'              => str_replace('.','',$kurs['rate']),
                    'nominal_rupiah'    => str_replace('.','',$kurs['rupiah']),
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
        $ppsv->status = 'A';
        $ppsv->processed_at = date('Y-m-d H:i:s');
        $ppsv->approved_by = Auth::user()->nama_user;
        
        // EVENT Ketika approve send email ke user yg meminta permintaan
        if( $ppsv->save() ) {
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
    function reject(Request $request) {
        $ppsv_id = $request->ppsv_id;
        $alasan  = $request->alasan;

        $ppsv    = Ppsv::find($ppsv_id);
        $ppsv->status       = 'R';
        $ppsv->processed_at = date('Y-m-d H:i:s');
        $ppsv->approved_by  = Auth::user()->nama_user;
        $created = $ppsv->ppsvMessage()->create([
            'body'  => $alasan,
        ]);
        if( $ppsv->save() && $created ) {
            
            return response()->json([
                'status'    => 200,
                'message'   => 'Berhasil melakukan reject',
                'data'      => $request->all()
            ]);
        }
        return response()->json([
            'status'    => 500,
            'message'   => 'Gagal melakukan reject',
        ]);
    }
    function viewed($ppsv_id) {
        $ppsv = Ppsv::find($ppsv_id);
        $ppsv->viewed_at = date('Y-m-d H:i:s');
        if( $ppsv->save() ) {
            return response()->json([
                'status'    => 200,
                'message'   => 'Viewed'
            ]);
        }
        return response()->json([
            'status'    => 500,
            'message'   => 'Failed'
        ]);
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
    function filter($status,$tanggal) {
        if( Auth::user()->roles()->first()->jenis === 'TELLER' ) {
            $status = 'A';
        }
        $ppsv = Ppsv::status($status)->tanggal($tanggal)
        ->with('detilPpsv','mitra','stafPembelian')
        ->get();
        return response()->json([
            'status'    => 200,
            'ppsv'      => $ppsv,
            'message'   => 'Success'
        ]);
    }
    function detil($ppsv_id) {

    }
    function approved($ppsv_id,$detil = null) {
        if($detil == 'detil') {
            $ppsv = Ppsv::approved($ppsv_id)->with('detilPpsv')->get();
        }
        else {
            $ppsv = Ppsv::approved($ppsv_id)->get();
        }
        return response()->json([
            'status'    => 200,
            'ppsv'      => $ppsv,
        ]);
    }
    function search($q) {
        $ppsv = Ppsv::search($q)->get();
        return response()->json([
            'status'    => 200,
            'ppsv'      => $ppsv
        ]);
    }
    
    
}
