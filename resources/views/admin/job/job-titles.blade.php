@extends('layouts.app')

@section('title', 'Admin - Job Titles')

@section('body')
    <x-main-layout title="Admin / Job">
        <x-admin.tabs activeTab="job-titles" />

        <!-- Job Titles Section -->
        <section class="hr-card p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-briefcase text-purple-500"></i> Job Titles
                </h2>
                <x-admin.add-button />
            </div>
            <x-admin.data-table 
                title="" 
                :records="$jobTitles"
                :columns="[
                    ['label' => 'Job Titles', 'sortable' => true],
                    ['label' => 'Job Description']
                ]"
                :addButton="false">
                @foreach($jobTitles as $jobTitle)
                <x-admin.table-row :record="$jobTitle">
                    <x-admin.table-cell bold>{{ $jobTitle['title'] }}</x-admin.table-cell>
                    <x-admin.table-cell>{{ $jobTitle['description'] ?: '-' }}</x-admin.table-cell>
                </x-admin.table-row>
                @endforeach
            </x-admin.data-table>
        </section>
    </x-main-layout>
@endsection
