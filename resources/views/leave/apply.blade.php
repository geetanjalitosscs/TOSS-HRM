@extends('layouts.app')

@section('title', 'Leave - Apply')

@section('body')
    <x-main-layout title="Leave">
        <x-leave.tabs activeTab="apply" />

        <!-- Apply Leave Section -->
        <section class="hr-card p-6">
            <h2 class="text-sm font-bold text-slate-800 flex items-baseline gap-2 mb-5">
                <i class="fas fa-calendar-plus text-[var(--color-primary)]"></i>
                <span class="mt-0.5">Apply Leave</span>
            </h2>

            <form method="POST" action="{{ route('leave.store') }}">
                @csrf
            <div class="rounded-lg p-3 mb-3"
                 style="background-color: var(--bg-card);">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-3">
                    {{-- Employee Name (Read-only) --}}
                    <div class="md:col-span-3">
                        <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                            Employee <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            value="{{ $employeeName ?? 'N/A' }}"
                            readonly
                            class="w-full px-3 py-2 text-sm rounded-lg"
                            style="border: 1px solid var(--border-default); background-color: var(--bg-hover); color: var(--text-primary); cursor: not-allowed;"
                        >
                        @if($employeeId)
                            <input type="hidden" name="employee_id" value="{{ $employeeId }}">
                        @endif
                    </div>

                    {{-- From Date --}}
                    <div>
                        <x-date-picker
                            name="from_date"
                            :value="now()->format('Y-m-d')"
                            label="From Date"
                        />
                    </div>

                    {{-- To Date --}}
                    <div>
                        <x-date-picker
                            name="to_date"
                            :value="now()->format('Y-m-d')"
                            label="To Date"
                        />
                    </div>

                    {{-- Leave Type --}}
                    <div>
                        <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                            Leave Type <span class="text-red-500">*</span>
                        </label>
                        <select
                            name="leave_type_id"
                                required
                            class="w-full px-3 py-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all"
                            style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);"
                        >
                            <option value="">-- Select --</option>
                            @foreach($leaveTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>

                        {{-- Comments --}}
                        <div class="md:col-span-3">
                            <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                                Comments
                            </label>
                            <textarea
                                name="reason"
                                rows="3"
                                class="w-full px-3 py-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all"
                                style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);"
                                placeholder="Enter reason for leave..."
                            ></textarea>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-3 mt-2">
                    <button
                            type="button"
                            onclick="window.location.href='{{ route('leave.leave-list') }}'"
                            class="hr-btn-secondary px-4 py-2 text-sm rounded-lg transition-all"
                    >
                        Cancel
                    </button>
                    <button
                            type="submit"
                            class="hr-btn-primary px-4 py-2 text-sm rounded-lg transition-all"
                    >
                        Apply
                    </button>
                </div>
            </div>
            </form>
        </section>
    </x-main-layout>
@endsection

