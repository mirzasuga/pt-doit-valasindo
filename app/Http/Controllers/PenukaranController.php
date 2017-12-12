<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Penukaran;

class PenukaranController extends Controller
{
    function __construct() {
        $this->middleware('auth');
        $this->middleware('role:penukaran-index');
    }
    function index() {
        return view('penukaran.index');
    }
    function store(Request $request) {

    }
    function cetak() {

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
