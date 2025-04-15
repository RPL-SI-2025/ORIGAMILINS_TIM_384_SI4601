<?php

use App\Http\Controllers\Produk_Controller;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Auth;

// Halaman welcome
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// Route produk (publik/user)
Route::get('/produk', [Produk_Controller::class, 'index'])->name('produk.melihat_produk');
Route::get('/produk/tambah', [Produk_Controller::class, 'create'])->name('produk.tambah_produk');
Route::post('/produk/store', [Produk_Controller::class, 'store'])->name('produk.store');

// Test route untuk admin middleware
Route::get('/test-admin', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    $user = auth()->user();
    return "Logged in as: {$user->name} (Role: {$user->role})";
})->middleware('auth')->middleware(AdminMiddleware::class);

// Route untuk user yang sudah login
Route::middleware(['auth'])->group(function () {
    // Redirect berdasarkan role
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return view('user.dashboard');
    })->name('dashboard');
});

// Route khusus admin
Route::prefix('admin')->middleware(['auth', AdminMiddleware::class])->group(function () {
    // Dashboard Admin
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Manajemen Produk
    Route::get('/produk', [Produk_Controller::class, 'index'])->name('admin.produk.index');
    Route::get('/produk/create', [Produk_Controller::class, 'create'])->name('admin.produk.create');
    Route::post('/produk', [Produk_Controller::class, 'store'])->name('admin.produk.store');
});

// Route untuk event
Route::resource('events', EventController::class);

// Debug login
Route::get('/debug-login', function () {
    if (!auth()->check()) {
        return 'Status: Not logged in';
    }

    $user = auth()->user();
    return [
        'status' => 'Logged in',
        'user' => [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role
        ]
    ];
});
