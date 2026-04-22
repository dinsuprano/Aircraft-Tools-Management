<x-guest-layout>
    <div class="mb-8">
        <h3 class="text-2xl font-bold text-white mb-2">Apply for Access</h3>
        <p class="text-slate-400 text-sm">Create an Employee Admin account to manage tools and staff. Your account will require approval from a System Admin.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-slate-300 mb-1.5">{{ __('Full Name') }}</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                   class="w-full px-4 py-3 bg-slate-900 border border-slate-700 rounded-xl text-slate-100 focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition-colors placeholder-slate-600"
                   placeholder="e.g. John Doe">
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-rose-400 text-sm" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-slate-300 mb-1.5">{{ __('Email Address') }}</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                   class="w-full px-4 py-3 bg-slate-900 border border-slate-700 rounded-xl text-slate-100 focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition-colors placeholder-slate-600"
                   placeholder="Enter your email">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-rose-400 text-sm" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-slate-300 mb-1.5">{{ __('Password') }}</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   class="w-full px-4 py-3 bg-slate-900 border border-slate-700 rounded-xl text-slate-100 focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition-colors placeholder-slate-600"
                   placeholder="Create a password">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-rose-400 text-sm" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-slate-300 mb-1.5">{{ __('Confirm Password') }}</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                   class="w-full px-4 py-3 bg-slate-900 border border-slate-700 rounded-xl text-slate-100 focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition-colors placeholder-slate-600"
                   placeholder="Confirm your password">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-rose-400 text-sm" />
        </div>

        <button type="submit" class="w-full py-3 px-4 bg-sky-500 hover:bg-sky-400 text-white font-semibold rounded-xl shadow-lg shadow-sky-500/20 transition-all active:scale-[0.98] mt-2">
            {{ __('Submit Application') }}
        </button>

        <div class="mt-8 text-center border-t border-slate-800 pt-6">
            <p class="text-sm text-slate-400">
                Already registered? 
                <a href="{{ route('login') }}" class="font-semibold text-sky-400 hover:text-sky-300 transition-colors ml-1">
                    Sign in here
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
