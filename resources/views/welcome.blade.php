<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartLibrary</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col justify-between font-sans antialiased text-slate-800 relative bg-slate-900">

    <!-- Cozy Warm Library Background Image -->
    <div class="fixed inset-0 z-0 bg-cover bg-center transition-all duration-700 opacity-40 scale-105" 
         style="background-image: url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=2010&auto=format&fit=crop');">
    </div>

    <!-- Smooth Soft Gradient Overlay -->
    <div class="fixed inset-0 z-0 bg-gradient-to-b from-slate-950/80 via-slate-900/60 to-slate-950/90"></div>

    <!-- Top Navigation Bar -->
    <header class="relative z-10 max-w-7xl mx-auto w-full px-6 py-8 flex justify-between items-center">
        <!-- Minimal Elegant Logo -->
        <a href="{{ route('welcome') }}" class="flex items-center gap-2.5 group">
            <span class="text-2xl font-black tracking-tight text-white group-hover:text-emerald-400 transition duration-300">
                Smart<span class="text-emerald-400">Library</span>
            </span>
        </a>

        <!-- Auth Navigation Buttons with Soft Glow & Lift Animations -->
        <nav class="flex items-center gap-3 sm:gap-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('home') }}" 
                       class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white font-medium text-xs rounded-full transition-all duration-300 ease-out hover:-translate-y-0.5 hover:shadow-lg hover:shadow-emerald-500/30 active:translate-y-0">
                        Enter Dashboard &rarr;
                    </a>
                @else
                    <!-- Log in Button with Subtle Glass Border -->
                    <a href="{{ route('login') }}" 
                       class="text-xs font-medium text-slate-300 hover:text-white px-5 py-2.5 rounded-full border border-transparent hover:border-slate-700/80 hover:bg-white/5 transition-all duration-300 ease-out hover:-translate-y-0.5 active:translate-y-0 tracking-wide">
                        Log in
                    </a>

                    <!-- Register Button with Emerald Glow -->
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" 
                           class="px-6 py-2.5 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-semibold text-xs rounded-full transition-all duration-300 ease-out hover:-translate-y-0.5 hover:shadow-xl hover:shadow-emerald-500/40 active:translate-y-0">
                            Register
                        </a>
                    @endif
                @endauth
            @endif
        </nav>
    </header>

    <!-- Main Hero Content -->
    <main class="relative z-10 max-w-4xl mx-auto px-6 text-center my-auto py-12">
        <span class="px-4 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-300 text-[11px] font-medium tracking-widest uppercase mb-6 inline-block backdrop-blur-sm">
            Knowledge Management System
        </span>
        
        <h1 class="text-4xl sm:text-6xl font-extrabold text-white tracking-tight leading-tight mb-6 drop-shadow-sm">
            Your Gateway to <br>
            <span class="text-emerald-400">Smarter Reading</span> & Discovery
        </h1>

        <p class="text-base sm:text-lg text-slate-300 max-w-xl mx-auto leading-relaxed font-light mb-8">
            Explore a curated collection of books, manage borrowing history, and track availability seamlessly in one refined workspace.
        </p>

        @auth
            <div>
                <a href="{{ route('home') }}" class="px-8 py-3.5 bg-emerald-600 hover:bg-emerald-500 text-white font-medium text-xs rounded-full transition-all duration-300 ease-out hover:-translate-y-0.5 hover:shadow-xl hover:shadow-emerald-600/30 inline-block">
                    Browse Books Catalog
                </a>
            </div>
        @endauth
    </main>

    <!-- Simple Modern Footer -->
    <footer class="relative z-10 text-center py-6 text-slate-400 text-xs font-light">
        &copy; {{ date('Y') }} SmartLibrary. Designed for seamless reading experiences.
    </footer>

</body>
</html>