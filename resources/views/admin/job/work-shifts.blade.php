@extends('layouts.app')

@section('title', 'Admin - Work Shifts')

@section('body')
    <x-main-layout title="Admin / Job">
        <x-admin.tabs activeTab="work-shifts" />

        <!-- Work Shifts Section -->
        <x-admin.data-table 
            title="Work Shifts" 
            :records="$shifts"
            :columns="[
                ['label' => 'Name'],
                ['label' => 'From'],
                ['label' => 'To'],
                ['label' => 'Hours Per Day']
            ]">
            @foreach($shifts as $shift)
            <x-admin.table-row :record="$shift">
                <x-admin.table-cell bold>{{ $shift['name'] }}</x-admin.table-cell>
                <x-admin.table-cell>{{ $shift['from'] }}</x-admin.table-cell>
                <x-admin.table-cell>{{ $shift['to'] }}</x-admin.table-cell>
                <x-admin.table-cell>{{ $shift['hours'] }}</x-admin.table-cell>
            </x-admin.table-row>
            @endforeach
        </x-admin.data-table>
    </x-main-layout>
@endsection
