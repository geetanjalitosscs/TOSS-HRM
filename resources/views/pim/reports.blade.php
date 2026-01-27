@extends('layouts.app')

@section('title', 'PIM - Reports')

@section('body')
    <x-main-layout title="PIM">
        <x-pim.tabs activeTab="reports" />

        <div class="space-y-6">
            <!-- Employee Reports Search Panel Card -->
            <section class="hr-card p-6">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2 mb-5">
                    <i class="fas fa-search text-purple-500"></i> Employee Reports
                </h2>
                <div class="mb-3">
                    <label class="block text-xs font-medium text-slate-700 mb-1">Report Name</label>
                    <input type="text" class="hr-input w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" placeholder="Type for hints...">
                </div>
                <x-admin.action-buttons />
            </section>

            <!-- Reports List Card -->
            <section class="hr-card p-6">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-file-alt text-purple-500"></i> Reports List
                    </h2>
                    <x-admin.add-button />
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
                        <div class="text-xs font-medium text-gray-700">{{ $report->name }}</div>
                    </x-admin.table-cell>
                    <div class="flex-shrink-0 flex items-center justify-end" style="width: 30px;">
                        <button class="hr-action-copy flex-shrink-0" title="Copy">
                            <i class="fas fa-copy text-sm"></i>
                        </button>
                    </div>
                </x-admin.table-row>
                @endforeach
            </x-admin.data-table>
            </section>
        </div>
    </x-main-layout>
@endsection

