<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100">
                
                <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-100">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">{{ $user->name }}</h3>
                        <p class="text-xs text-gray-500 mt-1">User Profile & Account Information</p>
                    </div>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-700' }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>

                <div class="space-y-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider block mb-1">User ID</span>
                        <p class="text-sm font-bold text-gray-800">#{{ $user->id }}</p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider block mb-1">Full Name</span>
                        <p class="text-sm font-bold text-gray-800">{{ $user->name }}</p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider block mb-1">Email Address</span>
                        <p class="text-sm font-bold text-gray-800">{{ $user->email }}</p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider block mb-1">Registered At</span>
                        <p class="text-sm font-bold text-gray-800">{{ $user->created_at ? $user->created_at->format('Y-m-d H:i A') : 'N/A' }}</p>
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-2">
                    <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-300">Back to Users</a>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="px-4 py-2 bg-amber-500 text-white text-sm font-semibold rounded-lg hover:bg-amber-600 shadow-sm">Edit User</a>
                </div>

            </div>
        </div>
    </div>
</x-admin-layout>