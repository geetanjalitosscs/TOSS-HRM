@extends('layouts.app')

@section('title', 'Admin - Languages')

@section('body')
    <x-main-layout title="Admin / Qualifications">
        <x-admin.tabs activeTab="qualifications-languages" />

        <x-admin.data-table 
            title="Languages" 
            :records="$languages"
            :columns="[
                ['label' => 'Name', 'sortable' => true, 'class' => 'flex-1']
            ]">
            @foreach($languages as $language)
                <x-admin.table-row>
                    <x-admin.table-cell class="flex-1">{{ $language['name'] }}</x-admin.table-cell>
                </x-admin.table-row>
            @endforeach
        </x-admin.data-table>
    </x-main-layout>
@endsection

