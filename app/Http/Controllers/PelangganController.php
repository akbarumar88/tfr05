<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $cari = request('q');
        $entri = request('entri', 10);

        $barang = Pelanggan::select("*")
            ->when(!empty($cari), function ($query) use ($cari) {
                return $query->where('nama', 'like', "%$cari%");
            })
            ->paginate($entri)
            ->withQueryString();
        $queryParams = request()->all();
        $builtQuery = http_build_query($queryParams);
        // dd($builtQuery);

        return view('pelanggan/index', [
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
        return view('pelanggan.create', [

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pelanggan = new Pelanggan();
        $pelanggan->nama = $request->input('nama');
        $pelanggan->alamat = $request->input('alamat');
        $pelanggan->notelp = $request->input('notelp');

        $after = [
            'nama' => $pelanggan->nama,
            'alamat' => $pelanggan->alamat,
            'notelp' => $pelanggan->notelp,
        ];

        $log = [
            'iduser' => Auth::user()->id,
            'menu' => 'Pelanggan',
            'keterangan' => 'Menambah pelanggan',
            'before' => '',
            'after' => json_encode($after),
        ];

        // dd($after, $log);
        $pelanggan->save();

        DB::table('log_user')->insert($log);

        return redirect('/admin/pelanggan')->with('success', 'Pelanggan berhasil ditambahkan');
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
        $pelanggan = Pelanggan::find($id);
        // dd($pelanggan);
        return view('pelanggan.edit', [
            'pelanggan' => $pelanggan
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
        // dd($request, $id, 'Masuk dong gan');
        $pelanggan = Pelanggan::find($id);
        
        $before = [
            'nama' => $pelanggan->nama,
            'alamat' => $pelanggan->alamat,
            'notelp' => $pelanggan->notelp,
        ];

        // Assign Value Baru
        $pelanggan->nama = $request->input('nama');
        $pelanggan->alamat= $request->input('alamat');
        $pelanggan->notelp = $request->input('notelp');

        $after = [
            'nama' => $pelanggan->nama,
            'alamat' => $pelanggan->alamat,
            'notelp' => $pelanggan->notelp,
        ];

        $log = [
            'iduser' => Auth::user()->id,
            'menu' => 'Pelanggan',
            'keterangan' => 'Mengubah pelanggan',
            'before' => json_encode($before),
            'after' => json_encode($after),
        ];
        // dd($before, $after, $log);

        $pelanggan->save();

        DB::table('log_user')->insert($log);

        return redirect('/admin/pelanggan')->with('success', 'Pelanggan berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pelanggan = Pelanggan::find($id);

        $before = [
            'nama' => $pelanggan->nama,
            'alamat' => $pelanggan->alamat,
            'notelp' => $pelanggan->notelp,
        ];

        $log = [
            'iduser' => Auth::user()->id,
            'menu' => 'Pelanggan',
            'keterangan' => 'Menghapus pelanggan',
            'before' => json_encode($before),
            'after' => '',
        ];

        // dd($before, $log);
        $pelanggan->delete();

        DB::table('log_user')->insert($log);

        return redirect('/admin/pelanggan')->with('success', 'Pelanggan berhasil dihapus');
    }
}
