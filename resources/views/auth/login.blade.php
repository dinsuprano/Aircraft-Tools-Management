<x-guest-layout>
    <div class="mb-8">
        <h3 class="text-2xl font-bold text-white mb-2">Welcome Back</h3>
        <p class="text-slate-400 text-sm">Sign in to your account to continue.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4 text-emerald-400 bg-emerald-400/10 p-3 rounded-lg border border-emerald-400/20 text-sm" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-slate-300 mb-1.5">{{ __('Email Address') }}</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                   class="w-full px-4 py-3 bg-slate-900 border border-slate-700 rounded-xl text-slate-100 focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition-colors placeholder-slate-600"
                   placeholder="Enter your email">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-rose-400 text-sm" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center mb-1.5">
                <label for="password" class="block text-sm font-medium text-slate-300">{{ __('Password') }}</label>
                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-sky-400 hover:text-sky-300 transition-colors" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   class="w-full px-4 py-3 bg-slate-900 border border-slate-700 rounded-xl text-slate-100 focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition-colors placeholder-slate-600"
                   placeholder="Enter your password">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-rose-400 text-sm" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-700 bg-slate-900 text-sky-500 focus:ring-sky-500/50 focus:ring-offset-slate-950 transition-colors">
            <label for="remember_me" class="ml-2 text-sm text-slate-400 select-none cursor-pointer">
                {{ __('Remember me') }}
            </label>
        </div>

        <button type="submit" class="w-full py-3 px-4 bg-sky-500 hover:bg-sky-400 text-white font-semibold rounded-xl shadow-lg shadow-sky-500/20 transition-all active:scale-[0.98]">
            {{ __('Sign In') }}
        </button>

        @if (Route::has('register'))
        <div class="mt-8 text-center border-t border-slate-800 pt-6">
            <p class="text-sm text-slate-400">
                New Employee Admin? 
                <a href="{{ route('register') }}" class="font-semibold text-sky-400 hover:text-sky-300 transition-colors ml-1">
                    Apply for Access
                </a>
            </p>
        </div>
        @endif
    </form>
</x-guest-layout>
