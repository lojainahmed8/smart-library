<x-app-layout>
    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <!-- AI Recommendation Banner -->
        <div class="bg-emerald-800 text-white p-6 rounded-2xl shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div>
                <span class="inline-block bg-emerald-700/60 text-emerald-100 text-xs font-semibold px-3 py-1 rounded-full mb-2">
                    ⚡ AI Personal Recommendation Engine
                </span>
                <h2 class="text-2xl font-bold">Tailored for your learning path</h2>
                <p class="text-emerald-100 text-sm mt-1">
                    Matching books based on your profile interests (<strong>{{ $displayInterests }}</strong>).
                </p>
            </div>
            <a href="{{ route('profile.edit') }}" class="bg-white text-emerald-800 hover:bg-emerald-50 px-4 py-2 rounded-xl text-sm font-semibold transition">
                Update Preferences
            </a>
        </div>

        <!-- Search & Filter Form -->
        <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm">
            <form method="GET" action="{{ route('home') }}" class="flex flex-col md:flex-row gap-3">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Search by title, author, or keywords..." class="w-full border-gray-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 text-sm py-2.5 px-4">
                </div>
                
                <div class="w-full md:w-56">
                    <select name="category" onchange="this.form.submit()" class="w-full border-gray-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 text-sm py-2.5 px-4 pr-8 bg-white">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-6 py-2.5 rounded-xl text-sm transition">
                    Search
                </button>
            </form>
        </div>

        <!-- Books Grid -->
        <div>
            <h3 class="text-lg font-bold text-gray-800 mb-4">Explore Available Books ({{ $books->count() }} total)</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($books as $book)
                    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex flex-col justify-between hover:shadow-md transition">
                        <div>
                            @if($book->cover_image)
                                <div class="w-full h-32 bg-white border border-gray-100 rounded-xl mb-3 flex items-center justify-center overflow-hidden">
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="max-w-full max-h-full object-contain mx-auto">
                                </div>
                            @endif

                            <div class="flex items-center justify-between mb-3">
                                <span class="bg-emerald-50 text-emerald-700 text-xs font-semibold px-2.5 py-1 rounded-md uppercase">
                                    {{ $book->category->name ?? 'General' }}
                                </span>
                                <span class="text-emerald-600 font-bold text-xs bg-emerald-50 px-2.5 py-1 rounded-full">
                                    {{ $book->match_percentage }}% Match
                                </span>
                            </div>

                            <h4 class="font-bold text-gray-900 text-base mb-1">{{ $book->title }}</h4>
                            <p class="text-xs text-gray-500 mb-2">Author: {{ $book->author }}</p>
                            <p class="text-sm text-gray-600 line-clamp-2 mb-4">{{ $book->description }}</p>
                        </div>

                        <div class="flex items-center justify-between pt-3 border-t border-gray-50">
                            <!-- منع الأدمن من الاستعارة إطلاقاً -->
                            @if(Auth::check() && Auth::user()->role === 'admin')
                                <span class="inline-flex items-center text-xs font-medium text-emerald-600">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 mr-1.5"></span> Available ({{ $book->available_copies }} copies)
                                </span>
                                <span class="bg-slate-100 text-slate-500 text-xs font-bold px-3 py-1.5 rounded-xl">
                                    Admin View
                                </span>
                            @else 
                                @if($book->is_borrowed_by_user)
                                    <span class="inline-flex items-center text-xs font-medium text-amber-600">
                                        <span class="w-2 h-2 rounded-full bg-amber-500 mr-1.5"></span> Borrowed by you
                                    </span>
                                    <button disabled class="bg-gray-100 text-gray-400 text-xs font-semibold px-4 py-2 rounded-xl cursor-not-allowed">
                                        Borrowed
                                    </button>
                                @else
                                    <span class="inline-flex items-center text-xs font-medium text-emerald-600">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500 mr-1.5"></span> Available
                                    </span>
                                    <form method="POST" action="{{ route('books.borrow', $book->id) }}">
                                        @csrf
                                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-4 py-2 rounded-xl transition">
                                            Borrow
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 text-gray-500">
                        No books found matching your criteria.
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</x-app-layout>