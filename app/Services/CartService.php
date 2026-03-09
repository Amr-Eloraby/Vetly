<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Medicine;

class CartService
{

    // create or get cart for user
    public function getCart($userId)
    {
        return Cart::firstOrCreate([
            'user_id' => $userId
        ]);
    }


    // add item to cart
    public function addToCart($userId, $medicineId, $quantity)
    {
        $cart = $this->getCart($userId);

        $medicine = Medicine::findOrFail($medicineId);

        if ($quantity > $medicine->stock) {
            throw new \Exception('the requested quantity is not available');
        }

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('medicine_id', $medicineId)
            ->first();

        if ($cartItem) {

            $newQuantity = $cartItem->quantity + $quantity;

            if ($newQuantity > $medicine->stock) {
                throw new \Exception('the requested quantity is not available');
            }

            $cartItem->update([
                'quantity' => $newQuantity
            ]);

        } else {

            CartItem::create([
                'cart_id' => $cart->id,
                'medicine_id' => $medicineId,
                'quantity' => $quantity
            ]);

        }

        return true;
    }
    
    // update cart item quantity
    public function changeQuantity($user, $medicineId, $action)
    {
        $cart= Cart::where('user_id', $user->id)->first();
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('medicine_id', $medicineId)
            ->first();

        if (!$cartItem) {
            return [
                'success' => false,
                'message' => 'Cart item not found'
            ];
        }

        if ($action === 'increase') {
            CartItem::where('medicine_id', $medicineId)->increment('quantity');
        }

        if ($action === 'decrease') {
           CartItem::where('medicine_id', $medicineId)->decrement('quantity');
        }

        return [
            'success' => true,
            'message' => 'Quantity updated successfully',
            'new_quantity' => $cartItem->quantity ?? 0
        ];
    }

    // view cart
    public function viewCart($userId)
    {
        $cart = $this->getCart($userId);

        return $cart->load('items.medicine');
    }


    // remove item from cart
    public function removeItem($userId, $medicineId)
    {
        $cart = $this->getCart($userId);

        CartItem::where('cart_id', $cart->id)
            ->where('medicine_id', $medicineId)
            ->delete();

        return true;
    }


    // clear cart
    public function clearCart($userId)
    {
        $cart = $this->getCart($userId);

        CartItem::where('cart_id', $cart->id)->delete();

        return true;
    }

}