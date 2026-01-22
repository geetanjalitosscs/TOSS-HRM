@extends('layouts.app')

@section('title', 'PIM - Custom Fields')

@section('body')
    <x-main-layout title="PIM">
        <x-pim.tabs activeTab="configuration-custom-fields" />

        <div class="bg-[var(--bg-card)] rounded-b-lg shadow-sm border border-purple-100 border-t-0 p-4">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-sm font-bold text-slate-800">Custom Fields</h2>
                <div class="flex items-center gap-3">
                    <span class="text-xs text-gray-600">Remaining number of custom fields: 8</span>
                    <button class="hr-btn-primary px-4 py-1.5 text-xs font-bold text-white bg-gradient-to-r from-[var(--color-hr-primary)] to-[var(--color-hr-primary-dark)] rounded-lg hover:shadow-lg hover:shadow-purple-300/50 transition-all flex items-center gap-1 shadow-md hover:scale-105 transform">
                        + Add
                    </button>
                </div>
            </div>

            <!-- Records Count -->
            <div class="mb-3 text-xs text-slate-600 font-medium">
                ({{ count($customFields) }}) Records Found
            </div>

            <!-- Table -->
            <x-admin.data-table 
                title="" 
                :records="$customFields"
                :columns="[
                    ['label' => 'Custom Field Name', 'sortable' => false],
                    ['label' => 'Screen', 'sortable' => false],
                    ['label' => 'Field Type', 'sortable' => false]
                ]"
                :addButton="false">
                @foreach($customFields as $field)
                <x-admin.table-row>
                    <x-admin.table-cell>
                        <div class="text-xs font-medium text-gray-700">{{ $field['name'] }}</div>
                    </x-admin.table-cell>
                    <x-admin.table-cell>
                        <div class="text-xs text-gray-700">{{ $field['screen'] }}</div>
                    </x-admin.table-cell>
                    <x-admin.table-cell>
                        <div class="text-xs text-gray-700">{{ $field['field_type'] }}</div>
                    </x-admin.table-cell>
                </x-admin.table-row>
                @endforeach
            </x-admin.data-table>
        </div>
    </x-main-layout>
@endsection
