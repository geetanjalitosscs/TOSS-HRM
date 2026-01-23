@extends('layouts.app')

@section('title', 'Admin - Licenses')

@section('body')
    <x-main-layout title="Admin / Qualifications">
        <x-admin.tabs activeTab="qualifications-licenses" />

        <section class="hr-card p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-certificate text-purple-500"></i> Licenses
                </h2>
                <x-admin.add-button />
            </div>
            <x-admin.data-table 
                title="" 
                :records="$licenses"
                :columns="[
                    ['label' => 'Name', 'sortable' => true, 'class' => 'flex-1']
                ]"
                :addButton="false">
                @foreach($licenses as $license)
                    <x-admin.table-row>
                        <x-admin.table-cell class="flex-1">{{ $license['name'] }}</x-admin.table-cell>
                    </x-admin.table-row>
                @endforeach
            </x-admin.data-table>
        </section>
    </x-main-layout>
@endsection

