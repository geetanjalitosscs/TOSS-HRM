@extends('layouts.app')

@section('title', 'Admin - Locations')

@section('body')
    <x-main-layout title="Admin / Organization">
        <x-admin.tabs activeTab="organization-locations" />

        <!-- Search Panel -->
        <section class="hr-card p-6 mb-6">
            <h2 class="text-sm font-bold text-slate-800 flex items-baseline gap-2 mb-5">
                <i class="fas fa-search text-purple-500"></i> <span class="mt-0.5">Location Search</span>
            </h2>
            <x-admin.search-panel title="">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <x-admin.form-field 
                    label="Name" 
                    name="search_name" 
                    placeholder="" 
                    :required="false"
                    :readonly="false" />
                
                <x-admin.form-field 
                    label="City" 
                    name="search_city" 
                    placeholder="" 
                    :required="false"
                    :readonly="false" />
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                    <select name="search_country" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-transparent">
                        <option value="">-- Select --</option>
                        <option value="United States">United States</option>
                        <option value="Canada">Canada</option>
                    </select>
                </div>
            </div>
            <x-admin.action-buttons />
        </x-admin.search-panel>
        </section>

        <!-- Locations Table -->
        <section class="hr-card p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-map-marker-alt text-purple-500"></i> Locations
                </h2>
                <x-admin.add-button />
            </div>
            <x-admin.data-table 
                title="" 
                :records="$locations"
                :columns="[
                    ['label' => 'Name', 'sortable' => true],
                    ['label' => 'City', 'sortable' => true],
                    ['label' => 'Country', 'sortable' => true],
                    ['label' => 'Phone', 'sortable' => true],
                    ['label' => 'Number of Employees', 'sortable' => true]
                ]"
                :addButton="false">
                @foreach($locations as $location)
                <x-admin.table-row :record="$location">
                    <x-admin.table-cell bold>{{ $location['name'] }}</x-admin.table-cell>
                    <x-admin.table-cell>{{ $location['city'] }}</x-admin.table-cell>
                    <x-admin.table-cell>{{ $location['country'] }}</x-admin.table-cell>
                    <x-admin.table-cell>{{ $location['phone'] }}</x-admin.table-cell>
                    <x-admin.table-cell>{{ $location['num_employees'] }}</x-admin.table-cell>
                </x-admin.table-row>
                @endforeach
            </x-admin.data-table>
        </section>
    </x-main-layout>
@endsection

