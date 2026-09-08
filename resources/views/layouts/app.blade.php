<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SmartLibrary') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- AlpineJS & Vite -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-slate-800 bg-slate-50 min-h-screen selection:bg-emerald-500 selection:text-white">

    <div class="min-h-screen flex flex-col">
        
        <!-- Navigation Bar -->
        <nav class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    
                    <!-- Logo & Navigation Links -->
                    <div class="flex items-center gap-8">
                        <a href="{{ route('home') }}" class="text-xl font-extrabold tracking-tight text-slate-900 flex items-center gap-2">
                            <span class="p-1.5 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            </span>
                            Smart<span class="text-emerald-600">Library</span>
                        </a>

                        <div class="hidden sm:flex items-center gap-2">
                            <!-- Home Link -->
                            <a href="{{ route('home') }}" 
                               class="px-3.5 py-2 rounded-xl text-xs font-semibold transition {{ request()->routeIs('home') ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                                Home
                            </a>

                            @auth
                                @if(Auth::user()->role === 'admin')
                                    <!-- Admin Dashboard Link (تظهر للأدمن فقط) -->
                                    <a href="{{ route('admin.dashboard') }}" 
                                       class="px-3.5 py-2 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.*') ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                                        Admin Dashboard
                                    </a>
                                @else
                                    <!-- My Books Link (تظهر للمستخدم العادي فقط) -->
                                    <a href="{{ route('borrowed.index') }}" 
                                       class="px-3.5 py-2 rounded-xl text-xs font-semibold transition {{ request()->routeIs('borrowed.index') ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                                        My Books
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>

                    <!-- Right User Menu Dropdown -->
                    <div class="hidden sm:flex sm:items-center">
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="inline-flex items-center gap-2 px-3.5 py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 bg-white hover:bg-slate-50 transition shadow-sm">
                                <span>{{ Auth::user()->name }}</span>
                                @if(Auth::user()->role === 'admin')
                                    <span class="text-[10px] bg-amber-100 text-amber-800 px-1.5 py-0.5 rounded font-bold">Admin</span>
                                @endif
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>

                            <div x-show="open" @click.outside="open = false" x-transition 
                                 class="absolute right-0 mt-2 w-48 bg-white border border-slate-200 rounded-xl shadow-xl py-1 z-50">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 font-medium">Profile</a>
                                
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-xs text-amber-600 font-bold hover:bg-slate-50">Admin Dashboard</a>
                                @endif

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-xs text-rose-600 hover:bg-slate-50 font-medium">Log Out</button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </nav>

        <!-- Main Content View Container -->
        <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="border-t border-slate-200 py-6 text-center text-xs text-slate-500 bg-white">
            &copy; {{ date('Y') }} SmartLibrary. All rights reserved.
        </footer>
    </div>

    <!-- AI Chatbot Floating Widget (Secured with Backend Proxy) -->
    <div x-data="{ 
        open: false, 
        messages: [], 
        newMessage: '', 
        loading: false,
        sendMessage() {
            if (!this.newMessage.trim() || this.loading) return;
            
            let userMsg = this.newMessage;
            this.messages.push({ sender: 'user', text: userMsg });
            this.newMessage = '';
            this.loading = true;

            fetch('{{ route('ai.chat') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message: userMsg })
            })
            .then(res => res.json())
            .then(data => {
                this.messages.push({ sender: 'ai', text: data.reply });
                this.loading = false;
            })
            .catch(() => {
                this.messages.push({ sender: 'ai', text: 'حدث خطأ أثناء الاتصال بالسيرفر.' });
                this.loading = false;
            });
        }
    }" class="fixed bottom-6 right-6 z-50">

        <!-- Toggle Button -->
        <button @click="open = !open" class="w-14 h-14 bg-emerald-600 hover:bg-emerald-500 text-white rounded-full shadow-xl flex items-center justify-center transition-all duration-300 hover:scale-105 focus:outline-none border-2 border-white">
            <svg x-show="!open" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
            </svg>
            <svg x-show="open" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <!-- Chat Popup Box -->
        <div x-show="open" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 scale-95"
             class="absolute bottom-16 right-0 w-80 sm:w-96 bg-white border border-slate-200 rounded-2xl shadow-2xl overflow-hidden flex flex-col" style="height: 480px; display: none;">
            
            <!-- Header -->
            <div class="bg-slate-900 p-4 text-white flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-emerald-500/20 border border-emerald-500/40 flex items-center justify-center text-emerald-400 font-bold text-xs">
                        AI
                    </div>
                    <div>
                        <h4 class="text-xs font-bold">Smart Library Assistant</h4>
                        <p class="text-[10px] text-emerald-400 font-medium">● Powered by Gemini AI</p>
                    </div>
                </div>
                <button @click="open = false" class="text-slate-400 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Chat Messages Area -->
            <div class="flex-1 p-4 overflow-y-auto space-y-3 bg-slate-50 text-xs">
                <div class="flex gap-2">
                    <div class="w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-[10px] shrink-0">AI</div>
                    <div class="bg-white border border-slate-200 text-slate-800 p-3 rounded-2xl rounded-tl-none shadow-sm max-w-[85%]">
                        Hello {{ Auth::user()->name }}! How can I help you find books or learning materials today?
                    </div>
                </div>

                <template x-for="(msg, index) in messages" :key="index">
                    <div :class="msg.sender === 'user' ? 'flex justify-end' : 'flex gap-2'">
                        <template x-if="msg.sender === 'ai'">
                            <div class="w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-[10px] shrink-0">AI</div>
                        </template>
                        <div :class="msg.sender === 'user' ? 'bg-emerald-600 text-white p-3 rounded-2xl rounded-tr-none shadow-sm max-w-[85%]' : 'bg-white border border-slate-200 text-slate-800 p-3 rounded-2xl rounded-tl-none shadow-sm max-w-[85%]'" x-text="msg.text"></div>
                    </div>
                </template>

                <!-- Indicator for Loading -->
                <div x-show="loading" class="flex gap-2 items-center text-slate-400 italic text-[11px]">
                    <div class="w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-[10px] shrink-0">AI</div>
                    <span>Thinking...</span>
                </div>
            </div>

            <!-- Input Box -->
            <div class="p-3 bg-white border-t border-slate-200 flex items-center gap-2">
                <input type="text" x-model="newMessage" @keydown.enter="sendMessage()" placeholder="Ask AI about books..." class="flex-1 px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500" :disabled="loading">
                <button @click="sendMessage()" class="p-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl transition shadow-sm disabled:opacity-50" :disabled="loading">
                    <svg class="w-4 h-4 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                </button>
            </div>
        </div>
    </div>
</body>
</html>