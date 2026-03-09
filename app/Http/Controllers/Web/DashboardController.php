<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    // return view for dashboard
    public function index()
    {
        return view('dashboard.index');
    }    
}

