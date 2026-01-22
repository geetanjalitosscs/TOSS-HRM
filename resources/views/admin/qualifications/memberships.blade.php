@extends('layouts.app')

@section('title', 'Admin - Memberships')

@section('body')
    <x-main-layout title="Admin / Qualifications">
        <x-admin.tabs activeTab="qualifications-memberships" />

        <x-admin.data-table 
            title="Memberships" 
            :records="$memberships"
            :columns="[
                ['label' => 'Membership', 'sortable' => true, 'class' => 'flex-1']
            ]">
            @foreach($memberships as $membership)
                <x-admin.table-row>
                    <x-admin.table-cell class="flex-1">{{ $membership['name'] }}</x-admin.table-cell>
                </x-admin.table-row>
            @endforeach
        </x-admin.data-table>
    </x-main-layout>
@endsection

