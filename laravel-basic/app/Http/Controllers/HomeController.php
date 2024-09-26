<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $this->middleware('auth');
        return view('home');
    }

    public function home()
    {
        // dd(Auth::user()->id);
        return view('home.index');
    }

    public function contact()
    {
        return view('home.contact ');
    }

    public function secret()
    {
        return view('secret');
    }
}
