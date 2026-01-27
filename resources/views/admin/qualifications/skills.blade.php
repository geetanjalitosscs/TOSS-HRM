@extends('layouts.app')

@section('title', 'Admin - Skills')

@section('body')
    <x-main-layout title="Admin / Qualifications">
        <x-admin.tabs activeTab="qualifications-skills" />

        <section class="hr-card p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-tools text-purple-500"></i> Skills
                </h2>
                <x-admin.add-button />
            </div>
            <x-admin.data-table 
                title="" 
                :records="$skills"
                :columns="[
                    ['label' => 'Name', 'sortable' => true, 'class' => 'flex-1'],
                    ['label' => 'Description', 'sortable' => true, 'class' => 'flex-1']
                ]"
                :addButton="false">
                @foreach($skills as $skill)
                    <x-admin.table-row>
                        <x-admin.table-cell class="flex-1">{{ $skill->name }}</x-admin.table-cell>
                        <x-admin.table-cell class="flex-1">{{ $skill->description ?: '-' }}</x-admin.table-cell>
                    </x-admin.table-row>
                @endforeach
            </x-admin.data-table>
        </section>
    </x-main-layout>
@endsection

