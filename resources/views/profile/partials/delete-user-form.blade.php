<div x-data="{ open: false }">
    <p class="text-sm text-slate-400 mb-4">Once your account is deleted, all data will be permanently removed. This cannot be undone.</p>
    <button @click="open = true" class="px-5 py-2.5 bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 border border-rose-500/30 text-sm font-semibold rounded-xl transition-colors">
        Delete Account
    </button>

    <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" @click.self="open = false">
        <div class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>
        <div class="relative bg-slate-900 border border-slate-700 rounded-2xl p-6 max-w-md w-full shadow-2xl">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-rose-500/15 flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-rose-400"></i>
                </div>
                <h3 class="font-semibold text-white">Delete Account?</h3>
            </div>
            <p class="text-slate-400 text-sm mb-5">This action is permanent and cannot be undone. Enter your password to confirm.</p>
            <form method="post" action="{{ route('profile.destroy') }}" class="space-y-4">
                @csrf @method('delete')
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Password</label>
                    <input type="password" name="password" placeholder="Your current password"
                           class="w-full px-4 py-3 rounded-xl bg-slate-800 border border-slate-700 text-slate-100 text-sm focus:outline-none focus:ring-2 focus:ring-rose-500/50 focus:border-rose-500 transition-colors">
                    @error('password', 'userDeletion') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" @click="open = false" class="px-4 py-2 rounded-xl bg-slate-800 text-slate-300 hover:bg-slate-700 text-sm font-medium transition-colors">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-rose-500 hover:bg-rose-400 text-white text-sm font-medium transition-colors">Yes, Delete Account</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($errors->userDeletion->isNotEmpty())
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelector('[x-data]').__x.$data.open = true;
    });
</script>
@endif
