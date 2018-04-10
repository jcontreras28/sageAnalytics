<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\GoogAnalyticsInterface;
use Hash;
use Auth;

class HomeController extends Controller
{
    use GoogAnalyticsInterface;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$GAConn = __DIR__.'/CredentialsJson/BendBulletinSage.json';
        $GAConn = $this->connect(__DIR__.'/CredentialJson/BendBulletinSage.json', 'BendBulletin');

        $resultsTotalPages = $this->getAllPageViews($GAConn, "3577111", '0daysAgo', 'today'); 

        return view('home', compact('resultsTotalPages'));
        //return view('home');
    }

    public function showChangePasswordForm() {
        return view('auth.changepassword');
    }

    public function changePassword(Request $request){
 
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not match the password you provided. Please try again.");
        }
 
        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }
 
        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);
 
        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        return redirect()->back()->with("success","Password changed successfully !");
    }
}
