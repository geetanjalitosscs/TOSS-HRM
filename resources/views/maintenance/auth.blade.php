@extends('layouts.app')

@section('title', 'Administrator Access')

@section('body')
<div class="min-h-screen flex items-center justify-center px-4 py-8" style="background-color: var(--bg-main);">
    <div class="max-w-md w-full">
        <!-- Administrator Access Card -->
        <div class="rounded-xl shadow-lg p-8" style="background-color: var(--bg-card); border: 1px solid var(--border-default);">
            <h1 class="text-xl font-bold mb-3" style="color: var(--text-primary);">Administrator Access</h1>
            <p class="text-sm mb-6 leading-relaxed" style="color: var(--text-secondary);">
                You have requested to access a critical Administrator function in TOAI HR and are required to validate your credentials below.
            </p>

            <form action="{{ route('maintenance.auth.post') }}" method="POST" class="space-y-5">
                @csrf

                @if ($errors->has('login'))
                    <div class="rounded-lg px-4 py-3 text-sm" style="background-color: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); color: #DC2626;">
                        <i class="fas fa-exclamation-circle mr-2"></i>{{ $errors->first('login') }}
                    </div>
                @endif

                <div class="space-y-2">
                    <label for="username" class="flex items-center gap-2 text-sm font-medium" style="color: var(--text-primary);">
                        <i class="fas fa-user" style="color: var(--color-hr-primary);"></i>
                        Username
                    </label>
                    <input
                        id="username"
                        name="username"
                        type="text"
                        class="block w-full rounded-lg px-4 py-3 text-sm transition-all focus:outline-none focus:ring-2"
                        style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);"
                        onfocus="this.style.borderColor='var(--color-hr-primary)'; this.style.boxShadow='0 0 0 2px var(--color-hr-primary-soft)';"
                        onblur="this.style.borderColor='var(--border-default)'; this.style.boxShadow='none';"
                        placeholder="Admin"
                        value="{{ old('username', 'admin') }}"
                    />
                </div>

                <div class="space-y-2">
                    <label for="password" class="flex items-center gap-2 text-sm font-medium" style="color: var(--text-primary);">
                        <i class="fas fa-lock" style="color: var(--color-hr-primary);"></i>
                        Password
                    </label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="block w-full rounded-lg px-4 py-3 text-sm transition-all focus:outline-none focus:ring-2"
                        style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);"
                        onfocus="this.style.borderColor='var(--color-hr-primary)'; this.style.boxShadow='0 0 0 2px var(--color-hr-primary-soft)';"
                        onblur="this.style.borderColor='var(--border-default)'; this.style.boxShadow='none';"
                        placeholder="Enter password"
                    />
                </div>

                <div class="flex gap-3 pt-4">
                    <a href="{{ route('dashboard') }}" class="hr-btn-secondary flex-1 text-center">
                        Cancel
                    </a>
                    <button
                        type="submit"
                        class="hr-btn-primary flex-1"
                    >
                        Confirm
                    </button>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8 text-sm" style="color: var(--text-muted);">
            <p class="font-medium">TOAI HR Suite Professional Edition</p>
            <p class="mt-1">© {{ date('Y') }} TOAI HR. All rights reserved.</p>
        </div>
    </div>
</div>
@endsection

