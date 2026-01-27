@extends('layouts.app')

@section('title', 'Leave - Work Week')

@section('body')
    <x-main-layout title="Leave / Configure">
        <x-leave.tabs activeTab="work-week" />
        
        <!-- Work Week Section -->
        <section class="hr-card p-6">
            <h2 class="text-sm font-bold flex items-baseline gap-2 mb-5" style="color: var(--text-primary);">
                <i class="fas fa-calendar-week" style="color: var(--color-hr-primary);"></i>
                <span class="mt-0.5">Work Week</span>
            </h2>
            
            <form>
                <!-- Days of Week -->
                <div class="space-y-4 mb-6">
                    @foreach($days as $day)
                    <div>
                        <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                            {{ $day->name }} <span style="color: var(--color-danger);">*</span>
                        </label>
                        <select class="w-full px-3 py-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all" style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);">
                            <option value="full_day" {{ $day->value === 'full_day' ? 'selected' : '' }}>Full Day</option>
                            <option value="half_day" {{ $day->value === 'half_day' ? 'selected' : '' }}>Half Day</option>
                            <option value="non_working" {{ $day->value === 'non_working' ? 'selected' : '' }}>Non-working Day</option>
                        </select>
                    </div>
                    @endforeach
                </div>
                
                <!-- Required Text and Save Button -->
                <div class="flex items-center justify-between mt-6">
                    <div class="text-xs" style="color: var(--text-muted);">
                        <span style="color: var(--color-danger);">*</span> Required
                    </div>
                    <div>
                        <button type="submit" class="hr-btn-primary px-4 py-2 text-sm rounded-lg transition-all">
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </section>
    </x-main-layout>
@endsection
