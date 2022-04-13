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
Route::post('admin/kategori/exportexcel', 'KategoriController@exportExcel')->middleware('cek_login');

// Barang
Route::resource('admin/barang', 'BarangController')->middleware('cek_login');
Route::post('admin/barang/exportpdf', 'BarangController@exportPDF')->middleware('cek_login');
Route::get('admin/barang/previewpdf', 'BarangController@previewPDF')->middleware('cek_login');
Route::post('admin/barang/exportexcel', 'BarangController@exportExcel')->middleware('cek_login');

// Pelanggan
Route::resource('admin/pelanggan', 'PelangganController')->middleware('cek_login');
Route::post('admin/pelanggan/exportpdf', 'PelangganController@exportPDF')->middleware('cek_login');
Route::get('admin/pelanggan/previewpdf', 'PelangganController@previewPDF')->middleware('cek_login');
Route::post('admin/pelanggan/exportexcel', 'PelangganController@exportExcel')->middleware('cek_login');

// Routing Transaksi Penjualan
Route::get('admin/penjualan', 'PenjualanController@create')->middleware('cek_login');
Route::post('admin/penjualan', 'PenjualanController@store')->middleware('cek_login');
Route::get('admin/penjualan/pilihbarang', 'PenjualanController@pilihBarang')->middleware('cek_login');
Route::post('admin/penjualan/centang', 'PenjualanController@centang')->middleware('cek_login');
Route::post('admin/penjualan/uncentang', 'PenjualanController@uncentang')->middleware('cek_login');
Route::post('admin/penjualan/setsession', 'PenjualanController@setSession')->middleware('cek_login');
Route::post('admin/penjualan/hapusbarang', 'PenjualanController@hapusBarang')->middleware('cek_login');
Route::post('admin/penjualan/cekstok', 'PenjualanController@cekStok')->middleware('cek_login');

// Log
Route::get('admin/log', 'LogController@index')->middleware('cek_login');

// Sample Diagram
Route::get('previewdiagram', 'AdminController@previewDiagram');
// Menampilkan Logo UPN & Kata-kata
Route::get('about', 'AdminController@about');
