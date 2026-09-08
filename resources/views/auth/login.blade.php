<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center px-4 sm:px-6 relative bg-slate-900 font-sans antialiased">
        
        <!-- Background Image with Dark Soft Overlay -->
        <div class="fixed inset-0 z-0 bg-cover bg-center opacity-30 scale-105" 
             style="background-image: url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=2010&auto=format&fit=crop');">
        </div>
        <div class="fixed inset-0 z-0 bg-gradient-to-b from-slate-950/80 via-slate-900/70 to-slate-950/90"></div>

        <div class="relative z-10 w-full max-w-md">
            <!-- Brand Logo -->
            <div class="text-center mb-8">
                <a href="{{ route('welcome') }}" class="inline-block text-3xl font-black text-white tracking-tight">
                    Smart<span class="text-emerald-400">Library</span>
                </a>
                <p class="text-slate-400 text-xs mt-2 font-light">Welcome back! Please enter your details.</p>
            </div>

            <!-- Card Box -->
            <div class="bg-slate-900/80 backdrop-blur-md border border-slate-700/50 p-8 rounded-2xl shadow-2xl">
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-xs font-medium text-slate-300 mb-1.5">Email Address</label>
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                               class="w-full px-4 py-2.5 bg-slate-800/80 border border-slate-700 rounded-lg text-white text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition placeholder-slate-500"
                               placeholder="name@example.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs text-rose-400" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-xs font-medium text-slate-300 mb-1.5">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                               class="w-full px-4 py-2.5 bg-slate-800/80 border border-slate-700 rounded-lg text-white text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition placeholder-slate-500"
                               placeholder="••••••••">
                        <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs text-rose-400" />
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between text-xs">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer">
                            <input id="remember_me" type="checkbox" name="remember" class="rounded border-slate-700 bg-slate-800 text-emerald-500 shadow-sm focus:ring-emerald-500">
                            <span class="ms-2 text-slate-400">Remember me</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a class="text-emerald-400 hover:text-emerald-300 transition font-medium" href="{{ route('password.request') }}">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full py-3 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold text-xs rounded-lg transition shadow-lg shadow-emerald-600/20">
                        Sign In
                    </button>
                </form>

                <div class="mt-6 text-center text-xs text-slate-400">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="text-emerald-400 hover:text-emerald-300 font-semibold transition">Register here</a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>