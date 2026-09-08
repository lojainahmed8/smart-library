<x-app-layout>
    <div class="space-y-6">

        <!-- Header -->
        <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm">
            <h2 class="text-xl font-bold text-slate-900 tracking-tight">My Borrowed Books</h2>
            <p class="text-xs text-slate-500 mt-1">View and manage all the books you have currently borrowed from the library.</p>
        </div>

        @if(!isset($borrowings) || $borrowings->isEmpty())
            <div class="bg-white border border-slate-200 rounded-2xl p-12 text-center shadow-sm">
                <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                <h3 class="text-sm font-bold text-slate-700">No books borrowed yet</h3>
                <p class="text-xs text-slate-500 mt-1 mb-4">Browse our collection on the home page to start borrowing!</p>
                <a href="{{ route('home') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs rounded-xl shadow-md transition">
                    Explore Books
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($borrowings as $borrowing)
                    <div class="bg-white border border-slate-200 rounded-2xl p-5 hover:border-emerald-500/50 hover:shadow-lg transition-all duration-300 flex flex-col justify-between shadow-sm">
                        <div>
                            <div class="flex items-center justify-between gap-2 mb-3">
                                <span class="px-2.5 py-1 rounded-md bg-emerald-50 border border-emerald-200 text-emerald-700 text-[10px] font-bold uppercase tracking-wider">
                                    {{ $borrowing->book->category->name ?? 'General' }}
                                </span>

                                <span class="px-2 py-0.5 rounded bg-emerald-100 border border-emerald-300 text-emerald-800 text-[11px] font-bold">
                                    Active Loan
                                </span>
                            </div>

                            <h4 class="text-base font-bold text-slate-900 mb-1 line-clamp-1">{{ $borrowing->book->title ?? 'Book Title' }}</h4>
                            <p class="text-xs text-slate-500 mb-3">Author: <span class="text-slate-700 font-medium">{{ $borrowing->book->author ?? 'Unknown' }}</span></p>
                            <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed mb-4 font-normal">{{ $borrowing->book->description ?? '' }}</p>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-3">
                            <span class="text-[11px] text-slate-500 font-medium">
                                Borrowed: {{ $borrowing->created_at ? $borrowing->created_at->format('M d, Y') : 'Recently' }}
                            </span>

                            <form method="POST" action="{{ route('books.return', $borrowing->id) }}">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs rounded-xl transition shadow-sm">
                                    Return Book
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</x-app-layout>