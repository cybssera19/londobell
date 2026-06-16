<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Order History - PT Londo Bell</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-[#f5f5f7] text-[#1d1d1f] min-h-screen">

    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-[#e8e8ed] px-8 py-4 flex justify-between items-center">
        <a href="{{ route('user.catalog') }}" class="text-sm text-[#0071e3] hover:underline">← Back to Store</a>
        <span class="font-semibold tracking-tight text-lg">Order Receipts</span>
    </nav>

    <main class="max-w-3xl mx-auto px-8 py-12">
        <h1 class="text-3xl font-bold tracking-tight mb-8">Your Orders.</h1>

        @if(session('success'))
            <div class="mb-6 p-4 text-sm text-emerald-600 bg-emerald-50 rounded-2xl border border-emerald-100 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="space-y-6">
            @forelse($transactions as $tx)
                <div class="bg-white border border-[#e8e8ed] rounded-3xl p-6 shadow-sm space-y-4">
                    <div class="flex justify-between items-center border-b border-[#e8e8ed] pb-3 text-sm">
                        <div>
                            <p class="text-[#86868b] text-xs uppercase tracking-wider font-semibold">Order ID</p>
                            <p class="font-mono text-black mt-0.5">#LB-TX-{{ $tx->id }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[#86868b] text-xs uppercase tracking-wider font-semibold">Date Placed</p>
                            <p class="text-black mt-0.5">{{ $tx->created_at->format('d M Y, H:i') }} WIB</p>
                        </div>
                    </div>

                    <div class="divide-y divide-gray-100">
                        @foreach($tx->details as $detail)
                            <div class="py-2.5 flex justify-between text-sm">
                                <span class="text-[#1d1d1f]">{{ $detail->item->item_name }} <strong class="text-xs text-[#86868b]">x{{ $detail->quantity }}</strong></span>
                                <span class="font-medium text-zinc-600">Rp {{ number_format($detail->item->price * $detail->quantity, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="pt-3 border-t border-[#e8e8ed] flex justify-between items-center text-base font-bold">
                        <span class="text-sm text-[#86868b] font-normal">Amount Paid</span>
                        <span class="text-[#0071e3]">Rp {{ number_format($tx->grand_total, 0, ',', '.') }}</span>
                    </div>
                </div>
            @empty
                <div class="bg-white border border-[#e8e8ed] rounded-3xl p-12 text-center text-[#86868b] shadow-sm">
                    No order transactions recorded yet.
                </div>
            @endforelse
        </div>
    </main>

</body>
</html>
