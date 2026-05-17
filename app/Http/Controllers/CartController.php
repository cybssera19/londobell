<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('item.category')->where('user_id', Auth::id())->get();

        $totalPrice = $cartItems->sum(function($cart) {
            return $cart->item->price * $cart->quantity;
        });

        return view('user.cart', compact('cartItems', 'totalPrice'));
    }

    public function addToCart(Request $request,int $itemId)
    {
        $item = Item::findOrFail($itemId);

        if ($item->stock <= 0) {
            return redirect()->back()->with('error', 'Maaf, stok barang sedang habis!');
        }
        $existingCart = Cart::where('user_id', Auth::id())->where('item_id', $itemId)->first();

        if ($existingCart) {
            if ($existingCart->quantity + 1 > $item->stock) {
                return redirect()->back()->with('error', 'Jumlah keranjang melebihi stok yang tersedia!');
            }
            $existingCart->increment('quantity');
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'item_id' => $itemId,
                'quantity' => 1
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Barang berhasil dimasukkan ke keranjang!');
    }

    public function destroy(int $id)
    {
        $cart = Cart::where('user_id', Auth::id())->findOrFail($id);
        $cart->delete();

        return redirect()->back()->with('success', 'Barang dihapus dari keranjang.');
    }
}
