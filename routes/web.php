<?php

use App\Models\Kategori;
use App\Http\Controllers\KategoriController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Route::get('/kategori', function ()
// {
//     return view('kategori.index', [
//         'judul' => 'Kategori',
//         'data' => Kategori::all()
//     ]);
// });

// Route::get('/kategori/{id}', function ($id)
// {
//     return view('kategori.detail', [
//         'judul' => 'Kategori',
//         'data' => Kategori::find($id)
//     ]);
// });

Route::get('/', 'LoginController@index');
// Untuk data kategori tidak ada menu Detail, jadi method show dinonaktifkan
Route::resource('admin/kategori', 'KategoriController')->except('show');
Route::post('admin/kategori/exportpdf', 'KategoriController@exportPDF');
Route::get('admin/kategori/previewpdf', 'KategoriController@previewPDF');
