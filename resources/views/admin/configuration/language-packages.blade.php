@extends('layouts.app')

@section('title', 'Admin - Language Packages')

@section('body')
    <x-main-layout title="Admin / Configuration">
        <x-admin.tabs activeTab="configuration-language-packages" />

        <x-admin.data-table 
            title="Language Packages" 
            :records="$languages"
            :columns="[
                ['label' => 'Language Packages', 'sortable' => true]
            ]">
            @foreach($languages as $language)
            <x-admin.table-row>
                <x-admin.table-cell>
                    <div>
                        <div class="text-xs font-medium text-gray-700">{{ $language['name'] }}</div>
                        <div class="text-xs text-gray-500">{{ $language['native'] }}</div>
                    </div>
                </x-admin.table-cell>
                <div class="flex-shrink-0 flex items-center justify-center gap-1.5" style="width: 70px;">
                    <button class="w-5 h-5 flex items-center justify-center hover:bg-gray-100 transition-colors rounded" title="Move Up">
                        <i class="fas fa-arrow-up text-xs text-gray-600"></i>
                    </button>
                    <button class="w-5 h-5 flex items-center justify-center hover:bg-gray-100 transition-colors rounded" title="Move Down">
                        <i class="fas fa-arrow-down text-xs text-gray-600"></i>
                    </button>
                </div>
            </x-admin.table-row>
            @endforeach
        </x-admin.data-table>
    </x-main-layout>
@endsection
