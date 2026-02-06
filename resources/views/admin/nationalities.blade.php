@extends('layouts.app')

@section('title', 'Admin - Nationalities')

@section('body')
    <x-main-layout title="Admin / Nationalities">
        <x-admin.tabs activeTab="nationalities" />

        <section class="hr-card p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-flag text-[var(--color-primary)]"></i> Nationalities
                </h2>
                <x-admin.add-button />
            </div>
            <x-admin.data-table 
                title="" 
                :records="$nationalities"
                :columns="[
                    ['label' => 'Nationality', 'sortable' => true, 'class' => 'flex-1']
                ]"
                :addButton="false">
                @foreach($nationalities as $nationality)
                    <x-admin.table-row>
                        <x-admin.table-cell class="flex-1">{{ $nationality->name }}</x-admin.table-cell>
                    </x-admin.table-row>
                @endforeach
            </x-admin.data-table>
        </section>
    </x-main-layout>
@endsection

