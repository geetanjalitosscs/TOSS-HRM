@extends('layouts.app')

@section('title', 'Admin - Social Media Authentication')

@section('body')
    <x-main-layout title="Admin / Configuration">
        <x-admin.tabs activeTab="configuration-social-media-authentication" />

        <section class="hr-card p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-sm font-bold text-slate-800 flex items-baseline gap-2">
                    <i class="fas fa-share-alt text-[var(--color-primary)]"></i> <span class="mt-0.5">Provider List</span>
                </h2>
                <button class="hr-btn-primary px-4 py-1.5 text-xs font-bold text-white bg-gradient-to-r from-[var(--color-hr-primary)] to-[var(--color-hr-primary-dark)] rounded-lg hover:shadow-lg hover:shadow-[var(--color-primary-light)] transition-all flex items-center gap-1 shadow-md hover:scale-105 transform">
                    <span class="text-sm font-bold">+</span> Add
                </button>
            </div>

            @if(isset($providers) && count($providers) > 0)
            <x-records-found :count="count($providers)" />
            @endif

            <div class="hr-table-wrapper" style="max-height: 22rem; overflow-y: auto;">
                <div class="bg-gray-50 rounded-t-lg px-2 py-1.5 flex items-center gap-1 border-b border-gray-200">
                    <div class="flex-shrink-0" style="width: 24px;">
                        <input type="checkbox" class="rounded border-gray-300 text-[var(--color-hr-primary)] focus:ring-2 focus:ring-[var(--color-hr-primary)] w-3.5 h-3.5">
                    </div>
                    <div class="flex-1">
                        <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide">Name</div>
                    </div>
                    <div class="flex-1">
                        <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide">Status</div>
                    </div>
                    <div class="flex-shrink-0" style="width: 70px;">
                        <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide text-center">Actions</div>
                    </div>
                </div>
                <div class="border border-gray-200 border-t-0 rounded-b-lg">
                    @forelse($providers as $provider)
                        <div class="flex items-center gap-1 px-2 py-1.5 border-b last:border-b-0" style="border-color: var(--border-default);">
                            <div class="flex-shrink-0" style="width: 24px;">
                                <input type="checkbox" class="rounded border-gray-300 text-[var(--color-hr-primary)] w-3.5 h-3.5">
                            </div>
                            <div class="flex-1">
                                <div class="text-xs text-gray-700">{{ $provider->name }}</div>
                            </div>
                            <div class="flex-1">
                                <span class="text-xs px-2 py-0.5 rounded-full {{ $provider->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                    {{ $provider->is_active ? 'Enabled' : 'Disabled' }}
                                </span>
                            </div>
                            <div class="flex-shrink-0" style="width: 70px;">
                                <div class="flex items-center justify-center gap-2">
                                    <button class="hr-action-edit" title="Edit">
                                        <i class="fas fa-edit text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="py-12 text-center text-sm text-gray-500">
                            No Records Found
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    </x-main-layout>
@endsection

