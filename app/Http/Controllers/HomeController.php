<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Order;
use App\User;

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
        $this->middleware('permission:'.$this->controller.'@B2B', ['only' => ['B2B']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home', ['users' => User::where('role', '<>', 1)->get()]);
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

    public function revoke(Request $request)
    {
        if($request->has('id')) {
            
            $user = User::find($request->id);
            if($user) {
                $role = $user->role == 2 ?  'B2C' : 'B2B';
                $user->removeRole($role);
                session()->flash('success', 'Role Revoked');
                return redirect()->back();
            }
        } else {
            session()->flash('error', 'User ID is missing');
            return redirect()->back();
        }
    }
}
