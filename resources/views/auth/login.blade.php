@extends('layouts.app')

@section('title', 'Login')

@section('body')
<script>
    // Force light mode on login page and reset theme preference
    (function() {
        // Always force light mode on login page
        document.documentElement.setAttribute('data-theme', 'light');
        
        // Reset theme to light when user logs out (comes to login page)
        // This ensures login page always opens in light mode
        localStorage.setItem('hr-theme', 'light');
        
        // Monitor and prevent any theme changes on login page
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'data-theme') {
                    const currentTheme = document.documentElement.getAttribute('data-theme');
                    if (currentTheme === 'dark') {
                        // Force back to light mode
                        document.documentElement.setAttribute('data-theme', 'light');
                    }
                }
            });
        });
        
        observer.observe(document.documentElement, {
            attributes: true,
            attributeFilter: ['data-theme']
        });
    })();
</script>
    <div class="min-h-screen flex items-center justify-center px-4 py-8 bg-hr-gradient overflow-y-auto" style="background: linear-gradient(135deg, var(--color-hr-primary) 0%, var(--color-hr-primary-soft) 50%, var(--color-hr-primary-light) 100%);">
        <div class="max-w-2xl w-full hr-card overflow-hidden flex flex-col">
            <!-- Login form section -->
            <div class="px-8 sm:px-10 py-10 sm:py-12">
                <div class="flex items-center gap-3 mb-8">
                    <div class="h-11 w-11 rounded-full flex items-center justify-center shadow-lg" style="background: linear-gradient(135deg, var(--color-hr-primary-light) 0%, var(--color-hr-primary-ultra-light) 100%); border: 2px solid var(--border-default);">
                        <span class="text-xl font-bold" style="color: var(--color-hr-primary-dark);">T</span>
                    </div>
                    <div>
                        <div class="text-[11px] uppercase tracking-[0.2em] font-semibold mb-0.5" style="color: var(--text-muted);">TOAI</div>
                        <div class="text-sm font-bold leading-tight" style="color: var(--text-primary);">Human Resource Management</div>
                    </div>
                </div>

                <h1 class="text-2xl font-bold mb-2.5" style="color: var(--text-primary);">Welcome Back</h1>
                <p class="text-sm mb-8" style="color: var(--text-muted);">
                    Sign in to <span class="font-semibold" style="color: var(--text-primary);">TOAI HR Suite</span> to access your dashboard.
                </p>

                <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                    @csrf

                    @if ($errors->has('login'))
                        <div class="rounded-lg px-4 py-3 text-sm font-medium" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); color: #DC2626;">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $errors->first('login') }}
                        </div>
                    @endif

                    <div class="space-y-2">
                        <label for="username" class="block text-sm font-semibold" style="color: var(--text-primary);">
                            Username <span style="color: #DC2626;">*</span>
                        </label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center" style="color: var(--text-muted); width: 1rem;">
                                <i class="fas fa-user text-sm"></i>
                            </span>
                            <input
                                id="username"
                                name="username"
                                type="text"
                                autocomplete="username"
                                class="hr-input"
                                style="padding-left: 2.75rem; padding-right: 0.75rem;"
                                placeholder="Enter your username"
                                value="{{ old('username') }}"
                            />
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-semibold" style="color: var(--text-primary);">
                            Password <span style="color: #DC2626;">*</span>
                        </label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center" style="color: var(--text-muted); width: 1rem;">
                                <i class="fas fa-lock text-sm"></i>
                            </span>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                autocomplete="current-password"
                                class="hr-input"
                                style="padding-left: 2.75rem; padding-right: 0.75rem;"
                                placeholder="Enter your password"
                            />
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-sm pt-1">
                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" class="h-4 w-4 rounded cursor-pointer transition" style="border: 1.5px solid var(--border-default); accent-color: var(--color-hr-primary);" />
                            <span style="color: var(--text-secondary); font-weight: 500;">Remember me</span>
                        </label>
                        <a href="#" class="font-semibold text-sm transition-colors duration-200" style="color: var(--color-hr-primary);" onmouseover="this.style.color='var(--color-hr-primary-dark)'" onmouseout="this.style.color='var(--color-hr-primary)'">
                            Forgot password?
                        </a>
                    </div>

                    <div class="flex justify-center pt-2">
                        <button
                            type="submit"
                            class="hr-btn-primary inline-flex items-center justify-center px-6 py-2.5"
                        >
                            <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                        </button>
                    </div>
                </form>

                <div class="mt-8 pt-6 text-xs flex items-center justify-between flex-wrap gap-3" style="border-top: 1px solid var(--border-subtle);">
                    <span style="color: var(--text-muted);">© {{ date('Y') }} TOAI HR Suite. All rights reserved.</span>
                    <div class="flex items-center gap-2.5">
                        <a href="#" class="h-6 w-6 rounded-full flex items-center justify-center transition-all duration-200" style="background: var(--color-hr-primary-ultra-light); color: var(--text-muted); border: 1px solid var(--border-subtle);" onmouseover="this.style.background='var(--color-hr-primary-light)'; this.style.color='var(--color-hr-primary-dark)'; this.style.borderColor='var(--color-hr-primary)'; this.style.transform='translateY(-1px)';" onmouseout="this.style.background='var(--color-hr-primary-ultra-light)'; this.style.color='var(--text-muted)'; this.style.borderColor='var(--border-subtle)'; this.style.transform='translateY(0)';"><i class="fab fa-linkedin-in text-[10px]"></i></a>
                        <a href="#" class="h-6 w-6 rounded-full flex items-center justify-center transition-all duration-200" style="background: var(--color-hr-primary-ultra-light); color: var(--text-muted); border: 1px solid var(--border-subtle);" onmouseover="this.style.background='var(--color-hr-primary-light)'; this.style.color='var(--color-hr-primary-dark)'; this.style.borderColor='var(--color-hr-primary)'; this.style.transform='translateY(-1px)';" onmouseout="this.style.background='var(--color-hr-primary-ultra-light)'; this.style.color='var(--text-muted)'; this.style.borderColor='var(--border-subtle)'; this.style.transform='translateY(0)';"><i class="fab fa-facebook-f text-[10px]"></i></a>
                        <a href="#" class="h-6 w-6 rounded-full flex items-center justify-center transition-all duration-200" style="background: var(--color-hr-primary-ultra-light); color: var(--text-muted); border: 1px solid var(--border-subtle);" onmouseover="this.style.background='var(--color-hr-primary-light)'; this.style.color='var(--color-hr-primary-dark)'; this.style.borderColor='var(--color-hr-primary)'; this.style.transform='translateY(-1px)';" onmouseout="this.style.background='var(--color-hr-primary-ultra-light)'; this.style.color='var(--text-muted)'; this.style.borderColor='var(--border-subtle)'; this.style.transform='translateY(0)';"><i class="fab fa-twitter text-[10px]"></i></a>
                        <a href="#" class="h-6 w-6 rounded-full flex items-center justify-center transition-all duration-200" style="background: var(--color-hr-primary-ultra-light); color: var(--text-muted); border: 1px solid var(--border-subtle);" onmouseover="this.style.background='var(--color-hr-primary-light)'; this.style.color='var(--color-hr-primary-dark)'; this.style.borderColor='var(--color-hr-primary)'; this.style.transform='translateY(-1px)';" onmouseout="this.style.background='var(--color-hr-primary-ultra-light)'; this.style.color='var(--text-muted)'; this.style.borderColor='var(--border-subtle)'; this.style.transform='translateY(0)';"><i class="fab fa-youtube text-[10px]"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection