<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ValasController extends Controller
{
    function __construct() {

    }
    function getEntry() {
        return view('valas.entry');
    }
}
