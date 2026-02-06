@extends('layouts.app')

@section('title', 'Change Password')

@section('body')
    <x-main-layout title="Update Password">
        <section class="hr-card p-6 max-w-4xl mx-auto">
            <h2 class="text-sm font-bold text-slate-800 flex items-baseline gap-2 mb-5">
                <i class="fas fa-key text-[var(--color-primary)]"></i> <span class="mt-0.5">Update Password</span>
            </h2>
            
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('profile.update-password') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf
                
                <!-- Left Column -->
                <div class="space-y-4">
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-1">
                            Username
                        </label>
                        <input 
                            type="text" 
                            id="username" 
                            name="username" 
                            value="{{ session('auth_user')['username'] ?? 'Admin' }}" 
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)]"
                        />
                    </div>
                    
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required
                                class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)]"
                        />
                            <button
                                type="button"
                                onclick="togglePasswordVisibility('password', 'password-eye')"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-sm transition-colors duration-200 hover:scale-105" style="color: var(--text-muted);" id="password-eye"
                            >
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">
                            For a strong password, please use a hard to guess combination of text with upper and lower case characters, symbols and numbers and the password field must be at least 8 characters.
                        </p>
                    </div>
                </div>
                
                <!-- Right Column -->
                <div class="space-y-4">
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">
                            Current Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                        <input 
                            type="password" 
                            id="current_password" 
                            name="current_password" 
                            required
                                class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)]"
                        />
                            <button
                                type="button"
                                onclick="togglePasswordVisibility('current_password', 'current_password-eye')"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-sm transition-colors duration-200 hover:scale-105" style="color: var(--text-muted);" id="current_password-eye"
                            >
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                            Confirm Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            required
                                class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)]"
                        />
                            <button
                                type="button"
                                onclick="togglePasswordVisibility('password_confirmation', 'password_confirmation-eye')"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-sm transition-colors duration-200 hover:scale-105" style="color: var(--text-muted);" id="password_confirmation-eye"
                            >
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Bottom Section -->
                <div class="md:col-span-2 flex items-center justify-between pt-4 border-t border-gray-200">
                    <p class="text-xs text-gray-500">
                        <span class="text-red-500">*</span> Required
                    </p>
                    <div class="flex gap-3">
                        <a href="{{ route('dashboard') }}" class="hr-btn-secondary px-4 py-2 text-sm">
                            Cancel
                        </a>
                        <button type="submit" class="hr-btn-primary px-4 py-2 text-sm">
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </section>
    </x-main-layout>

    <script>
        function togglePasswordVisibility(inputId, buttonId) {
            const input = document.getElementById(inputId);
            const button = document.getElementById(buttonId);
            const icon = button.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
                button.style.color = 'var(--color-primary)';
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
                button.style.color = 'var(--text-muted)';
            }
        }
    </script>
@endsection

