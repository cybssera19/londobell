<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Item;
use App\Models\TransactionHeader;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function checkout()
    {
        $userId = Auth::id();
        $cartItems = Cart::with('item')->where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang belanja Anda kosong.');
        }

        DB::beginTransaction();
        try {
            $grandTotal = 0;

            foreach ($cartItems as $cart) {
                if ($cart->item->stock < $cart->quantity) {
                    return redirect()->route('cart.index')->with('error', "Stok barang {$cart->item->item_name} tidak mencukupi!");
                }
                $grandTotal += $cart->item->price * $cart->quantity;
            }

            $header = TransactionHeader::create([
                'user_id' => $userId,
                'grand_total' => $grandTotal
            ]);

            foreach ($cartItems as $cart) {
                TransactionDetail::create([
                    'transaction_header_id' => $header->id,
                    'item_id' => $cart->item_id,
                    'quantity' => $cart->quantity
                ]);

                $item = Item::find($cart->item_id);
                $item->decrement('stock', $cart->quantity);
            }

            Cart::where('user_id', $userId)->delete();

            DB::commit();
            return redirect()->route('transactions.history')->with('success', 'Checkout Berhasil! Pesanan Anda sedang diproses.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', 'Terjadi kesalahan sistem saat checkout.');
        }
    }
    public function history()
    {
        $transactions = TransactionHeader::with('details.item')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.history', compact('transactions'));
    }
}
