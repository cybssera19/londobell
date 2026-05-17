<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - PT Londo Bell</title>
    <!-- Kita pakai Tailwind CSS untuk style ala Apple -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Menyisipkan font SF Pro via Google Fonts (Inter adalah alternatif terdekat) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#f5f5f7] flex items-center justify-center min-h-screen text-[#1d1d1f]">

    <div class="w-full max-w-[400px] p-8 bg-white md:rounded-3xl md:shadow-sm border border-[#e8e8ed]">

        <!-- Apple-like Logo Placeholder -->
        <div class="flex justify-center mb-6">
            <div class="w-12 h-12 bg-black rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-md">
                LB
            </div>
        </div>

        <h2 class="text-2xl font-semibold text-center tracking-tight mb-2">Sign in to Londo Bell</h2>
        <p class="text-sm text-[#86868b] text-center mb-8">Manage your stock and invoices seamlessly.</p>

        <!-- Notifikasi Sukses / Error dengan style clean -->
        @if(session('success'))
            <div class="mb-4 p-4 text-sm text-emerald-600 bg-emerald-50 rounded-2xl border border-emerald-100">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->has('loginError'))
            <div class="mb-4 p-4 text-sm text-rose-600 bg-rose-50 rounded-2xl border border-rose-100">
                {{ $errors->first('loginError') }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <input type="email" name="email" placeholder="Email (@gmail.com)" required
                    class="w-full px-4 py-3.5 bg-[#f5f5f7] border border-transparent rounded-2xl focus:outline-none focus:border-[#0071e3] focus:bg-white transition-all text-sm">
            </div>

            <div class="mb-6">
                <input type="password" name="password" placeholder="Password" required
                    class="w-full px-4 py-3.5 bg-[#f5f5f7] border border-transparent rounded-2xl focus:outline-none focus:border-[#0071e3] focus:bg-white transition-all text-sm">
            </div>

            <button type="submit"
                class="w-full py-3.5 bg-[#0071e3] hover:bg-[#0077ed] active:bg-[#0062c4] text-white font-medium rounded-2xl transition-all text-sm shadow-sm shadow-blue-500/20">
                Sign In
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-[#e8e8ed] text-center">
            <p class="text-xs text-[#86868b]">
                Don't have an Apple-level account?
                <a href="{{ route('register') }}" class="text-[#0071e3] hover:underline font-medium">Create yours now.</a>
            </p>
        </div>
    </div>

</body>
</html>
