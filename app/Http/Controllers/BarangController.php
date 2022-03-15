<?php

namespace App\Http\Controllers;

use App\Exports\BarangExport;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use PDF;
use Excel;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cari = request('q');
        $entri = request('entri', 10);

        if ($cari) {
            $barang = barang::where('nama', 'like', "%$cari%")->paginate($entri)->withQueryString();
        } else {
            $barang = barang::paginate($entri)->withQueryString();
        }
        // dd($kategori);
        //
        $queryParams = request()->all();
        $builtQuery = http_build_query($queryParams);
        // dd($builtQuery);

        return view('barang/index', [
            'data' => $barang,
            'params' => $builtQuery // Passing query params saat ini
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('barang.create', []);
    }

    /**a
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $barang = new Barang();
        $barang->idkategori = $request->input('idkategori');
        $barang->nama = $request->input('nama');
        $barang->harga = $request->input('harga');
        $barang->save();

        return redirect('/admin/barang')->with('success', 'Barang berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $barang = Barang::find($id);
        // dd($barang);
        return view('barang.edit', [
            'barang' => $barang
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $barang = Barang::find($id);
        $barang->idkategori = $request->input('idkategori');
        $barang->nama = $request->input('nama');
        $barang->harga = $request->input('harga');
        $barang->save();

        return redirect('/admin/barang')->with('success', 'Barang berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        // dd('masuk ke destroy gan', $id);
        $barang = Barang::find($id);
        $barang->delete();

        return redirect('/admin/barang')->with('success', 'Barang berhasil dihapus');
    }

    /**
     * Method untuk handle export PDF (PREVIEW)
     */
    public function previewPDF()
    {
        $cari = request('q');
        if ($cari) {
            $barang = Barang::where('nama', 'like', "%$cari%")->get();
        } else {
            $barang = Barang::all();
        }
        return view('barang.exportpdf', [
            'data' => $barang,
        ]);
        // return $pdf->download('invoice.pdf');
    }

    /**
     * Method untuk handle export PDF
     */
    public function exportPDF()
    {
        $cari = request('q');
        if ($cari) {
            $barang = Barang::where('barang', 'like', "%$cari%")->get();
        } else {
            $barang = Barang::all();
        }

        $pdf = PDF::loadView('barang.exportpdf', [
            'data' => $barang,
        ]);
        return $pdf->stream();
        // return $pdf->download('invoice.pdf');
        // dd('masuk sini gan');
    }

    /*
     * Method untuk handle export excel 
     */
    public function exportExcel()
    {
        return (new BarangExport)->download('Barang.xlsx');
    }
}
