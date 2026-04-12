<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Booking;
use App\Models\Medicine;

class DashboardController extends Controller
{
    // return view for dashboard
    public function index()
    {
        $orderCount = Order::count();
        $bookingCount = Booking::count();
        $medicineCount = Medicine::count();
        $lowStockCount = Medicine::where('stock', '<', 10)->count();
        $recentOrders = Order::latest()->take(5)->get();
        $totalPrice = Order::where('status', 'approved')->sum('total_price');
        return view('dashboard.index', compact('orderCount', 'bookingCount', 'medicineCount', 'lowStockCount', 'recentOrders', 'totalPrice'));
    }    
}

