@extends('layouts.app')

@section('title', 'Admin - Localization')

@section('body')
    <x-main-layout title="Admin / Configuration">
        <x-admin.tabs activeTab="configuration-localization" />

        <section class="hr-card p-6">
            <h2 class="text-sm font-bold text-slate-800 flex items-baseline gap-2 mb-5">
                <i class="fas fa-globe text-purple-500"></i> <span class="mt-0.5">Localization</span>
            </h2>

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
                    <button type="submit" class="hr-btn-primary px-4 py-2 text-sm font-medium">
                        Save
                    </button>
                </div>
            </form>
        </section>
    </x-main-layout>
@endsection
