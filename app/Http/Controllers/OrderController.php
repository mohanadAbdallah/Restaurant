<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index(Request $request)
    {
        $orders = Order::query();

        if (auth()->user()->restaurant) {

            if (\request()->filled('orders')){

                // here an error
                if (\request()->orders == 3){
                    $orders = $orders->with(['user', 'items' => function ($query) {
                        $query->where('restaurant_id', auth()->user()->restaurant->id);
                    }])->whereHas('user')->get();
                }

                $orders = $orders->where('status','=',\request('orders'));
            }
            $orders = $orders->with(['user', 'items' => function ($query) {
                $query->where('restaurant_id', auth()->user()->restaurant->id);
            }])->whereHas('user')->get();

        }
        return view('orders.index', ['orders' => $orders]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Item::all();

        return view('orders.create', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
        $request->session()->forget('cart');
        return redirect()->route('orders.payment.create',$order->id);


    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order){
        return view('orders.show',compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }


    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('status','تمت عملية إضافة مطعم بنجاح');
    }
}
