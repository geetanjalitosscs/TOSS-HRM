@extends('layouts.app')

@section('title', 'Admin - OAuth Client List')

@section('body')
    <x-main-layout title="Admin / Configuration">
        <x-admin.tabs activeTab="configuration-oauth-client-list" />

        <section class="hr-card p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-key text-purple-500"></i> OAuth Client List
                </h2>
                <x-admin.add-button />
            </div>

        <x-admin.data-table 
                title="" 
            :records="$oauthClients"
            :columns="[
                ['label' => 'Name', 'sortable' => true],
                ['label' => 'Redirect URI', 'sortable' => false],
                ['label' => 'Status', 'sortable' => false]
                ]"
                :addButton="false">
            @foreach($oauthClients as $client)
            <x-admin.table-row>
                <x-admin.table-cell>
                    <div class="text-xs font-medium text-gray-700">{{ $client->name }}</div>
                </x-admin.table-cell>
                <x-admin.table-cell>
                    <div class="text-xs text-gray-600">{{ $client->redirect_uri }}</div>
                </x-admin.table-cell>
                <x-admin.table-cell>
                    <span class="text-xs px-2 py-1 rounded-full {{ $client->status === 'Enabled' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                        {{ $client->status }}
                    </span>
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
    </x-main-layout>
@endsection

