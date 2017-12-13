<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StorePenukaran;

use App\Penukaran;
use Auth;
class PenukaranController extends Controller
{
    function __construct() {
        $this->middleware('auth');
        $this->middleware('role:penukaran-index');
    }
    function index() {
        return view('penukaran.index');
    }

    function store(StorePenukaran $request) {
        $teller = Auth::user();
        $penukaran = new Penukaran;

        $penukaran->total_rupiah    = $request->total_rupiah;
        $penukaran->jenis_tukar     = ($request->jenis_tukar == 'Jual') ? 'S' : 'B';
        $jenisRate                  = ($request->jenis_tukar == 'Jual') ? 'jual' : 'beli';
        
        $penukaran->teller()->associate($teller);

        if( $penukaran->save() ) {
            $detilTukar = array();
            foreach( $request->kurs_penukaran as $detil ) {
                $rate = $detil['rate'];
                $detilTukar[$detil['kurs_id'] ] = [
                    'amount'         => $detil['amount'],
                    'nominal_rupiah' => $detil['rupiah'],
                    'rate'           => $rate[$jenisRate],
                ];
            }
            $penukaran->detilTukar()->attach($detilTukar);
            return response()->json([
                'status' => 200,
                'message' => 'Berhasil',
                'tukar_id'  => $penukaran->tukar_id
            ]);
        }
        

        return response()->json($request);
    }
    function all() {
        return response()->json([
            'datas' => []
        ]);
    }
    function search(Request $request) {
        $q = $request->keyword;
        return response()->json([
            'datas' => []
        ]);
    }

}
