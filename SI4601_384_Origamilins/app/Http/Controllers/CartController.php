<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
<<<<<<< HEAD
use App\Models\Cart;
use App\Models\CartItem;
=======
>>>>>>> 067a531 (Cart Sementara)
=======
use App\Models\Cart;
use App\Models\CartItem;
>>>>>>> fa94269c81f6bb757422f1f6a9b2cd8607abca47
use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
<<<<<<< HEAD
<<<<<<< HEAD
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
=======
>>>>>>> 067a531 (Cart Sementara)
=======
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
>>>>>>> fa94269c81f6bb757422f1f6a9b2cd8607abca47

class CartController extends Controller
{
    public function __construct()
    {
        // Middleware auth agar hanya user yang sudah login yang bisa akses keranjang
        $this->middleware('auth')->except('add');
    }

    /**
     * Menampilkan halaman keranjang (GET /cart).
     * Jika keranjang kosong, tampilkan pesan "Keranjang Anda masih kosong".
     * Jika ada produk, tampilkan daftar produk (nama, harga, jumlah, subtotal, total harga).
     */
    public function index(Request $request)
    {
        $user = Auth::user();
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> fa94269c81f6bb757422f1f6a9b2cd8607abca47
        $cart = $user->getOrCreateCart();
        $cartItems = $cart->items()->with('produk')->get();
        $cartCount = $cartItems->sum('jumlah');
        
        if ($cartItems->isEmpty()) {
            return view('user.cart.index', [
                'cartItems' => [],
                'total' => 0,
                'message' => 'Keranjang Anda masih kosong',
                'cartCount' => $cartCount
            ]);
        }

        return view('user.cart.index', [
            'cartItems' => $cartItems,
            'total' => $cart->total,
            'cartCount' => $cartCount
        ]);
<<<<<<< HEAD
=======
        // Misalkan kita punya model Cart (atau CartItem) yang menyimpan data keranjang di database.
        // Contoh: $cart = Cart::where('user_id', $user->id)->with('cartItems.produk')->first();
        // Jika belum ada, buat keranjang baru (misal: Cart::create(['user_id' => $user->id]);)
        // Untuk contoh ini, kita asumsikan keranjang disimpan di session (atau di database) dan diambil dari model Cart.
        // Misalkan $cartItems berisi daftar item (misal: $cart->cartItems) atau diambil dari session.
        // Jika keranjang kosong (misal: $cartItems->isEmpty()), tampilkan pesan kosong.
        // Jika ada produk, tampilkan view (misal: view('cart.index', ['cartItems' => $cartItems, 'total' => $cart->total])).
        // Untuk contoh ini, kita tampilkan pesan kosong saja.
        return view('cart.index', ['cartItems' => [], 'total' => 0, 'message' => 'Keranjang Anda masih kosong']);
>>>>>>> 067a531 (Cart Sementara)
=======
>>>>>>> fa94269c81f6bb757422f1f6a9b2cd8607abca47
    }

    /**
     * Menambahkan produk ke keranjang (POST /cart/add).
     * Jika user belum login, kembalikan 401.
     * Jika belum ada keranjang, buat keranjang baru.
     * Jika produk sudah ada di keranjang, update jumlahnya.
     * Jika produk belum ada, tambahkan produk baru.
     */
    public function add(Request $request)
    {
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> fa94269c81f6bb757422f1f6a9b2cd8607abca47
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'jumlah' => 'required|integer|min:1'
        ]);

        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = Auth::user();
        $cart = $user->getOrCreateCart();
        $produk = Produk::findOrFail($request->produk_id);
        
        DB::beginTransaction();
        try {
            $cartItem = $cart->items()->where('produk_id', $produk->id)->first();
            
            if ($cartItem) {
                $cartItem->jumlah += $request->jumlah;
                $cartItem->updateSubtotal();
                $message = 'Produk berhasil ditambahkan (jumlah diperbarui)';
            } else {
                $cartItem = $cart->items()->create([
                    'produk_id' => $produk->id,
                    'jumlah' => $request->jumlah,
                    'subtotal' => $produk->harga * $request->jumlah
                ]);
                $cart->updateTotal();
                $message = 'Produk berhasil ditambahkan ke keranjang';
            }
            
            DB::commit();
            $cart->refresh(); // Refresh cart to get updated items relation
            $cartCount = $cart->items()->sum('jumlah');
            return response()->json(['message' => $message, 'cartCount' => $cartCount]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Terjadi kesalahan saat menambahkan produk'], 500);
        }
<<<<<<< HEAD
=======
        // Validasi request (misal: produk_id dan jumlah harus ada dan jumlah > 0)
        $request->validate(['produk_id' => 'required|exists:produks,id', 'jumlah' => 'required|integer|min:1']);
        $produk_id = $request->input('produk_id');
        $jumlah = $request->input('jumlah');
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $user = Auth::user();
        // Misalkan kita punya model Cart (atau CartItem) yang menyimpan data keranjang di database.
        // Contoh: $cart = Cart::where('user_id', $user->id)->first();
        // Jika belum ada, buat keranjang baru (misal: Cart::create(['user_id' => $user->id]);)
        // Misalkan $cartItem = CartItem::where('cart_id', $cart->id)->where('produk_id', $produk_id)->first();
        // Jika produk sudah ada, update jumlah (misal: $cartItem->update(['jumlah' => $cartItem->jumlah + $jumlah]);)
        // Jika belum ada, tambahkan produk baru (misal: CartItem::create(['cart_id' => $cart->id, 'produk_id' => $produk_id, 'jumlah' => $jumlah]);)
        // Untuk contoh ini, kita asumsikan produk ditambahkan ke session (atau di database) dan kita kembalikan pesan sukses.
        // Misalkan kita cek (misal: if ($cartItem) { ... } else { ... }), lalu kembalikan pesan sesuai.
        // Misalkan kita kembalikan pesan "Produk berhasil ditambahkan (jumlah diperbarui)" jika produk sudah ada, atau "Produk berhasil ditambahkan ke keranjang" jika baru.
        // Untuk contoh ini, kita kembalikan pesan "Produk berhasil ditambahkan ke keranjang".
        return response()->json(['message' => 'Produk berhasil ditambahkan ke keranjang']);
>>>>>>> 067a531 (Cart Sementara)
=======
>>>>>>> fa94269c81f6bb757422f1f6a9b2cd8607abca47
    }

    /**
     * Mengubah jumlah produk di keranjang (POST /cart/update).
     * Misalkan endpoint ini menerima produk_id dan jumlah baru.
     * Misalkan kita update jumlah (misal: CartItem::where('cart_id', $cart->id)->where('produk_id', $produk_id)->update(['jumlah' => $jumlah]);)
     * Misalkan kita kembalikan pesan "Jumlah produk berhasil diperbarui".
     */
    public function update(Request $request)
    {
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> fa94269c81f6bb757422f1f6a9b2cd8607abca47
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'jumlah' => 'required|integer|min:1'
        ]);

        $user = Auth::user();
        $cart = $user->cart;
        
        if (!$cart) {
            return response()->json(['message' => 'Keranjang tidak ditemukan'], 404);
        }

        DB::beginTransaction();
        try {
            $cartItem = $cart->items()->where('produk_id', $request->produk_id)->first();
            
            if (!$cartItem) {
                return response()->json(['message' => 'Produk tidak ditemukan di keranjang'], 404);
            }

            $cartItem->jumlah = $request->jumlah;
            $cartItem->updateSubtotal();
            $cart->refresh();
            $cartCount = $cart->items()->sum('jumlah');

            DB::commit();
            return response()->json([
                'message' => 'Jumlah produk berhasil diperbarui',
                'new_subtotal' => $cartItem->subtotal,
                'new_total' => $cart->total,
                'cartCount' => $cartCount
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Terjadi kesalahan saat memperbarui jumlah'], 500);
        }
<<<<<<< HEAD
=======
        // Validasi request (misal: produk_id dan jumlah harus ada dan jumlah > 0)
        $request->validate(['produk_id' => 'required|exists:produks,id', 'jumlah' => 'required|integer|min:1']);
        $produk_id = $request->input('produk_id');
        $jumlah = $request->input('jumlah');
        $user = Auth::user();
        // Misalkan kita punya model Cart (atau CartItem) yang menyimpan data keranjang di database.
        // Contoh: $cart = Cart::where('user_id', $user->id)->first();
        // Misalkan kita update jumlah (misal: CartItem::where('cart_id', $cart->id)->where('produk_id', $produk_id)->update(['jumlah' => $jumlah]);)
        // Misalkan kita kembalikan pesan "Jumlah produk berhasil diperbarui".
        return response()->json(['message' => 'Jumlah produk berhasil diperbarui']);
>>>>>>> 067a531 (Cart Sementara)
=======
>>>>>>> fa94269c81f6bb757422f1f6a9b2cd8607abca47
    }

    /**
     * Menghapus produk dari keranjang (POST /cart/remove).
     * Misalkan endpoint ini menerima produk_id.
     * Misalkan kita hapus produk (misal: CartItem::where('cart_id', $cart->id)->where('produk_id', $produk_id)->delete();)
     * Misalkan kita kembalikan pesan "Produk berhasil dihapus dari keranjang".
     */
    public function remove(Request $request)
    {
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> fa94269c81f6bb757422f1f6a9b2cd8607abca47
        $request->validate([
            'produk_id' => 'required|exists:produk,id'
        ]);

        $user = Auth::user();
        $cart = $user->cart;
        
        if (!$cart) {
            return response()->json(['message' => 'Keranjang tidak ditemukan'], 404);
        }

        DB::beginTransaction();
        try {
            $cartItem = $cart->items()->where('produk_id', $request->produk_id)->first();
            
            if (!$cartItem) {
                return response()->json(['message' => 'Produk tidak ditemukan di keranjang'], 404);
            }

            $cartItem->delete();
            $cart->updateTotal();
            
            DB::commit();
        return response()->json(['message' => 'Produk berhasil dihapus dari keranjang']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Terjadi kesalahan saat menghapus produk'], 500);
        }
<<<<<<< HEAD
=======
        // Validasi request (misal: produk_id harus ada)
        $request->validate(['produk_id' => 'required|exists:produks,id']);
        $produk_id = $request->input('produk_id');
        $user = Auth::user();
        // Misalkan kita punya model Cart (atau CartItem) yang menyimpan data keranjang di database.
        // Contoh: $cart = Cart::where('user_id', $user->id)->first();
        // Misalkan kita hapus produk (misal: CartItem::where('cart_id', $cart->id)->where('produk_id', $produk_id)->delete();)
        // Misalkan kita kembalikan pesan "Produk berhasil dihapus dari keranjang".
        return response()->json(['message' => 'Produk berhasil dihapus dari keranjang']);
>>>>>>> 067a531 (Cart Sementara)
=======
>>>>>>> fa94269c81f6bb757422f1f6a9b2cd8607abca47
    }

    /**
     * Memperbarui total harga keranjang (misal: saat mengubah jumlah atau menghapus produk).
     * Misalkan kita hitung ulang total (misal: $cart->update(['total' => CartItem::where('cart_id', $cart->id)->sum(DB::raw('jumlah * harga'))]);)
     * Misalkan kita kembalikan total harga (misal: "Total: Rp 20000").
     */
    public function updateTotal(Request $request)
    {
        $user = Auth::user();
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> fa94269c81f6bb757422f1f6a9b2cd8607abca47
        $cart = $user->cart;
        
        if (!$cart) {
            return response()->json(['message' => 'Keranjang tidak ditemukan'], 404);
        }

        $cart->updateTotal();
        return response()->json(['total' => 'Total: Rp ' . number_format($cart->total, 0, ',', '.')]);
    }

    /**
     * Proses checkout hanya untuk item yang dipilih user.
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'item_ids' => 'required|array',
            'item_ids.*' => 'exists:cart_items,id'
        ]);

        $user = Auth::user();
        $cart = $user->cart;
        $selectedItems = $cart->items()->whereIn('id', $request->item_ids)->with('produk')->get();

        if ($selectedItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Pilih minimal satu produk untuk checkout!');
        }

        // Simpan ke session atau langsung proses pembayaran
        session(['checkout_items' => $selectedItems->pluck('id')->toArray()]);
        // Redirect ke halaman pembayaran/checkout
        return redirect()->route('user.payments.index');
<<<<<<< HEAD
=======
        // Misalkan kita punya model Cart (atau CartItem) yang menyimpan data keranjang di database.
        // Contoh: $cart = Cart::where('user_id', $user->id)->first();
        // Misalkan kita hitung ulang total (misal: $cart->update(['total' => CartItem::where('cart_id', $cart->id)->sum(DB::raw('jumlah * harga'))]);)
        // Misalkan kita kembalikan total harga (misal: "Total: Rp 20000").
        return response()->json(['total' => 'Total: Rp 20000']);
>>>>>>> 067a531 (Cart Sementara)
=======
>>>>>>> fa94269c81f6bb757422f1f6a9b2cd8607abca47
    }
} 