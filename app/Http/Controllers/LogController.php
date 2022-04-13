<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogUser;
use PDF;

class LogController extends Controller
{
    public function index()
    {
        $cari = request('q');
        $entri = request('entri', 10);

        if ($cari) {
            $logUser = LogUser::where('menu', 'like', "%$cari%")->paginate($entri)->withQueryString();
        } else {
            $logUser = LogUser::paginate($entri)->withQueryString();
        }
        // dd($kategori);
        //
        $queryParams = request()->all();
        $builtQuery = http_build_query($queryParams);
        // dd($builtQuery);

        return view('log/index', [
            'data' => $logUser,
            'params' => $builtQuery // Passing query params saat ini
        ]);
    }

    public function previewPDF()
    {
        $cari = request('q');
        if ($cari) {
            $logUser = LogUser::where('menu', 'like', "%$cari%")->get();
        } else {
            $logUser = LogUser::all();
        }
        return view('log.exportpdf', [
            'data' => $logUser,
        ]);
    }

    public function exportPDF()
    {
        $cari = request('q');
        if ($cari) {
            $logUser = LogUser::where('menu', 'like', "%$cari%")->get();
        } else {
            $logUser = LogUser::all();
        }

        $pdf = PDF::loadView('log.exportpdf', [
            'data' => $logUser,
        ]);
        return $pdf->stream();
    }
}
