<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::get('/', function () {
    return view('admin.beranda.index');
});

Route::match(['get', 'post'], '/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->group(function () {
    Route::resource('kategori', App\Http\Controllers\Admin\KategoriController::class)->names('admin.kategori');
    Route::resource('unit', App\Http\Controllers\Admin\UnitController::class)->names('admin.unit');
    Route::resource('barang', App\Http\Controllers\Admin\BarangController::class)->names('admin.barang');
    Route::resource('meja', App\Http\Controllers\Admin\MejaController::class)->names('admin.meja');
    Route::resource('menu', App\Http\Controllers\Admin\MenuController::class)->names('admin.menu');
});

Route::get('/storage-link', function () {
    Artisan::call('storage:link');

    return 'Storage link created!';
});
