<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
        public function index()
    {
        $items = Item::with('category')->get(); // Mengambil semua barang beserta kategorinya
        return view('admin.dashboard', compact('items'));
    }

    public function create()
    {
        $categories = Category::all(); // Mengambil semua kategori untuk pilihan Dropdown
        return view('admin.create', compact('categories'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'item_name' => 'required|string|min:5|max:80',
            'price' => 'required|integer|min:1',
            'stock' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'item_name.min' => 'Nama barang minimal harus 5 huruf.',
            'item_name.max' => 'Nama barang maksimal harus 80 huruf.',
            'price.integer' => 'Harga barang harus berupa angka.',
            'stock.integer' => 'Stok barang harus berupa angka.',
            'image.required' => 'Foto barang wajib diunggah.',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('items', 'public');
        }

        Item::create([
            'category_id' => $request->category_id,
            'item_name' => $request->item_name,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Barang berhasil ditambahkan!');
    }

    public function edit(int $id)
    {
        $item = Item::findOrFail($id);
        $categories = Category::all();
        return view('admin.edit', compact('item', 'categories'));
    }

    public function update(Request $request, int $id)
    {
        $item = Item::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'item_name' => 'required|string|min:5|max:80',
            'price' => 'required|integer|min:1',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }

            $item->image = $request->file('image')->store('items', 'public');
        }

        $item->update([
            'category_id' => $request->category_id,
            'item_name' => $request->item_name,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $item->image,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Barang berhasil diperbarui!');
    }

    public function destroy(int $id)
    {
        $item = Item::findOrFail($id);

        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Barang berhasil dihapus!');
    }

    public function userCatalog()
    {
        $items = Item::with('category')->get();
        return view('user.catalog', compact('items'));
    }
}
