@extends('layouts.app')

@section('title', 'Admin - Register OAuth Client')

@section('body')
    <x-main-layout title="Admin / Configuration">
        <x-admin.tabs activeTab="configuration-oauth-client" />

        <section class="hr-card p-6">
            <h2 class="text-sm font-bold text-slate-800 flex items-baseline gap-2 mb-5">
                <i class="fas fa-key text-purple-500"></i> <span class="mt-0.5">Register OAuth Client</span>
            </h2>

            <form class="space-y-6">
                <!-- Client ID -->
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">
                        Client ID <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="client_id" 
                        class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]" 
                        style="border-color: var(--border-default); color: var(--text-primary); background: var(--bg-input);"
                        required>
                </div>

                <!-- Client Secret -->
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">
                        Client Secret <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="password" 
                        name="client_secret" 
                        class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]" 
                        style="border-color: var(--border-default); color: var(--text-primary); background: var(--bg-input);"
                        required>
                </div>

                <!-- Redirect URI -->
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">
                        Redirect URI <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="url" 
                        name="redirect_uri" 
                        class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]" 
                        style="border-color: var(--border-default); color: var(--text-primary); background: var(--bg-input);"
                        required>
                </div>

                <!-- Required Field Note -->
                <div class="mt-4">
                    <p class="text-xs" style="color: var(--text-muted);">* Required</p>
                </div>

                <!-- Action Button -->
                <div class="flex justify-end gap-3 mt-8 pt-6" style="border-top: 1px solid var(--border-default);">
                    <button type="submit" class="px-4 py-2 rounded-md text-sm font-medium text-white transition-colors" style="background: var(--color-hr-primary);" onmouseover="this.style.background='var(--color-hr-primary-dark)'" onmouseout="this.style.background='var(--color-hr-primary)'">
                        Save
                    </button>
                </div>
            </form>
        </section>
    </x-main-layout>
@endsection

