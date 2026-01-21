@extends('layouts.app')

@section('title', 'Maintenance / Purge Employee Records')

@section('body')
    <x-main-layout title="Maintenance / Purge Records">
        <!-- Top Navigation Tabs -->
        <div class="hr-sticky-tabs">
            <div class="flex items-center border-b border-purple-100 overflow-y-visible">
                <div class="px-6 py-3 border-b-2 border-[var(--color-hr-primary)] bg-purple-50/50 relative group cursor-pointer" onclick="toggleDropdown(event)" style="overflow: visible;">
                    <span class="text-sm font-semibold text-[var(--color-hr-primary-dark)]">Purge Records</span>
                    <span class="text-purple-400 ml-1">▼</span>
                    <!-- Dropdown Menu -->
                    <div class="hr-dropdown-menu absolute top-full left-0 mt-0 w-48 bg-white rounded-lg shadow-lg border border-purple-100" style="z-index: 9999; display: none;">
                        <a href="{{ route('maintenance.purge-employee') }}" class="block px-4 py-2 text-xs text-gray-700 hover:bg-purple-50 bg-purple-50 text-purple-600 font-medium">
                            Employee Records
                        </a>
                        <a href="{{ route('maintenance.purge-candidate') }}" class="block px-4 py-2 text-xs text-gray-700 hover:bg-purple-50">
                            Candidate Records
                        </a>
                    </div>
                </div>
                <a href="{{ route('maintenance.access-records') }}" class="px-6 py-3 hover:bg-purple-50/30 cursor-pointer transition-all">
                    <span class="text-sm font-medium text-slate-700">Access Records</span>
                </a>
            </div>
        </div>

        <!-- Purge Employee Records Section -->
        <div>
            <div class="bg-white rounded-b-lg shadow-sm border border-purple-100 border-t-0 p-4">
                <h2 class="text-sm font-bold text-slate-800 mb-3">Purge Employee Records</h2>

                <!-- Filter Form -->
                <div class="bg-purple-50/30 rounded-lg p-3 mb-3 border border-purple-100">
                    <div class="flex items-start gap-3">
                        <div class="flex-1">
                            <label class="block text-xs font-medium text-slate-700 mb-1">Past Employee*</label>
                            <input type="text" class="hr-input w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" placeholder="Type for hints...">
                            <div class="text-xs text-gray-500 mt-1">* Required</div>
                        </div>
                        <div class="pt-5">
                            <button class="hr-btn-primary px-4 py-2.5 text-xs font-medium text-white bg-gradient-to-r from-green-600 to-green-700 rounded-lg hover:shadow-md transition-all shadow-sm whitespace-nowrap">
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
            </div>
        </div>
    </x-main-layout>
@endsection

