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

        $user = Auth::user(); // Get the authenticated user
        $cart = $user->getOrCreateCart(); // Get or create the cart for the user
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
                $message = 'Produk berhasil ditambahkan ke keranjang';
            }
            
            $cart->updateTotal(); // Ensure cart total is updated
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
     */
    public function update(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:cart_items,id',
            'jumlah' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();
        try {
            $cartItem = CartItem::findOrFail($request->item_id);
            $cart = $cartItem->cart; // Get the cart related to the item
            
            $cartItem->jumlah = $request->jumlah;
            $cartItem->updateSubtotal(); // Update subtotal for the item
            $cartItem->save(); // Save the updated item
            
            $cart->updateTotal(); // Update the total for the cart
            $cart->refresh(); // Refresh cart to get the latest total
            
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
     */
    public function remove(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:cart_items,id'
        ]);

        DB::beginTransaction();
        try {
            $cartItem = CartItem::findOrFail($request->item_id);
            $cart = $cartItem->cart; // Get the cart related to the item
            
            $cartItem->delete();
            
            $cart->updateTotal(); // Update the total for the cart
            $cart->refresh(); // Refresh cart to get the latest total after removal
            
            $cartCount = $cart->items()->sum('jumlah'); // Recalculate cart count
            
            DB::commit();
            return response()->json([
                'message' => 'Produk berhasil dihapus dari keranjang',
                'new_total' => $cart->total,
                'cartCount' => $cartCount
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Terjadi kesalahan saat menghapus produk'], 500);
        }
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

        // Filter cart items based on selected IDs
        $selectedItems = $cart->items()->whereIn('id', $request->item_ids)->get();

        if ($selectedItems->isEmpty()) {
            return redirect()->back()->with('error', 'Pilih item untuk checkout.');
        }

        // Simpan ID item yang dipilih ke session atau langsung proses pembayaran
        session(['checkout_item_ids' => $selectedItems->pluck('id')->toArray()]);

        // Redirect ke halaman pembayaran/checkout
        return redirect()->route('user.payments.index'); // Assuming this is the correct route name
    }
}