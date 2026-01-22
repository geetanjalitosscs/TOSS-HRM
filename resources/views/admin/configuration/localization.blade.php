@extends('layouts.app')

@section('title', 'Admin - Localization')

@section('body')
    <x-main-layout title="Admin / Configuration">
        <x-admin.tabs activeTab="configuration-localization" />

        <div class="bg-[var(--bg-card)] rounded-b-lg shadow-sm border border-purple-100 border-t-0 p-4">
            <h2 class="text-lg font-bold mb-6" style="color: var(--text-primary);">Localization</h2>

            <form class="space-y-6">
                <!-- Language -->
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">
                        Language
                    </label>
                    <select name="language" class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]" style="border-color: var(--border-default); color: var(--text-primary); background: var(--bg-input);">
                        <option value="en_US" selected>English (United States)</option>
                        <option value="en_GB">English (United Kingdom)</option>
                        <option value="es_ES">Spanish</option>
                        <option value="fr_FR">French</option>
                        <option value="de_DE">German</option>
                    </select>
                </div>

                <!-- Date Format -->
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">
                        Date Format
                    </label>
                    <select name="date_format" class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)]" style="border-color: var(--border-default); color: var(--text-primary); background: var(--bg-input);">
                        <option value="yyyy-dd-mm" selected>yyyy-dd-mm (2026-22-01)</option>
                        <option value="yyyy-mm-dd">yyyy-mm-dd (2026-01-22)</option>
                        <option value="dd-mm-yyyy">dd-mm-yyyy (22-01-2026)</option>
                        <option value="mm-dd-yyyy">mm-dd-yyyy (01-22-2026)</option>
                    </select>
                </div>

                <!-- Action Button -->
                <div class="flex justify-end gap-3 mt-8 pt-6" style="border-top: 1px solid var(--border-default);">
                    <button type="submit" class="px-4 py-2 rounded-md text-sm font-medium text-white transition-colors" style="background: var(--color-hr-primary);" onmouseover="this.style.background='var(--color-hr-primary-dark)'" onmouseout="this.style.background='var(--color-hr-primary)'">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </x-main-layout>
@endsection
