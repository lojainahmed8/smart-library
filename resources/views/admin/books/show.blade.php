<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Book Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100">
                <div class="flex justify-between items-start mb-6 border-b border-gray-100 pb-4">
                    <div class="flex gap-4">
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-24 h-32 object-cover rounded-md border border-gray-200">
                        @endif
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">{{ $book->title }}</h3>
                            <p class="text-sm text-gray-500 mt-1">By {{ $book->author }}</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.books.edit', $book->id) }}" class="px-3 py-1.5 bg-amber-50 text-amber-700 border border-amber-200 text-xs font-medium rounded-md hover:bg-amber-100 transition">Edit Book</a>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
                    <div><span class="font-semibold text-gray-500">Category:</span> <span class="text-indigo-600 font-medium">{{ $book->category->name ?? 'None' }}</span></div>
                    <div><span class="font-semibold text-gray-500">ISBN:</span> {{ $book->isbn ?? 'N/A' }}</div>
                    <div><span class="font-semibold text-gray-500">Available Copies:</span> {{ $book->available_copies }}</div>
                    <div><span class="font-semibold text-gray-500">Publication Date:</span> {{ $book->publication_date ?? 'N/A' }}</div>
                </div>

                <div class="mb-6">
                    <h4 class="font-semibold text-gray-700 text-sm mb-2">Description:</h4>
                    <p class="text-gray-600 text-sm leading-relaxed bg-gray-50 p-4 rounded-lg border border-gray-100">
                        {{ $book->description ?? 'No description provided.' }}
                    </p>
                </div>

                <div>
                    <a href="{{ route('admin.books.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition">Back to List</a>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>