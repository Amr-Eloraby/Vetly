<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\ApiResponse;
use App\Services\OrderService;

class OrderController extends Controller
{

    private $orderService;

    public function __construct(OrderService $orderService)
    {

        $this->orderService = $orderService;
    }

    public function checkout()
    {
        $order = $this->orderService->checkout(auth()->user());
        return ApiResponse::sendResponse($order['status'], $order['message'], $order['order']);
    }
}
