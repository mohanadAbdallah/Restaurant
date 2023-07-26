<?php

namespace App\Http\Controllers;

use App\Events\NewMessageNotification;
use App\Models\Item;
use App\Models\Message;
use App\Models\Order;
use App\Models\User;
use App\Notifications\orderCreatedNotification;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

use Illuminate\View\View;

class OrderController extends Controller
{

    public function index(Request $request): View
    {
        //where relation

        $orders = Order::query();

        if (auth()->user()->restaurant) {

            $restaurantId = auth()->user()->restaurant->id;

            $orders = $orders->with(['user', 'items' => function ($query) use ($restaurantId) {
                $query->where('restaurant_id', $restaurantId);
            }]);

            if ($request->filled('orders') && $request->query('orders') != 3) {
                $orders = $orders->where('status', \request('orders'));

            }

        }
        $orders = $orders->get();

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
        $restaurantAdmin = null;

        foreach ($cart as $itemId => $result) {
            $item = Item::find($itemId);
            $restaurant_id =$item->restaurant_id;


            $restaurantAdmin = User::where('restaurant_id',$restaurant_id)->first();

            if ($item) {
                $orderTotal += $item->price * $result['quantity'];
            }
        }

        $order = Order::create([
            'user_id' => auth()->id(),
            'total' => $orderTotal,
            'status' => 2,
        ]);

        $restaurantAdmin->notify((new orderCreatedNotification($order)));

        // Notification::send($restaurantAdmin, new orderCreatedNotification($order));

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
