<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Catalog - PT Londo Bell</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-[#f5f5f7] text-[#1d1d1f] min-h-screen">

    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-[#e8e8ed] px-8 py-4 flex justify-between items-center">
        <span class="font-semibold tracking-tight text-lg">Londo Bell Store</span>
        <div class="flex items-center space-x-6">
            <a href="{{ route('cart.index') }}" class="text-sm text-[#0071e3] hover:underline font-medium">View Bag</a>
            <a href="{{ route('transactions.history') }}" class="text-sm text-zinc-600 hover:underline font-medium">Order History</a>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-sm text-rose-600 hover:underline font-medium">Sign Out</button>
            </form>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-8 py-10">
        <div class="mb-10">
            <h1 class="text-3xl font-bold tracking-tight">Available Goods</h1>
            <p class="text-sm text-[#86868b] mt-1">Browse and monitor authentic company supplies.</p>
        </div>

        <!-- Grid Layout ala App Store Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($items as $item)
                <div class="bg-white border border-[#e8e8ed] rounded-3xl overflow-hidden shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
                    <img src="{{ asset('storage/' . $item->image) }}" alt="product" class="w-full h-48 object-cover border-b border-[#e8e8ed]">
                    <div class="p-5 flex-grow">
                        <span class="text-xs font-semibold text-[#0071e3] tracking-wide uppercase">{{ $item->category->category_name }}</span>
                        <h3 class="font-semibold text-lg text-black mt-1 line-clamp-2">{{ $item->item_name }}</h3>
                        <p class="text-base font-medium text-[#1d1d1f] mt-2">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                    </div>
                    <div class="px-5 pb-5 pt-0">
                        <div class="w-full text-center py-2 bg-[#f5f5f7] text-xs font-medium text-[#86868b] rounded-xl">
                            Stock: {{ $item->stock }} remaining
                        </div>
                            <form action="{{ route('cart.add', $item->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full py-2.5 bg-black hover:bg-zinc-800 text-white text-xs font-medium rounded-xl transition-colors">
                                    Add to Bag
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-[#86868b] py-12">
                    The showcase is currently clean and empty.
                </div>
            @endforelse
        </div>
    </main>

</body>
</html>
