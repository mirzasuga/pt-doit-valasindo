<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kuitansipenukaran;
use App\Penukaran;
use View;
use Auth;

class KuitansiController extends Controller
{
    function buildKuitansi($no_kuitansi) {
        $kw = Kuitansipenukaran::find($no_kuitansi);
        $penukaran = Penukaran::find($kw->tukar_id);
        $kwitansi = [
            'no_kuitansi'   => $kw->no_kuitansi,
            'tanggal_cetak' => $kw->tanggal_cetak,
        ];
        foreach($penukaran->detilTukar()->get() as $detilTukar) {
            $kwitansi['detil'][] = [
                'jenis_valas' => $detilTukar->valas->prefix,
                'jumlah_amount' => $detilTukar->pivot->amount,
                'harga_satuan'  => $detilTukar->pivot->rate,
                'nominal_rupiah' => $detilTukar->pivot->nominal_rupiah
            ];
        }
        $kwitansi['jumlah_total'] = $penukaran->total_rupiah;
        $kwitansi['jenis_tukar'] = ($penukaran->jenis_tukar == 'S') ? 'PENJUALAN' : 'PEMBELIAN';
        $kwitansi['teller'] = Auth::user()->nama_user;
        return View::make('kuitansi.printout',['kwitansi' => $kwitansi])->render();
    }
    function cetak($tukar_id) {
        
        $kuitansiPenukaran = Kuitansipenukaran::where('tukar_id',$tukar_id)->first();
        if( !$kuitansiPenukaran ) {
            $kuitansiPenukaran = new Kuitansipenukaran;
            $kuitansiPenukaran->tanggal_cetak = date('Y-m-d H:i:s');
            $kuitansiPenukaran->jumlah_cetak  = 1;
            $kuitansiPenukaran->penukaran()->associate($tukar_id);
            if( $kuitansiPenukaran->save() ){
                return response()->json(['template' => $this->buildKuitansi( $kuitansiPenukaran->no_kuitansi )]);
            }
        }
        else {
            return response()->json(['template' => $this->buildKuitansi( $kuitansiPenukaran->no_kuitansi )]);
            
        }
    }
}
