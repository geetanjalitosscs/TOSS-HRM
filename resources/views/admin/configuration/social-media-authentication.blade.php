@extends('layouts.app')

@section('title', 'Admin - Social Media Authentication')

@section('body')
    <x-main-layout title="Admin / Configuration">
        <x-admin.tabs activeTab="configuration-social-media-authentication" />

        <div class="bg-[var(--bg-card)] rounded-b-lg shadow-sm border border-purple-100 border-t-0 p-4">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-sm font-bold" style="color: var(--text-primary);">Provider List</h2>
                <button class="hr-btn-primary px-4 py-1.5 text-xs font-bold text-white bg-gradient-to-r from-[var(--color-hr-primary)] to-[var(--color-hr-primary-dark)] rounded-lg hover:shadow-lg hover:shadow-purple-300/50 transition-all flex items-center gap-1 shadow-md hover:scale-105 transform">
                    <span class="text-sm font-bold">+</span> Add
                </button>
            </div>

            <!-- Empty State -->
            <div class="hr-table-wrapper">
                <div class="bg-gray-50 rounded-t-lg px-2 py-1.5 flex items-center gap-1 border-b border-gray-200">
                    <div class="flex-shrink-0" style="width: 24px;">
                        <input type="checkbox" class="rounded border-gray-300 text-[var(--color-hr-primary)] focus:ring-2 focus:ring-[var(--color-hr-primary)] w-3.5 h-3.5">
                    </div>
                    <div class="flex-1">
                        <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide">Name</div>
                    </div>
                    <div class="flex-shrink-0" style="width: 70px;">
                        <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide text-center">Actions</div>
                    </div>
                </div>
                <div class="border border-gray-200 border-t-0 rounded-b-lg py-12">
                    <div class="text-center text-sm text-gray-500">No Records Found</div>
                </div>
            </div>
        </div>
    </x-main-layout>
@endsection

