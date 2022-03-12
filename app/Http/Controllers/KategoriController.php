<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use PDF;

class KategoriController extends Controller
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
            $kategori = Kategori::where('kategori', 'like', "%$cari%")->paginate($entri)->withQueryString();
        } else {
            $kategori = Kategori::paginate($entri)->withQueryString();
        }
        // dd($kategori);
        //
        $queryParams = request()->all();
        $builtQuery = http_build_query($queryParams);
        // dd($builtQuery);

        return view('kategori/index', [
            'data' => $kategori,
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
        return view('kategori.create', []);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $kategori = new Kategori();
        $kategori->kategori = $request->input('kategori');
        $kategori->save();

        return redirect('/admin/kategori')->with('success', 'Kategori berhasil ditambahkan');
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
        $kategori = Kategori::find($id);
        // dd($kategori);
        return view('kategori.edit', [
            'kategori' => $kategori
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
        $kategori = Kategori::find($id);
        $kategori->kategori = $request->input('kategori');
        $kategori->save();

        return redirect('/admin/kategori')->with('success', 'Kategori berhasil diubah');
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
        $kategori = Kategori::find($id);
        $kategori->delete();

        return redirect('/admin/kategori')->with('success', 'Kategori berhasil dihapus');
    }

    /**
     * Method untuk handle export PDF (PREVIEW)
     */
    public function previewPDF()
    {
        $kategori = Kategori::paginate(100)->withQueryString();
        return view('kategori.exportpdf', [
            'data' => $kategori,
        ]);
        // return $pdf->download('invoice.pdf');
    }

    /**
     * Method untuk handle export PDF
     */
    public function exportPDF()
    {
        $kategori = Kategori::paginate(100)->withQueryString();
        $pdf = PDF::loadView('kategori.exportpdf', [
            'data' => $kategori,
        ]);
        return $pdf->stream();
        // return $pdf->download('invoice.pdf');
        // dd('masuk sini gan');
    }
}
