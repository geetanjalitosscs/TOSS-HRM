@extends('layouts.app')

@section('title', 'Admin - Education')

@section('body')
    <x-main-layout title="Admin / Qualifications">
        <x-admin.tabs activeTab="qualifications-education" />

        <x-admin.data-table 
            title="Education" 
            :records="$education"
            :columns="[
                ['label' => 'Name', 'sortable' => true, 'class' => 'flex-1']
            ]">
            @foreach($education as $edu)
                <x-admin.table-row>
                    <x-admin.table-cell class="flex-1">{{ $edu['name'] }}</x-admin.table-cell>
                </x-admin.table-row>
            @endforeach
        </x-admin.data-table>
    </x-main-layout>
@endsection

