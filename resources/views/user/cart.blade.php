<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review your Bag - Apple Style</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-[#f5f5f7] text-[#1d1d1f] min-h-screen">

    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-[#e8e8ed] px-8 py-4 flex justify-between items-center">
        <a href="{{ route('user.catalog') }}" class="text-sm text-[#0071e3] hover:underline">← Continue Shopping</a>
        <span class="font-semibold tracking-tight text-lg">Your Wholesale Bag</span>
    </nav>

    <main class="max-w-4xl mx-auto px-8 py-12">
        <h1 class="text-3xl font-bold tracking-tight mb-2">Review your Bag.</h1>
        <p class="text-sm text-[#86868b] mb-8">Free delivery and smooth processing inside PT Londo Bell logistics.</p>

        @if(session('success'))
            <div class="mb-6 p-4 text-sm text-emerald-600 bg-emerald-50 rounded-2xl border border-emerald-100 shadow-sm">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 p-4 text-sm text-rose-600 bg-rose-50 rounded-2xl border border-rose-100 shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- LIST BARANG DI KERANJANG -->
            <div class="md:col-span-2 space-y-4">
                @forelse($cartItems as $cart)
                    <div class="bg-white border border-[#e8e8ed] rounded-3xl p-5 flex items-center space-x-4 shadow-sm">
                        <img src="{{ asset('storage/' . $cart->item->image) }}" class="w-20 h-20 object-cover rounded-2xl border border-[#e8e8ed]">
                        <div class="flex-grow">
                            <span class="text-[10px] font-semibold text-[#0071e3] uppercase">{{ $cart->item->category->category_name }}</span>
                            <h3 class="font-semibold text-base text-black mt-0.5">{{ $cart->item->item_name }}</h3>
                            <p class="text-xs text-[#86868b] mt-1">Quantity: <strong class="text-black">{{ $cart->quantity }} pcs</strong></p>
                        </div>
                        <div class="text-right flex flex-col justify-between h-20">
                            <span class="font-medium text-sm">Rp {{ number_format($cart->item->price * $cart->quantity, 0, ',', '.') }}</span>
                            <form action="{{ route('cart.delete', $cart->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-rose-600 hover:underline font-medium">Remove</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="bg-white border border-[#e8e8ed] rounded-3xl p-8 text-center text-[#86868b] shadow-sm">
                        Your Bag is empty. Explore the catalog to select high-end goods.
                    </div>
                @endforelse
            </div>

            <!-- RINGKASAN PEMBAYARAN (ORDER SUMMARY) -->
            <div class="bg-white border border-[#e8e8ed] rounded-3xl p-6 shadow-sm h-fit space-y-4">
                <h3 class="text-lg font-bold tracking-tight">Order Summary</h3>
                <div class="divide-y divide-[#e8e8ed] text-sm">
                    <div class="py-3 flex justify-between">
                        <span class="text-[#86868b]">Subtotal</span>
                        <span class="font-medium">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>
                    <div class="py-3 flex justify-between">
                        <span class="text-[#86868b]">Shipping</span>
                        <span class="text-emerald-600 font-medium">Complimentary</span>
                    </div>
                    <div class="py-4 flex justify-between text-base font-bold">
                        <span>Total</span>
                        <span>Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>
                </div>

                @if($cartItems->count() > 0)
                <form action="{{ route('checkout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full py-3.5 bg-[#0071e3] hover:bg-[#0077ed] text-white font-medium rounded-2xl transition-all text-sm shadow-sm text-center block">
                        Proceed to Checkout
                    </button>
                </form>
                @else
                    <button disabled class="w-full py-3.5 bg-gray-100 text-gray-400 font-medium rounded-2xl text-sm cursor-not-allowed">
                        Bag is Empty
                    </button>
                @endif
            </div>
        </div>
    </main>

</body>
</html>
