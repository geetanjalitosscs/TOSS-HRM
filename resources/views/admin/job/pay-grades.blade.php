@extends('layouts.app')

@section('title', 'Admin - Pay Grades')

@section('body')
    <x-main-layout title="Admin / Job">
        <x-admin.tabs activeTab="pay-grades" />

        <!-- Pay Grades Section -->
        <section class="hr-card p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-dollar-sign text-purple-500"></i> Pay Grades
                </h2>
                <x-admin.add-button />
            </div>
            <x-admin.data-table 
                title="" 
                :records="$payGrades"
                :columns="[
                    ['label' => 'Name'],
                    ['label' => 'Currency']
                ]"
                :addButton="false">
                @foreach($payGrades as $payGrade)
                <x-admin.table-row :record="$payGrade">
                    <x-admin.table-cell bold>{{ $payGrade->name }}</x-admin.table-cell>
                    <x-admin.table-cell>{{ $payGrade->currency }}</x-admin.table-cell>
                </x-admin.table-row>
                @endforeach
            </x-admin.data-table>
        </section>
    </x-main-layout>
@endsection
