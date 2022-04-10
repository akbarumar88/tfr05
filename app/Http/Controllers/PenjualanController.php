<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    //
    public function create()
    {
        $pelanggan = Pelanggan::all();
        return view('penjualan.create', [
            'pelanggan' => $pelanggan
        ]);
    }
}
