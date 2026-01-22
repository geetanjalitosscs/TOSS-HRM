@extends('layouts.app')

@section('title', 'Admin - Employment Status')

@section('body')
    <x-main-layout title="Admin / Job">
        <x-admin.tabs activeTab="employment-status" />

        <!-- Employment Status Section -->
        <x-admin.data-table 
            title="Employment Status" 
            :records="$statuses"
            :columns="[
                ['label' => 'Employment Status']
            ]">
            @foreach($statuses as $status)
            <x-admin.table-row :record="$status">
                <x-admin.table-cell bold>{{ $status['name'] }}</x-admin.table-cell>
            </x-admin.table-row>
            @endforeach
        </x-admin.data-table>
    </x-main-layout>
@endsection
