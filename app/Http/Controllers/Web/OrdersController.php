<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;

class OrdersController extends Controller
{
    // orders
    public function index()
    {
        $orders = Order::all();
        return view('dashboard.orders.show', compact('orders'));
    }

    // order details
    public function viewDetails($id)
    {
        $order = Order::findOrFail($id);
        $orderItem = OrderItem::where('order_id', $id)->get();
        return view('dashboard.orders.viewdetails', compact('orderItem', 'order'));
    }

    // confirm order
    public function confirmOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'approved';
        $order->save();

        return redirect()->route('orders.index');
    }

    // ship order
    public function shipOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'shipped';
        $order->save();

        return redirect()->route('orders.index');
    }
}
