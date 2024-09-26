<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.login',['guard' => 'admin']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember) && Auth::user()->is_admin)
        {
            return redirect()->intended('/');
        }  else {
            // return redirect()
            //     ->back()
            //     ->with('error', 'Invalid Credentials');
            // session()->flash('error', 'Invalid Credentials');

            return redirect()->route('admin.login')->withErrors('Invalid Credentials');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
