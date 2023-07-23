<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{

    public function index(): View
    {
        //        $orders = Order::query();
//
//        if (auth()->user()->restaurant) {
//
//            if (\request()->filled('orders')){
//
//                // here an error
//                if (\request()->orders == 3){
//                    $orders = $orders->with(['user', 'items' => function ($query) {
//                        $query->where('restaurant_id', auth()->user()->restaurant->id);
//                    }])->whereHas('user')->get();
//                }
//
//                $orders = $orders->where('status','=',\request('orders'));
//            }
//            $orders = $orders->with(['user', 'items' => function ($query) {
//                $query->where('restaurant_id', auth()->user()->restaurant->id);
//            }])->whereHas('user')->get();
//
//        }
//        return view('orders.index', ['orders' => $orders]);

        $orders = Order::query();

        if (auth()->user()->restaurant) {

            $restaurantId = auth()->user()->restaurant->id;

            $orders = $orders->with(['user', 'items' => function ($query) use ($restaurantId) {
                $query->where('restaurant_id', $restaurantId);
            }]);

            if (\request()->filled('orders') && \request()->orders == 3) {

                $orders = $orders->whereHas('items', function ($q) use ($restaurantId) {
                    return $q->where('restaurant_id', $restaurantId);
                })->get();

            } else if (\request()->filled('orders') && \request()->orders != 3) {
                $orders = $orders->where('status', \request('orders'))
                    ->whereHas('items', function ($q) use ($restaurantId) {
                        return $q->where('restaurant_id', $restaurantId);
                    })
                    ->get();
            } else {
                $orders = $orders->whereHas('items', function ($q) use ($restaurantId) {
                    return $q->where('restaurant_id', $restaurantId);
                })->get();
            }
        }

        return view('orders.index', ['orders' => $orders]);
    }

    public function create(): View
    {
        $items = Item::all();

        return view('orders.create', compact('items'));
    }

    public function store(Request $request): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);
        $orderTotal = 0;

        foreach ($cart as $itemId => $result) {
            $item = Item::find($itemId);

            if ($item) {
                $orderTotal += $item->price * $result['quantity'];
            }
        }

        $order = Order::create([
            'user_id' => auth()->id(),
            'total' => $orderTotal,
            'status' => 2,

        ]);

        foreach ($cart as $itemId => $result) {
            $item = Item::find($itemId);
            if ($item) {
                $order->items()->attach($item->id, ['quantity' => $result['quantity'], 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
            }
        }

        return redirect()->route('orders.payment.create', $order->id);

    }

    public function show(Order $order): View
    {
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order): View
    {
        return \view('orders.edit',['order',$order]);
    }


    public function update(Request $request, Order $order): RedirectResponse
    {
        $order->update([
            'status' => $request->status,
        ]);
        return redirect()->route('orders.index')
            ->with('status', 'Order Successfully Updated');
    }


    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('status', 'تمت عملية إضافة مطعم بنجاح');
    }
}
