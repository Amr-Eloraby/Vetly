<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\ApiResponse;
use App\Models\Order;
use App\Services\OrderService;
use App\Http\Resources\MyOrderResource;

class OrderController extends Controller
{

    private $orderService;

    public function __construct(OrderService $orderService)
    {

        $this->orderService = $orderService;
    }

    // checkout
    public function checkout()
    {
        $order = $this->orderService->checkout(auth()->user());
        return ApiResponse::sendResponse($order['status'], $order['message'], $order['order']);
    }

    // get my orders
    public function getMyOrders()
    {
        $user = auth()->user();

        $orders = Order::with('items')->where('user_id', $user->id)->get();

        if ($orders->isEmpty()) {
            return ApiResponse::sendResponse(404, 'No orders found');
        }

        return ApiResponse::sendResponse(200, 'Orders retrieved successfully', MyOrderResource::collection($orders));
    }
}
