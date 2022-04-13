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

        $logUser = LogUser::select(
            "log_user.id",
            "user.nama as user",
            "log_user.menu",
            "log_user.keterangan",
            "log_user.created_at",
        )->join("user", "user.id", "=", "log_user.iduser")
            ->when(!empty($cari), function ($query) use ($cari) {
                return $query->where('menu', 'like', "%$cari%");
            })
            ->paginate($entri)
            ->withQueryString();

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

        $logUser = LogUser::select(
            "log_user.id",
            "user.nama as user",
            "log_user.menu",
            "log_user.keterangan",
            "log_user.created_at",
        )->join("user", "user.id", "=", "log_user.iduser")
            ->where('menu', 'like', "%$cari%")->get();

        return view('log.exportpdf', [
            'data' => $logUser,
        ]);
    }

    public function exportPDF()
    {
        $cari = request('q');

        $logUser = LogUser::select(
            "log_user.id",
            "user.nama as user",
            "log_user.menu",
            "log_user.keterangan",
            "log_user.created_at",
        )->join("user", "user.id", "=", "log_user.iduser")
            ->where('menu', 'like', "%$cari%")->get();


        $pdf = PDF::loadView('log.exportpdf', [
            'data' => $logUser,
        ]);
        return $pdf->stream();
    }
}
