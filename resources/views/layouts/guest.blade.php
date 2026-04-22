<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Aircraft Maintenance Tools Management') }}</title>
        
        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body { font-family: 'Inter', sans-serif; }
        </style>
    </head>
    <body class="font-sans text-slate-100 antialiased bg-slate-950">
        <div class="min-h-screen flex">
            
            {{-- Left Side: Image Banner --}}
            <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-slate-900">
                <img src="{{ asset('images/auth-bg.png') }}" alt="Aircraft Maintenance Hangar" class="absolute inset-0 w-full h-full object-cover opacity-60">
                
                {{-- Gradient Overlay --}}
                <div class="absolute inset-0 bg-gradient-to-r from-slate-950/80 to-slate-950/20"></div>
                
                <div class="absolute inset-0 flex flex-col justify-between p-12 z-10">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-12 h-12 rounded-xl shadow-2xl">
                        <span class="text-xl font-bold text-white tracking-wide">ATMS</span>
                    </div>
                    
                    <div>
                        <h2 class="text-4xl font-extrabold text-white mb-4 leading-tight">
                            Aircraft Maintenance<br>Tools Management
                        </h2>
                        <p class="text-slate-400 text-lg max-w-md">
                            Secure, efficient, and precise tracking of all physical aviation tools to ensure safety and compliance on the hangar floor.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Right Side: Form Content --}}
            <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-6 sm:p-12 relative overflow-y-auto">
                
                {{-- Mobile Logo --}}
                <div class="lg:hidden flex flex-col items-center mb-8">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-16 h-16 rounded-2xl mb-4 shadow-xl">
                    <h2 class="text-2xl font-bold text-white text-center">ATMS</h2>
                </div>

                <div class="w-full max-w-md">
                    {{ $slot }}
                </div>
                
            </div>
            
        </div>
    </body>
</html>
