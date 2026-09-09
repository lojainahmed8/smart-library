<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard - Smart Library</title>
    
    <!-- AlpineJS & Vite -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 antialiased font-sans">
    <div class="min-h-screen flex">

        <!-- Sidebar الجانبي الموحد للأدمن -->
        <aside class="w-64 bg-slate-900 text-slate-300 flex flex-col justify-between p-4 fixed h-full z-40">
            <div class="space-y-6">
                <!-- Logo -->
                <div class="flex items-center gap-3 px-3 py-2 border-b border-slate-800 pb-4">
                    <span class="p-1.5 bg-emerald-500 text-white rounded-lg shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </span>
                    <span class="font-extrabold text-white text-base tracking-wide">Smart<span class="text-emerald-400">Admin</span></span>
                </div>

                <!-- Nav Links -->
                <nav class="space-y-1.5 font-medium text-xs">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-600 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 00-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('admin.books.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.books.*') ? 'bg-emerald-600 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        <span>Books Management</span>
                    </a>

                    <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.categories.*') ? 'bg-emerald-600 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 11h.01M7 15h.01M11 7h8M11 11h8M11 15h8"/></svg>
                        <span>Categories</span>
                    </a>

                    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.users.*') ? 'bg-emerald-600 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <span>Users Management</span>
                    </a>
                </nav>
            </div>

            <!-- Profile & Logout Footer -->
            <div class="pt-4 border-t border-slate-800 flex items-center justify-between px-2">
                <div>
                    <p class="text-xs font-bold text-white">{{ Auth::user()->name }}</p>
                    <span class="text-[10px] text-emerald-400 font-bold">System Admin</span>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-xs text-rose-400 hover:text-rose-300 font-bold">Logout</button>
                </form>
            </div>
        </aside>

        <!-- Main Dashboard Body -->
        <main class="flex-1 ml-64 p-8">
            {{ $slot }}
        </main>
    </div>

    <!-- AI Chatbot Floating Widget for Admin -->
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

        <button @click="open = !open" class="w-14 h-14 bg-emerald-600 hover:bg-emerald-500 text-white rounded-full shadow-xl flex items-center justify-center transition-all duration-300 hover:scale-105 focus:outline-none border-2 border-white">
            <svg x-show="!open" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
            </svg>
            <svg x-show="open" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <div x-show="open" 
             x-transition
             class="absolute bottom-16 right-0 w-80 sm:w-96 bg-white border border-slate-200 rounded-2xl shadow-2xl overflow-hidden flex flex-col" style="height: 480px; display: none;">
            
            <div class="bg-slate-900 p-4 text-white flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-emerald-500/20 border border-emerald-500/40 flex items-center justify-center text-emerald-400 font-bold text-xs">
                        AI
                    </div>
                    <div>
                        <h4 class="text-xs font-bold">Admin AI Assistant</h4>
                        <p class="text-[10px] text-emerald-400 font-medium">● Role Aware Assistant</p>
                    </div>
                </div>
                <button @click="open = false" class="text-slate-400 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="flex-1 p-4 overflow-y-auto space-y-3 bg-slate-50 text-xs">
                <div class="flex gap-2">
                    <div class="w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-[10px] shrink-0">AI</div>
                    <div class="bg-white border border-slate-200 text-slate-800 p-3 rounded-2xl rounded-tl-none shadow-sm max-w-[85%]">
                        Hello Admin {{ Auth::user()->name }}! Ask me anything about library stats, users, or books.
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

                <div x-show="loading" class="flex gap-2 items-center text-slate-400 italic text-[11px]">
                    <div class="w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-[10px] shrink-0">AI</div>
                    <span>Processing Admin query...</span>
                </div>
            </div>

            <div class="p-3 bg-white border-t border-slate-200 flex items-center gap-2">
                <input type="text" x-model="newMessage" @keydown.enter="sendMessage()" placeholder="Ask Admin AI..." class="flex-1 px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500" :disabled="loading">
                <button @click="sendMessage()" class="p-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl transition shadow-sm disabled:opacity-50" :disabled="loading">
                    <svg class="w-4 h-4 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                </button>
            </div>
        </div>
    </div>
</body>
</html>