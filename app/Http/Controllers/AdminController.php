<?php

namespace App\Http\Controllers;

use App\Models\Diagram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    //
    public function index()
    {
        // Mengambil 10 barang dengan pengadaan terbanyak.
        $barangUrutStok = DB::table('barang')
            ->orderBy('stock', 'desc')
            ->limit(10)
            ->get(['id', 'nama', 'stock']);

        $kategoriUrutStok = DB::table('barang', 'b')
            ->join('kategori as k', 'k.id', '=', 'b.idkategori')
            ->groupBy(['b.idkategori', 'k.kategori'])
            ->orderBy('jumlah_stok', 'desc')
            ->get(['b.idkategori', 'k.kategori', DB::raw('sum(b.stock) as jumlah_stok')]);

        // Mengambil Data Barang Terlaris.
        $barangTerlaris = DB::table('penjualan_detail', 'pd')
            ->join('barang as b2', 'b2.id', '=', 'pd.idbarang')
            ->groupBy(['pd.idbarang', 'b2.nama'])
            ->orderBy('terjual', 'desc')
            ->limit(10)
            ->get(['idbarang', DB::raw('COUNT(pd.id) as terjual'), 'b2.nama']);
        // dd($barangTerlaris);
        return view('admin.index', [
            'barang' => $barangUrutStok,
            'kategori' => $kategoriUrutStok,
            'barangTerlaris' => $barangTerlaris
        ]);
    }

    public function previewDiagram()
    {
        $dataSample = Diagram::getSample();
        // dd($dataSample);
        return view('admin.sample-diagram', [
            'dataSample' => $dataSample
        ]);
    }

    public function about()
    {
        return view('admin.about');
    }
}
