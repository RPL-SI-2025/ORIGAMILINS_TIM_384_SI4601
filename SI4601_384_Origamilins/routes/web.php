<?php

use App\Http\Controllers\Produk_Controller;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// testing aja
Route::get('/produk', [Produk_Controller::class, 'index']);

// utama
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/produk', [Produk_Controller::class, 'index'])->name('admin.produk.index');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
