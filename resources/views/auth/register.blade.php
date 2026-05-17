<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Your Account - PT Londo Bell</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#f5f5f7] flex items-center justify-center min-h-screen text-[#1d1d1f] my-10 md:my-0">

    <div class="w-full max-w-[460px] p-8 bg-white md:rounded-3xl md:shadow-sm border border-[#e8e8ed]">

        <h2 class="text-2xl font-semibold text-center tracking-tight mb-2">Create Your Account</h2>
        <p class="text-sm text-[#86868b] text-center mb-8">One account for all PT Londo Bell services.</p>

        <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Full Name" required
                    class="w-full px-4 py-3.5 bg-[#f5f5f7] border border-transparent rounded-2xl focus:outline-none focus:border-[#0071e3] focus:bg-white transition-all text-sm">
                @error('name') <p class="text-xs text-rose-500 mt-1 ml-2">{{ $message }}</p> @enderror
            </div>

            <div>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email address (@gmail.com)" required
                    class="w-full px-4 py-3.5 bg-[#f5f5f7] border border-transparent rounded-2xl focus:outline-none focus:border-[#0071e3] focus:bg-white transition-all text-sm">
                @error('email') <p class="text-xs text-rose-500 mt-1 ml-2">{{ $message }}</p> @enderror
            </div>

            <div>
                <input type="password" name="password" placeholder="Password (6-12 characters)" required
                    class="w-full px-4 py-3.5 bg-[#f5f5f7] border border-transparent rounded-2xl focus:outline-none focus:border-[#0071e3] focus:bg-white transition-all text-sm">
                @error('password') <p class="text-xs text-rose-500 mt-1 ml-2">{{ $message }}</p> @enderror
            </div>

            <div>
                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Phone Number (e.g., 081234...)" required
                    class="w-full px-4 py-3.5 bg-[#f5f5f7] border border-transparent rounded-2xl focus:outline-none focus:border-[#0071e3] focus:bg-white transition-all text-sm">
                @error('phone') <p class="text-xs text-rose-500 mt-1 ml-2">{{ $message }}</p> @enderror
            </div>

            <div class="pt-2">
                <button type="submit"
                    class="w-full py-3.5 bg-[#0071e3] hover:bg-[#0077ed] active:bg-[#0062c4] text-white font-medium rounded-2xl transition-all text-sm shadow-sm shadow-blue-500/20">
                    Submit
                </button>
            </div>
        </form>

        <div class="mt-8 pt-6 border-t border-[#e8e8ed] text-center">
            <p class="text-xs text-[#86868b]">
                Already have an account?
                <a href="{{ route('login') }}" class="text-[#0071e3] hover:underline font-medium">Sign in here.</a>
            </p>
        </div>
    </div>

</body>
</html>
