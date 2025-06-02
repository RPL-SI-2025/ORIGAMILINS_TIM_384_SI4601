<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Produk;
use App\Models\User;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
        $this->middleware('auth')->except('add');
    }

    /**
     * Menampilkan halaman keranjang (GET /cart).
     * Jika keranjang kosong, tampilkan pesan "Keranjang Anda masih kosong".
     * Jika ada produk, tampilkan daftar produk (nama, harga, jumlah, subtotal, total harga).
     */
    public function index()
    {
        $user = Auth::user();
        $cart = $user->getOrCreateCart();
        $items = $cart->items()->with('produk')->get();
        $cartCount = $items->sum('jumlah');
        $total = $items->sum(function($item) {
            return ($item->produk->harga ?? 0) * $item->jumlah;
        });

        return view('user.cart.index', [
            'items' => $items,
            'total' => $total,
            'cartCount' => $cartCount
        ]);
    }

    public function add(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Sesi Anda habis, silakan login ulang.'], 401);
        }

        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'jumlah' => 'required|integer|min:1'
        ]);

        $user = Auth::user();
        $cart = $user->getOrCreateCart();
        $produk = Produk::findOrFail($request->produk_id);

        $subtotal = $request->jumlah * $produk->harga;

        $cartItem = $cart->items()->where('produk_id', $produk->id)->first();

        if ($cartItem) {
            $newJumlah = $cartItem->jumlah + $request->jumlah;
            $cartItem->update([
                'jumlah' => $newJumlah,
                'subtotal' => $newJumlah * $produk->harga
            ]);
        } else {
            $cart->items()->create([
                'produk_id' => $produk->id,
                'jumlah' => $request->jumlah,
                'subtotal' => $subtotal
            ]);
        }

        // Get updated cart count
        $cartCount = $cart->items()->sum('jumlah');

        // SELALU return JSON!
        return response()->json([
            'success' => true,
            'cart_count' => $cartCount
        ]);
    }

    /**
     * Mengubah jumlah produk di keranjang (POST /cart/update).
     */

    public function update(Request $request)
    {
        $item = CartItem::findOrFail($request->item_id);
        $jumlah = (int) $request->jumlah;

        if ($jumlah < 1) {
            $item->delete();
            return back()->with('success', 'Barang dihapus dari keranjang');
        }

        $item->update([
            'jumlah' => $jumlah,
            'subtotal' => $jumlah * $item->produk->harga
        ]);
        return back()->with('success', 'Jumlah barang diperbarui');
    }

    /**
     * Menghapus produk dari keranjang (POST /cart/remove).
     */
    
    public function delete(Request $request)
    {
        $item = CartItem::findOrFail($request->item_id);
        $item->delete();
        return back()->with('success', 'Barang dihapus dari keranjang');
    }

    /**
     * Memperbarui total harga keranjang (via AJAX). This method is for fetching, not updating.
     */
    public function updateTotal()
    {
        $user = Auth::user();
        $cart = $user->cart;
        
        if (!$cart) {
            return response()->json(['message' => 'Keranjang tidak ditemukan'], 404);
        }

        // Ensure the total is up-to-date based on current items
        $cart->updateTotal();
        $cart->refresh(); // Refresh to get the latest total from the DB

        return response()->json(['total' => $cart->total]);
    }

    /**
     * Proses checkout hanya untuk item yang dipilih user (POST /cart/checkout).
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'item_ids' => 'required|array',
            'item_ids.*' => 'exists:cart_items,id'
        ]);

        $user = Auth::user();
        $cart = $user->cart;
        
        if (!$cart) {
            return redirect()->back()->with('error', 'Keranjang belanja kosong');
        }

        // Create order logic here
        // ...

        return redirect()->route('checkout.index');
    }

    /**
     * Get the count of items in the authenticated user's cart.
     */
    public function getCartItemCount()
    {
        $user = auth()->user();
        $cartItemCount = 0;
        if ($user) {
            $cart = $user->cart()->first();
            if ($cart) {
                $cartItemCount = $cart->items()->sum('jumlah');
            }
        }
        return response()->json(['count' => $cartItemCount]);
    }

    /**
     * Get cart item ID by product ID
     */
    public function getCartItemId(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $produkId = $request->query('produk_id');
        if (!$produkId) {
            return response()->json(['error' => 'Product ID is required'], 400);
        }

        $cart = $user->cart()->first();
        if (!$cart) {
            return response()->json(['error' => 'Cart not found'], 404);
        }

        $cartItem = $cart->items()->where('produk_id', $produkId)->first();
        if (!$cartItem) {
            return response()->json(['error' => 'Cart item not found'], 404);
        }

        return response()->json(['cart_item_id' => $cartItem->id]);
    }
}