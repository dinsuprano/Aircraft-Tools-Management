@extends('layouts.app')
@section('page-title', 'Edit Tool')
@section('content')
<div class="p-6 max-w-3xl">
    <div class="flex items-start justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white">Edit Tool</h1>
            <p class="text-sm text-slate-500 mt-1">Barcode: <span class="font-mono text-sky-400">{{ $tool->barcode }}</span></p>
        </div>
        
        <a href="{{ route('tools.print', $tool) }}" target="_blank"
           class="flex items-center gap-2 px-4 py-2 bg-slate-800 hover:bg-slate-700 border border-slate-700 text-white text-sm font-semibold rounded-xl transition-colors">
            <i class="fas fa-print text-sky-400"></i>
            Print Barcode Label
        </a>
    </div>

    @if($tool->print_count > 0)
    <div class="flex items-center gap-3 px-4 py-3 mb-6 {{ $tool->print_count > 2 ? 'bg-rose-500/10 border-rose-500/20 text-rose-400' : 'bg-amber-500/10 border-amber-500/20 text-amber-400' }} border rounded-xl text-sm">
        <i class="fas {{ $tool->print_count > 2 ? 'fa-exclamation-triangle' : 'fa-info-circle' }}"></i>
        <div>
            <strong>Security Log:</strong> This barcode label has been generated and printed <strong>{{ $tool->print_count }}</strong> time(s).
        </div>
    </div>
    @else
    <div class="flex items-center gap-3 px-4 py-3 mb-6 bg-slate-800/50 border border-slate-700 rounded-xl text-slate-400 text-sm">
        <i class="fas fa-shield-alt text-emerald-500"></i>
        <div>
            <strong>Security Log:</strong> This barcode label has never been printed.
        </div>
    </div>
    @endif

    <form action="{{ route('tools.update', $tool) }}" method="POST" class="space-y-5">
        @csrf @method('PUT')
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-5">

            <div>
                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Tool Name <span class="text-rose-400">*</span></label>
                <input type="text" name="name" value="{{ old('name', $tool->name) }}" required
                       class="w-full px-4 py-3 rounded-xl bg-slate-800/50 border border-slate-700 text-slate-100 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition-colors">
                @error('name') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Description</label>
                <textarea name="description" rows="3"
                          class="w-full px-4 py-3 rounded-xl bg-slate-800/50 border border-slate-700 text-slate-100 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition-colors resize-none">{{ old('description', $tool->description) }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Location</label>
                    <input type="text" name="location" value="{{ old('location', $tool->location) }}"
                           class="w-full px-4 py-3 rounded-xl bg-slate-800/50 border border-slate-700 text-slate-100 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Price ($)</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $tool->price) }}"
                           class="w-full px-4 py-3 rounded-xl bg-slate-800/50 border border-slate-700 text-slate-100 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition-colors">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Status</label>
                <select name="status" class="w-full px-4 py-3 rounded-xl bg-slate-800/50 border border-slate-700 text-slate-100 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition-colors">
                    <option value="Available" {{ $tool->status == 'Available' ? 'selected' : '' }}>Available</option>
                    <option value="Maintenance" {{ $tool->status == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                    <option value="Active" {{ $tool->status == 'Active' ? 'selected' : '' }}>Active</option>
                </select>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="px-6 py-2.5 bg-sky-500 hover:bg-sky-400 text-white text-sm font-semibold rounded-xl transition-colors shadow-lg shadow-sky-500/20">
                Update Tool
            </button>
            <a href="{{ route('tools.index') }}" class="px-6 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-300 text-sm font-medium rounded-xl transition-colors">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
