<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gate;
use App\Valas;
use Auth;
use Validator;
use View;

class ValasController extends Controller
{
    function __construct() {
        $this->middleware('role:index-valas');
    }
    function index(Request $request) {
        // if( $request->ajax() ) {
        //     return View::make('valas.index')->render();
        // }
        return view('valas.index');
    }
    function store(Request $request) {
        $stored = Valas::create([
            'nama_valas' => $request->nama_valas,
            'prefix'    => $request->prefix,
            'deskripsi' => $request->deskripsi,
            'stok'  => $request->stok
        ]);
        if($stored) {
            return response()->json(['valas' => $request->all()]);
        }
        return response('Gagal menyimpan data',500);
    }

    function cari(Request $request) {
        $q = $request->q;
        $valas = new Valas();
        $valas = $valas->search($q);
        return response()->json(['search_result' => $valas]);
    }

    function all() {
        $valas = Valas::get();
        return response()->json(['valas' => $valas]);
    }
    function putAll() {
        dd('oke');
    }
    function putValasRate($prefix) {
        $valas   = Valas::where('prefix',$prefix)->first();
        if($valas) {
            $kurs    = $valas->activeKurs();
            $response= [
                'status'    => 200,
                'message'   => 'Found!',
                'data'      => $kurs
            ];
            if($kurs !== null) {
                return response()->json( $response );
            }
        }
        
        $response['status']  = 404;
        $response['message'] = 'Data tidak ditemukan!';
        return response()->json( $response );
    }
    function showEntryForm(Request $request) {

    }



    function postEntry(Request $request) {
        $rules = [
            'nama_valas'      => 'required|unique:valas|max:90',
            'prefix'    => 'required|unique:valas|size:3',
            'deskripsi' => 'max:50'
        ];
        $messages = config('app.validation_msg');

        $validator = Validator::make($request->all(),$rules,$messages);
        if($validator->fails()) {
            return redirect(route('getentry.valas'))
                ->withErrors($validator)
                ->withInput();
        }

        $created = Valas::create([
            'nama_valas'    => $request->nama_valas,
            'prefix'         => $request->prefix,
            'deskripsi'     => $request->deskripsi
        ]);
        if($created) {
            return redirect()->back()->with('success','Berhasil menyimpan data valas');
        }
        return redirect()->back()->with(['failed' => 'Berhasil menyimpan data valas']);
    }
    /**
     * API
     */
    function getFormEntry(Request $request) {
        if($request->ajax()) {
            return View::make('valas.frmEntry')->render();
        }
    }
    function frmValas() {
        
    }
    function test() {
        if(Gate::denies('c-dashboard')) {
            dd('oke');
        }
    }
}
