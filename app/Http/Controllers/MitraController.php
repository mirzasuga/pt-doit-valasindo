<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Mitra;

class MitraController extends Controller
{
    function __construct() {
        $this->middleware('auth');
    }
    function index() {
        $this->middleware('role:index-mitra');
        return view('mitra.index');
    }
    function all() {
        $mitras = Mitra::get();
        return response()->json(['mitras' => $mitras]);
    }
    function store(Request $request) {
        $stored = Mitra::create([
            'nama'  => $request->nama,
            'telepon'   => $request->telepon,
            'fax'   => $request->fax,
            'alamat'    => $request->alamat
        ]);
        if($stored) {
            return response()->json(['mitra' => $request->all()]);
        }
        return response(['message' => 'Terjadi kesalahan saat menyimpan mitra'],200);
    }
    function search($q) {
        $mitra = new Mitra();
        $mitras = $mitra->search($q);
        return response()->json(['search_result' => $mitras]);
    }
}
