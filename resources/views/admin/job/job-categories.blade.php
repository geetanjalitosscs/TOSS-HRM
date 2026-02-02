@extends('layouts.app')

@section('title', 'Admin - Job Categories')

@section('body')
    <x-main-layout title="Admin">
        <x-admin.tabs activeTab="job-categories" />

        <!-- Job Categories Section -->
        <section class="hr-card p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-folder text-purple-500"></i> Job Categories
                </h2>
                <x-admin.add-button />
            </div>
            <x-admin.data-table 
                title="" 
                :records="$categories"
                :columns="[
                    ['label' => 'Job Category']
                ]"
                :addButton="false">
                @foreach($categories as $category)
                <x-admin.table-row :record="$category">
                    <x-admin.table-cell bold>{{ $category->name }}</x-admin.table-cell>
                </x-admin.table-row>
                @endforeach
            </x-admin.data-table>
        </section>
    </x-main-layout>
@endsection
