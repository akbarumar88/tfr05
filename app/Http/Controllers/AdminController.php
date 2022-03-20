<?php

namespace App\Http\Controllers;

use App\Models\Diagram;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function index()
    {
        return view('admin.index');
    }

    public function previewDiagram()
    {
        $dataSample = Diagram::getSample();
        // dd($dataSample);
        return view('admin.sample-diagram', [
            'dataSample' => $dataSample
        ]);
    }
}
