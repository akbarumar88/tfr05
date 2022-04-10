<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    //
    public function create()
    {
        // dd(session('cart'));
        $pelanggan = Pelanggan::all();
        return view('penjualan.create', [
            'pelanggan' => $pelanggan
        ]);
    }

    public function pilihBarang()
    {
        $cari = request('q');
        $entri = request('entri', 10);

        $barang = Barang::select(
                "barang.id",
                "kategori.kategori as kategori",
                "barang.nama",
                "barang.harga",
                "barang.stock",
                "barang.created_at",
                "barang.updated_at"
            )->join("kategori", "kategori.id", "=", "barang.idkategori")
            ->when(!empty($cari), function ($query) use ($cari) {
                return $query->where('nama', 'like', "%$cari%");
            })
            ->paginate($entri)
            ->withQueryString();
        // if ($cari) {
            
        // } else {
        //     $barang = barang::select(
        //         "barang.id",
        //         "kategori.kategori as kategori",
        //         "barang.nama",
        //         "barang.harga",
        //         "barang.stock",
        //         "barang.created_at",
        //         "barang.updated_at"
        //     )->join("kategori", "kategori.id", "=", "barang.idkategori")->paginate($entri)->withQueryString();
        // }
        // dd($barang);
        //
        $queryParams = request()->all();
        $builtQuery = http_build_query($queryParams);
        // dd($builtQuery);

        return view('penjualan/pilihbarang', [
            'data' => $barang,
            'params' => $builtQuery // Passing query params saat ini
        ]);
    }

    public function centang(Request $request)
    {
        // $res = [
        //     'status' => 1,
        //     'message' => 'Berhasil Gan',
        //     'data' => $request->all()
        // ];

        $barang = $request->all();
        $current = session('cart', []); // Getting old data
        
        $current[] = $barang; // Push new data
        session(['cart' => $current]);
        return json_encode([
            'status' => 1,
            'message' => "Berhasil centang"
        ]);
    }

    public function uncentang(Request $request)
    {
        $barang = $request->all();
        $current = collect(session('cart', [])); // Getting old data
        
        $filtered = $current->filter(function ($el) use ($barang)
        {
            return $el['id'] != $barang['id'];
        });
        session(['cart' => $filtered->all()]);
        return json_encode([
            'status' => 1,
            'message' => "Berhasil Uncentang"
        ]);
    }
}
