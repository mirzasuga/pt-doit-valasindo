<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use Auth;
class UserController extends Controller
{
    function __construct() {
        $this->middleware('auth');
    }
    function cekRole() {
        $role = Auth::user()->roles()->first()->jenis;
        return response()->json([
            'role'  =>  $role
        ]);
    }
    function findAll($jenis) {
        $purchaser = Role::find($jenis)->users()->get();
        return response()->json([
            'status' => 200,
            'purchaser' => $purchaser
        ]);
    }
}
