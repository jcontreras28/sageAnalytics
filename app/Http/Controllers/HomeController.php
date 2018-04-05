<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\GoogAnalyticsInterface;

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
}
