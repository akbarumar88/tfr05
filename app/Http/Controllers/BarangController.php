<?php

namespace App\Http\Controllers;

use App\Exports\BarangExport;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use PDF;
use Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        $barang = barang::select(
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
        $kategori = Kategori::all();

        //
        return view('barang.create', [
            'data' => $kategori,
        ]);
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
        $barang->idkategori = $request->input('kategori');
        $barang->nama = $request->input('nama');
        $barang->harga = $request->input('harga');
        $barang->stock = $request->input('stok');
        $barang->save();

        $kategori = Kategori::find($barang->idkategori);

        $after = [
            'kategori' => $kategori->kategori,
            'nama' => $barang->nama,
            'harga' => $barang->harga,
            'stock' => $barang->stock,
        ];

        $log = [
            'iduser' => Auth::user()->id,
            'menu' => 'Barang',
            'keterangan' => 'Menambah barang',
            'before' => '',
            'after' => json_encode($after),
        ];

        DB::table('log_user')->insert($log);

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
        $kategori = Kategori::all();
        $barang = Barang::find($id);
        // dd($barang);
        return view('barang.edit', [
            'kategori' => $kategori,
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
        $barang_old = Barang::find($id);
        $barang->idkategori = $request->input('kategori');
        $barang->nama = $request->input('nama');
        $barang->harga = $request->input('harga');
        $barang->stock = $request->input('stok');
        $barang->save();

        $kategori_old = Kategori::find($barang_old->idkategori);
        $kategori = Kategori::find($barang->idkategori);

        $before = [
            'kategori' => $kategori_old->kategori,
            'nama' => $barang_old->nama,
            'harga' => $barang_old->harga,
            'stock' => $barang_old->stock,
        ];

        $after = [
            'kategori' => $kategori->kategori,
            'nama' => $barang->nama,
            'harga' => $barang->harga,
            'stock' => $barang->stock,
        ];

        $log = [
            'iduser' => Auth::user()->id,
            'menu' => 'Barang',
            'keterangan' => 'Mengubah barang',
            'before' => json_encode($before),
            'after' => json_encode($after),
        ];

        DB::table('log_user')->insert($log);

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
        $kategori = Kategori::find($barang->idkategori);

        $before = [
            'kategori' => $kategori->kategori,
            'nama' => $barang->nama,
            'harga' => $barang->harga,
            'stock' => $barang->stock,
        ];

        $log = [
            'iduser' => Auth::user()->id,
            'menu' => 'Barang',
            'keterangan' => 'Mengahpus barang',
            'before' => json_encode($before),
            'after' => '',
        ];

        $barang->delete();

        DB::table('log_user')->insert($log);

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
            $barang = barang::select(
                "barang.id",
                "kategori.kategori as kategori",
                "barang.nama",
                "barang.harga",
                "barang.stock",
                "barang.created_at",
                "barang.updated_at",
            )->join("kategori", "kategori.id", "=", "barang.idkategori")->where('nama', 'like', "%$cari%")->get();
        } else {
            $barang = barang::select(
                "barang.id",
                "kategori.kategori as kategori",
                "barang.nama",
                "barang.harga",
                "barang.stock",
                "barang.created_at",
                "barang.updated_at",
            )->join("kategori", "kategori.id", "=", "barang.idkategori")->get();
        }
        // if ($cari) {
        //     $barang = Barang::where('barang', 'like', "%$cari%")->get();
        // } else {
        //     $barang = Barang::all();
        // }

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
