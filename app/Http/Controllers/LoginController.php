<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //

    /**
     * Handle Login View.
     */
    public function index()
    {
        return view('login.index', []);
    }

    /**
     * Fungsi untuk handle login.
     */
    public function login(Request $request)
    {
        // dd($request);
        $credentials = $request->validate([]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->intended('dashboard');
        }
 
        return back()->withErrors([
            'username' => 'Username tidak ditemukan dalam database.',
            'password' => 'Password yang anda inputkan salah.'
        ]);
    }
}
