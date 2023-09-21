<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use \Illuminate\Http\Request;
use Auth;
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    public function credentials(Request $request)
    {
        $credentials = $request->only('email', 'password');
        return $credentials;
    } 

    public function redirectTo() {
        $role = Auth::user()->role; 
        Session::forget('session_timeout');
        switch ($role) {
          case '1':
            return 'home';
            break;
          case '2':
            return 'B2C';
            break;
          case '3':
            return 'B2B';
            break;
          default:
            return 'login'; 
            break;
        }
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
