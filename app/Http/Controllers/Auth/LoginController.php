<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Support\Facades\Redirect;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function showLoginForm()
    {
        if(!Auth::check())
        {
            $cekmobile = strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile');
            $cekwv = strpos($_SERVER['HTTP_USER_AGENT'],'wv');
            if ($cekmobile !== false && $cekwv !== false)
            {
                return view('auth.login-mobile');
            }
            else
            {
                return view('auth.login');
            }
        }
        else
        {
            return Redirect::route('home');
        }
    }

}
