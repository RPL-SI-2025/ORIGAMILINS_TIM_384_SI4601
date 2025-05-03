<?php

use App\Http\Controllers\Admin\Produk_Controller;
use App\Http\Controllers\Admin\EventController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserProfileController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\ArtikelController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\PengrajinManagementController;
use App\Http\Controllers\Admin\EventReviewController;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Controllers\Admin\PesananEventController;
use App\Http\Controllers\Admin\ProductReviewController;

// Home
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Event Publik
Route::get('/event', [EventController::class, 'index'])->name('event.melihat_event');

// Authentication
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// User Profile (butuh login)
Route::middleware(['auth'])->group(function () {
    Route::get('/profilpengguna', [UserProfileController::class, 'show'])->name('profilpengguna');
    Route::get('/profilpengguna/create', [UserProfileController::class, 'create'])->name('profilpengguna.create');
    Route::post('/profilpengguna', [UserProfileController::class, 'store'])->name('profilpengguna.store');
    Route::put('/profilpengguna/{user}', [UserProfileController::class, 'update'])->name('profilpengguna.update');
    
    // Dashboard
    Route::get('/dashboard', function () {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return view('user.dashboard');
    })->name('dashboard');

    // Pesanan Produk
    Route::get('/pesananproduk', [PesananController::class, 'index'])->name('pesananproduk.index');
    Route::get('/pesananproduk/{id_pesanan}/edit', [PesananController::class, 'edit'])->name('pesananproduk.edit');
    Route::put('/pesananproduk/{id_pesanan}', [PesananController::class, 'update'])->name('pesananproduk.update');
    Route::get('/pesananproduk/{id_pesanan}', [PesananController::class, 'show'])->name('pesananproduk.show');
});

// Produk Input Publik
Route::get('/produk/tambah', [Produk_Controller::class, 'create'])->name('produk.tambah_produk');
Route::post('/produk/store', [Produk_Controller::class, 'store'])->name('produk.store');

// Tes Middleware Admin
Route::get('/test-admin', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    $user = Auth::user();
    return "Logged in as: {$user->name} (Role: {$user->role})";
})->middleware(['auth', AdminMiddleware::class]);

// Admin Routes
Route::prefix('admin')->middleware(['auth', AdminMiddleware::class])->group(function () {
    // Dashboard
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Manajemen Produk
    Route::prefix('produk')->name('admin.produk.')->group(function () {
        Route::get('/', [Produk_Controller::class, 'index'])->name('index');
        Route::get('/create', [Produk_Controller::class, 'create'])->name('create');
        Route::post('/', [Produk_Controller::class, 'store'])->name('store');
        Route::get('/{product}', [Produk_Controller::class, 'show'])->name('show');
        Route::get('/{product}/edit', [Produk_Controller::class, 'edit'])->name('edit');
        Route::put('/{product}', [Produk_Controller::class, 'update'])->name('update');
        Route::delete('/{product}', [Produk_Controller::class, 'destroy'])->name('destroy');
    });

    // Manajemen Event
    Route::prefix('event')->name('admin.event.')->group(function () {
        Route::get('/', [EventController::class, 'index'])->name('index');
        Route::get('/create', [EventController::class, 'create'])->name('create');
        Route::post('/', [EventController::class, 'store'])->name('store');
        Route::get('/{event}', [EventController::class, 'show'])->name('show');
        Route::get('/{event}/edit', [EventController::class, 'edit'])->name('edit');
        Route::put('/{event}', [EventController::class, 'update'])->name('update');
        Route::delete('/{event}', [EventController::class, 'destroy'])->name('destroy');
    });

    // Manajemen Artikel
    Route::prefix('artikel')->name('admin.artikel.')->group(function () {
        Route::get('/', [ArtikelController::class, 'index'])->name('index');
        Route::get('/create', [ArtikelController::class, 'create'])->name('create');
        Route::post('/', [ArtikelController::class, 'store'])->name('store');
        Route::get('/{id_artikel}', [ArtikelController::class, 'show'])->name('show');
        Route::get('/{id_artikel}/edit', [ArtikelController::class, 'edit'])->name('edit');
        Route::put('/{id_artikel}', [ArtikelController::class, 'update'])->name('update');
        Route::delete('/{id_artikel}', [ArtikelController::class, 'destroy'])->name('destroy');
    });

    // Manajemen User
    Route::prefix('users')->name('admin.users.')->group(function () {
        Route::get('/', [UserManagementController::class, 'index'])->name('index');
        Route::post('/{user}/toggle-status', [UserManagementController::class, 'toggleStatus'])->name('toggle-status');
    });

    // Manajemen Pengrajin
    Route::prefix('pengrajin')->name('admin.pengrajin.')->group(function () {
        Route::get('/', [PengrajinManagementController::class, 'index'])->name('index');
        Route::post('/{pengrajin}/toggle-status', [PengrajinManagementController::class, 'toggleStatus'])->name('toggle-status');
        Route::get('/{pengrajin}/details', [PengrajinManagementController::class, 'showDetails'])->name('details');
    });

    // Manajemen Event Reviews
    Route::prefix('event-reviews')->name('admin.event-reviews.')->group(function () {
        Route::get('/', [EventReviewController::class, 'index'])->name('index');
        Route::get('/{review}', [EventReviewController::class, 'show'])->name('show');
        Route::patch('/{review}/approve', [EventReviewController::class, 'approve'])->name('approve');
        Route::patch('/{review}/reject', [EventReviewController::class, 'reject'])->name('reject');
    });

    // Manajemen Pesanan Produk
    Route::prefix('pesanan-produk')->name('admin.pesananproduk.')->group(function () {
        Route::get('/', [PesananController::class, 'index'])->name('index');
        Route::get('/{id_pesanan}/edit', [PesananController::class, 'edit'])->name('edit');
        Route::put('/{id_pesanan}', [PesananController::class, 'update'])->name('update');
        Route::get('/{id_pesanan}', [PesananController::class, 'show'])->name('show');
        Route::post('/{id}/mark-siap-dikirim', [PesananController::class, 'markSiapDikirim'])->name('markSiapDikirim');
    });

    // Manajemen Pesanan Event
    Route::prefix('pesanan-event')->name('admin.pesananevent.')->group(function () {
        Route::get('/', [PesananEventController::class, 'index'])->name('index');
        Route::get('/{id_pesanan_event}/edit', [PesananEventController::class, 'edit'])->name('edit');
        Route::put('/{id_pesanan_event}', [PesananEventController::class, 'update'])->name('update');
    });

    // Product Reviews
    Route::prefix('product-reviews')->name('admin.product-reviews.')->group(function () {
        Route::get('/', [ProductReviewController::class, 'index'])->name('index');
        Route::get('/{review}', [ProductReviewController::class, 'show'])->name('show');
        Route::post('/{review}/approve', [ProductReviewController::class, 'approve'])->name('approve');
        Route::post('/{review}/reject', [ProductReviewController::class, 'reject'])->name('reject');
    });
});

// Debug Route
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
