@extends('layouts.app')

@section('title', 'Login')

@section('body')
    <div class="min-h-screen flex items-center justify-center px-4 py-8 bg-hr-gradient">
        <div class="max-w-5xl w-full bg-white shadow-2xl rounded-3xl overflow-hidden grid grid-cols-1 lg:grid-cols-[1.3fr_1fr]">
            <!-- Left: Login form -->
            <div class="px-6 sm:px-8 py-6 sm:py-8">
                <div class="flex items-center gap-2 mb-6">
                    <div class="h-9 w-9 rounded-full bg-purple-100 flex items-center justify-center shadow-sm">
                        <span class="text-lg font-bold text-purple-600">T</span>
                    </div>
                    <div>
                        <div class="text-[10px] uppercase tracking-[0.2em] text-gray-400">TOAI</div>
                        <div class="text-sm font-semibold text-gray-800 leading-tight">Human Resource Management</div>
                    </div>
                </div>

                <div class="mb-5 rounded-xl bg-gray-50 border border-gray-200 px-4 py-3 text-xs text-gray-600">
                    <div class="font-semibold text-gray-800 mb-1 text-xs">Demo Credentials</div>
                    <div class="space-y-0.5 text-[10px]">
                        <p><span class="font-medium text-gray-700">Username:</span> <span class="font-mono text-gray-900">admin</span></p>
                        <p><span class="font-medium text-gray-700">Password:</span> <span class="font-mono text-gray-900">admin123</span></p>
                    </div>
                </div>

                <h1 class="text-xl font-semibold text-gray-900 mb-1.5">Login</h1>
                <p class="text-xs text-gray-500 mb-5">
                    Welcome back to <span class="font-medium text-gray-700">TOAI HR</span>. Please enter your credentials to continue.
                </p>

                <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                    @csrf

                    @if ($errors->has('login'))
                        <p class="text-xs text-red-500 bg-red-50 border border-red-100 rounded-lg px-3 py-1.5">
                            {{ $errors->first('login') }}
                        </p>
                    @endif

                    <div class="space-y-1">
                        <label for="username" class="block text-xs font-medium text-gray-700">
                            Username
                        </label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-2.5 flex items-center text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0v.75H4.5v-.75Z" />
                                </svg>
                            </span>
                            <input
                                id="username"
                                name="username"
                                type="text"
                                autocomplete="username"
                                class="block w-full rounded-lg border border-purple-200 bg-purple-50/60 px-8 py-2 text-xs text-gray-900 shadow-sm focus:border-[var(--color-hr-primary)] focus:ring-2 focus:ring-[var(--color-hr-primary)]/30 focus:outline-none transition"
                                placeholder="Enter your username"
                                value="{{ old('username') }}"
                            />
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label for="password" class="block text-xs font-medium text-gray-700">
                            Password
                        </label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-2.5 flex items-center text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.5 10.5V7.5a4.5 4.5 0 1 0-9 0v3M6.75 10.5h10.5v9.75H6.75V10.5Z" />
                                </svg>
                            </span>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                autocomplete="current-password"
                                class="block w-full rounded-lg border border-purple-200 bg-purple-50/60 px-8 py-2 text-xs text-gray-900 shadow-sm focus:border-[var(--color-hr-primary)] focus:ring-2 focus:ring-[var(--color-hr-primary)]/30 focus:outline-none transition"
                                placeholder="Enter your password"
                            />
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-xs">
                        <label class="inline-flex items-center gap-1.5 text-gray-600">
                            <input type="checkbox" class="h-3.5 w-3.5 rounded border-gray-300 text-[var(--color-hr-primary)] focus:ring-[var(--color-hr-primary)]/40" />
                            <span>Remember me</span>
                        </label>
                        <a href="#" class="text-[var(--color-hr-primary)] hover:text-[var(--color-hr-primary-dark)] font-medium text-xs">
                            Forgot your password?
                        </a>
                    </div>

                    <button
                        type="submit"
                        class="w-full mt-1.5 inline-flex items-center justify-center rounded-lg bg-gradient-to-r from-[var(--color-hr-primary)] to-[var(--color-hr-primary-dark)] px-4 py-2 text-xs font-bold text-white shadow-md shadow-purple-300/50 hover:shadow-lg hover:shadow-purple-400/50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[var(--color-hr-primary)] transition transform hover:scale-[1.02]"
                    >
                        Login
                    </button>
                </form>

                <div class="mt-6 text-[10px] text-gray-400 flex items-center justify-between flex-wrap gap-2">
                    <span>© {{ date('Y') }} TOAI HR. All rights reserved.</span>
                    <div class="flex items-center gap-2">
                        <span class="h-5 w-5 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 text-[10px]">in</span>
                        <span class="h-5 w-5 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 text-[10px]">f</span>
                        <span class="h-5 w-5 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 text-[10px]">X</span>
                        <span class="h-5 w-5 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 text-[10px]">▶</span>
                    </div>
                </div>
            </div>

            <!-- Right: Brand panel -->
            <div class="relative hidden lg:block bg-gradient-to-b from-white/10 via-purple-50/30 to-white">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,#ffffff_0,#e9d5ff_45%,#8b5cf6_100%)] opacity-90"></div>

                <div class="relative h-full flex flex-col items-center justify-center px-6 py-6 text-center">
                    <div class="mb-4 h-24 w-24 rounded-full bg-white/80 shadow-xl flex items-center justify-center border-3 border-purple-200/50">
                        <div class="h-16 w-16 rounded-full border-[5px] border-[var(--color-hr-primary)] flex items-center justify-center relative">
                            <span class="text-2xl font-bold text-[var(--color-hr-primary)]">HR</span>
                            <span class="absolute -top-1.5 right-0 h-3 w-3 rounded-full bg-purple-400 border-2 border-white"></span>
                        </div>
                    </div>

                    <h2 class="text-lg font-semibold text-gray-900 mb-2">HR for Everyone</h2>
                    <p class="text-xs text-gray-600 max-w-xs mb-5">
                        Streamline onboarding, leave management, and performance reviews with a modern and intuitive HR platform.
                    </p>

                    <div class="flex flex-col gap-2 text-left w-full max-w-sm">
                        <div class="flex items-start gap-2">
                            <span class="mt-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full bg-white shadow text-[var(--color-hr-primary)] text-[10px] font-bold">1</span>
                            <div>
                                <div class="text-xs font-semibold text-gray-900">Smart Employee Profiles</div>
                                <div class="text-[10px] text-gray-600">Centralize all employee data with rich profiles and quick search.</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="mt-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full bg-white shadow text-[#ff7a1a] text-[10px] font-semibold">2</span>
                            <div>
                                <div class="text-xs font-semibold text-gray-900">Leave & Attendance</div>
                                <div class="text-[10px] text-gray-600">Automate leave approvals and gain real‑time visibility on attendance.</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="mt-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full bg-white shadow text-[#ff7a1a] text-[10px] font-semibold">3</span>
                            <div>
                                <div class="text-xs font-semibold text-gray-900">Analytics & Insights</div>
                                <div class="text-[10px] text-gray-600">Make informed decisions with visual dashboards and reports.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection