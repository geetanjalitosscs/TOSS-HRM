@extends('layouts.app')

@section('title', 'Admin - Licenses')

@section('body')
    <x-main-layout title="Admin / Qualifications">
        <x-admin.tabs activeTab="qualifications-licenses" />

        <x-admin.data-table 
            title="Licenses" 
            :records="$licenses"
            :columns="[
                ['label' => 'Name', 'sortable' => true, 'class' => 'flex-1']
            ]">
            @foreach($licenses as $license)
                <x-admin.table-row>
                    <x-admin.table-cell class="flex-1">{{ $license['name'] }}</x-admin.table-cell>
                </x-admin.table-row>
            @endforeach
        </x-admin.data-table>
    </x-main-layout>
@endsection

