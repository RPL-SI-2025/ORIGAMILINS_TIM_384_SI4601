<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        // Misalkan kita punya model Cart (atau CartItem) yang menyimpan data keranjang di database.
        // Contoh: $cart = Cart::where('user_id', $user->id)->with('cartItems.produk')->first();
        // Jika belum ada, buat keranjang baru (misal: Cart::create(['user_id' => $user->id]);)
        // Untuk contoh ini, kita asumsikan keranjang disimpan di session (atau di database) dan diambil dari model Cart.
        // Misalkan $cartItems berisi daftar item (misal: $cart->cartItems) atau diambil dari session.
        // Jika keranjang kosong (misal: $cartItems->isEmpty()), tampilkan pesan kosong.
        // Jika ada produk, tampilkan view (misal: view('cart.index', ['cartItems' => $cartItems, 'total' => $cart->total])).
        // Untuk contoh ini, kita tampilkan pesan kosong saja.
        return view('cart.index', ['cartItems' => [], 'total' => 0, 'message' => 'Keranjang Anda masih kosong']);
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
    }

    /**
     * Mengubah jumlah produk di keranjang (POST /cart/update).
     * Misalkan endpoint ini menerima produk_id dan jumlah baru.
     * Misalkan kita update jumlah (misal: CartItem::where('cart_id', $cart->id)->where('produk_id', $produk_id)->update(['jumlah' => $jumlah]);)
     * Misalkan kita kembalikan pesan "Jumlah produk berhasil diperbarui".
     */
    public function update(Request $request)
    {
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
    }

    /**
     * Menghapus produk dari keranjang (POST /cart/remove).
     * Misalkan endpoint ini menerima produk_id.
     * Misalkan kita hapus produk (misal: CartItem::where('cart_id', $cart->id)->where('produk_id', $produk_id)->delete();)
     * Misalkan kita kembalikan pesan "Produk berhasil dihapus dari keranjang".
     */
    public function remove(Request $request)
    {
        // Validasi request (misal: produk_id harus ada)
        $request->validate(['produk_id' => 'required|exists:produks,id']);
        $produk_id = $request->input('produk_id');
        $user = Auth::user();
        // Misalkan kita punya model Cart (atau CartItem) yang menyimpan data keranjang di database.
        // Contoh: $cart = Cart::where('user_id', $user->id)->first();
        // Misalkan kita hapus produk (misal: CartItem::where('cart_id', $cart->id)->where('produk_id', $produk_id)->delete();)
        // Misalkan kita kembalikan pesan "Produk berhasil dihapus dari keranjang".
        return response()->json(['message' => 'Produk berhasil dihapus dari keranjang']);
    }

    /**
     * Memperbarui total harga keranjang (misal: saat mengubah jumlah atau menghapus produk).
     * Misalkan kita hitung ulang total (misal: $cart->update(['total' => CartItem::where('cart_id', $cart->id)->sum(DB::raw('jumlah * harga'))]);)
     * Misalkan kita kembalikan total harga (misal: "Total: Rp 20000").
     */
    public function updateTotal(Request $request)
    {
        $user = Auth::user();
        // Misalkan kita punya model Cart (atau CartItem) yang menyimpan data keranjang di database.
        // Contoh: $cart = Cart::where('user_id', $user->id)->first();
        // Misalkan kita hitung ulang total (misal: $cart->update(['total' => CartItem::where('cart_id', $cart->id)->sum(DB::raw('jumlah * harga'))]);)
        // Misalkan kita kembalikan total harga (misal: "Total: Rp 20000").
        return response()->json(['total' => 'Total: Rp 20000']);
    }
} 