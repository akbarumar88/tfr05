<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            $log = [
                'iduser' => Auth::user()->id,
                'menu' => 'Log In',
                'keterangan' => 'User telah log in',
                'before' => '',
                'after' => '',
            ];

            DB::table('log_user')->insert($log);

            $request->session()->regenerate();

            return redirect()->intended('/admin');
        }

        return back()->withErrors([
            'username' => 'Username tidak ditemukan dalam database.',
            'password' => 'Password yang anda inputkan salah.'
        ]);
    }

    /**
     * Fungsi untuk handle logout user.
     */
    public function logout(Request $request)
    {
        $log = [
            'iduser' => Auth::user()->id,
            'menu' => 'Log Out',
            'keterangan' => 'User telah log out',
            'before' => '',
            'after' => '',
        ];

        DB::table('log_user')->insert($log);

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); // Arahkan ke halaman login.
    }
}
