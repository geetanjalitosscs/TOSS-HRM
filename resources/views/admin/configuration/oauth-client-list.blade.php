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
                <div class="flex-shrink-0 flex items-center justify-end" style="width: 70px;">
                    <button class="w-7 h-7 flex items-center justify-center hover:bg-gray-100 transition-colors rounded" title="Copy">
                        <i class="fas fa-copy text-sm text-gray-600"></i>
                    </button>
                </div>
            </x-admin.table-row>
            @endforeach
        </x-admin.data-table>
    </x-main-layout>
@endsection

