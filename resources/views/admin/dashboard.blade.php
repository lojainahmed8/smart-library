<x-admin-layout>
    <div class="space-y-8">
        
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-200 pb-5">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">System Overview</h1>
                <p class="text-xs text-slate-500 mt-1">Welcome back, {{ Auth::user()->name }}. Here is what's happening in your library today.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-xl transition shadow-sm">
                    + Add Category
                </a>
                <a href="{{ route('admin.books.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold rounded-xl transition shadow-sm">
                    + Add New Book
                </a>
            </div>
        </div>

        <!-- Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Total Books</p>
                <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ $stats['total_books'] ?? 0 }}</h3>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Available Copies</p>
                <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ $stats['total_copies'] ?? 0 }}</h3>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Categories</p>
                <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ $stats['total_categories'] ?? 0 }}</h3>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Borrowing Orders</p>
                <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ $stats['total_borrowings'] ?? 0 }}</h3>
            </div>
        </div>

        <!-- Recent Books Catalog Table -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Recently Added Books</h3>
                    <p class="text-xs text-slate-400">Overview of the latest additions to your catalog.</p>
                </div>
                <a href="{{ route('admin.books.index') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 transition">
                    View All Books &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50 text-[11px] uppercase font-bold text-slate-400 border-b border-slate-100">
                        <tr>
                            <th class="py-3.5 px-5">ID</th>
                            <th class="py-3.5 px-5">Title</th>
                            <th class="py-3.5 px-5">Author</th>
                            <th class="py-3.5 px-5">Category</th>
                            <th class="py-3.5 px-5">Available Copies</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse($recent_books ?? [] as $book)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-4 px-5 text-slate-400 font-bold">#{{ $book->id }}</td>
                                <td class="py-4 px-5 font-bold text-slate-900">{{ $book->title }}</td>
                                <td class="py-4 px-5 text-slate-600">{{ $book->author }}</td>
                                <td class="py-4 px-5">
                                    <span class="bg-slate-100 text-slate-700 px-2.5 py-1 rounded-md text-[10px] font-bold">
                                        {{ $book->category->name ?? 'Uncategorized' }}
                                    </span>
                                </td>
                                <td class="py-4 px-5 font-bold text-slate-800">{{ $book->available_copies }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400">No recent books found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-admin-layout>