@extends('layouts.app')

@section('title', 'Reset Password')

@section('body')
<script>
    // Default to dark theme on reset password page
    (function() {
        document.documentElement.setAttribute('data-theme', 'dark');
        localStorage.setItem('hr-theme', 'dark');
    })();
</script>
    <div class="min-h-screen flex items-center justify-center px-4 py-8 bg-hr-gradient overflow-y-auto" style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-soft) 50%, var(--color-primary-light) 100%);">
        <div class="max-w-2xl w-full hr-card overflow-hidden flex flex-col">
            <!-- Reset Password form section -->
            <div class="px-8 sm:px-10 py-10 sm:py-12">
                <div class="flex items-center gap-3 mb-8">
                    <div class="h-11 w-11 rounded-full flex items-center justify-center shadow-lg transition-all duration-300 hover:scale-105 hover:shadow-xl" style="background: linear-gradient(135deg, var(--color-primary-light) 0%, var(--color-primary-ultra-light) 100%); border: 2px solid var(--border-default); box-shadow: 0 0 15px rgba(228, 87, 69, 0.2), 0 0 30px rgba(228, 87, 69, 0.1);">
                        <span class="text-xl font-bold transition-colors duration-300" style="color: var(--color-primary-dark);">T</span>
                    </div>
                    <div>
                        <div class="text-[11px] uppercase tracking-[0.2em] font-semibold mb-0.5" style="color: var(--text-muted);">TOAI</div>
                        <div class="text-sm font-bold leading-tight" style="color: var(--text-primary);">Human Resource Management</div>
                    </div>
                </div>

                <h1 class="text-2xl font-bold mb-2.5" style="color: var(--text-primary);">Reset Password</h1>
                <p class="text-sm mb-8" style="color: var(--text-muted);">
                    Enter your new password below.
                </p>

                <form action="{{ route('password.reset.post') }}" method="POST" class="space-y-5">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    @if (session('status'))
                        <div class="rounded-lg px-4 py-3 text-sm font-medium" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); color: #10B981;">
                            <i class="fas fa-check-circle mr-2"></i>{{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->has('token'))
                        <div class="rounded-lg px-4 py-3 text-sm font-medium" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); color: #DC2626;">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $errors->first('token') }}
                        </div>
                    @endif

                    @if ($errors->has('password'))
                        <div class="rounded-lg px-4 py-3 text-sm font-medium" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); color: #DC2626;">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $errors->first('password') }}
                        </div>
                    @endif

                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-semibold" style="color: var(--text-primary);">
                            New Password <span style="color: #DC2626;">*</span>
                        </label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center" style="color: var(--text-muted); width: 1rem;">
                                <i class="fas fa-lock text-sm"></i>
                            </span>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                autocomplete="new-password"
                                class="hr-input"
                                style="padding-left: 2.75rem; padding-right: 0.75rem;"
                                placeholder="Enter your new password"
                                required
                                minlength="8"
                            />
                        </div>
                        <p class="text-xs" style="color: var(--text-muted);">Password must be at least 8 characters long.</p>
                    </div>

                    <div class="space-y-2">
                        <label for="password_confirmation" class="block text-sm font-semibold" style="color: var(--text-primary);">
                            Confirm Password <span style="color: #DC2626;">*</span>
                        </label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center" style="color: var(--text-muted); width: 1rem;">
                                <i class="fas fa-lock text-sm"></i>
                            </span>
                            <input
                                id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                autocomplete="new-password"
                                class="hr-input"
                                style="padding-left: 2.75rem; padding-right: 0.75rem;"
                                placeholder="Confirm your new password"
                                required
                                minlength="8"
                            />
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-sm pt-1">
                        <a href="{{ route('login') }}" class="font-semibold text-sm transition-all duration-300 hover:scale-105" style="color: var(--color-primary);" onmouseover="this.style.color='var(--color-primary-dark)'; this.style.transform='translateY(-1px)'" onmouseout="this.style.color='var(--color-primary)'; this.style.transform='translateY(0)'">
                            <i class="fas fa-arrow-left mr-1"></i>Back to Login
                        </a>
                    </div>

                    <div class="flex justify-center pt-2">
                        <button
                            type="submit"
                            class="hr-btn-primary inline-flex items-center justify-center px-6 py-2.5 transition-all duration-300 hover:scale-105 hover:shadow-xl"
                            style="box-shadow: 0 0 15px rgba(228, 87, 69, 0.2), 0 0 30px rgba(228, 87, 69, 0.1);"
                        >
                            <i class="fas fa-key mr-2"></i>Reset Password
                        </button>
                    </div>
                </form>

                <div class="mt-8 pt-6 text-xs flex items-center justify-between flex-wrap gap-3" style="border-top: 1px solid var(--border-subtle);">
                    <span style="color: var(--text-muted);"> {{ date('Y') }} TOAI HRM Suite. All rights reserved.</span>
                    <div class="flex items-center gap-2.5">
                        <a href="#" class="h-6 w-6 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg" style="background: var(--color-primary-light); color: var(--text-muted); border: 1px solid var(--border-subtle); box-shadow: 0 0 8px rgba(228, 87, 69, 0.15), 0 0 16px rgba(228, 87, 69, 0.08);" onmouseover="this.style.background='var(--color-primary)'; this.style.color='var(--color-primary-dark)'; this.style.borderColor='var(--color-primary-light)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.background='var(--color-primary-light)'; this.style.color='var(--text-muted)'; this.style.borderColor='var(--border-subtle)'; this.style.transform='translateY(0)'"><i class="fab fa-linkedin-in text-[10px]"></i></a>
                        <a href="#" class="h-6 w-6 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg" style="background: var(--color-primary-light); color: var(--text-muted); border: 1px solid var(--border-subtle); box-shadow: 0 0 8px rgba(228, 87, 69, 0.15), 0 0 16px rgba(228, 87, 69, 0.08);" onmouseover="this.style.background='var(--color-primary)'; this.style.color='var(--color-primary-dark)'; this.style.borderColor='var(--color-primary-light)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.background='var(--color-primary-light)'; this.style.color='var(--text-muted)'; this.style.borderColor='var(--border-subtle)'; this.style.transform='translateY(0)'"><i class="fab fa-facebook-f text-[10px]"></i></a>
                        <a href="#" class="h-6 w-6 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg" style="background: var(--color-primary-light); color: var(--text-muted); border: 1px solid var(--border-subtle); box-shadow: 0 0 8px rgba(228, 87, 69, 0.15), 0 0 16px rgba(228, 87, 69, 0.08);" onmouseover="this.style.background='var(--color-primary)'; this.style.color='var(--color-primary-dark)'; this.style.borderColor='var(--color-primary-light)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.background='var(--color-primary-light)'; this.style.color='var(--text-muted)'; this.style.borderColor='var(--border-subtle)'; this.style.transform='translateY(0)'"><i class="fab fa-twitter text-[10px]"></i></a>
                        <a href="#" class="h-6 w-6 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg" style="background: var(--color-primary-light); color: var(--text-muted); border: 1px solid var(--border-subtle); box-shadow: 0 0 8px rgba(228, 87, 69, 0.15), 0 0 16px rgba(228, 87, 69, 0.08);" onmouseover="this.style.background='var(--color-primary)'; this.style.color='var(--color-primary-dark)'; this.style.borderColor='var(--color-primary-light)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.background='var(--color-primary-light)'; this.style.color='var(--text-muted)'; this.style.borderColor='var(--border-subtle)'; this.style.transform='translateY(0)'"><i class="fab fa-youtube text-[10px]"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

