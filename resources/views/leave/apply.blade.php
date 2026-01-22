@extends('layouts.app')

@section('title', 'Leave - Apply')

@section('body')
    <x-main-layout title="Leave">
        <x-leave.tabs activeTab="apply" />
        
        <!-- Apply Leave Section -->
        <div class="rounded-lg shadow-sm border p-6" style="background-color: var(--bg-card); border-color: var(--border-default);">
            <h2 class="text-lg font-bold mb-4" style="color: var(--text-primary);">Apply Leave</h2>
            
            <div class="text-center py-12">
                <p class="text-sm" style="color: var(--text-muted);">No Leave Types with Leave Balance</p>
            </div>
        </div>
    </x-main-layout>
@endsection

