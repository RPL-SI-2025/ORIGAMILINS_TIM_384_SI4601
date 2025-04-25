<?php

use App\Http\Controllers\Produk_Controller;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserProfileController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\EventReviewController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\PesananEventController;
use App\Http\Controllers\ProductReviewController;

Route::get('/', function () {
    return view('welcome');
});

// Produk Publik
Route::get('/produk', [Produk_Controller::class, 'index'])->name('produk.melihat_produk');

// Authenticated User Routes
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

    // Pesanan Produk
    Route::get('/pesananproduk', [PesananController::class, 'index'])->name('admin.pesananproduk.index');
    Route::get('/pesananproduk/{id_pesanan}/edit', [PesananController::class, 'edit'])->name('admin.pesananproduk.edit');
    Route::put('/pesananproduk/{id_pesanan}', [PesananController::class, 'update'])->name('admin.pesananproduk.update');

    // Pesanan Event
    Route::get('/pesananevent', [PesananEventController::class, 'index'])->name('admin.pesananevent.index');
    Route::get('/pesananevent/{id_pesanan_event}/edit', [PesananEventController::class, 'edit'])->name('admin.pesananevent.edit');
    Route::put('/pesananevent/{id_pesanan_event}', [PesananEventController::class, 'update'])->name('admin.pesananevent.update');
});

// Admin Route Sementara
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/produk', [Produk_Controller::class, 'index'])->name('admin.produk.index');
});

// Authentication
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// Produk Input
Route::get('/produk/tambah', [Produk_Controller::class, 'create'])->name('produk.tambah_produk');
Route::post('/produk/store', [Produk_Controller::class, 'store'])->name('produk.store');

// Tes Middleware Admin
Route::get('/test-admin', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $user = Auth::user();
    return "Logged in as: {$user->name} (Role: {$user->role})";
})->middleware('auth')->middleware(AdminMiddleware::class);

// Event Publik
Route::get('/event', [EventController::class, 'index'])->name('event.melihat_event');
Route::get('/event/tambah', [EventController::class, 'create'])->name('event.tambah_event');
Route::post('/event/store', [EventController::class, 'store'])->name('event.store');

// Admin Panel Routes
Route::prefix('admin')->middleware(['auth', AdminMiddleware::class])->group(function () {
    // Dashboard
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Manajemen User
    Route::get('/users', [UserManagementController::class, 'index'])->name('admin.users.index');
    Route::post('/users/{user}/toggle-status', [UserManagementController::class, 'toggleStatus'])->name('admin.users.toggle-status');

    // Manajemen Event Reviews
    Route::get('/event-reviews', [EventReviewController::class, 'index'])->name('admin.event-reviews.index');
    Route::get('/event-reviews/{review}', [EventReviewController::class, 'show'])->name('admin.event-reviews.show');
    Route::get('/event-reviews/{event}/get-reviews', [EventReviewController::class, 'getReviews'])->name('admin.event-reviews.get-reviews');

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

    // Manajemen Pesanan Produk
    Route::prefix('pesanan-produk')->name('admin.pesananproduk.')->group(function () {
        Route::get('/', [PesananController::class, 'index'])->name('index');
        Route::get('/{id_pesanan}/edit', [PesananController::class, 'edit'])->name('edit');
        Route::put('/{id_pesanan}', [PesananController::class, 'update'])->name('update');
    });

    // Manajemen Pesanan Event
    Route::prefix('pesanan-event')->name('admin.pesananevent.')->group(function () {
        Route::get('/', [PesananEventController::class, 'index'])->name('index');
        Route::get('/{id_pesanan_event}/edit', [PesananEventController::class, 'edit'])->name('edit');
        Route::put('/{id_pesanan_event}', [PesananEventController::class, 'update'])->name('update');
    });

    // Product Review Routes
    Route::prefix('product-reviews')->name('admin.product-reviews.')->group(function () {
        Route::get('/', [ProductReviewController::class, 'index'])->name('index');
        Route::get('/{review}', [ProductReviewController::class, 'show'])->name('show');
        Route::post('/{review}/approve', [ProductReviewController::class, 'approve'])->name('approve');
        Route::post('/{review}/reject', [ProductReviewController::class, 'reject'])->name('reject');
    });
});

// Event Review Routes
Route::prefix('admin/event-reviews')->name('admin.event-reviews.')->middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\EventReviewController::class, 'index'])->name('index');
    Route::get('/{review}', [App\Http\Controllers\Admin\EventReviewController::class, 'show'])->name('show');
    Route::patch('/{review}/approve', [App\Http\Controllers\Admin\EventReviewController::class, 'approve'])->name('approve');
    Route::patch('/{review}/reject', [App\Http\Controllers\Admin\EventReviewController::class, 'reject'])->name('reject');
});

// Debug Login Info
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
