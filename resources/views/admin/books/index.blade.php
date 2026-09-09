<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            {{ __('Admin Dashboard - Manage Books') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Success Alert -->
            @if(session('success'))
                <div class="p-4 text-sm text-emerald-800 bg-emerald-50 rounded-xl border border-emerald-200 shadow-sm flex items-center justify-between">
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Clean Stats Cards (Professional SVG Icons) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                
                <!-- Total Books -->
                <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Books</p>
                        <h4 class="text-2xl font-bold text-slate-800 mt-1">{{ $books->count() }}</h4>
                    </div>
                    <div class="p-3 bg-slate-100 text-slate-600 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                </div>

                <!-- Available Copies -->
                <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Available Copies</p>
                        <h4 class="text-2xl font-bold text-emerald-600 mt-1">{{ $books->sum('available_copies') }}</h4>
                    </div>
                    <div class="p-3 bg-emerald-50 text-emerald-600 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Categories -->
                <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Categories</p>
                        <h4 class="text-2xl font-bold text-slate-800 mt-1">{{ $books->pluck('category_id')->unique()->count() }}</h4>
                    </div>
                    <div class="p-3 bg-slate-100 text-slate-600 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                </div>

            </div>

            <!-- Books Table Section -->
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-slate-200/80 p-6">
                
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Books Catalog</h3>
                        <p class="text-xs text-slate-500 mt-1">Manage library records, stock, and status.</p>
                    </div>
                    <a href="{{ route('admin.books.create') }}" class="px-4 py-2 bg-slate-900 text-white text-sm font-medium rounded-lg hover:bg-slate-800 transition shadow-sm inline-flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add New Book
                    </a>
                </div>

                <div class="overflow-x-auto rounded-lg border border-slate-200">
                    <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                        <thead class="bg-slate-50">
                            <tr>
                                <th scope="col" class="px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">ID</th>
                                <th scope="col" class="px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Title</th>
                                <th scope="col" class="px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Author</th>
                                <th scope="col" class="px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Category</th>
                                <th scope="col" class="px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Copies</th>
                                <th scope="col" class="px-6 py-3.5 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-100">
                            @forelse($books as $book)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-400">#{{ $book->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-800">{{ Str::title($book->title) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ Str::title($book->author) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2.5 py-1 bg-slate-100 text-slate-700 text-xs font-medium rounded-md">
                                            {{ $book->category->name ?? 'Uncategorized' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 font-medium">{{ $book->available_copies }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                        <div class="inline-flex items-center justify-center space-x-2">
                                            <a href="{{ route('admin.books.show', $book->id) }}" class="px-2.5 py-1.5 text-xs font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-md transition">View</a>
                                            <a href="{{ route('admin.books.edit', $book->id) }}" class="px-2.5 py-1.5 text-xs font-medium text-amber-700 hover:bg-amber-50 rounded-md transition">Edit</a>
                                            <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this book?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-2.5 py-1.5 text-xs font-medium text-rose-600 hover:bg-rose-50 rounded-md transition">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-slate-400 text-sm">No books found in the database.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-admin-layout>