@extends('layouts.app')

@section('title', 'Admin - Work Shifts')

@section('body')
    <x-main-layout title="Admin / Job">
        <x-admin.tabs activeTab="work-shifts" />

        <!-- Work Shifts Section -->
        <section class="hr-card p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-clock text-purple-500"></i> Work Shifts
                </h2>
                <x-admin.add-button />
            </div>

            @if(isset($shifts) && count($shifts) > 0)
            <x-admin.data-table 
                title="" 
                :records="$shifts"
                :columns="[
                    ['label' => 'Name'],
                    ['label' => 'From'],
                    ['label' => 'To'],
                    ['label' => 'Hours Per Day']
                ]"
                :addButton="false">
                @foreach($shifts as $shift)
                <x-admin.table-row :record="$shift">
                    <x-admin.table-cell bold>{{ $shift->name }}</x-admin.table-cell>
                    <x-admin.table-cell>{{ $shift->start_time_formatted }}</x-admin.table-cell>
                    <x-admin.table-cell>{{ $shift->end_time_formatted }}</x-admin.table-cell>
                    <x-admin.table-cell>{{ $shift->hours }}</x-admin.table-cell>
                </x-admin.table-row>
                @endforeach
            </x-admin.data-table>
            @else
            <!-- No Data Found - Centered Message -->
            <div class="flex flex-col items-center justify-center min-h-[220px]">
                <div class="mb-3 text-xs font-medium" style="color: var(--text-muted);">
                    No Data Found
                </div>
            </div>
            @endif
        </section>
    </x-main-layout>
@endsection
