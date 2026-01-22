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
                <div class="flex-shrink-0 flex items-center justify-center gap-2" style="width: 70px;">
                    <button class="w-6 h-6 rounded-full flex items-center justify-center hover:bg-purple-50 transition-colors" title="Upload">
                        <i class="fas fa-upload text-xs" style="color: var(--color-hr-primary);"></i>
                    </button>
                    <button class="w-6 h-6 rounded-full flex items-center justify-center hover:bg-purple-50 transition-colors" title="Download">
                        <i class="fas fa-download text-xs" style="color: var(--color-hr-primary);"></i>
                    </button>
                    <button class="w-6 h-6 rounded-full flex items-center justify-center hover:bg-red-50 transition-colors" title="Delete">
                        <i class="fas fa-trash-alt text-xs text-red-600"></i>
                    </button>
                </div>
            </x-admin.table-row>
            @endforeach
        </x-admin.data-table>
    </x-main-layout>
@endsection
