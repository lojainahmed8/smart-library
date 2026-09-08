<x-app-layout>
    <div class="space-y-8">
        
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-200 pb-5">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">System Overview</h1>
                <p class="text-xs text-slate-500 mt-1">Welcome back, {{ Auth::user()->name }}. Here is what's happening in your library today.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.categories.create') ?? '#' }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-xl transition shadow-sm">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Add Category
                </a>
                <a href="{{ route('admin.books.create') ?? '#' }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold rounded-xl transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Add New Book
                </a>
            </div>
        </div>

        <!-- Metric KPI Cards (قراءة من مصفوفة $stats) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- Total Books -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Total Books</p>
                    <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ $stats['total_books'] ?? 0 }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
            </div>

            <!-- Available Copies -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Available Copies</p>
                    <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ $stats['total_copies'] ?? 0 }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>

            <!-- Categories -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Categories</p>
                    <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ $stats['total_categories'] ?? 0 }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-purple-50 border border-purple-100 flex items-center justify-center text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 7h.01M7 11h.01M7 15h.01M11 7h8M11 11h8M11 15h8"/></svg>
                </div>
            </div>

            <!-- Borrowing Orders -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Borrowing Orders</p>
                    <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ $stats['total_borrowings'] ?? 0 }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
            </div>
        </div>

        <!-- Quick Navigation Links -->
        <div class="flex items-center gap-3 bg-white p-2 rounded-2xl border border-slate-200/80 shadow-sm">
            <a href="{{ route('admin.books.index') ?? '#' }}" class="flex-1 text-center py-2.5 px-4 rounded-xl text-xs font-bold transition bg-slate-900 text-white shadow-sm">
                Books Management
            </a>
            <a href="{{ route('admin.categories.index') ?? '#' }}" class="flex-1 text-center py-2.5 px-4 rounded-xl text-xs font-bold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition">
                Categories Management
            </a>
            <a href="{{ route('admin.users.index') ?? '#' }}" class="flex-1 text-center py-2.5 px-4 rounded-xl text-xs font-bold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition">
                Users Management ({{ $stats['total_users'] ?? 0 }})
            </a>
        </div>

        <!-- Recent Books Catalog Table Section (قراءة من $recent_books) -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Recently Added Books</h3>
                    <p class="text-xs text-slate-400">Overview of the latest additions to your catalog.</p>
                </div>
                <a href="{{ route('admin.books.index') ?? '#' }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 transition flex items-center gap-1">
                    View All Books
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
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
                            <th class="py-3.5 px-5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse($recent_books ?? [] as $book)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-4 px-5 text-slate-400 font-bold">#{{ $book->id }}</td>
                                <td class="py-4 px-5 font-bold text-slate-900">{{ $book->title }}</td>
                                <td class="py-4 px-5 text-slate-600">{{ $book->author }}</td>
                                <td class="py-4 px-5">
                                    <span class="inline-block bg-slate-100 text-slate-700 px-2.5 py-1 rounded-md text-[10px] font-bold">
                                        {{ $book->category->name ?? 'Uncategorized' }}
                                    </span>
                                </td>
                                <td class="py-4 px-5 font-bold text-slate-800">{{ $book->available_copies }}</td>
                                <td class="py-4 px-5 text-right space-x-2">
                                    <a href="{{ route('admin.books.edit', $book->id) ?? '#' }}" class="inline-flex items-center p-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition" title="Edit">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400">No recent books found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>