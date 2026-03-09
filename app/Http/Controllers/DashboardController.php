<?php

namespace App\Http\Controllers;


class DashboardController extends Controller
{
    // return view for dashboard
    public function index()
    {
        return view('dashboard.index');
    }    
}
