<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

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
Route::get('/', [AuthController::class, 'index'])->name('login');
// Main
Route::prefix('/apotek')->name('apotek.')->group(function () {
    Route::post('/postlogin', [AuthController::class, 'login'])->name('postlogin');
    Route::get('/logout', [AuthController::class, 'signOut'])->name('logout');
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('home')->middleware('auth');
    // User Handling
    Route::get('/user/data', [UserController::class, 'userData'])->name('userInfo')->middleware('auth');
    Route::post('/user/create', [UserController::class, 'signupsave'])->name('postsignup');
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('edit')->middleware('auth');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('update');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('useDestroy');
    // Obat Handling
    Route::get('/obat/data', [ObatController::class, 'obatData'])->name('obatInfo')->middleware('auth');
    Route::post('/obat/create', [ObatController::class, 'tambahObat'])->name('tambah');
    Route::get('/obat/{id}/edit', [ObatController::class, 'obatEdit'])->name('obatEdit')->middleware('auth');
    Route::put('/obat/{id}', [ObatController::class, 'obatUpdate'])->name('obatUpdate');
    Route::delete('/obat/{id}', [ObatController::class, 'obatDestroy'])->name('obatDestroy');
    Route::get('/obat/stock', [ObatController::class, 'stock'])->name('obatStok')->middleware('auth');
    Route::get('/obat/{id}/stock', [ObatController::class, 'stockEdit'])->name('stokEdit')->middleware('auth');
    Route::put('/stock/{id}', [ObatController::class, 'stockUpdate'])->name('stockUpdate');
});

