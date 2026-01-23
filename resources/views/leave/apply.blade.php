@extends('layouts.app')

@section('title', 'Leave - Apply')

@section('body')
    <x-main-layout title="Leave">
        <x-leave.tabs activeTab="apply" />
        
        <!-- Apply Leave Section -->
        <section class="hr-card p-6">
            <h2 class="text-sm font-bold text-slate-800 flex items-baseline gap-2 mb-5">
                <i class="fas fa-calendar-plus text-purple-500"></i> <span class="mt-0.5">Apply Leave</span>
            </h2>
            
            <div class="text-center py-12">
                <p class="text-sm" style="color: var(--text-muted);">No Leave Types with Leave Balance</p>
            </div>
        </section>
    </x-main-layout>
@endsection

