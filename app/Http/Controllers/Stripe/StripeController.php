<?php

namespace App\Http\Controllers\Stripe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function index()
    {
        return view('stripe.index');
    }

    public function checkout(Request $request)
    { 
        if($request->has('_productId')) {
            
            \Stripe\Stripe::setApiKey(config('stripe.sk'));

            $session = \Stripe\Checkout\Session::create([
                'line_items'  => [
                    [
                        'price_data' => [
                            'currency'     => 'gbp',
                            'product_data' => [
                                'name' => ,
                            ],
                            'unit_amount'  => 500,
                        ],
                        'quantity'   => 1,
                    ],
                ],
                'mode'        => 'payment',
                'success_url' => route('success'),
                'cancel_url'  => url('/'),
            ]);
    
            return redirect()->away($session->url);
        } else {
            session()->flash('error', 'Product ID is missing.');
            return redirect()->back();
        }
        
    }

    public function success()
    {
        return "Yay, It works!!!";
    }
}
