@extends('layouts.app')

@section('title', 'Directory')

@section('body')
    <x-main-layout title="Directory">
        <!-- Directory Search/Filter Section -->
        <div>
            <div class="bg-white rounded-lg shadow-sm border border-purple-100 p-4">
                <h2 class="text-sm font-bold text-slate-800 mb-3">Directory</h2>

                <!-- Filter Form -->
                <div class="bg-purple-50/30 rounded-lg p-3 mb-3 border border-purple-100">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-3">
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Employee Name</label>
                            <input type="text" class="hr-input w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" placeholder="Type for hints...">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Job Title</label>
                            <select class="hr-select w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white">
                                <option>-- Select --</option>
                                <option>Software Engineer</option>
                                <option>QA Engineer</option>
                                <option>HR Manager</option>
                                <option>Business Analyst</option>
                                <option>Project Manager</option>
                                <option>Chief Financial Officer</option>
                                <option>DevOps Engineer</option>
                                <option>UI/UX Designer</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Location</label>
                            <select class="hr-select w-full px-2 py-1.5 text-xs border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white">
                                <option>-- Select --</option>
                                <option>New York</option>
                                <option>London</option>
                                <option>Tokyo</option>
                                <option>Mumbai</option>
                                <option>Singapore</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button class="hr-btn-secondary px-3 py-1.5 text-xs font-medium text-purple-600 border border-purple-300 rounded-lg hover:bg-purple-50 transition-all">
                            Reset
                        </button>
                        <button class="hr-btn-primary px-3 py-1.5 text-xs font-medium text-white bg-gradient-to-r from-[var(--color-hr-primary)] to-[var(--color-hr-primary-dark)] rounded-lg hover:shadow-md transition-all shadow-sm">
                            Search
                        </button>
                    </div>
                </div>

                <!-- Records Count -->
                <div class="mb-4 text-xs text-slate-600 font-medium">
                    ({{ count($employees) }}) Records Found
                </div>

                <!-- Employee Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($employees as $employee)
                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-4 hover:shadow-md transition-shadow">
                        <!-- Profile Picture -->
                        <div class="flex justify-center mb-3">
                            @if($employee['has_photo'])
                                <div class="w-20 h-20 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center text-white text-xl font-bold shadow-lg shadow-purple-200/50 overflow-hidden">
                                    <img src="https://via.placeholder.com/80x80/8b5cf6/ffffff?text={{ substr($employee['name'], 0, 1) }}" alt="{{ $employee['name'] }}" class="w-full h-full object-cover">
                                </div>
                            @else
                                <div class="w-20 h-20 rounded-full bg-gray-300 flex items-center justify-center text-gray-500 text-2xl">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Employee Name -->
                        <div class="text-center mb-2">
                            <h3 class="text-sm font-semibold text-slate-800">{{ $employee['name'] }}</h3>
                        </div>

                        <!-- Job Title -->
                        @if($employee['job_title'])
                        <div class="text-center mb-1">
                            <p class="text-xs text-slate-600 font-medium">{{ $employee['job_title'] }}</p>
                        </div>
                        @endif

                        <!-- Department -->
                        @if($employee['department'])
                        <div class="text-center">
                            <p class="text-xs text-purple-600">{{ $employee['department'] }}</p>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </x-main-layout>
@endsection

