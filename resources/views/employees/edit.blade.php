@extends('layouts.app')
@section('page-title', 'Edit Employee')
@section('content')
<div class="p-6 max-w-2xl">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-white">Edit Employee</h1>
        <p class="text-sm text-slate-500 mt-1">Update the details for {{ $employee->name }}</p>
    </div>

    <form action="{{ route('employees.update', $employee) }}" method="POST" class="space-y-5">
        @csrf @method('PUT')
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-5">

            <div>
                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Full Name <span class="text-rose-400">*</span></label>
                <input type="text" name="name" value="{{ old('name', $employee->name) }}" required
                       class="w-full px-4 py-3 rounded-xl bg-slate-800/50 border border-slate-700 text-slate-100 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition-colors">
                @error('name') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Email Address <span class="text-rose-400">*</span></label>
                <input type="email" name="email" value="{{ old('email', $employee->email) }}" required
                       class="w-full px-4 py-3 rounded-xl bg-slate-800/50 border border-slate-700 text-slate-100 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition-colors">
                @error('email') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Department <span class="text-rose-400">*</span></label>
                    <input type="text" name="department" value="{{ old('department', $employee->department) }}" required
                           class="w-full px-4 py-3 rounded-xl bg-slate-800/50 border border-slate-700 text-slate-100 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition-colors">
                    @error('department') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Role / Job Title <span class="text-rose-400">*</span></label>
                    <input type="text" name="role" value="{{ old('role', $employee->role) }}" required
                           class="w-full px-4 py-3 rounded-xl bg-slate-800/50 border border-slate-700 text-slate-100 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition-colors">
                    @error('role') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="px-6 py-2.5 bg-sky-500 hover:bg-sky-400 text-white text-sm font-semibold rounded-xl transition-colors shadow-lg shadow-sky-500/20">
                Update Employee
            </button>
            <a href="{{ route('employees.index') }}" class="px-6 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-300 text-sm font-medium rounded-xl transition-colors">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
