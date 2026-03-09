<?php

namespace App\Services;

use App\Helpers\ApiResponse;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Http\Resources\OrderResource;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function checkout($user)
    {
        // get cart
        $cart = Cart::where('user_id', $user->id)->first();
        
        // cart not found OR empty
        if (!$cart || $cart->items->isEmpty()) {
            return [
                'status' => 400,
                'message' => 'Cart is empty',
                'order' => null,
            ];
        }

        // return DB::beginTransaction(); 
        
        try {

            $total = 0;

            // create order
            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => 0,
                'status' => 'pending',
            ]);

            
            foreach ($cart->items as $item) {

                $price = $item->medicine->price;
                $subtotal = $price * $item->quantity;

                OrderItem::create([
                    'order_id' => $order->id,
                    'medicine_id' => $item->medicine_id,
                    'quantity' => $item->quantity,
                    'price' => $price,
                ]);

                $stock = $item->medicine->stock;
                if ($stock < $item->quantity) {
                    return [
                        'status' => 400,
                        'message' => "Not enough stock for medicine: {$item->medicine->name}",
                        'order' => null,
                    ];
                }
                // update stock
                $item->medicine->update([
                    'stock' => $stock - $item->quantity
                ]);
                $total += $subtotal;
            }

            // update total
            $order->update([
                'total_price' => $total
            ]);

            // clear cart
            $cart->items()->delete();

            DB::commit();

            $orderResource = new OrderResource($order->load('items.medicine'));

            return [
                'status' => 200,
                'message' => 'Order placed successfully',
                'order' => $orderResource
            ];

        } catch (\Exception $e) {

            DB::rollBack();

            return ApiResponse::sendResponse(500, 'Order failed');
        }
        
        
    }
}