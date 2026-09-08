<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Categories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100">
                
                @if(session('success'))
                    <div class="mb-4 p-4 text-sm text-green-800 bg-green-50 rounded-lg border border-green-200">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Categories List</h3>
                        <p class="text-xs text-gray-500 mt-1">Manage and organize all book categories in your library.</p>
                    </div>
                    <a href="{{ route('admin.categories.create') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition shadow-sm">
                        + Add New Category
                    </a>
                </div>

                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">ID</th>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Name</th>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Description</th>
                                <th scope="col" class="px-6 py-3.5 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($categories as $category)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-400">#{{ $category->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-800">{{ $category->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ \Illuminate\Support\Str::limit($category->description, 60, '...') ?? 'No description' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="inline-flex items-center space-x-2">
                                            <!-- View Button (Slate/Neutral) -->
                                            <a href="{{ route('admin.categories.show', $category->id) }}" class="w-16 text-center px-2.5 py-1.5 bg-slate-100 text-slate-700 text-xs font-medium rounded-md hover:bg-slate-200 transition border border-slate-300 mr-1">
                                                View
                                            </a>
                                            <!-- Edit Button (Amber/Soft) -->
                                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="w-16 text-center px-2.5 py-1.5 bg-amber-50 text-amber-700 text-xs font-medium rounded-md hover:bg-amber-100 transition border border-amber-200 mr-1">
                                                Edit
                                            </a>
                                            <!-- Delete Button (Rose/Soft Red) -->
                                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-16 text-center px-2.5 py-1.5 bg-rose-50 text-rose-700 text-xs font-medium rounded-md hover:bg-rose-100 transition border border-rose-200">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500 text-sm">No categories found. Click "+ Add New Category" to create one.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>