@extends('layouts.app')

@section('title', 'Admin - Locations')

@section('body')
    <x-main-layout title="Admin / Organization">
        <x-admin.tabs activeTab="organization-locations" />

        <!-- Search Panel -->
        <x-admin.search-panel>
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
            <div class="flex gap-2">
                <button class="px-4 py-2 border border-green-600 text-green-600 rounded-md text-sm font-medium hover:bg-green-50 transition-colors">
                    Reset
                </button>
                <button class="px-4 py-2 bg-green-600 text-white rounded-md text-sm font-medium hover:bg-green-700 transition-colors">
                    Search
                </button>
            </div>
        </x-admin.search-panel>

        <!-- Locations Table -->
        <x-admin.data-table 
            title="Locations" 
            :records="$locations"
            :columns="[
                ['label' => 'Name', 'sortable' => true],
                ['label' => 'City', 'sortable' => true],
                ['label' => 'Country', 'sortable' => true],
                ['label' => 'Phone', 'sortable' => true],
                ['label' => 'Number of Employees', 'sortable' => true]
            ]">
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
    </x-main-layout>
@endsection

