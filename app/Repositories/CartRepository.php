<?php

namespace App\Repositories;

use App\Http\Resources\Cart as CartResources;
use App\Interfaces\CartInterface;
use App\Models\Web\Cart;
use App\Traits\CommonHelperTrait;

class CartRepository implements CartInterface
{
    use CommonHelperTrait;



    public function store($data)
    {
        $sessionId = $data['session_id'];
        $productId = $data['product_id'];
        $variantId = $data['product_variant_id'];
        $quantity = $data['quantity'];

        // Check if the cart item already exists
        $cartItem = Cart::where('session_id', $sessionId)
            ->where('product_id', $productId)
            ->where('product_variant_id', $variantId)
            ->first();

        if ($cartItem) {
            // If item exists, update the quantity
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            // If item doesn't exist, create a new cart item
            Cart::create([
                'session_id' => $sessionId,
                'product_id' => $productId,
                'product_variant_id' => $variantId,
                'quantity' => $quantity
            ]);
        }

        // Get the updated cart items and return using the CartResource
        $cartItems = Cart::where('session_id', $sessionId)
            ->with('product', 'variant')
            ->get();

        return CartResources::collection($cartItems);
    }

    public function show($data)
    {
        //return $data['session_id'];
        $sessionId = $data['session_id'];

        // Get the cart items for the given session ID
        $cartItems = Cart::where('session_id', $sessionId)
            ->with('product', 'variant') // Load related product and variant info
            ->get();

        // Return the cart items using CartResource to format the response
        return CartResources::collection($cartItems);
    }

    public function destroy($cart)
    {
        return $cart->delete();
    }
}
