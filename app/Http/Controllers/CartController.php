<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // 1. Menampilkan isi keranjang belanja user
    public function index()
    {
        $cartItems = Cart::with('item.category')->where('user_id', Auth::id())->get();

        // Menghitung total harga belanjaan di dalam keranjang
        $totalPrice = $cartItems->sum(function($cart) {
            return $cart->item->price * $cart->quantity;
        });

        return view('user.cart', compact('cartItems', 'totalPrice'));
    }

    // 2. Memasukkan barang ke dalam keranjang
    public function addToCart(Request $request, $itemId)
    {
        $item = Item::findOrFail($itemId);

        // Validasi: Apakah stok barang masih tersedia?
        if ($item->stock <= 0) {
            return redirect()->back()->with('error', 'Maaf, stok barang sedang habis!');
        }

        // Cek apakah user sudah pernah memasukkan barang yang sama ke keranjang
        $existingCart = Cart::where('user_id', Auth::id())->where('item_id', $itemId)->first();

        if ($existingCart) {
            // Jika sudah ada, cek apakah penambahan melebihi stok yang ada
            if ($existingCart->quantity + 1 > $item->stock) {
                return redirect()->back()->with('error', 'Jumlah keranjang melebihi stok yang tersedia!');
            }
            $existingCart->increment('quantity');
        } else {
            // Jika belum ada, buat data baru di tabel carts
            Cart::create([
                'user_id' => Auth::id(),
                'item_id' => $itemId,
                'quantity' => 1
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Barang berhasil dimasukkan ke keranjang!');
    }

    // 3. Menghapus satu item dari keranjang
    public function destroy($id)
    {
        $cart = Cart::where('user_id', Auth::id())->findOrFail($id);
        $cart->delete();

        return redirect()->back()->with('success', 'Barang dihapus dari keranjang.');
    }
}
