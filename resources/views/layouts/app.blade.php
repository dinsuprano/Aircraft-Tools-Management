<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Aircraft Tools Management') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 h-full antialiased">

<div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">

    {{-- ── Mobile Sidebar Overlay ── --}}
    <div x-show="sidebarOpen" x-cloak
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-black/60 backdrop-blur-sm z-20 lg:hidden">
    </div>

    {{-- ── Sidebar ── --}}
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           class="fixed inset-y-0 left-0 z-30 w-64 bg-slate-900 border-r border-slate-800 flex flex-col
                  transform transition-transform duration-300 ease-in-out
                  lg:translate-x-0 lg:static lg:flex">

        {{-- Logo --}}
        <div class="flex items-center gap-3 px-6 py-5 border-b border-slate-800">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-sky-500 to-indigo-600 flex items-center justify-center flex-shrink-0">
                <i class="fas fa-plane text-white text-sm"></i>
            </div>
            <div class="min-w-0">
                <p class="text-sm font-700 text-white truncate leading-tight">Aircraft Tools</p>
                <p class="text-xs text-slate-500 truncate">Management System</p>
            </div>
        </div>

        {{-- User Panel --}}
        <div class="flex items-center gap-3 mx-4 mt-4 mb-2 px-3 py-3 rounded-xl bg-slate-800/60 border border-slate-700/50">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-content-center flex-shrink-0 flex items-center justify-center text-xs font-bold text-white">
                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-sm font-medium text-slate-200 truncate">{{ Auth::user()->name ?? 'Guest' }}</p>
                <p class="text-xs text-slate-500 truncate">{{ Auth::user()->email ?? '' }}</p>
            </div>
            <a href="{{ route('profile.edit') }}" class="text-slate-400 hover:text-sky-400 transition-colors text-xs">
                <i class="fas fa-pen"></i>
            </a>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-4 py-3 space-y-1 overflow-y-auto">

            <p class="px-3 py-1 text-xs font-semibold text-slate-600 uppercase tracking-widest">Main Menu</p>

            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150
                      {{ request()->routeIs('dashboard') ? 'bg-sky-500/15 text-sky-400 border border-sky-500/20' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800' }}">
                <i class="fas fa-chart-pie w-4 text-center"></i>
                Dashboard
            </a>

            <a href="{{ route('employees.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150
                      {{ request()->routeIs('employees.*') ? 'bg-sky-500/15 text-sky-400 border border-sky-500/20' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800' }}">
                <i class="fas fa-users w-4 text-center"></i>
                Employee Profile
            </a>

            <a href="{{ route('tools.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150
                      {{ request()->routeIs('tools.*') ? 'bg-sky-500/15 text-sky-400 border border-sky-500/20' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800' }}">
                <i class="fas fa-toolbox w-4 text-center"></i>
                Tool Inventory
            </a>

            <a href="{{ route('borrows.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150
                      {{ request()->routeIs('borrows.*') ? 'bg-sky-500/15 text-sky-400 border border-sky-500/20' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800' }}">
                <i class="fas fa-right-left w-4 text-center"></i>
                Check In / Out
            </a>

            <a href="{{ route('maintenance.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150
                      {{ request()->routeIs('maintenance.*') ? 'bg-sky-500/15 text-sky-400 border border-sky-500/20' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800' }}">
                <i class="fas fa-wrench w-4 text-center"></i>
                Maintenance
            </a>
        </nav>

        {{-- Logout --}}
        <div class="px-4 pb-4 border-t border-slate-800 pt-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="flex items-center gap-3 w-full px-3 py-2.5 rounded-xl text-sm font-medium text-slate-400 hover:text-red-400 hover:bg-red-400/10 transition-all duration-150">
                    <i class="fas fa-sign-out-alt w-4 text-center"></i>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- ── Main Content ── --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Top Navbar --}}
        <header class="flex items-center justify-between px-6 py-4 bg-slate-900/80 backdrop-blur border-b border-slate-800 flex-shrink-0">
            <div class="flex items-center gap-4">
                {{-- Mobile Menu Toggle --}}
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-slate-400 hover:text-white transition-colors">
                    <i class="fas fa-bars text-lg"></i>
                </button>
                {{-- Breadcrumb --}}
                <div class="hidden sm:flex items-center gap-2 text-sm text-slate-500">
                    <i class="fas fa-home text-xs"></i>
                    <span>/</span>
                    <span class="text-slate-300">@yield('page-title', 'Dashboard')</span>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center text-xs font-bold text-white">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                </div>
                <span class="hidden sm:block text-sm text-slate-400">{{ Auth::user()->name ?? 'Guest' }}</span>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="flex-1 overflow-y-auto bg-slate-950">
            @yield('content')
        </main>

    </div>
</div>

</body>
</html>
