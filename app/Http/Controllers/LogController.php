<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogUser;

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
}
