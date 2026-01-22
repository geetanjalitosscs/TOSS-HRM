@extends('layouts.app')

@section('title', 'Admin - Job Titles')

@section('body')
    <x-main-layout title="Admin / Job">
        <x-admin.tabs activeTab="job-titles" />

        <!-- Job Titles Section -->
        <x-admin.data-table 
            title="Job Titles" 
            :records="$jobTitles"
            :columns="[
                ['label' => 'Job Titles', 'sortable' => true],
                ['label' => 'Job Description']
            ]">
            @foreach($jobTitles as $jobTitle)
            <x-admin.table-row :record="$jobTitle">
                <x-admin.table-cell bold>{{ $jobTitle['title'] }}</x-admin.table-cell>
                <x-admin.table-cell>{{ $jobTitle['description'] ?: '-' }}</x-admin.table-cell>
            </x-admin.table-row>
            @endforeach
        </x-admin.data-table>
    </x-main-layout>
@endsection
