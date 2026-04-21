@extends('layouts.app')
@section('page-title', 'Resolve Maintenance')
@section('content')
<div class="p-6 max-w-2xl">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-white">Resolve Maintenance</h1>
        <p class="text-sm text-slate-500 mt-1">Log the solution and release the tool back to inventory</p>
    </div>

    <form action="{{ route('maintenance.update', $maintenance) }}" method="POST" class="space-y-5">
        @csrf @method('PUT')
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Tool</label>
                    <div class="px-4 py-3 rounded-xl bg-slate-800/30 border border-slate-700/50 text-slate-300 text-sm">{{ $maintenance->tool->name ?? $maintenance->barcode }}</div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Date Reported</label>
                    <div class="px-4 py-3 rounded-xl bg-slate-800/30 border border-slate-700/50 text-slate-300 text-sm">{{ \Carbon\Carbon::parse($maintenance->date_report)->format('d M Y') }}</div>
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Reported Problem</label>
                <div class="px-4 py-3 rounded-xl bg-slate-800/30 border border-slate-700/50 text-slate-300 text-sm">{{ $maintenance->problem }}</div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Solution / Repair Actions <span class="text-rose-400">*</span></label>
                <textarea name="solution" rows="4" required placeholder="Describe what was repaired..."
                          class="w-full px-4 py-3 rounded-xl bg-slate-800/50 border border-slate-700 text-slate-100 text-sm placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-colors resize-none">{{ old('solution') }}</textarea>
                @error('solution') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Date Released <span class="text-rose-400">*</span></label>
                <input type="date" name="date_released" required value="{{ old('date_released', \Carbon\Carbon::now()->format('Y-m-d')) }}"
                       class="w-full px-4 py-3 rounded-xl bg-slate-800/50 border border-slate-700 text-slate-100 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-colors">
                @error('date_released') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
        <div class="flex items-center gap-3">
            <button type="submit" class="px-6 py-2.5 bg-emerald-500 hover:bg-emerald-400 text-white text-sm font-semibold rounded-xl transition-colors">Confirm Release</button>
            <a href="{{ route('maintenance.index') }}" class="px-6 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-300 text-sm font-medium rounded-xl transition-colors">Cancel</a>
        </div>
    </form>
</div>
@endsection
