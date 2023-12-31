<?php

namespace App\Http\Controllers\Api\V1\Home;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Stripe\StripeClient;

class PaymentController extends Controller
{
    use ApiResponser;
    public function createStripePaymentIntent(Request $request, Order $order): JsonResponse
    {
        $stripe = new StripeClient(config('services.stripe.secret_key'));

        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => $order->total * 100,
            'currency' => 'ILS',
            'payment_method_types' => ['card'],
            'payment_method' => $request->input('payment_method'),
            'confirm' => true
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

        if ($paymentIntent->status == 'succeeded') {
            $payment = Payment::where('order_id', $order->id)->first();
            $payment->forceFill([
                'status' => 'completed',
                'transaction_data' => json_encode($paymentIntent),
            ])->save();

            $order->forceFill([
                'status' => '1'
            ])->save();

            Cart::where('user_id',auth()->id())->delete();

            return $this->successResponse($order,200);

        }
        return $this->errorResponse('Failed Payment Process.',500);
    }

}
