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
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
            // 'email' => 'required'
        ]);
        // dd($credentials);
        $attempt1 = Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']]);
        // $attempt2 = Auth::attempt(['email' => 'saiful@gmail.com', 'password' => $credentials['password']]);
        // dd([$attempt1, $attempt2]);

        if ($attempt1) {
            $request->session()->regenerate();

            return redirect()->intended('/admin');
        }

        return back()->withErrors([
            'username' => 'Username tidak ditemukan dalam database.',
            'password' => 'Password yang anda inputkan salah.'
        ]);
    }
}
