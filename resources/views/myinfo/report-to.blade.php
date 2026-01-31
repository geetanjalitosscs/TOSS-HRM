@extends('layouts.app')

@section('title', 'My Info - Report-to')

@section('body')
    <x-main-layout title="My Info">
        <div class="flex items-stretch">
            @include('myinfo.partials.sidebar')

            <!-- Right Content Area -->
            <div class="flex-1">
                <div class="rounded-lg shadow-sm border border-purple-100 p-4 mb-3" style="background-color: var(--bg-card);">
                    <h2 class="text-sm font-bold text-slate-800 mb-3">Report-to</h2>
                    <div class="space-y-3">
                        <!-- Content will be added here -->
                    </div>
                </div>
            </div>
        </div>
    </x-main-layout>
@endsection
