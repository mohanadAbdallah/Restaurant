<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

class PaymentsController extends Controller
{
    public function create(Order $order): View
    {
        return view('home.payments.create', compact('order'));
    }


    /**
     * @throws ApiErrorException
     */
    public function createStripePaymentIntent(Order $order): array

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

        return [
            'clientSecret' => $paymentIntent->client_secret,
        ];

    }

    /**
     * @throws ApiErrorException
     */
    public function confirm(Request $request, Order $order): RedirectResponse
    {
        $stripe = new StripeClient(config('services.stripe.secret_key'));

        $paymentIntent = $stripe->paymentIntents->retrieve(
            $request->query('payment_intent'),
            []
        );
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

            return redirect()->route('home')->with('status', 'payment-succeed');
        }
        return redirect()->route('orders.payments.create', [
            'order' => $order->id,
            'status' => $paymentIntent->status,
        ]);
    }
}
