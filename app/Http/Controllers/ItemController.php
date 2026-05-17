<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    // 1. Menampilkan Semua Barang di Dashboard Admin (READ)
    public function index()
    {
        $items = Item::with('category')->get(); // Mengambil semua barang beserta kategorinya
        return view('admin.dashboard', compact('items'));
    }

    // 2. Menampilkan Form Tambah Barang
    public function create()
    {
        $categories = Category::all(); // Mengambil semua kategori untuk pilihan Dropdown
        return view('admin.create', compact('categories'));
    }

    // 3. Menyimpan Barang Baru ke Database (CREATE)
    public function store(Request $request)
    {
        // Validasi ketat sesuai instruksi Pak Noa
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'item_name' => 'required|string|min:5|max:80',
            'price' => 'required|integer|min:1',
            'stock' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Wajib ada gambar, max 2MB
        ], [
            'item_name.min' => 'Nama barang minimal harus 5 huruf.',
            'item_name.max' => 'Nama barang maksimal harus 80 huruf.',
            'price.integer' => 'Harga barang harus berupa angka.',
            'stock.integer' => 'Stok barang harus berupa angka.',
            'image.required' => 'Foto barang wajib diunggah.',
        ]);

        // Proses Upload Gambar
        $imagePath = null;
        if ($request->hasFile('image')) {
            // Menyimpan gambar ke folder public/storage/items
            $imagePath = $request->file('image')->store('items', 'public');
        }

        // Simpan data ke tabel items
        Item::create([
            'category_id' => $request->category_id,
            'item_name' => $request->item_name,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Barang berhasil ditambahkan!');
    }

    // 4. Menampilkan Form Edit Barang
    public function edit($id)
    {
        $item = Item::findOrFail($id);
        $categories = Category::all();
        return view('admin.edit', compact('item', 'categories'));
    }

    // 5. Memperbarui Data Barang (UPDATE)
    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'item_name' => 'required|string|min:5|max:80',
            'price' => 'required|integer|min:1',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Opsional saat edit
        ]);

        // Jika ada gambar baru yang di-upload
        if ($request->hasFile('image')) {
            // Hapus gambar lama dari storage agar tidak memicu sampah file
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }
            // Simpan gambar baru
            $item->image = $request->file('image')->store('items', 'public');
        }

        // Update data lainnya
        $item->update([
            'category_id' => $request->category_id,
            'item_name' => $request->item_name,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $item->image,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Barang berhasil diperbarui!');
    }

    // 6. Menghapus Barang (DELETE)
    public function destroy($id)
    {
        $item = Item::findOrFail($id);

        // Hapus foto barang dari storage sebelum datanya dihapus
        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Barang berhasil dihapus!');
    }

    // 7. Menampilkan Katalog untuk User Biasa (Hanya READ)
    public function userCatalog()
    {
        $items = Item::with('category')->get();
        return view('user.catalog', compact('items'));
    }
}
