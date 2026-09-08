<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Profile Information & AI Preferences
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            Update your account's profile information, email address, and AI recommendation preferences.
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <!-- AI Interests -->
        <div>
            <x-input-label for="interests" :value="__('Interests (for AI Recommendation)')" />
            <x-text-input id="interests" name="interests" type="text" class="mt-1 block w-full" :value="old('interests', $user->interests)" placeholder="e.g. Data Science, Machine Learning, Python" />
            <p class="mt-1 text-xs text-gray-500">Separate topics with commas so AI can match books for you.</p>
            <x-input-error class="mt-2" :messages="$errors->get('interests')" />
        </div>

        <!-- Skills -->
        <div>
            <x-input-label for="skills" :value="__('Skills')" />
            <x-text-input id="skills" name="skills" type="text" class="mt-1 block w-full" :value="old('skills', $user->skills)" placeholder="e.g. Data Analysis, SQL, Web Scraping" />
            <x-input-error class="mt-2" :messages="$errors->get('skills')" />
        </div>

        <!-- Learning Goals -->
        <div>
            <x-input-label for="learning_goals" :value="__('Learning Goals')" />
            <x-text-input id="learning_goals" name="learning_goals" type="text" class="mt-1 block w-full" :value="old('learning_goals', $user->learning_goals)" placeholder="e.g. Become Senior Data Scientist" />
            <x-input-error class="mt-2" :messages="$errors->get('learning_goals')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save Changes') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">
                    {{ __('Saved successfully.') }}
                </p>
            @endif
        </div>
    </form>
</section>