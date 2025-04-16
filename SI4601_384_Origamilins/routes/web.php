<?php

use App\Http\Controllers\Produk_Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/produk', [Produk_Controller::class, 'index']);

Route::middleware(['auth'])->group(function () {
    Route::get('/profilpengguna', [UserProfileController::class, 'create'])->name('profile.create');
    Route::post('/profilpengguna', [UserProfileController::class, 'store'])->name('profile.store');
});

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

Route::middleware(['auth:sanctum', 'verified'])->get('/redirect-by-role', function () {
    $user = auth()->user();

    if ($user->role === 'admin') {
        return redirect('/admin');
    } else {
        return redirect('/dashboard');
    }
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('dashboard');
});

