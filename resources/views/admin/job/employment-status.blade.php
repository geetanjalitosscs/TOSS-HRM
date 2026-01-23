@extends('layouts.app')

@section('title', 'Admin - Employment Status')

@section('body')
    <x-main-layout title="Admin / Job">
        <x-admin.tabs activeTab="employment-status" />

        <!-- Employment Status Section -->
        <section class="hr-card p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-user-check text-purple-500"></i> Employment Status
                </h2>
                <x-admin.add-button />
            </div>
            <x-admin.data-table 
                title="" 
                :records="$statuses"
                :columns="[
                    ['label' => 'Employment Status']
                ]"
                :addButton="false">
                @foreach($statuses as $status)
                <x-admin.table-row :record="$status">
                    <x-admin.table-cell bold>{{ $status['name'] }}</x-admin.table-cell>
                </x-admin.table-row>
                @endforeach
            </x-admin.data-table>
        </section>
    </x-main-layout>
@endsection
