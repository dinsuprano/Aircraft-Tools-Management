@extends('layouts.app')
@section('page-title', 'Tools Maintenance')
@section('content')
<div class="p-6 space-y-5">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Tools Maintenance</h1>
            <p class="text-sm text-slate-500 mt-1">Track and resolve tool damage reports</p>
        </div>
        <a href="{{ route('maintenance.create') }}"
           class="flex items-center gap-2 px-4 py-2 bg-rose-500 hover:bg-rose-400 text-white text-sm font-semibold rounded-xl transition-colors shadow-lg shadow-rose-500/20">
            <i class="fas fa-plus text-xs"></i>
            Report Issue
        </a>
    </div>

    @if(session('success'))
    <div class="flex items-center gap-3 px-4 py-3 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400 text-sm">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
    @endif

    <div class="space-y-4">
        {{-- Search Bar --}}
        <form action="{{ route('maintenance.index') }}" method="GET" class="relative max-w-md">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-slate-500"></i>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by tool, barcode, problem, or status..."
                   class="w-full pl-10 pr-4 py-2 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition-colors placeholder-slate-600">
        </form>

        <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-800 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            <th class="px-5 py-4 text-left">Tool</th>
                            <th class="px-5 py-4 text-left"><x-sortable-link column="barcode" label="Barcode" /></th>
                            <th class="px-5 py-4 text-left"><x-sortable-link column="problem" label="Problem" /></th>
                            <th class="px-5 py-4 text-left"><x-sortable-link column="date_report" label="Reported" /></th>
                            <th class="px-5 py-4 text-left"><x-sortable-link column="date_released" label="Released" /></th>
                            <th class="px-5 py-4 text-center">Status</th>
                            <th class="px-5 py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        @forelse($maintenances as $maintenance)
                        <tr class="hover:bg-slate-800/40 transition-colors">
                            <td class="px-5 py-4 font-medium text-slate-200">{{ $maintenance->tool->name ?? '—' }}</td>
                            <td class="px-5 py-4 font-mono text-xs text-slate-400">{{ $maintenance->barcode }}</td>
                            <td class="px-5 py-4 text-slate-400">{{ \Illuminate\Support\Str::limit($maintenance->problem, 55) }}</td>
                            <td class="px-5 py-4 text-slate-400">{{ \Carbon\Carbon::parse($maintenance->date_report)->format('d M Y') }}</td>
                            <td class="px-5 py-4 text-slate-400">{{ $maintenance->date_released ? \Carbon\Carbon::parse($maintenance->date_released)->format('d M Y') : '—' }}</td>
                            <td class="px-5 py-4 text-center">
                                @if($maintenance->date_released)
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/15 text-emerald-400 border border-emerald-500/20">Released</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-500/15 text-rose-400 border border-rose-500/20">Under Repair</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-center" x-data="{ open: false }">
                                @if(!$maintenance->date_released)
                                <a href="{{ route('maintenance.edit', $maintenance) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 hover:bg-emerald-500/20 transition-colors text-xs font-medium mr-1">
                                    <i class="fas fa-check text-xs"></i> Resolve
                                </a>
                                @endif
                                <button @click="open = true"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-rose-500/10 text-rose-400 border border-rose-500/20 hover:bg-rose-500/20 transition-colors text-xs font-medium">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                                <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" @click.self="open = false">
                                    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>
                                    <div class="relative bg-slate-900 border border-slate-700 rounded-2xl p-6 max-w-md w-full shadow-2xl">
                                        <div class="flex items-center gap-3 mb-4">
                                            <div class="w-10 h-10 rounded-xl bg-rose-500/15 flex items-center justify-center">
                                                <i class="fas fa-trash text-rose-400"></i>
                                            </div>
                                            <h3 class="font-semibold text-white">Delete Log</h3>
                                        </div>
                                        <p class="text-slate-400 text-sm mb-2">Delete maintenance log for <span class="text-white font-medium">{{ $maintenance->tool->name ?? $maintenance->barcode }}</span>?</p>
                                        @if(!$maintenance->date_released)
                                        <p class="text-orange-400 text-xs mb-6"><i class="fas fa-exclamation-triangle mr-1"></i>Warning: Tool will be returned to available inventory.</p>
                                        @else
                                        <div class="mb-6"></div>
                                        @endif
                                        <div class="flex justify-end gap-3">
                                            <button @click="open = false" class="px-4 py-2 rounded-xl bg-slate-800 text-slate-300 hover:bg-slate-700 text-sm font-medium transition-colors">Cancel</button>
                                            <form action="{{ route('maintenance.destroy', $maintenance) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="px-4 py-2 rounded-xl bg-rose-500 hover:bg-rose-400 text-white text-sm font-medium transition-colors">Yes, Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-5 py-16 text-center text-slate-600">
                                <i class="fas fa-check-circle text-emerald-500/40 text-3xl mb-3 block"></i>
                                No maintenance logs. All tools are operational.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $maintenances->links() }}
        </div>
    </div>
</div>
@endsection
