@extends('layouts.app')

@section('title', 'Admin - Memberships')

@section('body')
    <x-main-layout title="Admin / Qualifications">
        <x-admin.tabs activeTab="qualifications-memberships" />

        <section class="hr-card p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-users text-purple-500"></i> Memberships
                </h2>
                <x-admin.add-button />
            </div>
            <x-admin.data-table 
                title="" 
                :records="$memberships"
                :columns="[
                    ['label' => 'Membership', 'sortable' => true, 'class' => 'flex-1']
                ]"
                :addButton="false">
                @foreach($memberships as $membership)
                    <x-admin.table-row>
                        <x-admin.table-cell class="flex-1">{{ $membership['name'] }}</x-admin.table-cell>
                    </x-admin.table-row>
                @endforeach
            </x-admin.data-table>
        </section>
    </x-main-layout>
@endsection

