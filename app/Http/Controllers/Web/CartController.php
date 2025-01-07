<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Web\Cart;
use Illuminate\Http\Request;
use App\Http\Requests\CartStoreRequest;
use App\Interfaces\CartInterface;

class CartController extends Controller
{
    protected $cartRepository;

    public function __construct(CartInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function store(CartStoreRequest $request)
    {
        return $this->cartRepository->store($request->all());
    }


    public function show(Request $request)
    {
        return $this->cartRepository->show($request->all());
    }
    public function destroy($id)
    {
        $cartItem = Cart::findOrFail($id);
        $cartItem->delete();

        // Return updated cart summary
        $cartItems = Cart::where('session_id', $cartItem->session_id)
            ->with('product', 'variant')
            ->get()
            ->map(function ($cartItem) {
                return [
                    'id' => $cartItem->id,
                    'product_name' => $cartItem->product->name,
                    'quantity' => $cartItem->quantity,
                    'price' => number_format($cartItem->variant->price, 2)
                ];
            });

        return response()->json(['cartItems' => $cartItems]);
    }
}
