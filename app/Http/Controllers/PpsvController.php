<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PpsvController extends Controller
{
    function __construct() {
        $this->middleware('auth');
    }
    function index() {

    }
    function store(Request $request) {

    }
    function all() {

    }
    function detil($ppsv_id) {

    }
    function approve($ppsv_id) {

    }
    function reject($ppsv_id) {
        
    }
}
