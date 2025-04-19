<?php

use App\Http\Controllers\Produk_Controller;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserProfileController;

use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ArtikelController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/produk', [Produk_Controller::class, 'index'])->name('produk.melihat_produk');

Route::middleware(['auth'])->group(function () {
    Route::get('/profilpengguna', [UserProfileController::class, 'create'])->name('profile.create');
    Route::post('/profilpengguna', [UserProfileController::class, 'store'])->name('profile.store');

    // Redirect berdasarkan role
    Route::get('/dashboard', function () {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return view('user.dashboard');
    })->name('dashboard');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/produk', [Produk_Controller::class, 'index'])->name('admin.produk.index');
});

// Authentication Routes
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

Route::get('/produk/tambah', [Produk_Controller::class, 'create'])->name('produk.tambah_produk');
Route::post('/produk/store', [Produk_Controller::class, 'store'])->name('produk.store');


// Test route untuk admin middleware
Route::get('/test-admin', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $user = Auth::user();
    return "Logged in as: {$user->name} (Role: {$user->role})";
})->middleware('auth')->middleware(AdminMiddleware::class);

// Route untuk event publik
Route::get('/event', [EventController::class, 'index'])->name('event.melihat_event');
Route::get('/event/tambah', [EventController::class, 'create'])->name('event.tambah_event');
Route::post('/event/store', [EventController::class, 'store'])->name('event.store');

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
    Route::get('/produk/{product}/edit', [Produk_Controller::class, 'edit'])->name('admin.produk.edit');
    Route::put('/produk/{product}', [Produk_Controller::class, 'update'])->name('admin.produk.update');
    Route::delete('/produk/{product}', [Produk_Controller::class, 'destroy'])->name('admin.produk.destroy');
    Route::get('/produk/{product}', [Produk_Controller::class, 'show'])->name('admin.produk.show');

    // Manajemen Event
    Route::get('/event', [EventController::class, 'index'])->name('admin.event.index');
    Route::get('/event/create', [EventController::class, 'create'])->name('admin.event.create');
    Route::post('/event', [EventController::class, 'store'])->name('admin.event.store');
    Route::get('/event/{event}', [EventController::class, 'show'])->name('admin.event.show');
    Route::get('/event/{event}/edit', [EventController::class, 'edit'])->name('admin.event.edit');
    Route::put('/event/{event}', [EventController::class, 'update'])->name('admin.event.update');
    Route::delete('/event/{event}', [EventController::class, 'destroy'])->name('admin.event.destroy');

    // Manajemen Artikel
    Route::get('/artikel', [ArtikelController::class, 'index'])->name('admin.artikel.index');
    Route::get('/artikel/create', [ArtikelController::class, 'create'])->name('admin.artikel.create');
    Route::post('/artikel', [ArtikelController::class, 'store'])->name('admin.artikel.store');
    Route::get('/artikel/{id_artikel}', [ArtikelController::class, 'show'])->name('admin.artikel.show');
    Route::get('/artikel/{id_artikel}/edit', [ArtikelController::class, 'edit'])->name('admin.artikel.edit');
    Route::put('/artikel/{id_artikel}', [ArtikelController::class, 'update'])->name('admin.artikel.update');
    Route::delete('/artikel/{id_artikel}', [ArtikelController::class, 'destroy'])->name('admin.artikel.destroy');
});

// Debug login
Route::get('/debug-login', function () {
    if (!Auth::check()) {
        return 'Status: Not logged in';
    }

    $user = Auth::user();
    return [
        'status' => 'Logged in',
        'user' => [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role
        ]
    ];
});
