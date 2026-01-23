@extends('layouts.app')

@section('title', 'PIM - Custom Fields')

@section('body')
    <x-main-layout title="PIM">
        <x-pim.tabs activeTab="configuration-custom-fields" />

        <section class="hr-card p-6">
            <div class="flex items-center justify-between mb-5" style="overflow: visible;">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-list-alt text-purple-500"></i> Custom Fields
                </h2>
                <div class="flex items-center gap-3" style="position: relative; z-index: 10; overflow: visible;">
                    <span class="text-xs text-gray-600">Remaining number of custom fields: 8</span>
                    <x-admin.add-button class="mb-0" />
                </div>
            </div>

            <!-- Records Count -->
            <div class="mb-4 text-xs text-slate-600 font-medium">
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
        </section>
    </x-main-layout>
@endsection
