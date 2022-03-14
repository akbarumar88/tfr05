<?php

use App\Models\Kategori;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BarangController;
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

// Otentikasi
Route::get('/', 'LoginController@index');
Route::post('/login', 'LoginController@login');
Route::post('/logout', 'LoginController@logout');

// Dashboard Admin
Route::get('admin', 'AdminController@index')->middleware('cek_login');

// Kategori
// Untuk data kategori tidak ada menu Detail, jadi method show dinonaktifkan
Route::resource('admin/kategori', 'KategoriController')->except('show')->middleware('cek_login');
Route::post('admin/kategori/exportpdf', 'KategoriController@exportPDF')->middleware('cek_login');
Route::get('admin/kategori/previewpdf', 'KategoriController@previewPDF')->middleware('cek_login');

// Barang
Route::resource('admin/barang', 'BarangController')->middleware('cek_login');
Route::post('admin/barang/exportpdf', 'BarangController@exportPDF')->middleware('cek_login');
Route::get('admin/barang/previewpdf', 'BarangController@previewPDF')->middleware('cek_login');
