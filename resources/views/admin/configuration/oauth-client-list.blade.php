@extends('layouts.app')

@section('title', 'Admin - OAuth Client List')

@section('body')
    <x-main-layout title="Admin / Configuration">
        <x-admin.tabs activeTab="configuration-oauth-client-list" />

        <x-admin.data-table 
            title="OAuth Client List" 
            :records="$oauthClients"
            :columns="[
                ['label' => 'Name', 'sortable' => true],
                ['label' => 'Redirect URI', 'sortable' => false],
                ['label' => 'Status', 'sortable' => false]
            ]">
            @foreach($oauthClients as $client)
            <x-admin.table-row>
                <x-admin.table-cell>
                    <div class="text-xs font-medium text-gray-700">{{ $client['name'] }}</div>
                </x-admin.table-cell>
                <x-admin.table-cell>
                    <div class="text-xs text-gray-600">{{ $client['redirect_uri'] }}</div>
                </x-admin.table-cell>
                <x-admin.table-cell>
                    <span class="text-xs px-2 py-1 rounded-full {{ $client['status'] === 'Enabled' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                        {{ $client['status'] }}
                    </span>
                </x-admin.table-cell>
                <div class="flex-shrink-0 flex items-center justify-center gap-2" style="width: 70px;">
                    <button class="w-6 h-6 rounded-full flex items-center justify-center hover:bg-purple-50 transition-colors" title="Edit">
                        <i class="fas fa-edit text-xs" style="color: var(--color-hr-primary);"></i>
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

