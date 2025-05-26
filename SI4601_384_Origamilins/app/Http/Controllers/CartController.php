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
        // Middleware auth agar hanya user yang sudah login yang bisa akses keranjang
        $this->middleware('auth')->except('add');
    }

    /**
     * Menampilkan halaman keranjang (GET /cart).
     * Jika keranjang kosong, tampilkan pesan "Keranjang Anda masih kosong".
     * Jika ada produk, tampilkan daftar produk (nama, harga, jumlah, subtotal, total harga).
     */
    public function index()
    {
        $cart = $this->cartService->getOrCreateCart(Auth::user());
        $items = $cart->items()->with('produk')->get();
        $total = $items->sum(function ($item) {
            return $item->jumlah * $item->produk->harga;
        });

        return view('user.cart.index', compact('items', 'total'));
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

        $cart = $this->cartService->getOrCreateCart(Auth::user());
        $produk = Produk::findOrFail($request->produk_id);

        // Check if product already in cart
        $cartItem = $cart->items()->where('produk_id', $produk->id)->first();

        if ($cartItem) {
            $cartItem->update([
                'jumlah' => $cartItem->jumlah + $request->jumlah
            ]);
        } else {
            $cart->items()->create([
                'produk_id' => $produk->id,
                'jumlah' => $request->jumlah
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang');
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
            'item_id' => 'required|exists:cart_items,id',
            'jumlah' => 'required|integer|min:1'
        ]);

        $cartItem = CartItem::findOrFail($request->item_id);
        $cartItem->update(['jumlah' => $request->jumlah]);

        return response()->json(['success' => true]);
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
            'item_id' => 'required|exists:cart_items,id'
        ]);

        CartItem::destroy($request->item_id);

        return response()->json(['success' => true]);
    }

    /**
     * Memperbarui total harga keranjang (misal: saat mengubah jumlah atau menghapus produk).
     * Misalkan kita hitung ulang total (misal: $cart->update(['total' => CartItem::where('cart_id', $cart->id)->sum(DB::raw('jumlah * harga'))]);)
     * Misalkan kita kembalikan total harga (misal: "Total: Rp 20000").
     */
    public function updateTotal()
    {
        $cart = $this->cartService->getOrCreateCart(Auth::user());
        $total = $cart->items()->with('produk')->get()->sum(function ($item) {
            return $item->jumlah * $item->produk->harga;
        });

        return response()->json(['total' => $total]);
    }

    /**
     * Proses checkout hanya untuk item yang dipilih user.
     */
    public function checkout()
    {
        $cart = $this->cartService->getOrCreateCart(Auth::user());
        $items = $cart->items()->with('produk')->get();

        if ($items->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang belanja kosong');
        }

        // Create order logic here
        // ...

        return redirect()->route('checkout.index');
    }
} 