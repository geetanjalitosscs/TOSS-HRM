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
    <div class="h-screen flex items-center justify-center px-4 py-4 bg-hr-gradient overflow-hidden" style="background: linear-gradient(135deg, var(--color-hr-primary) 0%, var(--color-hr-primary-soft) 50%, var(--color-hr-primary-light) 100%);">
        <div class="max-w-5xl w-full bg-white shadow-2xl rounded-2xl overflow-hidden grid grid-cols-1 lg:grid-cols-[1.3fr_1fr]" style="box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25), 0 0 0 1px rgba(139, 92, 246, 0.1); border: 1px solid rgba(139, 92, 246, 0.15); max-height: 90vh;">
            <!-- Left: Login form -->
            <div class="px-6 sm:px-8 py-5 sm:py-6 overflow-y-auto" style="max-height: 90vh;">
                <div class="flex items-center gap-2.5 mb-4">
                    <div class="h-9 w-9 rounded-full flex items-center justify-center shadow-lg" style="background: linear-gradient(135deg, var(--color-hr-primary-light) 0%, var(--color-hr-primary-ultra-light) 100%); border: 2px solid var(--border-default);">
                        <span class="text-lg font-bold" style="color: var(--color-hr-primary-dark);">T</span>
                    </div>
                    <div>
                        <div class="text-[10px] uppercase tracking-[0.2em] font-semibold" style="color: var(--text-muted);">TOAI</div>
                        <div class="text-xs font-bold leading-tight" style="color: var(--text-primary);">Human Resource Management</div>
                    </div>
                </div>

                <div class="mb-4 rounded-lg px-4 py-2.5 text-xs" style="background: var(--color-hr-primary-ultra-light); border: 1px solid var(--border-default);">
                    <div class="font-bold mb-1 text-xs" style="color: var(--color-hr-primary-dark);">Demo Credentials</div>
                    <div class="space-y-0.5 text-[10px]">
                        <p><span class="font-semibold" style="color: var(--text-secondary);">Username:</span> <span class="font-mono font-bold ml-1" style="color: var(--text-primary);">admin</span></p>
                        <p><span class="font-semibold" style="color: var(--text-secondary);">Password:</span> <span class="font-mono font-bold ml-1" style="color: var(--text-primary);">admin123</span></p>
                    </div>
                </div>

                <h1 class="text-xl font-bold mb-1" style="color: var(--text-primary);">Welcome Back</h1>
                <p class="text-xs mb-4" style="color: var(--text-muted);">
                    Sign in to <span class="font-semibold" style="color: var(--text-primary);">TOAI HR Suite</span> to access your dashboard.
                </p>

                <form action="{{ route('login.post') }}" method="POST" class="space-y-3.5">
                    @csrf

                    @if ($errors->has('login'))
                        <div class="rounded-lg px-3 py-2 text-xs font-medium" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); color: #DC2626;">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $errors->first('login') }}
                        </div>
                    @endif

                    <div class="space-y-1.5">
                        <label for="username" class="block text-xs font-semibold" style="color: var(--text-primary);">
                            Username <span style="color: #DC2626;">*</span>
                        </label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center" style="color: var(--text-muted);">
                                <i class="fas fa-user h-3.5 w-3.5"></i>
                            </span>
                            <input
                                id="username"
                                name="username"
                                type="text"
                                autocomplete="username"
                                class="block w-full rounded-lg px-9 py-2.5 text-xs font-medium shadow-sm focus:outline-none transition-all duration-200"
                                style="background: var(--bg-input); border: 1.5px solid var(--border-default); color: var(--text-primary);"
                                onfocus="this.style.borderColor='var(--color-hr-primary)'; this.style.boxShadow='0 0 0 3px rgba(139, 92, 246, 0.1)';"
                                onblur="this.style.borderColor='var(--border-default)'; this.style.boxShadow='none';"
                                placeholder="Enter your username"
                                value="{{ old('username') }}"
                            />
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label for="password" class="block text-xs font-semibold" style="color: var(--text-primary);">
                            Password <span style="color: #DC2626;">*</span>
                        </label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center" style="color: var(--text-muted);">
                                <i class="fas fa-lock h-3.5 w-3.5"></i>
                            </span>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                autocomplete="current-password"
                                class="block w-full rounded-lg px-9 py-2.5 text-xs font-medium shadow-sm focus:outline-none transition-all duration-200"
                                style="background: var(--bg-input); border: 1.5px solid var(--border-default); color: var(--text-primary);"
                                onfocus="this.style.borderColor='var(--color-hr-primary)'; this.style.boxShadow='0 0 0 3px rgba(139, 92, 246, 0.1)';"
                                onblur="this.style.borderColor='var(--border-default)'; this.style.boxShadow='none';"
                                placeholder="Enter your password"
                            />
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-xs">
                        <label class="inline-flex items-center gap-1.5 cursor-pointer">
                            <input type="checkbox" class="h-3.5 w-3.5 rounded cursor-pointer transition" style="border: 1.5px solid var(--border-default); accent-color: var(--color-hr-primary);" />
                            <span style="color: var(--text-secondary); font-weight: 500;">Remember me</span>
                        </label>
                        <a href="#" class="font-semibold text-xs transition-colors duration-200" style="color: var(--color-hr-primary);" onmouseover="this.style.color='var(--color-hr-primary-dark)'" onmouseout="this.style.color='var(--color-hr-primary)'">
                            Forgot password?
                        </a>
                    </div>

                    <button
                        type="submit"
                        class="hr-btn-primary w-full mt-1.5 inline-flex items-center justify-center px-5 py-2.5 text-xs font-bold"
                    >
                        <i class="fas fa-sign-in-alt mr-1.5"></i>Sign In
                    </button>
                </form>

                <div class="mt-4 pt-4 text-[10px] flex items-center justify-between flex-wrap gap-2" style="border-top: 1px solid var(--border-subtle);">
                    <span style="color: var(--text-muted);">© {{ date('Y') }} TOAI HR Suite. All rights reserved.</span>
                    <div class="flex items-center gap-2">
                        <a href="#" class="h-5 w-5 rounded-full flex items-center justify-center transition-all duration-300 ease-out" style="background: var(--color-hr-primary-ultra-light); color: var(--text-muted); border: 1px solid var(--border-subtle);" onmouseover="this.style.background='linear-gradient(135deg, var(--color-hr-primary) 0%, var(--color-hr-primary-dark) 100%)'; this.style.color='white'; this.style.borderColor='var(--color-hr-primary-dark)'; this.style.transform='translateY(-2px) scale(1.1)'; this.style.boxShadow='0 4px 12px rgba(139, 92, 246, 0.3)';" onmouseout="this.style.background='var(--color-hr-primary-ultra-light)'; this.style.color='var(--text-muted)'; this.style.borderColor='var(--border-subtle)'; this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='none';"><i class="fab fa-linkedin-in text-[9px]"></i></a>
                        <a href="#" class="h-5 w-5 rounded-full flex items-center justify-center transition-all duration-300 ease-out" style="background: var(--color-hr-primary-ultra-light); color: var(--text-muted); border: 1px solid var(--border-subtle);" onmouseover="this.style.background='linear-gradient(135deg, var(--color-hr-primary) 0%, var(--color-hr-primary-dark) 100%)'; this.style.color='white'; this.style.borderColor='var(--color-hr-primary-dark)'; this.style.transform='translateY(-2px) scale(1.1)'; this.style.boxShadow='0 4px 12px rgba(139, 92, 246, 0.3)';" onmouseout="this.style.background='var(--color-hr-primary-ultra-light)'; this.style.color='var(--text-muted)'; this.style.borderColor='var(--border-subtle)'; this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='none';"><i class="fab fa-facebook-f text-[9px]"></i></a>
                        <a href="#" class="h-5 w-5 rounded-full flex items-center justify-center transition-all duration-300 ease-out" style="background: var(--color-hr-primary-ultra-light); color: var(--text-muted); border: 1px solid var(--border-subtle);" onmouseover="this.style.background='linear-gradient(135deg, var(--color-hr-primary) 0%, var(--color-hr-primary-dark) 100%)'; this.style.color='white'; this.style.borderColor='var(--color-hr-primary-dark)'; this.style.transform='translateY(-2px) scale(1.1)'; this.style.boxShadow='0 4px 12px rgba(139, 92, 246, 0.3)';" onmouseout="this.style.background='var(--color-hr-primary-ultra-light)'; this.style.color='var(--text-muted)'; this.style.borderColor='var(--border-subtle)'; this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='none';"><i class="fab fa-twitter text-[9px]"></i></a>
                        <a href="#" class="h-5 w-5 rounded-full flex items-center justify-center transition-all duration-300 ease-out" style="background: var(--color-hr-primary-ultra-light); color: var(--text-muted); border: 1px solid var(--border-subtle);" onmouseover="this.style.background='linear-gradient(135deg, var(--color-hr-primary) 0%, var(--color-hr-primary-dark) 100%)'; this.style.color='white'; this.style.borderColor='var(--color-hr-primary-dark)'; this.style.transform='translateY(-2px) scale(1.1)'; this.style.boxShadow='0 4px 12px rgba(139, 92, 246, 0.3)';" onmouseout="this.style.background='var(--color-hr-primary-ultra-light)'; this.style.color='var(--text-muted)'; this.style.borderColor='var(--border-subtle)'; this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='none';"><i class="fab fa-youtube text-[9px]"></i></a>
                    </div>
                </div>
            </div>

            <!-- Right: Brand panel -->
            <div class="relative hidden lg:block overflow-y-auto" style="background: linear-gradient(135deg, rgba(255, 255, 255, 0.15) 0%, rgba(139, 92, 246, 0.1) 50%, rgba(255, 255, 255, 0.05) 100%); max-height: 90vh;">
                <div class="absolute inset-0" style="background: radial-gradient(circle at top left, rgba(255, 255, 255, 0.9) 0%, rgba(233, 213, 255, 0.6) 45%, rgba(139, 92, 246, 0.3) 100%);"></div>

                <div class="relative h-full flex flex-col items-center justify-center px-6 py-6 text-center">
                    <div class="mb-4 h-20 w-20 rounded-full flex items-center justify-center shadow-2xl relative" style="background: rgba(255, 255, 255, 0.95); border: 3px solid rgba(139, 92, 246, 0.2);">
                        <div class="h-16 w-16 rounded-full flex items-center justify-center relative" style="border: 4px solid var(--color-hr-primary); background: linear-gradient(135deg, var(--color-hr-primary-light) 0%, rgba(255, 255, 255, 0.9) 100%);">
                            <span class="text-2xl font-bold" style="color: var(--color-hr-primary-dark);">HR</span>
                            <span class="absolute -top-1.5 -right-1.5 h-3 w-3 rounded-full border-2 border-white shadow-lg" style="background: var(--color-hr-primary-soft);"></span>
                        </div>
                    </div>

                    <h2 class="text-lg font-bold mb-2" style="color: var(--text-primary);">HR for Everyone</h2>
                    <p class="text-xs leading-relaxed max-w-xs mb-5" style="color: var(--text-secondary);">
                        Streamline onboarding, leave management, and performance reviews with a modern HR platform.
                    </p>

                    <div class="flex flex-col gap-2.5 text-left w-full max-w-sm">
                        <div class="flex items-start gap-2.5 p-2.5 rounded-lg transition-all duration-200" style="background: rgba(255, 255, 255, 0.6); border: 1px solid var(--border-subtle);" onmouseover="this.style.background='rgba(255, 255, 255, 0.8)'; this.style.borderColor='var(--border-default)'; this.style.transform='translateX(4px)';" onmouseout="this.style.background='rgba(255, 255, 255, 0.6)'; this.style.borderColor='var(--border-subtle)'; this.style.transform='translateX(0)';">
                            <span class="mt-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full shadow-md text-[10px] font-bold" style="background: linear-gradient(135deg, var(--color-hr-primary) 0%, var(--color-hr-primary-dark) 100%); color: white; flex-shrink: 0;">1</span>
                            <div>
                                <div class="text-xs font-bold mb-0.5" style="color: var(--text-primary);">Smart Employee Profiles</div>
                                <div class="text-[10px] leading-relaxed" style="color: var(--text-muted);">Centralize all employee data with rich profiles and quick search.</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-2.5 p-2.5 rounded-lg transition-all duration-200" style="background: rgba(255, 255, 255, 0.6); border: 1px solid var(--border-subtle);" onmouseover="this.style.background='rgba(255, 255, 255, 0.8)'; this.style.borderColor='var(--border-default)'; this.style.transform='translateX(4px)';" onmouseout="this.style.background='rgba(255, 255, 255, 0.6)'; this.style.borderColor='var(--border-subtle)'; this.style.transform='translateX(0)';">
                            <span class="mt-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full shadow-md text-[10px] font-bold" style="background: linear-gradient(135deg, #FF7A1A 0%, #FF6B00 100%); color: white; flex-shrink: 0;">2</span>
                            <div>
                                <div class="text-xs font-bold mb-0.5" style="color: var(--text-primary);">Leave & Attendance</div>
                                <div class="text-[10px] leading-relaxed" style="color: var(--text-muted);">Automate leave approvals and gain real‑time visibility on attendance.</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-2.5 p-2.5 rounded-lg transition-all duration-200" style="background: rgba(255, 255, 255, 0.6); border: 1px solid var(--border-subtle);" onmouseover="this.style.background='rgba(255, 255, 255, 0.8)'; this.style.borderColor='var(--border-default)'; this.style.transform='translateX(4px)';" onmouseout="this.style.background='rgba(255, 255, 255, 0.6)'; this.style.borderColor='var(--border-subtle)'; this.style.transform='translateX(0)';">
                            <span class="mt-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full shadow-md text-[10px] font-bold" style="background: linear-gradient(135deg, #10B981 0%, #059669 100%); color: white; flex-shrink: 0;">3</span>
                            <div>
                                <div class="text-xs font-bold mb-0.5" style="color: var(--text-primary);">Analytics & Insights</div>
                                <div class="text-[10px] leading-relaxed" style="color: var(--text-muted);">Make informed decisions with visual dashboards and reports.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection