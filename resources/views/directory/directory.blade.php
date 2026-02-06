@extends('layouts.app')

@section('title', 'Directory')

@section('body')
    <x-main-layout title="Directory">
        <!-- Directory Search/Filter Section -->
        <section class="hr-card p-6">
            <h2 class="text-sm font-bold text-slate-800 flex items-baseline gap-2 mb-5">
                <i class="fas fa-address-book text-[var(--color-primary)]"></i> <span class="mt-0.5">Directory</span>
            </h2>

                <!-- Filter Form -->
                <form method="GET" action="{{ route('directory') }}" id="directory-search-form">
                    <div class="bg-[var(--color-primary-light)] rounded-lg p-3 mb-3 border border-[var(--border-default)]">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                            <div>
                                <label class="block text-xs font-medium text-slate-700 mb-1">Employee Name</label>
                                <input 
                                    type="text" 
                                    name="employee_name"
                                    value="{{ request('employee_name') }}"
                                    class="hr-input w-full px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" 
                                    placeholder="Type for hints...">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-700 mb-1">Job Title</label>
                                <select 
                                    name="job_title"
                                    class="hr-select w-full px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white">
                                    <option value="">-- Select --</option>
                                    @foreach($jobTitles ?? [] as $title)
                                        <option value="{{ $title->id }}" {{ request('job_title') == $title->id ? 'selected' : '' }}>
                                            {{ $title->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <x-admin.action-buttons resetType="button" searchType="submit" />
                    </div>
                </form>

                <!-- Records Count -->
                <x-records-found :count="count($employees)" />

                <!-- Employee Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($employees as $employee)
                    <a href="{{ route('pim.add-employee.edit', $employee->id) }}" class="block rounded-lg border shadow-sm p-4 transition-all cursor-pointer" style="background-color: var(--bg-card); border-color: var(--border-default); text-decoration: none;" onmouseover="this.style.boxShadow='var(--shadow-md)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.boxShadow='none'; this.style.transform='translateY(0)'">
                        <!-- Profile Picture -->
                        <div class="flex justify-center mb-3">
                            @if($employee->photo_url)
                                <div class="w-20 h-20 rounded-full overflow-hidden shadow-lg shadow-[var(--color-primary-light)]" style="background-color: var(--bg-hover); border: 2px solid var(--border-default);">
                                    <img src="{{ $employee->photo_url }}?t={{ time() }}" alt="{{ $employee->name }}" class="w-full h-full object-contain">
                                </div>
                            @else
                                <div class="w-20 h-20 rounded-full bg-gray-300 flex items-center justify-center text-gray-500 text-2xl">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Employee Name -->
                        <div class="text-center mb-2">
                            <h3 class="text-sm font-semibold text-slate-800">{{ $employee->name }}</h3>
                        </div>

                        <!-- Job Title -->
                        @if($employee->job_title)
                        <div class="text-center mb-1">
                            <p class="text-xs text-slate-600 font-medium">{{ $employee->job_title }}</p>
                        </div>
                        @endif
                    </a>
                    @endforeach
                </div>
        </section>
    </x-main-layout>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Reset button functionality
            var searchForm = document.getElementById('directory-search-form');
            if (searchForm) {
                var resetBtn = searchForm.querySelector('button[type="button"]');
                if (resetBtn) {
                    resetBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        // Clear input/select values
                        searchForm.querySelectorAll('input[name], select[name]').forEach(function (el) {
                            if (el.tagName === 'SELECT') {
                                el.value = '';
                            } else {
                                el.value = '';
                            }
                        });
                        // Navigate to base route (no query) so URL is clean
                        window.location.href = '{{ route("directory") }}';
                    });
                }
            }
        });
    </script>
@endsection

