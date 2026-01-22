@extends('layouts.app')

@section('title', 'PIM - Reports')

@section('body')
    <x-main-layout title="PIM">
        <x-pim.tabs activeTab="reports" />

        <div class="bg-[var(--bg-card)] rounded-b-lg shadow-sm border border-purple-100 border-t-0 p-4">
            <!-- Employee Reports Search Panel -->
            <x-admin.search-panel title="Employee Reports" :collapsed="false">
                <div class="mb-3">
                    <label class="block text-xs font-medium text-slate-700 mb-1">Report Name</label>
                    <input type="text" class="hr-input w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" placeholder="Type for hints...">
                </div>
                <div class="flex justify-end gap-2">
                    <button class="hr-btn-secondary px-3 py-1.5 text-xs font-medium text-purple-600 border border-purple-300 rounded-lg hover:bg-purple-50 transition-all">
                        Reset
                    </button>
                    <button class="hr-btn-primary px-3 py-1.5 text-xs font-medium text-white bg-gradient-to-r from-[var(--color-hr-primary)] to-[var(--color-hr-primary-dark)] rounded-lg hover:shadow-md transition-all shadow-sm">
                        Search
                    </button>
                </div>
            </x-admin.search-panel>

            <!-- Add Button -->
            <div class="mb-3">
                <button class="hr-btn-primary px-4 py-1.5 text-xs font-bold text-white bg-gradient-to-r from-[var(--color-hr-primary)] to-[var(--color-hr-primary-dark)] rounded-lg hover:shadow-lg hover:shadow-purple-300/50 transition-all flex items-center gap-1 shadow-md hover:scale-105 transform">
                    + Add
                </button>
            </div>

            <!-- Records Count -->
            <div class="mb-3 text-xs text-slate-600 font-medium">
                ({{ count($reports) }}) Records Found
            </div>

            <!-- Table -->
            <x-admin.data-table 
                title="" 
                :records="$reports"
                :columns="[
                    ['label' => 'Name', 'sortable' => true]
                ]"
                :addButton="false"
                :showActions="true">
                @foreach($reports as $report)
                <x-admin.table-row>
                    <x-admin.table-cell>
                        <div class="text-xs font-medium text-gray-700">{{ $report['name'] }}</div>
                    </x-admin.table-cell>
                    <div class="flex-shrink-0 flex items-center justify-end" style="width: 70px;">
                        <button class="w-7 h-7 flex items-center justify-center hover:bg-gray-100 transition-colors rounded" title="Copy">
                            <i class="fas fa-copy text-sm text-gray-600"></i>
                        </button>
                    </div>
                </x-admin.table-row>
                @endforeach
            </x-admin.data-table>
        </div>
    </x-main-layout>
@endsection

