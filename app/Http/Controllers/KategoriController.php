<?php

namespace App\Http\Controllers;

use App\Exports\KategoriExport;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use PDF;
use Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        $log = [
            'iduser' => Auth::user()->id,
            'menu' => 'Kategori',
            'keterangan' => 'Menambah kategori',
            'before' => '',
            'after' => $kategori->kategori,
        ];

        $kategori->save();

        DB::table('log_user')->insert($log);

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
        $kategori_old = Kategori::find($id);
        $kategori->kategori = $request->input('kategori');

        $log = [
            'iduser' => Auth::user()->id,
            'menu' => 'Kategori',
            'keterangan' => 'Mengubah kategori',
            'before' => $kategori_old->kategori,
            'after' => $kategori->kategori,
        ];

        $kategori->save();

        DB::table('log_user')->insert($log);

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

        $log = [
            'iduser' => Auth::user()->id,
            'menu' => 'Kategori',
            'keterangan' => 'Mengahpus kategori',
            'before' => $kategori->kategori,
            'after' => '',
        ];

        $kategori->delete();

        DB::table('log_user')->insert($log);

        return redirect('/admin/kategori')->with('success', 'Kategori berhasil dihapus');
    }

    /**
     * Method untuk handle export PDF (PREVIEW)
     */
    public function previewPDF()
    {
        $cari = request('q');
        if ($cari) {
            $kategori = Kategori::where('kategori', 'like', "%$cari%")->get();
        } else {
            $kategori = Kategori::all();
        }
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
        $cari = request('q');
        if ($cari) {
            $kategori = Kategori::where('kategori', 'like', "%$cari%")->get();
        } else {
            $kategori = Kategori::all();
        }

        $pdf = PDF::loadView('kategori.exportpdf', [
            'data' => $kategori,
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
        // $cari = request('q');
        // if ($cari) {
        //     $kategori = Kategori::where('kategori', 'like', "%$cari%")->get();
        // } else {
        //     $kategori = Kategori::all();
        // }
        // $coba = new KategoriExport;
        // dd($coba->collection());

        return (new KategoriExport)->download('Kategori.xlsx');
    }
}
