<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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

    
//protected $redirectTo = '/pub';

    public function redirectPath()
    {
        if (\Auth::user()->publication_id == 0) {
            return "/admin";
            // or return route('routename');
        }


        $pubId = \Auth::user()->publication_id;
        if ($pubId == 1)
            return "/admin";
            
        return "/pub/".$pubId;
        // or return route('routename');
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
