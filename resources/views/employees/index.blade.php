@extends('layouts.app')
@section('page-title', 'Employee Profile')
@section('content')
<div class="p-6 space-y-5">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Employee Profile</h1>
            <p class="text-sm text-slate-500 mt-1">Manage staff profiles and assignments</p>
        </div>
        <a href="{{ route('employees.create') }}"
           class="flex items-center gap-2 px-4 py-2 bg-sky-500 hover:bg-sky-400 text-white text-sm font-semibold rounded-xl transition-colors shadow-lg shadow-sky-500/20">
            <i class="fas fa-plus text-xs"></i>
            Add Employee
        </a>
    </div>

    @if(session('success'))
    <div class="flex items-center gap-3 px-4 py-3 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400 text-sm">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-800 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        <th class="px-5 py-4 text-left">Name</th>
                        <th class="px-5 py-4 text-left">Email</th>
                        <th class="px-5 py-4 text-left">Department</th>
                        <th class="px-5 py-4 text-left">Role</th>
                        <th class="px-5 py-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse($employees as $employee)
                    <tr class="hover:bg-slate-800/40 transition-colors">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center text-xs font-bold text-white flex-shrink-0">
                                    {{ strtoupper(substr($employee->name, 0, 1)) }}
                                </div>
                                <span class="font-medium text-slate-200">{{ $employee->name }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-slate-400">{{ $employee->email }}</td>
                        <td class="px-5 py-4 text-slate-400">{{ $employee->department }}</td>
                        <td class="px-5 py-4">
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-violet-500/15 text-violet-400 border border-violet-500/20">{{ $employee->role }}</span>
                        </td>
                        <td class="px-5 py-4 text-center" x-data="{ open: false }">
                            <a href="{{ route('employees.edit', $employee) }}"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-sky-500/10 text-sky-400 border border-sky-500/20 hover:bg-sky-500/20 transition-colors text-xs font-medium mr-1">
                                <i class="fas fa-pen text-xs"></i> Edit
                            </a>
                            <button @click="open = true"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-rose-500/10 text-rose-400 border border-rose-500/20 hover:bg-rose-500/20 transition-colors text-xs font-medium">
                                <i class="fas fa-trash text-xs"></i> Delete
                            </button>
                            <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" @click.self="open = false">
                                <div class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>
                                <div class="relative bg-slate-900 border border-slate-700 rounded-2xl p-6 max-w-md w-full shadow-2xl">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="w-10 h-10 rounded-xl bg-rose-500/15 flex items-center justify-center">
                                            <i class="fas fa-trash text-rose-400"></i>
                                        </div>
                                        <h3 class="font-semibold text-white">Confirm Deletion</h3>
                                    </div>
                                    <p class="text-slate-400 text-sm mb-6">Are you sure you want to remove <span class="text-white font-medium">{{ $employee->name }}</span> from the system?</p>
                                    <div class="flex justify-end gap-3">
                                        <button @click="open = false" class="px-4 py-2 rounded-xl bg-slate-800 text-slate-300 hover:bg-slate-700 text-sm font-medium transition-colors">Cancel</button>
                                        <form action="{{ route('employees.destroy', $employee) }}" method="POST">
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
                        <td colspan="5" class="px-5 py-16 text-center text-slate-600">
                            <i class="fas fa-users text-3xl mb-3 block"></i>
                            No employees found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
