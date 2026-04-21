@extends('layouts.app')
@section('page-title', 'Check In Tool')
@section('content')
<div class="p-6 max-w-2xl">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-white">Check In Tool</h1>
        <p class="text-sm text-slate-500 mt-1">Confirm the return of a borrowed tool</p>
    </div>

    <form action="{{ route('borrows.update', $borrow) }}" method="POST" class="space-y-5">
        @csrf @method('PUT')
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-5">

            {{-- Read-only summary --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Tool</label>
                    <div class="px-4 py-3 rounded-xl bg-slate-800/30 border border-slate-700/50 text-slate-300 text-sm">
                        {{ $borrow->tool->name ?? $borrow->barcode }}
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Employee</label>
                    <div class="px-4 py-3 rounded-xl bg-slate-800/30 border border-slate-700/50 text-slate-300 text-sm">
                        {{ $borrow->employee->name ?? 'Unknown' }}
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Checked Out On</label>
                <div class="px-4 py-3 rounded-xl bg-slate-800/30 border border-slate-700/50 text-slate-300 text-sm">
                    {{ \Carbon\Carbon::parse($borrow->check_out_date)->format('d M Y, H:i') }}
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Date Returned <span class="text-rose-400">*</span></label>
                <input type="datetime-local" name="actual_date_returned" required
                       value="{{ old('actual_date_returned', \Carbon\Carbon::now()->format('Y-m-d\TH:i')) }}"
                       class="w-full px-4 py-3 rounded-xl bg-slate-800/50 border border-slate-700 text-slate-100 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-colors">
                @error('actual_date_returned') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <input type="hidden" name="status" value="Returned">
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="px-6 py-2.5 bg-emerald-500 hover:bg-emerald-400 text-white text-sm font-semibold rounded-xl transition-colors shadow-lg shadow-emerald-500/20">
                Confirm Return
            </button>
            <a href="{{ route('borrows.index') }}" class="px-6 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-300 text-sm font-medium rounded-xl transition-colors">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
