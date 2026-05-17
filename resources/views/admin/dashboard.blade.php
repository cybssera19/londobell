<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Dashboard - Apple Style</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-[#f5f5f7] text-[#1d1d1f] min-h-screen">

    <!-- Navigation Bar ala macOS App Store Header -->
    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-[#e8e8ed] px-8 py-4 flex justify-between items-center">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 bg-black text-white rounded-lg flex items-center justify-center font-bold text-sm">LB</div>
            <span class="font-semibold tracking-tight text-lg">Londo Bell Command Center</span>
        </div>
        <div class="flex items-center space-x-6">
            <span class="text-sm text-[#86868b]">Hello, <strong class="text-black">{{ Auth::user()->name }}</strong></span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-sm text-rose-600 hover:underline font-medium">Sign Out</button>
            </form>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-8 py-10">
        <!-- Header Section -->
        <div class="space-x-2">
            <a href="{{ route('categories.index') }}"
            class="px-5 py-2.5 bg-white border border-[#e8e8ed] hover:bg-[#f5f5f7] text-[#1d1d1f] text-sm font-medium rounded-full transition-all shadow-sm">
            Manage Categories
            </a>
            <a href="{{ route('items.create') }}"
            class="px-5 py-2.5 bg-[#0071e3] hover:bg-[#0077ed] text-white text-sm font-medium rounded-full transition-all shadow-sm">
            + Add New Item
            </a>
        </div>


        <!-- Alert Notification -->
        @if(session('success'))
            <div class="mb-6 p-4 text-sm text-emerald-600 bg-emerald-50 rounded-2xl border border-emerald-100 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Inventory List (Apple Table Container) -->
        <div class="bg-white border border-[#e8e8ed] rounded-3xl overflow-hidden shadow-sm">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#f5f5f7] border-b border-[#e8e8ed] text-xs font-semibold text-[#86868b] uppercase tracking-wider">
                        <th class="px-6 py-4">Image</th>
                        <th class="px-6 py-4">Item Name</th>
                        <th class="px-6 py-4">Category</th>
                        <th class="px-6 py-4">Price</th>
                        <th class="px-6 py-4">Stock Level</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e8e8ed] text-sm">
                    @forelse($items as $item)
                        <tr class="hover:bg-[#fafafa] transition-colors">
                            <td class="px-6 py-4">
                                <img src="{{ asset('storage/' . $item->image) }}" alt="product" class="w-12 h-12 object-cover rounded-xl border border-[#e8e8ed]">
                            </td>
                            <td class="px-6 py-4 font-medium text-black">{{ $item->item_name }}</td>
                            <td class="px-6 py-4 text-[#86868b]">{{ $item->category->category_name }}</td>
                            <td class="px-6 py-4 font-medium">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                @if($item->stock <= 5)
                                    <span class="px-2.5 py-1 text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200 rounded-full">Low Stock: {{ $item->stock }}</span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full">{{ $item->stock }} units</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right space-x-3">
                                <a href="{{ route('items.edit', $item->id) }}" class="text-[#0071e3] hover:underline font-medium">Edit</a>
                                <form action="{{ route('items.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this exquisite item?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:underline font-medium">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-[#86868b]">
                                No items found. Click "+ Add New Item" to populate the ecosystem.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>
