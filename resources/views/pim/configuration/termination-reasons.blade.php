@extends('layouts.app')

@section('title', 'PIM - Termination Reasons')

@section('body')
    <x-main-layout title="PIM">
        <x-pim.tabs activeTab="configuration-termination-reasons" />

        <section class="hr-card p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-ban text-purple-500"></i> Termination Reasons
                </h2>
                <x-admin.add-button />
            </div>

            <!-- Records Count -->
            <div class="mb-4 text-xs text-slate-600 font-medium">
                ({{ count($terminationReasons) }}) Records Found
            </div>

            <!-- Table -->
            <x-admin.data-table 
                title="" 
                :records="$terminationReasons"
                :columns="[
                    ['label' => 'Name', 'sortable' => true]
                ]"
                :addButton="false">
                @foreach($terminationReasons as $reason)
                <x-admin.table-row>
                    <x-admin.table-cell>
                        <div class="text-xs font-medium text-gray-700">{{ $reason['name'] }}</div>
                    </x-admin.table-cell>
                </x-admin.table-row>
                @endforeach
            </x-admin.data-table>
        </section>
    </x-main-layout>
@endsection
