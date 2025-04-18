<?php

use App\Http\Controllers\Produk_Controller;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserProfileController;

use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Auth;


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

    // Manajemen Event
    Route::get('/event', [EventController::class, 'index'])->name('admin.event.index');
    Route::get('/event/create', [EventController::class, 'create'])->name('admin.event.create');
    Route::post('/event', [EventController::class, 'store'])->name('admin.event.store');
    Route::get('/event/{event}', [EventController::class, 'show'])->name('admin.event.show');
    Route::get('/event/{event}/edit', [EventController::class, 'edit'])->name('admin.event.edit');
    Route::put('/event/{event}', [EventController::class, 'update'])->name('admin.event.update');
    Route::delete('/event/{event}', [EventController::class, 'destroy'])->name('admin.event.destroy');
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
