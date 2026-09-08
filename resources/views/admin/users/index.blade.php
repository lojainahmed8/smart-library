<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Users') }}
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
                @if(session('error'))
                    <div class="mb-4 p-4 text-sm text-red-800 bg-red-50 rounded-lg border border-red-200">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Registered Users</h3>
                        <p class="text-xs text-gray-500 mt-1">Manage accounts, roles, and view user details.</p>
                    </div>
                    <a href="{{ route('admin.users.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-sm">
                        + Add New User
                    </a>
                </div>

                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">ID</th>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Name</th>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Email</th>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Role</th>
                                <th scope="col" class="px-6 py-3.5 text-center text-xs font-semibold text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-400 whitespace-nowrap">#{{ $user->id }}</td>
                                    <td class="px-6 py-4 text-sm font-bold text-gray-800 whitespace-nowrap">{{ $user->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">{{ $user->email }}</td>
                                    <td class="px-6 py-4 text-sm whitespace-nowrap">
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-700' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                        <div class="flex items-center justify-center space-x-2 {{ $user->id === auth()->id() ? 'pl-6' : '' }}">
                                            
                                            <!-- View -->
                                            <a href="{{ route('admin.users.show', $user->id) }}" class="px-3 py-1.5 bg-slate-100 text-slate-700 text-xs font-medium rounded-md hover:bg-slate-200 border border-slate-300 transition">
                                                View
                                            </a>

                                            <!-- Edit -->
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="px-3 py-1.5 bg-amber-50 text-amber-700 text-xs font-medium rounded-md hover:bg-amber-100 border border-amber-200 transition">
                                                Edit
                                            </a>

                                            <!-- Delete OR Logged-in Admin -->
                                            @if($user->id !== auth()->id())
                                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-3 py-1.5 bg-rose-50 text-rose-700 text-xs font-medium rounded-md hover:bg-rose-100 border border-rose-200 transition">
                                                        Delete
                                                    </button>
                                                </form>
                                            @else
                                                <span class="px-3 py-1.5 text-xs text-gray-500 font-normal border border-gray-200 rounded bg-gray-50 whitespace-nowrap">
                                                    Logged-in Admin
                                                </span>
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>