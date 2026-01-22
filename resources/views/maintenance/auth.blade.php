@extends('layouts.app')

@section('title', 'Administrator Access')

@section('body')
<div class="min-h-screen flex items-center justify-center px-4 py-8 bg-gray-50">
    <div class="max-w-md w-full">
        <!-- Administrator Access Card -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-lg font-bold text-gray-900 mb-2">Administrator Access</h1>
            <p class="text-xs text-gray-600 mb-6">
                You have requested to access a critical Administrator function in TOAI HR and are required to validate your credentials below.
            </p>

            <form action="{{ route('maintenance.auth.post') }}" method="POST" class="space-y-4">
                @csrf

                @if ($errors->has('login'))
                    <p class="text-xs text-red-500 bg-red-50 border border-red-100 rounded-lg px-3 py-1.5">
                        {{ $errors->first('login') }}
                    </p>
                @endif

                <div class="space-y-1">
                    <label for="username" class="flex items-center gap-2 text-xs font-medium text-gray-700">
                        <i class="fas fa-user h-4 w-4"></i>
                        Username
                    </label>
                    <input
                        id="username"
                        name="username"
                        type="text"
                        class="block w-full rounded-lg border border-gray-300 bg-purple-50/30 px-3 py-2 text-xs text-gray-900 shadow-sm focus:border-[var(--color-hr-primary)] focus:ring-2 focus:ring-[var(--color-hr-primary)]/30 focus:outline-none transition"
                        placeholder="Admin"
                        value="{{ old('username', 'admin') }}"
                    />
                </div>

                <div class="space-y-1">
                    <label for="password" class="flex items-center gap-2 text-xs font-medium text-gray-700">
                        <i class="fas fa-lock h-4 w-4"></i>
                        Password
                    </label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs text-gray-900 shadow-sm focus:border-[var(--color-hr-primary)] focus:ring-2 focus:ring-[var(--color-hr-primary)]/30 focus:outline-none transition"
                        placeholder="Enter password"
                    />
                </div>

                <div class="flex gap-2 pt-2">
                    <a href="{{ route('dashboard') }}" class="flex-1 inline-flex items-center justify-center rounded-lg border border-green-500 bg-white px-4 py-2 text-xs font-medium text-green-600 hover:bg-green-50 transition">
                        Cancel
                    </a>
                    <button
                        type="submit"
                        class="flex-1 inline-flex items-center justify-center rounded-lg bg-green-600 px-4 py-2 text-xs font-medium text-white hover:bg-green-700 transition shadow-sm"
                    >
                        Confirm
                    </button>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6 text-xs text-gray-500">
            <p>TOAI HR Suite Professional Edition</p>
            <p>© {{ date('Y') }} TOAI HR. All rights reserved.</p>
        </div>
    </div>
</div>
@endsection

