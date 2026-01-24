@extends('layouts.app')

@section('title', 'Leave - Leave Types')

@section('body')
    <x-main-layout title="Leave / Configure">
        <x-leave.tabs activeTab="leave-types" />
        
        <!-- Leave Types Section -->
        <section class="hr-card p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-sm font-bold flex items-baseline gap-2" style="color: var(--text-primary);">
                    <i class="fas fa-list" style="color: var(--color-hr-primary);"></i>
                    <span class="mt-0.5">Leave Types</span>
                </h2>
                <x-admin.add-button label="+ Add" />
            </div>
            
            @if(isset($leaveTypes) && count($leaveTypes) > 0)
            <!-- Records Count -->
            <x-records-found :count="count($leaveTypes)" />
            @else
            <!-- Records Count -->
            <x-records-found :count="10" />
            @endif
            
            <!-- Table Header -->
            <div class="rounded-t-lg pl-1 pr-2 py-1.5 flex items-center gap-1 border-b" style="background-color: var(--bg-hover); border-color: var(--border-default);">
                <div class="flex-shrink-0" style="width: 24px;">
                    <input type="checkbox" class="rounded w-3.5 h-3.5" style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                </div>
                <div class="flex-1" style="min-width: 0;">
                    <span class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Name</span>
                </div>
                <div class="flex-shrink-0" style="width: 90px;">
                    <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words text-center" style="color: var(--text-primary);">Actions</div>
                </div>
            </div>
            
            <!-- Table Rows -->
            <div class="border border-t-0 rounded-b-lg" style="border-color: var(--border-default);">
                @php
                    $leaveTypes = [
                        'CAN - Bereavement', 'CAN - FMLA', 'CAN - Maternity', 'CAN - Personal', 'CAN - Vacation',
                        'US - Bereavement', 'US - FMLA', 'US - Maternity', 'US - Personal', 'US - Vacation'
                    ];
                @endphp
                @foreach($leaveTypes as $type)
                <div class="border-b last:border-b-0 pl-1 pr-2 py-1.5 transition-colors flex items-center gap-1" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
                    <div class="flex-shrink-0" style="width: 24px;">
                        <input type="checkbox" class="rounded w-3.5 h-3.5" style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs font-medium break-words" style="color: var(--text-primary);">{{ $type }}</div>
                    </div>
                    <div class="flex-shrink-0" style="width: 90px;">
                        <div class="flex items-center justify-center gap-2">
                            <button class="hr-action-edit flex-shrink-0" title="Edit">
                                <i class="fas fa-edit text-sm"></i>
                            </button>
                            <button class="hr-action-delete flex-shrink-0" title="Delete">
                                <i class="fas fa-trash-alt text-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
    </x-main-layout>
@endsection
