<?php

namespace App\Http\Controllers\Stripe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Order;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Exception;

class StripeController extends Controller
{
    public function checkout(Request $request)
    {
        if ($request->has('_productId')) {
            try {
                $product = Product::find($request->_productId);
                if ($product) {
                    $data = [
                        'name' => $request->username,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                        'remember_token' => Str::random(10),
                        'role' => $product->type == 1 ? 3 : 2
                    ];
                    $user = User::createUsers($data);
                    $user->assignRole($product->type == 1 ? 'B2B' : 'B2C');

                    \Stripe\Stripe::setApiKey(config('stripe.sk'));
                    $session = \Stripe\Checkout\Session::create([
                        'line_items'  => [
                            [
                                'price_data' => [
                                    'currency'     => 'INR',
                                    'product_data' => [
                                        'name' => $product->name,
                                    ],
                                    'unit_amount'  => $product->price,
                                ],
                                'quantity'   => 1,
                            ],
                        ],
                        'mode'        => 'payment',
                        'success_url' => "http://localhost:8000/success?session_id={CHECKOUT_SESSION_ID}&price={$product->price}&id={$product->id}&userId={$user->id}",
                        'cancel_url'  => url('/'),
                        'customer_email' => $request->email
                    ]);

                    return redirect()->away($session->url);
                }
            } catch (Exception $e) {
                session()->flash('error', 'Something went wrong.' . $e->getMessage());
                return redirect()->back();
            }
        } else {
            session()->flash('error', 'Product ID is missing.');
            return redirect()->back();
        }
    }

    public function success(Request $request)
    {
        try {
            $stripe = new \Stripe\StripeClient(config('stripe.sk'));
            $retrieve = $stripe->checkout->sessions->retrieve(
                $request->session_id,
                []
            );

            $order = new Order;
            $order->user_id = $request->userId;
            $order->order_id = $retrieve->id;
            $order->payment_id = $retrieve->payment_intent;
            $order->order_item_id = $request->id;
            $order->order_value = $request->price;
            $order->payment_status = $retrieve->payment_status;
            $order->mode = $retrieve->mode;
            $order->status = $retrieve->status;
            $order->save();

            session()->flash('success', 'Order Created Successfully. Your Order ID is ' . $retrieve->id);
            return redirect()->back();
        } catch (Exception $e) {
            session()->flash('error', 'Something went wrong.' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function refund(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('stripe.sk'));
        $paymentIntentId = $request->id;

        try {
            $refund = \Stripe\Refund::create([
                'payment_intent' => $paymentIntentId,
            ]);
            
            if ($refund->status === 'succeeded') {
                session()->flash('success', 'Refunded Successfully');
                return redirect()->back();
            } else {
                session()->flash('error', 'Something went wrong.');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Something went wrong. ' . $e->getMessage());
            return redirect()->back();
        }
    }
}
