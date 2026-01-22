@extends('layouts.app')

@section('title', 'Admin - Nationalities')

@section('body')
    <x-main-layout title="Admin / Nationalities">
        <x-admin.tabs activeTab="nationalities" />

        <x-admin.data-table 
            title="Nationalities" 
            :records="$nationalities"
            :columns="[
                ['label' => 'Nationality', 'sortable' => true, 'class' => 'flex-1']
            ]">
            @foreach($nationalities as $nationality)
                <x-admin.table-row>
                    <x-admin.table-cell class="flex-1">{{ $nationality['name'] }}</x-admin.table-cell>
                </x-admin.table-row>
            @endforeach
        </x-admin.data-table>
    </x-main-layout>
@endsection

