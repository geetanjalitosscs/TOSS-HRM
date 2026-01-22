@extends('layouts.app')

@section('title', 'Change Password')

@section('body')
    <x-main-layout title="Update Password">
        <div class="hr-card p-8 max-w-4xl mx-auto">
            <h1 class="text-xl font-semibold text-gray-900 mb-6">Update Password</h1>
            
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
                            readonly
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-600 text-sm"
                        />
                    </div>
                    
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)]"
                        />
                        <p class="mt-1 text-xs text-gray-500">
                            For a strong password, please use a hard to guess combination of text with upper and lower case characters, symbols and numbers.
                        </p>
                    </div>
                </div>
                
                <!-- Right Column -->
                <div class="space-y-4">
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">
                            Current Password <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="password" 
                            id="current_password" 
                            name="current_password" 
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)]"
                        />
                    </div>
                    
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                            Confirm Password <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)]"
                        />
                    </div>
                </div>
                
                <!-- Bottom Section -->
                <div class="md:col-span-2 flex items-center justify-between pt-4 border-t border-gray-200">
                    <p class="text-xs text-gray-500">
                        <span class="text-red-500">*</span> Required
                    </p>
                    <div class="flex gap-3">
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit" class="px-4 py-2 bg-[var(--color-hr-primary)] text-white rounded-lg text-sm hover:bg-[var(--color-hr-primary-dark)]">
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </x-main-layout>
@endsection

