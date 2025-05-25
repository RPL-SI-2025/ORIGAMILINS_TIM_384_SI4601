<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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
    }

    /**
     * Mengubah jumlah produk di keranjang (POST /cart/update).
     * Misalkan endpoint ini menerima produk_id dan jumlah baru.
     * Misalkan kita update jumlah (misal: CartItem::where('cart_id', $cart->id)->where('produk_id', $produk_id)->update(['jumlah' => $jumlah]);)
     * Misalkan kita kembalikan pesan "Jumlah produk berhasil diperbarui".
     */
    public function update(Request $request)
    {
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
    }

    /**
     * Menghapus produk dari keranjang (POST /cart/remove).
     * Misalkan endpoint ini menerima produk_id.
     * Misalkan kita hapus produk (misal: CartItem::where('cart_id', $cart->id)->where('produk_id', $produk_id)->delete();)
     * Misalkan kita kembalikan pesan "Produk berhasil dihapus dari keranjang".
     */
    public function remove(Request $request)
    {
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
    }

    /**
     * Memperbarui total harga keranjang (misal: saat mengubah jumlah atau menghapus produk).
     * Misalkan kita hitung ulang total (misal: $cart->update(['total' => CartItem::where('cart_id', $cart->id)->sum(DB::raw('jumlah * harga'))]);)
     * Misalkan kita kembalikan total harga (misal: "Total: Rp 20000").
     */
    public function updateTotal(Request $request)
    {
        $user = Auth::user();
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
    }
} 