<?php

use App\Http\Controllers\Admin\Produk_Controller;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserProfileController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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
use App\Http\Controllers\CartController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\UserPaymentHistoryController;
use App\Http\Controllers\UserNotifikasiController;
use App\Http\Controllers\UserPesananController;

// Home
Route::get('/', [WelcomeController::class, 'index'])->name('home');

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

    // pesanan saya
    Route::get('/pesanan-saya/{id_pesanan}', [UserPesananController::class, 'show'])->name('pesanan.show');

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
        $kategoriRequest = request('kategori');
        if (is_array($kategoriRequest) && !empty($kategoriRequest)) {
            // Jika 'Semua' dicentang, tampilkan semua kategori (tidak perlu filter)
            if (!in_array('Semua', $kategoriRequest)) {
                $query->whereIn('kategori', $kategoriRequest);
            }
        } elseif (!empty($kategoriRequest) && $kategoriRequest != 'Semua') {
            // Jika hanya satu kategori dipilih dan bukan 'Semua'
            $query->where('kategori', $kategoriRequest);
        }
        if (request()->has('nama') && request('nama') != '') {
            $query->where('nama', 'like', '%' . request('nama') . '%');
        }
        // Bersihkan input harga dari titik
        $hargaMin = str_replace('.', '', request('harga_min'));
        $hargaMax = str_replace('.', '', request('harga_max'));
        if (request()->has('harga_min') && $hargaMin !== null && $hargaMin !== '') {
            $query->where('harga', '>=', $hargaMin);
        }
        if (request()->has('harga_max') && $hargaMax !== null && $hargaMax !== '') {
            $query->where('harga', '<=', $hargaMax);
        }
        $products = $query->paginate(9);
        $categories = \App\Models\Produk::distinct()->pluck('kategori');
        
        $cartCount = 0;
        if (Auth::check()) {
            try {
                $cart = Auth::user()->cart;
                if ($cart) {
                    $cartCount = $cart->items()->sum('jumlah');
                }
            } catch (\Exception $e) {
                $cartCount = 0;
            }
        }
        
        return view('user.produk.etalase', compact('products', 'categories', 'cartCount'));
    })->name('etalase');

    // Detail Produk Route 
    Route::get('/produk/{id}', function ($id) {
        $produk = \App\Models\Produk::findOrFail($id);
        
        // Ambil ulasan produk
        $ulasan = \App\Models\ProductReview::where('produk_id', $id)
                                    ->with('user')
                                    ->orderBy('created_at', 'desc')
                                    ->get();
        
        // Hitung jumlah item di keranjang
        $cartCount = 0;
        if (Auth::check()) {
            $cartService = app(\App\Services\CartService::class);
            $cart = $cartService->getOrCreateCart(Auth::user());
            $cartCount = $cart->items()->sum('jumlah');
        }
        
        // Ambil produk terkait (kategori sama, exclude produk saat ini)
        $produkTerkait = \App\Models\Produk::where('kategori', $produk->kategori)
                                        ->where('id', '!=', $id)
                                        ->limit(4)
                                        ->get();
        
        return view('user.produk.produk-detail', compact('produk', 'ulasan', 'cartCount', 'produkTerkait'));
    })->name('detail.produk');
    Route::get('/events', [EventController::class, 'index'])->name('user.event.index');
    Route::get('/events/{id}', [EventController::class, 'show'])->name('user.event.show');

    // Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/delete', [CartController::class, 'delete'])->name('cart.delete');
    Route::post('/cart/update-total', [CartController::class, 'updateTotal'])->name('cart.update-total');
    Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    

    // Payment History Routes
    Route::get('/payments/history', [UserPaymentHistoryController::class, 'index'])->name('user.payments.history');
    Route::get('/payments/{id}', [UserPaymentHistoryController::class, 'show'])->name('user.payments.show');
    Route::match(['get', 'post'], '/user/payments/create', [PaymentsController::class, 'create'])->name('user.payments.create');

    // Tambahkan route shipping berikut
    Route::get('/user/payments/shipping', [PaymentsController::class, 'shipping'])->name('user.payments.shipping');
    Route::post('/user/payments/shipping', [PaymentsController::class, 'shipping'])->name('user.payments.shipping');
    Route::get('/user/payments/checkout', [PaymentsController::class, 'checkout'])->name('user.payments.checkout');

    Route::get('/payment/success/{order_id}', function($order_id) {
        $payment = \App\Models\Payments::where('order_id', $order_id)->firstOrFail();
        return view('user.payments.success', compact('payment'));
    })->name('payment.success');

    Route::get('/payment/pending/{order_id}', function($order_id) {
        $payment = \App\Models\Payments::where('order_id', $order_id)->firstOrFail();
        return view('user.payments.status', compact('payment'));
    })->name('payment.pending');

    // Notifikasi Routes
    Route::get('/notifikasi', [UserNotifikasiController::class, 'index'])->name('user.notifikasi');
    Route::post('/notifikasi/{id}/read', [UserNotifikasiController::class, 'read'])->name('user.notifikasi.read');
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
    // Manajemen User (CRUD lengkap)
    Route::resource('users', UserManagementController::class, [
        'as' => 'admin'
    ]);
    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

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
Route::post('/user/profile/photo', function(Request $request) {
    $request->validate([
        'photo' => 'required|image|max:1024',
    ]);
    $user = \App\Models\User::find(Auth::id());
    $path = $request->file('photo')->store('profile-photos', 'public');
    $user->profile_photo_path = $path;
    $user->save();
    return back()->with('success', 'Foto profil berhasil diubah.');
})->middleware(['auth'])->name('profile.photo');

Route::get('/reset-password', [ResetPasswordController::class, 'showForm'])->name('reset.password.form');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('reset.password');

Route::middleware(['auth'])->group(function() {
    Route::get('/pesanan-saya', [App\Http\Controllers\UserPesananController::class, 'index'])->name('user.pesanan.index');
});

