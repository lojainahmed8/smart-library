<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Category Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border">
                
                <div class="border-b pb-4 mb-6 flex justify-between items-center">
                    <div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Category Name</span>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $category->name }}</h3>
                    </div>
                    <span class="px-3 py-1 bg-indigo-50 text-indigo-700 rounded-full text-xs font-bold">
                        ID: #{{ $category->id }}
                    </span>
                </div>

                <div class="mb-8">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Description</span>
                    <div class="mt-2 p-4 bg-gray-50 rounded-lg text-gray-700 leading-relaxed whitespace-pre-line border">
                        {{ $category->description ?? 'No detailed description available for this category.' }}
                    </div>
                </div>

                <div class="flex items-center space-x-3 border-t pt-6">
                    <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded hover:bg-gray-700 mr-2">
                        ← Back to List
                    </a>
                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="px-4 py-2 bg-amber-500 text-white text-sm font-medium rounded hover:bg-amber-600">
                        Edit Category
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-admin-layout>