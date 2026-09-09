<x-admin-layout>
    <div class="space-y-6">
        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-slate-200/80 p-6">
            
            @if(session('success'))
                <div class="mb-4 p-4 text-sm text-emerald-800 bg-emerald-50 rounded-xl border border-emerald-200">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Categories List</h3>
                    <p class="text-xs text-slate-500 mt-1">Manage and organize all book categories in your library.</p>
                </div>
                <a href="{{ route('admin.categories.create') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg transition shadow-sm inline-flex items-center gap-1.5">
                    + Add New Category
                </a>
            </div>

            <div class="overflow-x-auto rounded-lg border border-slate-200">
                <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th scope="col" class="px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Name</th>
                            <th scope="col" class="px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Description</th>
                            <th scope="col" class="px-6 py-3.5 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @forelse($categories as $category)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-400">#{{ $category->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-800">{{ $category->name }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ \Illuminate\Support\Str::limit($category->description, 60, '...') ?? 'No description' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                    <div class="inline-flex items-center justify-center space-x-2">
                                        <a href="{{ route('admin.categories.show', $category->id) }}" class="px-2.5 py-1.5 text-xs font-medium text-slate-600 hover:bg-slate-100 rounded-md transition">View</a>
                                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="px-2.5 py-1.5 text-xs font-medium text-amber-700 hover:bg-amber-50 rounded-md transition">Edit</a>
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2.5 py-1.5 text-xs font-medium text-rose-600 hover:bg-rose-50 rounded-md transition">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-400 text-sm">No categories found. Click "+ Add New Category" to create one.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-admin-layout>