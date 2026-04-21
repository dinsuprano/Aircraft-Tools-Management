<form method="post" action="{{ route('password.update') }}" class="space-y-4">
    @csrf @method('put')
    <div>
        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Current Password</label>
        <input type="password" name="current_password" autocomplete="current-password"
               class="w-full px-4 py-3 rounded-xl bg-slate-800/50 border border-slate-700 text-slate-100 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-colors">
        @error('current_password', 'updatePassword') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">New Password</label>
        <input type="password" name="password" autocomplete="new-password"
               class="w-full px-4 py-3 rounded-xl bg-slate-800/50 border border-slate-700 text-slate-100 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-colors">
        @error('password', 'updatePassword') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Confirm New Password</label>
        <input type="password" name="password_confirmation" autocomplete="new-password"
               class="w-full px-4 py-3 rounded-xl bg-slate-800/50 border border-slate-700 text-slate-100 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-colors">
        @error('password_confirmation', 'updatePassword') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
    <div class="flex items-center gap-3 pt-2">
        <button type="submit" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-400 text-white text-sm font-semibold rounded-xl transition-colors">Update Password</button>
        @if (session('status') === 'password-updated')
            <span class="text-emerald-400 text-sm flex items-center gap-1"><i class="fas fa-check-circle text-xs"></i> Updated!</span>
        @endif
    </div>
</form>
