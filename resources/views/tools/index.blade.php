@extends('layouts.app')
@section('page-title', 'Tool Inventory')
@section('content')
<div class="p-6 space-y-5">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Tool Inventory</h1>
            <p class="text-sm text-slate-500 mt-1">Manage all aviation tools in the system</p>
        </div>
        <a href="{{ route('tools.create') }}"
           class="flex items-center gap-2 px-4 py-2 bg-sky-500 hover:bg-sky-400 text-white text-sm font-semibold rounded-xl transition-colors shadow-lg shadow-sky-500/20">
            <i class="fas fa-plus text-xs"></i>
            Add New Tool
        </a>
    </div>

    {{-- Alert --}}
    @if(session('success'))
    <div class="flex items-center gap-3 px-4 py-3 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400 text-sm">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
    @endif

    {{-- Table Card --}}
    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-800 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        <th class="px-5 py-4 text-left">Barcode</th>
                        <th class="px-5 py-4 text-left">Name</th>
                        <th class="px-5 py-4 text-left">Location</th>
                        <th class="px-5 py-4 text-left">Price</th>
                        <th class="px-5 py-4 text-center">Qty</th>
                        <th class="px-5 py-4 text-center">Available</th>
                        <th class="px-5 py-4 text-left">Status</th>
                        <th class="px-5 py-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse($tools as $tool)
                    <tr class="hover:bg-slate-800/40 transition-colors">
                        <td class="px-5 py-4 font-mono text-xs text-slate-400">{{ $tool->barcode }}</td>
                        <td class="px-5 py-4 font-medium text-slate-200">{{ $tool->name }}</td>
                        <td class="px-5 py-4 text-slate-400">{{ $tool->location ?? '—' }}</td>
                        <td class="px-5 py-4 text-slate-400">${{ number_format($tool->price, 2) }}</td>
                        <td class="px-5 py-4 text-center text-slate-300">{{ $tool->quantity }}</td>
                        <td class="px-5 py-4 text-center">
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                                {{ $tool->available_quantity > 0 ? 'bg-emerald-500/15 text-emerald-400' : 'bg-rose-500/15 text-rose-400' }}">
                                {{ $tool->available_quantity }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-800 text-slate-400 border border-slate-700">{{ $tool->status ?? 'Active' }}</span>
                        </td>
                        <td class="px-5 py-4 text-center" x-data="{ open: false }">
                            <a href="{{ route('tools.edit', $tool) }}"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-sky-500/10 text-sky-400 border border-sky-500/20 hover:bg-sky-500/20 transition-colors text-xs font-medium mr-1">
                                <i class="fas fa-pen text-xs"></i> Edit
                            </a>
                            <button @click="open = true"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-rose-500/10 text-rose-400 border border-rose-500/20 hover:bg-rose-500/20 transition-colors text-xs font-medium">
                                <i class="fas fa-trash text-xs"></i> Delete
                            </button>

                            {{-- Delete Modal --}}
                            <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" @click.self="open = false">
                                <div class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>
                                <div class="relative bg-slate-900 border border-slate-700 rounded-2xl p-6 max-w-md w-full shadow-2xl">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="w-10 h-10 rounded-xl bg-rose-500/15 flex items-center justify-center">
                                            <i class="fas fa-trash text-rose-400"></i>
                                        </div>
                                        <h3 class="font-semibold text-white">Confirm Deletion</h3>
                                    </div>
                                    <p class="text-slate-400 text-sm mb-6">Are you sure you want to delete <span class="text-white font-medium">{{ $tool->name }}</span>? This action cannot be undone.</p>
                                    <div class="flex justify-end gap-3">
                                        <button @click="open = false" class="px-4 py-2 rounded-xl bg-slate-800 text-slate-300 hover:bg-slate-700 text-sm font-medium transition-colors">Cancel</button>
                                        <form action="{{ route('tools.destroy', $tool) }}" method="POST">
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
                        <td colspan="8" class="px-5 py-16 text-center text-slate-600">
                            <i class="fas fa-toolbox text-3xl mb-3 block"></i>
                            No tools found. <a href="{{ route('tools.create') }}" class="text-sky-400 hover:underline">Add your first tool</a>.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
