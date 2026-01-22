@extends('layouts.app')

@section('title', 'Admin - Job Categories')

@section('body')
    <x-main-layout title="Admin / Job">
        <x-admin.tabs activeTab="job-categories" />

        <!-- Job Categories Section -->
        <x-admin.data-table 
            title="Job Categories" 
            :records="$categories"
            :columns="[
                ['label' => 'Job Category']
            ]">
            @foreach($categories as $category)
            <x-admin.table-row :record="$category">
                <x-admin.table-cell bold>{{ $category['name'] }}</x-admin.table-cell>
            </x-admin.table-row>
            @endforeach
        </x-admin.data-table>
    </x-main-layout>
@endsection
