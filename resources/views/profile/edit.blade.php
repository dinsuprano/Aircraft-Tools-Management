@extends('layouts.app')
@section('page-title', 'Profile Settings')
@section('content')
<div class="p-6 max-w-2xl space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-white">Profile Settings</h1>
        <p class="text-sm text-slate-500 mt-1">Manage your account information and security</p>
    </div>

    {{-- Profile Info --}}
    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-800">
            <h2 class="font-semibold text-slate-200 flex items-center gap-2">
                <i class="fas fa-user text-sky-400 text-sm"></i>
                Profile Information
            </h2>
        </div>
        <div class="p-6">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    {{-- Password --}}
    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-800">
            <h2 class="font-semibold text-slate-200 flex items-center gap-2">
                <i class="fas fa-lock text-amber-400 text-sm"></i>
                Update Password
            </h2>
        </div>
        <div class="p-6">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    {{-- Delete Account --}}
    <div class="bg-slate-900 border border-rose-500/20 rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-rose-500/20">
            <h2 class="font-semibold text-rose-400 flex items-center gap-2">
                <i class="fas fa-exclamation-triangle text-sm"></i>
                Danger Zone
            </h2>
        </div>
        <div class="p-6">
            @include('profile.partials.delete-user-form')
        </div>
    </div>

</div>
@endsection
