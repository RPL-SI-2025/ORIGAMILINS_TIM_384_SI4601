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
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Auth\ResetPasswordController;

// Home
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Event Publik
Route::get('/event', [EventController::class, 'index'])->name('event.melihat_event');

// Authentication
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// User Profile (butuh login)
Route::middleware(['auth'])->group(function () {
    Route::get('/profilpengguna', [UserProfileController::class, 'create'])->name('profile.create');
    Route::post('/profilpengguna', [UserProfileController::class, 'store'])->name('profile.store');

    // Dashboard
    Route::get('/dashboard', function () {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('etalase');
    })->name('dashboard');

    // Pesanan Produk
    Route::get('/pesananproduk', [PesananController::class, 'index'])->name('pesananproduk.index');
    Route::get('/pesananproduk/{id_pesanan}/edit', [PesananController::class, 'edit'])->name('pesananproduk.edit');
    Route::put('/pesananproduk/{id_pesanan}', [PesananController::class, 'update'])->name('pesananproduk.update');
    Route::get('/pesananproduk/{id_pesanan}', [PesananController::class, 'show'])->name('pesananproduk.show');

    Route::get('/etalase-produk', function () {
        $query = \App\Models\Produk::query();
        if (request()->has('kategori') && request('kategori') != '') {
            $query->where('kategori', request('kategori'));
        }
        if (request()->has('nama') && request('nama') != '') {
            $query->where('nama', 'like', '%' . request('nama') . '%');
        }
        $products = $query->paginate(9);
        $categories = \App\Models\Produk::distinct()->pluck('kategori');
        return view('user.etalase', compact('products', 'categories'));
    })->name('etalase');
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
    Route::get('/', [App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('admin.dashboard');

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
        Route::resource('pengrajin', PengrajinManagementController::class);
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

    // Payment History
    Route::prefix('payments')->name('admin.payments.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\PaymentHistoryController::class, 'index'])->name('index');
        Route::get('/{payment}', [App\Http\Controllers\Admin\PaymentHistoryController::class, 'show'])->name('show');
    });

    // Refund Management Routes
    Route::prefix('refunds')->name('admin.refunds.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\RefundController::class, 'index'])->name('index');
        Route::get('/{id}', [App\Http\Controllers\Admin\RefundController::class, 'show'])->name('show');
        Route::post('/{id}/process', [App\Http\Controllers\Admin\RefundController::class, 'processRefund'])->name('process');
        Route::post('/{id}/reject', [App\Http\Controllers\Admin\RefundController::class, 'rejectRefund'])->name('reject');
    });
});

    // Pembayaran
    Route::prefix('user/payments')->name('user.payments.')->middleware(['auth'])->group(function () {
        Route::get('/', [PaymentsController::class, 'index'])->name('index'); // Menampilkan form pembayaran
        Route::post('/', [PaymentsController::class, 'store'])->name('store'); // Menyimpan data pembayaran
        Route::get('/{payment}/finish', [PaymentsController::class, 'finish'])->name('finish'); // Redirect setelah pembayaran selesai
        Route::post('/callback', [PaymentsController::class, 'callback'])->name('callback'); // Callback dari Midtrans
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

Route::get('/produk/{id}', function ($id) {
    $product = \App\Models\Produk::findOrFail($id);
    return view('user.produk-detail', compact('product'));
})->name('user.produk.detail');

Route::get('/reset-password', [ResetPasswordController::class, 'showForm'])->name('reset.password.form');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('reset.password');

