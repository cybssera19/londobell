<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item - PT Londo Bell</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-[#f5f5f7] text-[#1d1d1f] min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-[540px] bg-white border border-[#e8e8ed] rounded-3xl p-8 shadow-sm">
        <div class="mb-8">
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-[#0071e3] hover:underline">← Cancel & Return</a>
            <h2 class="text-2xl font-bold tracking-tight mt-3">Modify Specifications</h2>
            <p class="text-sm text-[#86868b]">Updating specifications for item asset ID: #{{ $item->id }}</p>
        </div>

        <form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-semibold text-[#86868b] uppercase tracking-wider mb-2 ml-1">Item Name</label>
                <input type="text" name="item_name" value="{{ old('item_name', $item->item_name) }}" required
                    class="w-full px-4 py-3 bg-[#f5f5f7] border border-transparent rounded-2xl focus:outline-none focus:border-[#0071e3] focus:bg-white transition-all text-sm">
                @error('item_name') <p class="text-xs text-rose-500 mt-1 ml-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-[#86868b] uppercase tracking-wider mb-2 ml-1">Price (IDR)</label>
                    <input type="number" name="price" value="{{ old('price', $item->price) }}" required
                        class="w-full px-4 py-3 bg-[#f5f5f7] border border-transparent rounded-2xl focus:outline-none focus:border-[#0071e3] focus:bg-white transition-all text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#86868b] uppercase tracking-wider mb-2 ml-1">Adjust Stock</label>
                    <input type="number" name="stock" value="{{ old('stock', $item->stock) }}" required
                        class="w-full px-4 py-3 bg-[#f5f5f7] border border-transparent rounded-2xl focus:outline-none focus:border-[#0071e3] focus:bg-white transition-all text-sm">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-[#86868b] uppercase tracking-wider mb-2 ml-1">Category Classification</label>
                <select name="category_id" required
                    class="w-full px-4 py-3 bg-[#f5f5f7] border border-transparent rounded-2xl focus:outline-none focus:border-[#0071e3] focus:bg-white transition-all text-sm">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $item->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-[#86868b] uppercase tracking-wider mb-2 ml-1">Replace Media (Leave blank to keep current)</label>
                <div class="flex items-center space-x-4 mb-2">
                    <img src="{{ asset('storage/' . $item->image) }}" class="w-14 h-14 object-cover rounded-xl border border-[#e8e8ed]">
                    <span class="text-xs text-[#86868b]">Current Asset Image</span>
                </div>
                <input type="file" name="image"
                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-[#f5f5f7] file:text-black hover:file:bg-[#e8e8ed] file:cursor-pointer">
            </div>

            <div class="pt-4">
                <button type="submit"
                    class="w-full py-3.5 bg-black hover:bg-zinc-800 text-white font-medium rounded-2xl transition-all text-sm shadow-sm">
                    Save Structural Changes
                </button>
            </div>
        </form>
    </div>

</body>
</html>
