<?php

namespace App\Http\Controllers\bbsv;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Events\BbsvStored;

use App\Valas;
use App\Bbsv;
class BbsvController extends Controller
{
    function __construct() {
        //dosomething
    }

    function index() {
    }
    function entry() {
        return view('bbsv.entry');
    }
    function store(Request $request) {
        //event on store increment stok valas
        // return response()->json([
        //     'collect' => $this->collectDetilPpsv( $request->detil_ppsv ),
        // ]);
        $bbsv                   = new Bbsv;
        $bbsv->keterangan       = $request->keterangan;
        $bbsv->url_kuitansi     = $request->url_kuitansi;
        $bbsv->tgl_bbsv         = date('Y-m-d');
        $bbsv->ppsv()->associate( $request->no_ppsv );
        $bbsv->save();
        
        $detilPpsv  = $this->collectDetilPpsv( $request->detil_ppsv );
        $valas      = new Valas;
        
        event( new BbsvStored( $valas, $detilPpsv) );

        return response()->json([
            'status'    => 200,
            'bbsv'      => $bbsv
        ]);

    }

    private function collectDetilPpsv( $detilPpsv ) {

        $newCollect = collect();
        foreach($detilPpsv as $detil) {
            $newCollect->push([
                'valas_id'  => $detil['valas']['valas_id'],
                'stok'      => $detil['pivot']['amount']
            ]);
        }
        return $newCollect->all();
    }
}
