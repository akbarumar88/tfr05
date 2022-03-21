<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index', [
            'judul' => 'Nama Web | Home'
        ]);
    }
}
