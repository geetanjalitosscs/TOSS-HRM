@extends('layouts.app')

@section('title', 'Admin - Pay Grades')

@section('body')
    <x-main-layout title="Admin / Job">
        <x-admin.tabs activeTab="pay-grades" />

        <!-- Pay Grades Section -->
        <x-admin.data-table 
            title="Pay Grades" 
            :records="$payGrades"
            :columns="[
                ['label' => 'Name'],
                ['label' => 'Currency']
            ]">
            @foreach($payGrades as $payGrade)
            <x-admin.table-row :record="$payGrade">
                <x-admin.table-cell bold>{{ $payGrade['name'] }}</x-admin.table-cell>
                <x-admin.table-cell>{{ $payGrade['currency'] }}</x-admin.table-cell>
            </x-admin.table-row>
            @endforeach
        </x-admin.data-table>
    </x-main-layout>
@endsection
