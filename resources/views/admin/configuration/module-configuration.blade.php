@extends('layouts.app')

@section('title', 'Admin - Module Configuration')

@section('body')
    <x-main-layout title="Admin / Configuration">
        <x-admin.tabs activeTab="configuration-modules" />

        <section class="hr-card p-6">
            <h2 class="text-sm font-bold text-slate-800 flex items-baseline gap-2 mb-5">
                <i class="fas fa-cogs text-purple-500"></i> <span class="mt-0.5">Module Configuration</span>
            </h2>

            <form class="space-y-4">
                @foreach($modules as $module)
                <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-b-0">
                    <label class="text-sm font-medium cursor-pointer" style="color: var(--text-primary);">
                        {{ $module->name }}
                    </label>
                    <x-admin.toggle-switch id="module-{{ $module->id }}" :checked="$module->enabled" />
                </div>
                @endforeach

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

