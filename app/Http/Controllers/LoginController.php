<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    //

    /**
     * Handle Login View
     */
    public function index()
    {
        return view('login.index', []);
    }
}
