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
        $iduser = auth()->user()->id;
        $head = session($iduser.'_penjualan');
        // dd($head);
        // session(['cart' => []]);
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
        $iduser = auth()->user()->id;
        $current = session($iduser . '_cart', []);

        $current[] = array_merge($barang, ['jumlah' => 1]); // Push new data
        session([$iduser . '_cart' => $current]);
        return json_encode([
            'status' => 1,
            'message' => "Berhasil centang"
        ]);
    }

    public function uncentang(Request $request)
    {
        $barang = $request->all();
        $iduser = auth()->user()->id;
        $current = collect(session($iduser . '_cart', [])); // Getting old data

        $filtered = $current->filter(function ($el) use ($barang) {
            return $el['id'] != $barang['id'];
        });
        session([$iduser . '_cart' => $filtered]);
        return json_encode([
            'status' => 1,
            'message' => "Berhasil Uncentang"
        ]);
    }

    public function setSession(Request $request)
    {
        $data = $request->all();
        $iduser = auth()->user()->id;

        session([$iduser . '_penjualan' => $data]);
        return json_encode([
            'status' => 1,
            'message' => "Berhasil set session",
            'data' => $data,
            'iduser' => $iduser
        ]);
    }

    public function hapusBarang(Request $request)
    {
        $data = $request->all();
        $iduser = auth()->user()->id;
        $id = $data['id'];

        $current = collect(session($iduser . '_cart', []));
        $filtered = $current->filter(function ($el) use ($id)
        {
            return $el['id'] != $id;
        });
        session([$iduser . '_cart' => $filtered]);
        return json_encode([
            'status' => 1,
            'message' => "Berhasil Hapus Keranjang"
        ]);
    }
}
