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
    return redirect("/login");
});

Route::match(['get', 'post'], '/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->middleware(['auth', 'checkRole:admin'])->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('kategori', App\Http\Controllers\Admin\KategoriController::class)->names('admin.kategori');
    Route::resource('unit', App\Http\Controllers\Admin\UnitController::class)->names('admin.unit');
    Route::resource('barang', App\Http\Controllers\Admin\BarangController::class)->names('admin.barang');
    Route::resource('meja', App\Http\Controllers\Admin\MejaController::class)->names('admin.meja');
    Route::resource('menu', App\Http\Controllers\Admin\MenuController::class)->names('admin.menu');
    Route::resource('pembayaran', App\Http\Controllers\Admin\PembayaranController::class)->names('admin.pembayaran');
    Route::resource('user', App\Http\Controllers\Admin\UserController::class)->names('admin.user');
    Route::resource('stok', App\Http\Controllers\Admin\StokController::class)->names('admin.stok');
    Route::resource('detail-stok', App\Http\Controllers\Admin\DetailStokController::class)->names('admin.detail-stok');
    Route::match(['get', 'put'], 'profil', [App\Http\Controllers\Admin\ProfilController::class, 'index'])->name('admin.profil');
    Route::put('profil/password', [App\Http\Controllers\Admin\ProfilController::class, 'updatePassword'])->name('admin.profil.password');
});

Route::prefix('kasir')->middleware(['auth', 'checkRole:kasir'])->group(function () {
    Route::get('/', [App\Http\Controllers\Kasir\DashboardController::class, 'index'])->name('kasir.dashboard');
    Route::match(['get', 'put'], 'profil', [App\Http\Controllers\Kasir\ProfilController::class, 'index'])->name('kasir.profil');
    Route::put('profil/password', [App\Http\Controllers\Kasir\ProfilController::class, 'updatePassword'])->name('kasir.profil.password');
});

Route::get('/storage-link', function () {
    Artisan::call('storage:link');

    return 'Storage link created!';
});
