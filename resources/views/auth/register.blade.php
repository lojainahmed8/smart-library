<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center px-4 sm:px-6 py-12 relative bg-slate-900 font-sans antialiased">
        
        <!-- Background Image with Dark Soft Overlay -->
        <div class="fixed inset-0 z-0 bg-cover bg-center opacity-30 scale-105" 
             style="background-image: url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=2010&auto=format&fit=crop');">
        </div>
        <div class="fixed inset-0 z-0 bg-gradient-to-b from-slate-950/80 via-slate-900/70 to-slate-950/90"></div>

        <div class="relative z-10 w-full max-w-lg">
            <!-- Brand Logo -->
            <div class="text-center mb-6">
                <a href="{{ route('welcome') }}" class="inline-block text-3xl font-black text-white tracking-tight">
                    Smart<span class="text-emerald-400">Library</span>
                </a>
                <p class="text-slate-400 text-xs mt-1.5 font-light">Create your account & personalize your learning profile.</p>
            </div>

            <!-- Card Box -->
            <div class="bg-slate-900/85 backdrop-blur-md border border-slate-700/50 p-8 rounded-2xl shadow-2xl">
                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-xs font-medium text-slate-300 mb-1">Full Name</label>
                        <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                               class="w-full px-4 py-2 bg-slate-800/80 border border-slate-700 rounded-lg text-white text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition placeholder-slate-500"
                               placeholder="e.g. Lojain Ahmed">
                        <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs text-rose-400" />
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-xs font-medium text-slate-300 mb-1">Email Address</label>
                        <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                               class="w-full px-4 py-2 bg-slate-800/80 border border-slate-700 rounded-lg text-white text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition placeholder-slate-500"
                               placeholder="name@example.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-rose-400" />
                    </div>

                    <!-- Grid Passwords -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-xs font-medium text-slate-300 mb-1">Password</label>
                            <input id="password" type="password" name="password" required autocomplete="new-password"
                                   class="w-full px-4 py-2 bg-slate-800/80 border border-slate-700 rounded-lg text-white text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition placeholder-slate-500"
                                   placeholder="••••••••">
                            <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-rose-400" />
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-xs font-medium text-slate-300 mb-1">Confirm Password</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                                   class="w-full px-4 py-2 bg-slate-800/80 border border-slate-700 rounded-lg text-white text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition placeholder-slate-500"
                                   placeholder="••••••••">
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs text-rose-400" />
                        </div>
                    </div>

                    <div class="border-t border-slate-800 pt-3 my-2"></div>

                    <!-- Custom Profile Fields -->
                    <!-- Interests -->
                    <div>
                        <label for="interests" class="block text-xs font-medium text-slate-300 mb-1">Interests</label>
                        <input id="interests" type="text" name="interests" :value="old('interests')"
                               class="w-full px-4 py-2 bg-slate-800/80 border border-slate-700 rounded-lg text-white text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition placeholder-slate-500"
                               placeholder="e.g. AI, Web Development, Machine Learning">
                        <x-input-error :messages="$errors->get('interests')" class="mt-1 text-xs text-rose-400" />
                    </div>

                    <!-- Skills -->
                    <div>
                        <label for="skills" class="block text-xs font-medium text-slate-300 mb-1">Skills</label>
                        <input id="skills" type="text" name="skills" :value="old('skills')"
                               class="w-full px-4 py-2 bg-slate-800/80 border border-slate-700 rounded-lg text-white text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition placeholder-slate-500"
                               placeholder="e.g. Python, PHP, SQL, Laravel">
                        <x-input-error :messages="$errors->get('skills')" class="mt-1 text-xs text-rose-400" />
                    </div>

                    <!-- Learning Goals -->
                    <div>
                        <label for="learning_goals" class="block text-xs font-medium text-slate-300 mb-1">Learning Goals</label>
                        <input id="learning_goals" type="text" name="learning_goals" :value="old('learning_goals')"
                               class="w-full px-4 py-2 bg-slate-800/80 border border-slate-700 rounded-lg text-white text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition placeholder-slate-500"
                               placeholder="e.g. Master Backend Development">
                        <x-input-error :messages="$errors->get('learning_goals')" class="mt-1 text-xs text-rose-400" />
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full py-3 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold text-xs rounded-lg transition shadow-lg shadow-emerald-600/20 mt-4">
                        Register Account
                    </button>
                </form>

                <div class="mt-5 text-center text-xs text-slate-400">
                    Already registered? 
                    <a href="{{ route('login') }}" class="text-emerald-400 hover:text-emerald-300 font-semibold transition">Log in here</a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>