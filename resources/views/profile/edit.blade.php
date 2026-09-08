<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-6">

        <!-- Header -->
        <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm">
            <h2 class="text-xl font-bold text-slate-900 tracking-tight">
                Profile & <span class="text-emerald-600">AI Preferences</span>
            </h2>
            <p class="text-slate-500 text-xs mt-1">
                Manage your account details, security settings, and update your profile for personalized AI recommendations.
            </p>
        </div>

        <!-- 1. Full AI Personalization Profile (Matching PDF Specs) -->
        <div class="bg-white border border-slate-200 p-6 sm:p-8 rounded-2xl shadow-sm">
            <div class="flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold w-fit mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                AI Personalization Profile
            </div>
            
            <h3 class="text-base font-bold text-slate-900 mb-1">Career Interests & AI Recommendation Preferences</h3>
            <p class="text-xs text-slate-500 mb-6">Update your parameters so our AI algorithm can accurately match and score books for you.</p>

            <form method="post" action="{{ route('profile.update') }}" class="space-y-4">
                @csrf
                @method('patch')

                {{-- حقول مخفية: الفورم ده معندوش Name/Email، لكن الـ validation
                     بتطلبهم إجباري، فبنبعتهم مخفيين بالقيمة الحالية عشان الحفظ ينجح --}}
                <input type="hidden" name="name" value="{{ $user->name }}">
                <input type="hidden" name="email" value="{{ $user->email }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- General Interests -->
                    <div>
                        <label for="interests" class="block text-xs font-semibold text-slate-700 mb-1.5">Interests</label>
                        <input id="interests" name="interests" type="text" 
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs placeholder-slate-400 focus:ring-2 focus:ring-emerald-500 outline-none transition" 
                               value="{{ old('interests', $user->interests) }}" 
                               placeholder="e.g. Technology, Science, Business">
                        <x-input-error class="mt-1 text-xs text-rose-500" :messages="$errors->get('interests')" />
                    </div>

                    <!-- Favorite Topics -->
                    <div>
                        <label for="favorite_topics" class="block text-xs font-semibold text-slate-700 mb-1.5">Favorite Topics</label>
                        <input id="favorite_topics" name="favorite_topics" type="text" 
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs placeholder-slate-400 focus:ring-2 focus:ring-emerald-500 outline-none transition" 
                               value="{{ old('favorite_topics', $user->favorite_topics ?? '') }}" 
                               placeholder="e.g. Neural Networks, Web Security, System Architecture">
                        <x-input-error class="mt-1 text-xs text-rose-500" :messages="$errors->get('favorite_topics')" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Preferred Book Categories -->
                    <div>
                        <label for="preferred_book_categories" class="block text-xs font-semibold text-slate-700 mb-1.5">Preferred Book Categories</label>
                        <input id="preferred_book_categories" name="preferred_book_categories" type="text" 
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs placeholder-slate-400 focus:ring-2 focus:ring-emerald-500 outline-none transition" 
                               value="{{ old('preferred_book_categories', $user->preferred_book_categories ?? '') }}" 
                               placeholder="e.g. Computer Science, AI, Software Engineering">
                        <x-input-error class="mt-1 text-xs text-rose-500" :messages="$errors->get('preferred_book_categories')" />
                    </div>

                    <!-- Current Technical Skills -->
                    <div>
                        <label for="skills" class="block text-xs font-semibold text-slate-700 mb-1.5">Skills</label>
                        <input id="skills" name="skills" type="text" 
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs placeholder-slate-400 focus:ring-2 focus:ring-emerald-500 outline-none transition" 
                               value="{{ old('skills', $user->skills) }}" 
                               placeholder="e.g. Python, PHP, SQL, Laravel, Data Structures">
                        <x-input-error class="mt-1 text-xs text-rose-500" :messages="$errors->get('skills')" />
                    </div>
                </div>

                <!-- Educational or Professional Interests -->
                <div>
                    <label for="educational_interests" class="block text-xs font-semibold text-slate-700 mb-1.5">Educational or Professional Interests</label>
                    <input id="educational_interests" name="educational_interests" type="text" 
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs placeholder-slate-400 focus:ring-2 focus:ring-emerald-500 outline-none transition" 
                           value="{{ old('educational_interests', $user->educational_interests ?? '') }}" 
                           placeholder="e.g. Machine Learning Engineering, Backend Development">
                    <x-input-error class="mt-1 text-xs text-rose-500" :messages="$errors->get('educational_interests')" />
                </div>

                <!-- Learning Goals -->
                <div>
                    <label for="learning_goals" class="block text-xs font-semibold text-slate-700 mb-1.5">Learning Goals</label>
                    <textarea id="learning_goals" name="learning_goals" rows="3" 
                              class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs placeholder-slate-400 focus:ring-2 focus:ring-emerald-500 outline-none transition" 
                              placeholder="e.g. Master full-stack Laravel web application development and AI integration">{{ old('learning_goals', $user->learning_goals) }}</textarea>
                    <x-input-error class="mt-1 text-xs text-rose-500" :messages="$errors->get('learning_goals')" />
                </div>

                <div class="pt-2 flex items-center gap-4">
                    <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs rounded-xl transition shadow-md shadow-emerald-600/20">
                        Save Learning Preferences
                    </button>

                    @if (session('status') === 'profile-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2500)" class="text-xs text-emerald-600 font-semibold">
                            Saved successfully.
                        </p>
                    @endif
                </div>
            </form>
        </div>

        <!-- 2. Basic Account Information -->
        <div class="bg-white border border-slate-200 p-6 sm:p-8 rounded-2xl shadow-sm">
            <h3 class="text-base font-bold text-slate-900 mb-1">Account Information</h3>
            <p class="text-xs text-slate-500 mb-6">Update your account's profile information and email address.</p>

            <form method="post" action="{{ route('profile.update') }}" class="space-y-4">
                @csrf
                @method('patch')

                <div>
                    <label for="name" class="block text-xs font-semibold text-slate-700 mb-1.5">Full Name</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs outline-none focus:ring-2 focus:ring-emerald-500">
                    <x-input-error class="mt-1 text-xs text-rose-500" :messages="$errors->get('name')" />
                </div>

                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-700 mb-1.5">Email Address</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs outline-none focus:ring-2 focus:ring-emerald-500">
                    <x-input-error class="mt-1 text-xs text-rose-500" :messages="$errors->get('email')" />
                </div>

                <div class="pt-2">
                    <button type="submit" class="px-6 py-2.5 bg-slate-800 hover:bg-slate-700 text-white font-semibold text-xs rounded-xl transition shadow-sm">
                        Update Account Details
                    </button>
                </div>
            </form>
        </div>

        <!-- 3. Security Settings (Password) -->
        <div class="bg-white border border-slate-200 p-6 sm:p-8 rounded-2xl shadow-sm">
            <h3 class="text-base font-bold text-slate-900 mb-1">Update Password</h3>
            <p class="text-xs text-slate-500 mb-6">Ensure your account is using a long, random password to stay secure.</p>

            <form method="post" action="{{ route('password.update') }}" class="space-y-4">
                @csrf
                @method('put')

                <div>
                    <label for="update_password_current_password" class="block text-xs font-semibold text-slate-700 mb-1.5">Current Password</label>
                    <input id="update_password_current_password" name="current_password" type="password" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs outline-none focus:ring-2 focus:ring-emerald-500">
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1 text-xs text-rose-500" />
                </div>

                <div>
                    <label for="update_password_password" class="block text-xs font-semibold text-slate-700 mb-1.5">New Password</label>
                    <input id="update_password_password" name="password" type="password" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs outline-none focus:ring-2 focus:ring-emerald-500">
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1 text-xs text-rose-500" />
                </div>

                <div>
                    <label for="update_password_password_confirmation" class="block text-xs font-semibold text-slate-700 mb-1.5">Confirm Password</label>
                    <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs outline-none focus:ring-2 focus:ring-emerald-500">
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1 text-xs text-rose-500" />
                </div>

                <div class="pt-2 flex items-center gap-4">
                    <button type="submit" class="px-6 py-2.5 bg-slate-800 hover:bg-slate-700 text-white font-semibold text-xs rounded-xl transition shadow-sm">
                        Save New Password
                    </button>
                </div>
            </form>
        </div>

        <!-- 4. Danger Zone (Delete Account) -->
        <div class="bg-white border border-rose-200 p-6 sm:p-8 rounded-2xl shadow-sm">
            <h3 class="text-base font-bold text-rose-600 mb-1">Delete Account</h3>
            <p class="text-xs text-slate-500 mb-4">Once your account is deleted, all of its resources and data will be permanently deleted.</p>

            <x-danger-button
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                class="px-4 py-2 bg-rose-600 hover:bg-rose-500 text-white font-bold text-xs rounded-xl transition"
            >
                Delete Account
            </x-danger-button>

            <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                    @csrf
                    @method('delete')

                    <h2 class="text-base font-bold text-slate-900">
                        Are you sure you want to delete your account?
                    </h2>

                    <p class="mt-1 text-xs text-slate-500">
                        Please enter your password to confirm you would like to permanently delete your account.
                    </p>

                    <div class="mt-4">
                        <input id="password" name="password" type="password" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs outline-none focus:ring-2 focus:ring-rose-500" placeholder="Password">
                        <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-1 text-xs text-rose-500" />
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <x-secondary-button x-on:click="$dispatch('close')" class="px-4 py-2 text-xs">
                            Cancel
                        </x-secondary-button>

                        <x-danger-button class="px-4 py-2 bg-rose-600 hover:bg-rose-500 text-white text-xs">
                            Delete Account
                        </x-danger-button>
                    </div>
                </form>
            </x-modal>
        </div>

    </div>
</x-app-layout>