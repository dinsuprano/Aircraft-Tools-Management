<form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>

<form method="post" action="{{ route('profile.update') }}" class="space-y-4">
    @csrf @method('patch')
    <div>
        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Name</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
               class="w-full px-4 py-3 rounded-xl bg-slate-800/50 border border-slate-700 text-slate-100 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition-colors">
        @error('name') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
               class="w-full px-4 py-3 rounded-xl bg-slate-800/50 border border-slate-700 text-slate-100 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition-colors">
        @error('email') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <p class="text-xs text-amber-400 mt-2">Your email is unverified.
                <button form="send-verification" class="underline hover:text-amber-300">Resend verification.</button>
            </p>
            @if (session('status') === 'verification-link-sent')
                <p class="text-xs text-emerald-400 mt-1">Verification link sent!</p>
            @endif
        @endif
    </div>
    <div class="flex items-center gap-3 pt-2">
        <button type="submit" class="px-5 py-2.5 bg-sky-500 hover:bg-sky-400 text-white text-sm font-semibold rounded-xl transition-colors">Save Changes</button>
        @if (session('status') === 'profile-updated')
            <span class="text-emerald-400 text-sm flex items-center gap-1"><i class="fas fa-check-circle text-xs"></i> Saved!</span>
        @endif
    </div>
</form>
