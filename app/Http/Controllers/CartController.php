<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CartController extends Controller
{
    public function viewCart(): View
    {
        $cart = Cart::with('items')->where('user_id', auth()->id())->first();
        return view('home.restaurant.cart', compact('cart'));
    }

    public function addToCart(Request $request): \Illuminate\Http\JsonResponse
    {
        if (auth()->check()) {

            $item = Item::findOrFail($request->Item_Id);

            $cart = Cart::where('user_id', auth()->id())->first();

            if ($cart && $cart->items()->where('item_id', $item->id)->exists()) {
                $cart->items()->sync([
                    $item->id => ['quantity' => DB::raw('quantity + 1')]
                ], false);
            } else {
                if ($cart && $cart->where('user_id', auth()->id())->exists()) {
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

            $response = [
                'message' => 'Item added to cart successfully!',
            ];
        }
        $redirectResponse = [
            'message' => 'Authentication required!',
            'login_required' => true,
        ];

        return !auth()->check()
            ? response()->json($redirectResponse)
            : response()->json($response);

    }

    public function delete(Request $request)
    {
        if ($request->id) {

            $cart = auth()->user()->cart()->with('items',function ($q) use ($request){
                $q->where('item_id',$request->id);
            })->first();

            if ($cart){
                $cart->items()->where('item_id',$request->id)->detach($request->id);

                if ($cart->items()->count() == 0){
                    $cart->delete();
                }
            }

            session()->flash('success', 'تم إزالة المنتج من السلة بنجاح ');
        }
    }

    public function update(Request $request)
    {
        if ($request->id && $request->quantity) {

            $cart = auth()->user()->cart()->with('items',function ($q) use ($request){
                $q->where('item_id',$request->id);
            })->first();

            $cart->items()->where('item_id',$request->id)->update([
                'quantity' => $request->quantity
            ]);

            session()->flash('success', 'تم تحديث السلة بنجاح');
        }
    }
}
