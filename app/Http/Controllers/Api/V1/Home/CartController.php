<?php

namespace App\Http\Controllers\Api\V1\Home;

use App\Http\Controllers\ApiController;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends ApiController
{

    public function index(): JsonResponse
    {
        $cart = Cart::where('user_id', auth()->id())->first();

        return $this->showOne($cart);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'item_id' => ['required', 'exists:items,id']
        ]);

        $item = Item::findOrFail($request->item_id);

        $cart = Cart::where('user_id', auth()->id())->first();

        if ($cart && $cart->items()->where('item_id', $item->id)->exists()) {
            if ($request->quantity == 0){
                $cart->items()->detach([
                    $item->id
                ]);
            }else{
                $cart->items()->sync([
                    $item->id => ['quantity' => $request->quantity]
                ], false);
            }

        } else {
            if ($cart) {
                $cart->items()->attach(
                    $item->id, [
                    'quantity' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            } else {
                $cart = Cart::create([
                    'user_id' => auth()->id(),
                ]);

                $cart->items()->attach(
                    $item->id, [
                    'quantity' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }

        }
        $cart->load('items');
        return $this->successResponse(['cart'=>new CartResource($cart)],200);
        //CartItemResource::collection
    }

}
