@extends('layouts.app')

@section('page-title', 'Dashboard')

@section('content')
@php
    $totalTools     = \App\Models\Tool::count();
    $totalEmployees = \App\Models\Employee::count();
    $toolsOut       = \App\Models\BorrowTool::where('status', 'Checked Out')->count();
    $toolsIn        = \App\Models\BorrowTool::where('status', 'Returned')->count();
    $maintenance    = \App\Models\Maintenance::whereNull('date_released')->count();

    $recentBorrows = \App\Models\BorrowTool::with(['tool', 'employee'])
                        ->orderBy('created_at', 'desc')->take(6)->get();
    $recentMaintenance = \App\Models\Maintenance::with('tool')
                        ->orderBy('created_at', 'desc')->take(5)->get();
@endphp

<div class="p-6 space-y-6">

    {{-- ── Page Header ── --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Dashboard</h1>
            <p class="text-sm text-slate-500 mt-1">{{ now()->format('l, d F Y') }}</p>
        </div>
        <a href="{{ route('borrows.create') }}"
           class="flex items-center gap-2 px-4 py-2 bg-sky-500 hover:bg-sky-400 text-white text-sm font-semibold rounded-xl transition-colors shadow-lg shadow-sky-500/20">
            <i class="fas fa-plus text-xs"></i>
            Check Out Tool
        </a>
    </div>

    {{-- ── Stat Cards ── --}}
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">

        @php
        $stats = [
            ['label' => 'Total Tools',     'value' => $totalTools,     'icon' => 'fa-toolbox',       'color' => 'from-sky-500 to-cyan-500',     'ring' => 'ring-sky-500/20',    'bg' => 'bg-sky-500/10',    'text' => 'text-sky-400',    'route' => 'tools.index'],
            ['label' => 'Employees',        'value' => $totalEmployees, 'icon' => 'fa-users',         'color' => 'from-violet-500 to-purple-500', 'ring' => 'ring-violet-500/20', 'bg' => 'bg-violet-500/10', 'text' => 'text-violet-400', 'route' => 'employees.index'],
            ['label' => 'Checked Out',      'value' => $toolsOut,       'icon' => 'fa-sign-out-alt',  'color' => 'from-orange-500 to-amber-500',  'ring' => 'ring-orange-500/20', 'bg' => 'bg-orange-500/10', 'text' => 'text-orange-400', 'route' => 'borrows.index'],
            ['label' => 'Returned',         'value' => $toolsIn,        'icon' => 'fa-sign-in-alt',   'color' => 'from-emerald-500 to-teal-500',  'ring' => 'ring-emerald-500/20','bg' => 'bg-emerald-500/10','text' => 'text-emerald-400','route' => 'borrows.index'],
            ['label' => 'Under Repair',     'value' => $maintenance,    'icon' => 'fa-wrench',        'color' => 'from-rose-500 to-red-500',      'ring' => 'ring-rose-500/20',   'bg' => 'bg-rose-500/10',   'text' => 'text-rose-400',   'route' => 'maintenance.index'],
        ];
        @endphp

        @foreach($stats as $stat)
        <a href="{{ route($stat['route']) }}"
           class="group relative bg-slate-900 border border-slate-800 hover:border-slate-600 rounded-2xl p-5 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-xl ring-1 {{ $stat['ring'] }} ring-0 hover:ring-1 block">
            <div class="flex items-start justify-between">
                <div class="{{ $stat['bg'] }} rounded-xl w-10 h-10 flex items-center justify-center flex-shrink-0">
                    <i class="fas {{ $stat['icon'] }} {{ $stat['text'] }} text-sm"></i>
                </div>
                <i class="fas fa-arrow-up-right-from-square text-slate-700 group-hover:text-slate-500 text-xs transition-colors"></i>
            </div>
            <div class="mt-4">
                <p class="text-3xl font-extrabold text-white tracking-tight">{{ $stat['value'] }}</p>
                <p class="text-xs text-slate-500 font-medium uppercase tracking-wider mt-1">{{ $stat['label'] }}</p>
            </div>
            <div class="absolute bottom-0 left-5 right-5 h-0.5 bg-gradient-to-r {{ $stat['color'] }} opacity-0 group-hover:opacity-100 transition-opacity rounded-full"></div>
        </a>
        @endforeach
    </div>

    {{-- ── Bottom Panels ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Recent Activity (wider) --}}
        <div class="lg:col-span-2 bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-800">
                <h2 class="font-semibold text-slate-200 flex items-center gap-2">
                    <i class="fas fa-history text-sky-400 text-sm"></i>
                    Recent Check Out Activity
                </h2>
                <a href="{{ route('borrows.index') }}" class="text-xs text-sky-400 hover:text-sky-300 font-medium transition-colors">View all →</a>
            </div>

            @if($recentBorrows->count() > 0)
            <div class="divide-y divide-slate-800">
                @foreach($recentBorrows as $borrow)
                <div class="flex items-center gap-4 px-6 py-4 hover:bg-slate-800/40 transition-colors">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-500 to-sky-500 flex items-center justify-center text-xs font-bold text-white flex-shrink-0">
                        {{ strtoupper(substr($borrow->employee->name ?? 'U', 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-200 truncate">{{ $borrow->employee->name ?? 'Unknown Employee' }}</p>
                        <p class="text-xs text-slate-500 truncate">{{ $borrow->tool->name ?? $borrow->barcode }} &mdash; {{ \Carbon\Carbon::parse($borrow->check_out_date)->diffForHumans() }}</p>
                    </div>
                    @if($borrow->status == 'Returned')
                        <span class="flex-shrink-0 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/15 text-emerald-400 border border-emerald-500/20">Returned</span>
                    @else
                        <span class="flex-shrink-0 px-2.5 py-1 rounded-full text-xs font-semibold bg-orange-500/15 text-orange-400 border border-orange-500/20">Out</span>
                    @endif
                </div>
                @endforeach
            </div>
            @else
            <div class="flex flex-col items-center justify-center py-16 text-slate-600">
                <i class="fas fa-inbox text-3xl mb-3"></i>
                <p class="text-sm">No check-out activity yet</p>
            </div>
            @endif
        </div>

        {{-- Right Column --}}
        <div class="space-y-6">

            {{-- Quick Actions --}}
            <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-800">
                    <h2 class="font-semibold text-slate-200 flex items-center gap-2">
                        <i class="fas fa-bolt text-yellow-400 text-sm"></i>
                        Quick Actions
                    </h2>
                </div>
                <div class="grid grid-cols-2 gap-3 p-4">
                    @php
                    $actions = [
                        ['href' => route('tools.create'),       'icon' => 'fa-plus-circle',   'label' => 'Add Tool'],
                        ['href' => route('employees.create'),   'icon' => 'fa-user-plus',     'label' => 'Add Employee'],
                        ['href' => route('borrows.create'),     'icon' => 'fa-sign-out-alt',  'label' => 'Check Out'],
                        ['href' => route('maintenance.create'), 'icon' => 'fa-tools',         'label' => 'Report Issue'],
                    ];
                    @endphp
                    @foreach($actions as $action)
                    <a href="{{ $action['href'] }}"
                       class="flex flex-col items-center gap-2 p-4 rounded-xl bg-slate-800/50 border border-slate-700/50 hover:border-sky-500/40 hover:bg-sky-500/8 hover:text-sky-400 text-slate-400 text-xs font-medium transition-all duration-150 text-center group">
                        <i class="fas {{ $action['icon'] }} text-lg group-hover:scale-110 transition-transform"></i>
                        {{ $action['label'] }}
                    </a>
                    @endforeach
                </div>
            </div>

            {{-- Active Maintenance --}}
            <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-800">
                    <h2 class="font-semibold text-slate-200 flex items-center gap-2">
                        <i class="fas fa-wrench text-rose-400 text-sm"></i>
                        Active Maintenance
                    </h2>
                    <a href="{{ route('maintenance.index') }}" class="text-xs text-sky-400 hover:text-sky-300 font-medium transition-colors">View all →</a>
                </div>

                @if($recentMaintenance->count() > 0)
                <div class="divide-y divide-slate-800">
                    @foreach($recentMaintenance as $m)
                    <div class="flex items-center gap-3 px-5 py-3 hover:bg-slate-800/40 transition-colors">
                        <div class="w-7 h-7 rounded-lg bg-rose-500/15 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-rose-400 text-xs"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-200 truncate">{{ $m->tool->name ?? $m->barcode }}</p>
                            <p class="text-xs text-slate-500 truncate">{{ \Illuminate\Support\Str::limit($m->problem, 35) }}</p>
                        </div>
                        @if($m->date_released)
                            <span class="flex-shrink-0 px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-500/15 text-emerald-400">Fixed</span>
                        @else
                            <span class="flex-shrink-0 px-2 py-0.5 rounded-full text-xs font-semibold bg-rose-500/15 text-rose-400">Repair</span>
                        @endif
                    </div>
                    @endforeach
                </div>
                @else
                <div class="flex flex-col items-center justify-center py-10 text-slate-600">
                    <i class="fas fa-check-circle text-emerald-500/50 text-2xl mb-2"></i>
                    <p class="text-xs">All tools are operational</p>
                </div>
                @endif
            </div>

        </div>
    </div>

</div>
@endsection
