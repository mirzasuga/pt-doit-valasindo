<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
class DashboardController extends Controller
{
    function __construct() {
        $this->middleware('auth');
        $this->middleware('role:dashboard');
    }

    function index(Request $request) {
        $this->isCustomer();
        return view('dashboard.index');
    }

    function isCustomer() {
        if(Auth::user()->inRole('customer')) {
            return redirect(route('customer_dashboard'));
        }
        return false;
    }
}
