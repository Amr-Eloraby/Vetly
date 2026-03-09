<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CartService;
use App\Http\Resources\CartResource;
use App\Helpers\ApiResponse;
use App\Http\Requests\CartRequest;
use App\Models\CartItem;

class CartController extends Controller
{

    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function add(CartRequest $request)
    {
        $request->validated();

        $cart = $this->cartService->addToCart(
            auth()->id(),
            $request->medicine_id,
            $request->quantity
        );

        return ApiResponse::sendResponse(200,'Medicine has been successfully added to cart', null);
    }

    public function changeQuantity(Request $request)
    {
        $request->validate([
            'medicine_id' => 'required|exists:cart_items,medicine_id',
            'action' => 'required|in:increase,decrease'
        ]);

        $result = $this->cartService->changeQuantity(
            auth()->user(),
            $request->medicine_id,
            $request->action
        );

        if (isset($result['success']) && !$result['success']) {
            return ApiResponse::sendResponse(400, $result['message'], null);
        }
        $quantity = CartItem::where('medicine_id', $request->medicine_id)->first()->quantity;
         if ($quantity == 0) {
            $this->cartService->removeItem(
                auth()->id(),
                $request->medicine_id
            );
        }
        return ApiResponse::sendResponse(200,'Cart item quantity has been successfully updated', $quantity);
    }


    public function view()
    {
        $cart = $this->cartService->viewCart(auth()->id());
        return ApiResponse::sendResponse(200,'Cart retrieved successfully', new CartResource($cart));
    }


    public function remove(Request $request)
    {
        $request->validate([
            'medicine_id' => 'required|exists:medicines,id'
        ]);

        $this->cartService->removeItem(
            auth()->id(),
            $request->medicine_id
        );

        return ApiResponse::sendResponse(200,'Product has been successfully removed from cart', null);
    }


    public function clear()
    {
        $this->cartService->clearCart(auth()->id());
        return ApiResponse::sendResponse(200,'Cart has been successfully cleared', null);
    }

}
