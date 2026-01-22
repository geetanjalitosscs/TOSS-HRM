@extends('layouts.app')

@section('title', 'Admin - Skills')

@section('body')
    <x-main-layout title="Admin / Qualifications">
        <x-admin.tabs activeTab="qualifications-skills" />

        <x-admin.data-table 
            title="Skills" 
            :records="$skills"
            :columns="[
                ['label' => 'Name', 'sortable' => true, 'class' => 'flex-1'],
                ['label' => 'Description', 'sortable' => true, 'class' => 'flex-1']
            ]">
            @foreach($skills as $skill)
                <x-admin.table-row>
                    <x-admin.table-cell class="flex-1">{{ $skill['name'] }}</x-admin.table-cell>
                    <x-admin.table-cell class="flex-1">{{ $skill['description'] ?: '-' }}</x-admin.table-cell>
                </x-admin.table-row>
            @endforeach
        </x-admin.data-table>
    </x-main-layout>
@endsection

