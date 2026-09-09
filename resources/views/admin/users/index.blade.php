<x-admin-layout>
    <div class="space-y-6">
        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-slate-200/80 p-6">
            
            @if(session('success'))
                <div class="mb-4 p-4 text-sm text-emerald-800 bg-emerald-50 rounded-xl border border-emerald-200">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-4 text-sm text-rose-800 bg-rose-50 rounded-xl border border-rose-200">
                    {{ session('error') }}
                </div>
            @endif

            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Registered Users</h3>
                    <p class="text-xs text-slate-500 mt-1">Manage accounts, roles, and view user details.</p>
                </div>
                <a href="{{ route('admin.users.create') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-lg shadow-sm transition">
                    + Add New User
                </a>
            </div>

            <div class="overflow-x-auto rounded-lg border border-slate-200">
                <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th scope="col" class="px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase">ID</th>
                            <th scope="col" class="px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase">Name</th>
                            <th scope="col" class="px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase">Email</th>
                            <th scope="col" class="px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase">Role</th>
                            <th scope="col" class="px-6 py-3.5 text-center text-xs font-semibold text-slate-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @foreach($users as $user)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-slate-400 whitespace-nowrap">#{{ $user->id }}</td>
                                <td class="px-6 py-4 text-sm font-bold text-slate-800 whitespace-nowrap">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600 whitespace-nowrap">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-sm whitespace-nowrap">
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-700' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                    <div class="grid grid-cols-[56px_56px_auto] items-center gap-2">
                                        <a href="{{ route('admin.users.show', $user->id) }}" class="px-2.5 py-1.5 text-xs font-medium text-slate-600 hover:bg-slate-100 rounded-md transition text-center">
                                            View
                                        </a>

                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="px-2.5 py-1.5 text-xs font-medium text-amber-700 hover:bg-amber-50 rounded-md transition text-center">
                                            Edit
                                        </a>

                                        @if($user->id !== auth()->id())
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-2.5 py-1.5 text-xs font-medium text-rose-600 hover:bg-rose-50 rounded-md transition text-center">
                                                    Delete
                                                </button>
                                            </form>
                                        @else
                                            <span class="px-2.5 py-1 text-xs text-slate-400 font-normal border border-slate-200 rounded bg-slate-50 whitespace-nowrap text-center">
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
</x-admin-layout>