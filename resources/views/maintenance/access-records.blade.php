@extends('layouts.app')

@section('title', 'Maintenance / Access Records')

@section('body')
    <x-main-layout title="Maintenance">
        <!-- Top Navigation Tabs -->
        <div class="hr-sticky-tabs">
            <div class="flex items-center border-b border-purple-100 overflow-y-visible">
                <x-dropdown-menu 
                    :items="[
                        ['url' => route('maintenance.purge-employee'), 'label' => 'Employee Records', 'active' => false],
                        ['url' => route('maintenance.purge-candidate'), 'label' => 'Candidate Records', 'active' => false]
                    ]"
                    position="left"
                    width="w-48">
                    <div class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all">
                        <span class="text-sm font-medium text-slate-700">Purge Records</span>
                        <x-dropdown-arrow color="#a78bfa" />
                    </div>
                </x-dropdown-menu>
                <div class="px-6 py-3 border-b-2 border-[var(--color-hr-primary)] bg-purple-50/50">
                    <span class="text-sm font-semibold text-[var(--color-hr-primary-dark)]">Access Records</span>
                </div>
            </div>
        </div>

        <!-- Download Personal Data Section -->
        <section class="hr-card p-6">
            <h2 class="text-sm font-bold text-slate-800 flex items-baseline gap-2 mb-5">
                <i class="fas fa-download text-purple-500"></i> <span class="mt-0.5">Download Personal Data</span>
            </h2>

                <!-- Filter Form -->
                <div class="bg-purple-50/30 rounded-lg p-3 mb-3 border border-purple-100">
                    <div class="flex items-start gap-3">
                        <div class="flex-1">
                            <label class="block text-xs font-medium text-slate-700 mb-1">Employee Name*</label>
                            <input type="text" class="hr-input w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" placeholder="Type for hints...">
                            <div class="text-xs text-gray-500 mt-1">* Required</div>
                        </div>
                        <div class="pt-5">
                            <button class="hr-btn-primary px-4 py-2.5 text-xs font-medium whitespace-nowrap">
                                Search
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Note Section -->
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <h3 class="text-xs font-bold text-slate-800 mb-2">Note</h3>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Users who seek access to their data, or who seek to correct, amend, or delete the given information should direct their requests to <span class="font-medium text-purple-600">Data@toaihr.com</span> with the subject "Purge Records (Instance Identifier: TOAI_HR_{{ date('Ymd') }}_{{ strtoupper(substr(md5('toaihr'), 0, 8)) }})".
                    </p>
                </div>
        </section>
    </x-main-layout>
@endsection

