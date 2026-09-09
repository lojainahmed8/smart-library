<nav x-data="{ open: false }" class="bg-white border-b border-slate-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            <!-- Left Side: Logo & Navigation -->
            <div class="flex items-center space-x-8">
                <!-- Brand Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-slate-900 font-bold text-lg tracking-tight hover:opacity-80 transition">
                    <span class="p-1.5 bg-emerald-600 text-white rounded-lg shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </span>
                    <span class="font-bold text-slate-800">Smart<span class="text-emerald-600">Library</span></span>
                </a>

                <!-- Navigation Links -->
                <div class="hidden sm:flex sm:items-center sm:space-x-6">
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                                Admin Control Panel
                            </a>
                        @else
                            <a href="{{ route('home') }}" class="px-3 py-2 text-sm font-medium transition {{ request()->routeIs('home') ? 'text-emerald-600 border-b-2 border-emerald-600 font-semibold' : 'text-slate-600 hover:text-slate-900' }}">
                                Home
                            </a>
                            <a href="{{ route('borrowed.index') }}" class="px-3 py-2 text-sm font-medium transition {{ request()->routeIs('borrowed.index') ? 'text-emerald-600 border-b-2 border-emerald-600 font-semibold' : 'text-slate-600 hover:text-slate-900' }}">
                                My Books
                            </a>
                        @endif
                    @else
                        <a href="{{ route('home') }}" class="px-3 py-2 text-sm font-medium transition {{ request()->routeIs('home') ? 'text-emerald-600 border-b-2 border-emerald-600 font-semibold' : 'text-slate-600 hover:text-slate-900' }}">
                            Home
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Right Side: Profile / Auth -->
            <div class="hidden sm:flex sm:items-center">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-2 text-sm font-medium text-slate-700 hover:text-slate-900 focus:outline-none transition py-2 px-3 rounded-lg hover:bg-slate-50">
                                <span>{{ Auth::user()->name }}</span>
                                @if(Auth::user()->role === 'admin')
                                    <span class="text-[10px] bg-amber-100 text-amber-800 px-2 py-0.5 rounded-full font-bold">Admin</span>
                                @endif
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}" class="text-sm text-slate-600 hover:text-slate-900 font-medium">Log in</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-medium transition shadow-sm">Register</a>
                    </div>
                @endauth
            </div>

        </div>
    </div>
</nav>