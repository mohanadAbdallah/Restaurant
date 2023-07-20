<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function viewCart(): View
    {
        return view('home.restaurant.cart');
    }

    public function addToCart(Request $request)
    {
        if(auth()->check()){

            $item = Item::findOrFail($request->Item_Id);

            $cart = session()->get('cart', []);

            if (isset($cart[$item->id])) {
                $cart[$item->id]['quantity']++;
            } else {
                // Add the item to the cart if it's not already there
                $cart[$item->id] = [
                    'name' => $item->name,
                    'price' => $item->price,
                    'image' => $item->image,
                    'quantity' => 1, // Set the initial quantity to 1
                ];
            }
            session()->put('cart', $cart);
            $response = [
                'message' => 'Item added to cart successfully!',
                'cart_count' => count($cart),
                'cart' => $cart,
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
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'تم إزالة المنتج من السلة بنجاح ');
        }
    }

    public function update(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'تم تحديث السلة بنجاح');
        }
    }
}
