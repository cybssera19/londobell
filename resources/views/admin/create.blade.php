<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories - Apple Style</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-[#f5f5f7] text-[#1d1d1f] min-h-screen">

    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-[#e8e8ed] px-8 py-4 flex justify-between items-center">
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-[#0071e3] hover:underline">← Back to Dashboard</a>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-8 py-10">
        <h1 class="text-3xl font-bold tracking-tight mb-8">Inventory Categories</h1>

        @if(session('success'))
            <div class="mb-6 p-4 text-sm text-emerald-600 bg-emerald-50 rounded-2xl border border-emerald-100 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Form Tambah Kategori -->
            <div class="bg-white border border-[#e8e8ed] rounded-3xl p-6 shadow-sm h-fit">
                <h3 class="text-lg font-semibold mb-4">Create Category</h3>
                <form action="{{ route('categories.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <input type="text" name="category_name" placeholder="Category Name" required
                            class="w-full px-4 py-3 bg-[#f5f5f7] border border-transparent rounded-2xl focus:outline-none focus:border-[#0071e3] focus:bg-white transition-all text-sm">
                        @error('category_name') <p class="text-xs text-rose-500 mt-1 ml-1">{{ $message }}</p> @enderror
                    </div>
                    <button type="submit" class="w-full py-3 bg-[#0071e3] hover:bg-[#0077ed] text-white font-medium rounded-2xl transition-all text-sm shadow-sm">
                        Add Category
                    </button>
                </form>
            </div>

            <!-- Tabel Daftar Kategori -->
            <div class="md:col-span-2 bg-white border border-[#e8e8ed] rounded-3xl overflow-hidden shadow-sm">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#f5f5f7] border-b border-[#e8e8ed] text-xs font-semibold text-[#86868b] uppercase tracking-wider">
                            <th class="px-6 py-4">Category Name</th>
                            <th class="px-6 py-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#e8e8ed] text-sm">
                        @forelse($categories as $category)
                            <tr class="hover:bg-[#fafafa] transition-colors">
                                <td class="px-6 py-4 font-medium text-black">{{ $category->category_name }}</td>
                                <td class="px-6 py-4 text-right">
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Deleting category will affect related items. Proceed?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-600 hover:underline font-medium">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-8 text-center text-[#86868b]">No categories defined yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</body>
</html>
