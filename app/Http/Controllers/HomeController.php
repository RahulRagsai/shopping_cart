<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Order;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->controller = 'HomeController';
        $this->middleware('auth');
        $this->middleware('permission:'.$this->controller.'@index', ['only' => ['index']]);
        $this->middleware('permission:'.$this->controller.'@B2C', ['only' => ['B2C']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function B2C()
    {
        $userId = Auth::user()->id;
        $latestOrder = Order::where('user_id', $userId)->latest()->first();
        return view('b2b', ['lastOrder' => $latestOrder]);
    }

    public function B2B()
    {
        $userId = Auth::user()->id;
        $latestOrder = Order::where('user_id', $userId)->latest()->first();
        return view('b2b', ['lastOrder' => $latestOrder]);
    }
}
