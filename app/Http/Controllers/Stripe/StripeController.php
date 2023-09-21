<?php

namespace App\Http\Controllers\Stripe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Order;
use Exception;

class StripeController extends Controller
{
    public function checkout(Request $request)
    {
        if ($request->has('_productId')) {
            try {
                $product = Product::find($request->_productId);
                if ($product) {
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
                        'success_url' => "http://localhost:8000/success?session_id={CHECKOUT_SESSION_ID}&price={$product->price}&id={$product->id}",
                        'cancel_url'  => url('/'),
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
            $order->order_id = $retrieve->id;
            $order->payment_id = $retrieve->payment_intent;
            $order->order_item_id = $request->id;
            $order->order_value = $request->price;
            $order->save();
        } catch(Exception $e) {
            
        }
        
    }
}
