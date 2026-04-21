@extends('layouts.app')
@section('page-title', 'Report Maintenance')
@section('content')
<div class="p-6 max-w-2xl">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-white">Report Tool for Maintenance</h1>
        <p class="text-sm text-slate-500 mt-1">Document a damaged or faulty tool</p>
    </div>

    @if($errors->has('barcode'))
    <div class="flex items-center gap-3 px-4 py-3 mb-5 bg-rose-500/10 border border-rose-500/20 rounded-xl text-rose-400 text-sm">
        <i class="fas fa-exclamation-circle"></i>
        {{ $errors->first('barcode') }}
    </div>
    @endif

    <form action="{{ route('maintenance.store') }}" method="POST" class="space-y-5">
        @csrf
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-5">
            <div>
                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Select Tool <span class="text-rose-400">*</span></label>
                <select name="barcode" required class="w-full px-4 py-3 rounded-xl bg-slate-800/50 border border-slate-700 text-slate-100 text-sm focus:outline-none focus:ring-2 focus:ring-rose-500/50 focus:border-rose-500 transition-colors">
                    <option value="">— Choose a Tool —</option>
                    @foreach($tools as $tool)
                    <option value="{{ $tool->barcode }}" {{ old('barcode') == $tool->barcode ? 'selected' : '' }}>
                        {{ $tool->name }} ({{ $tool->barcode }})
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Problem Description <span class="text-rose-400">*</span></label>
                <textarea name="problem" rows="4" required placeholder="Describe the damage or fault..."
                          class="w-full px-4 py-3 rounded-xl bg-slate-800/50 border border-slate-700 text-slate-100 text-sm placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-rose-500/50 focus:border-rose-500 transition-colors resize-none">{{ old('problem') }}</textarea>
                @error('problem') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Date Reported <span class="text-rose-400">*</span></label>
                <input type="date" name="date_report" required value="{{ old('date_report', \Carbon\Carbon::now()->format('Y-m-d')) }}"
                       class="w-full px-4 py-3 rounded-xl bg-slate-800/50 border border-slate-700 text-slate-100 text-sm focus:outline-none focus:ring-2 focus:ring-rose-500/50 focus:border-rose-500 transition-colors">
                @error('date_report') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
        <div class="flex items-center gap-3">
            <button type="submit" class="px-6 py-2.5 bg-rose-500 hover:bg-rose-400 text-white text-sm font-semibold rounded-xl transition-colors">Submit Report</button>
            <a href="{{ route('maintenance.index') }}" class="px-6 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-300 text-sm font-medium rounded-xl transition-colors">Cancel</a>
        </div>
    </form>
</div>
@endsection
