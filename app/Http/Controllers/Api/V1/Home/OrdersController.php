<?php

namespace App\Http\Controllers\Api\v1\Home;

use App\Http\Controllers\ApiController;
use App\Http\Resources\CartResource;
use App\Http\Resources\OrdersResource;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use App\Notifications\orderCreatedNotification;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;

class OrdersController extends ApiController
{

    public function index(): JsonResponse
    {
        $orders = auth()->user()->orders;
        $orders->load('items');

        return $this->successResponse(OrdersResource::collection($orders), 200);
    }

    public function store(): JsonResponse
    {
        $orderTotal = 0;
        $restaurantAdmin = [];

        $dbCart = auth()->user()->cart()->with('items')->first();

        foreach ($dbCart->items as $item) {

            $restaurant_id = $item->restaurant_id;
            $restaurantAdmin[] = User::where('restaurant_id', $restaurant_id)->first();

            if ($item) {
                $orderTotal += $item->price * $item->pivot->quantity;
            }
        }
        $order = Order::create([
            'user_id' => auth()->id(),
            'total' => $orderTotal,
            'status' => 2,
        ]);

        Notification::send($restaurantAdmin, new orderCreatedNotification($order));

        foreach ($dbCart->items as $item) {
                $order->items()->attach($item->id, [
                    'quantity' => $item->pivot->quantity,
                    'cost' => $item->price,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
        }

        return response()->json([
            'message' => 'Order processed successfully',
            'order_id' => $order->id
        ]);

    }

    public function show(Order $order): JsonResponse
    {
        return $this->successResponse($order, 200);
    }

    public function update(Request $request, Order $order)
    {
        //
    }


    public function destroy(Order $order): Response
    {
        $order->delete();

        return response()->noContent();
    }

}
