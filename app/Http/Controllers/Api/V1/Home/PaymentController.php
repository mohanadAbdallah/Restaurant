<?php

namespace App\Http\Controllers\Api\V1\Home;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Stripe\StripeClient;

class PaymentController extends Controller
{
    public function createStripePaymentIntent(Order $order): JsonResponse
    {
        $stripe = new StripeClient(config('services.stripe.secret_key'));

        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => $order->total * 100,
            'currency' => 'ILS',
            'payment_method_types' => ['card']
        ]);

        $payment = new Payment();

        $payment->forceFill([
            'order_id' => $order->id,
            'amount' => $paymentIntent->amount,
            'method' => 'stripe',
            'currency' => $paymentIntent->currency,
            'status' => 'pending',
            'transaction_id' => $paymentIntent->id,
            'transaction_data' => json_encode($paymentIntent),

        ])->save();

        return response()->json([
            'clientSecret' => $paymentIntent->client_secret,
        ]);
    }
    public function confirm()
    {

    }
}
