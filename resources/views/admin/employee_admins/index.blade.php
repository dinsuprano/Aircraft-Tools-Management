@extends('layouts.app')
@section('page-title', 'Admin Control Panel')
@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white">Employee Admin Management</h1>
            <p class="text-sm text-slate-400 mt-1">Review and manage access for Employee Admins</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 px-4 py-3 bg-emerald-500/10 border border-emerald-500/20 rounded-xl flex items-center gap-3 text-emerald-400 text-sm">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="space-y-4 mb-4">
        {{-- Search Bar --}}
        <form action="{{ url('admin/employee-admins') }}" method="GET" class="relative max-w-md">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-slate-500"></i>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email..."
                   class="w-full pl-10 pr-4 py-2 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition-colors placeholder-slate-600">
        </form>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="bg-slate-800/50 border-b border-slate-800 text-slate-400 font-medium">
                        <th class="px-6 py-4">Name</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Registered On</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/50">
                    @forelse($employeeAdmins as $admin)
                    <tr class="hover:bg-slate-800/20 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-200">{{ $admin->name }}</div>
                        </td>
                        <td class="px-6 py-4 text-slate-400">{{ $admin->email }}</td>
                        <td class="px-6 py-4 text-slate-400">{{ $admin->created_at->format('M d, Y - g:i A') }}</td>
                        <td class="px-6 py-4">
                            @if($admin->is_approved)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Approved
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                    Pending Approval
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right" x-data="{ open: false }">
                            <div class="flex items-center justify-end gap-2">
                                <form action="{{ route('admin.employee-admins.toggle', $admin) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-{{ $admin->is_approved ? 'amber' : 'emerald' }}-400 transition-colors tooltip" title="{{ $admin->is_approved ? 'Revoke Access' : 'Approve Access' }}">
                                        <i class="fas fa-{{ $admin->is_approved ? 'ban' : 'check-circle' }}"></i>
                                    </button>
                                </form>
                                <button type="button" @click="open = true" class="p-2 text-slate-400 hover:text-rose-400 transition-colors tooltip" title="Delete Application">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                
                                {{-- Delete Modal --}}
                                <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 text-left" @click.self="open = false">
                                    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>
                                    <div class="relative bg-slate-900 border border-slate-700 rounded-2xl p-6 max-w-md w-full shadow-2xl">
                                        <div class="flex items-center gap-3 mb-4">
                                            <div class="w-10 h-10 rounded-xl bg-rose-500/15 flex items-center justify-center flex-shrink-0">
                                                <i class="fas fa-trash text-rose-400"></i>
                                            </div>
                                            <h3 class="font-semibold text-white">Confirm Deletion</h3>
                                        </div>
                                        <p class="text-slate-400 text-sm mb-6 whitespace-normal">Are you sure you want to permanently delete the application for <span class="text-white font-medium">{{ $admin->name }}</span>? This action cannot be undone.</p>
                                        <div class="flex justify-end gap-3">
                                            <button @click="open = false" class="px-4 py-2 rounded-xl bg-slate-800 text-slate-300 hover:bg-slate-700 text-sm font-medium transition-colors">Cancel</button>
                                            <form action="{{ route('admin.employee-admins.destroy', $admin) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="px-4 py-2 rounded-xl bg-rose-500 hover:bg-rose-400 text-white text-sm font-medium transition-colors">Yes, Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                            No Employee Admin applications found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($employeeAdmins->hasPages())
        <div class="px-6 py-4 border-t border-slate-800">
            {{ $employeeAdmins->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
