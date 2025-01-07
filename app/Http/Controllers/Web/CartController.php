<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Web\Cart;
use Illuminate\Http\Request;
use App\Http\Requests\CartStoreRequest;
use App\Http\Resources\Cart as ResourcesCart;
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
        return $this->cartRepository->destroy($id);
    }
}
