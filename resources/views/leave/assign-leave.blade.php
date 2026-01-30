@extends('layouts.app')

@section('title', 'Leave - Assign Leave')

@section('body')
    <x-main-layout title="Leave">
        <x-leave.tabs activeTab="assign-leave" />
        
        <!-- Assign Leave Section -->
        <section class="hr-card p-6">
            <h2 class="text-sm font-bold text-slate-800 flex items-baseline gap-2 mb-5">
                <i class="fas fa-user-check text-purple-500"></i> <span class="mt-0.5">Assign Leave</span>
            </h2>
            
            <form method="POST" action="{{ route('leave.assign-leave.store') }}" id="assign-leave-form">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <!-- Employee Name -->
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-primary);">
                            Employee Name <span class="text-red-500">*</span>
                        </label>
                        <select
                            name="employee_id"
                            id="employee_id"
                            required
                            class="w-full px-3 py-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all"
                            style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);"
                        >
                            <option value="">-- Select --</option>
                            @foreach($employees ?? [] as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->display_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Leave Type -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-sm font-medium" style="color: var(--text-primary);">
                                Leave Type <span class="text-red-500">*</span>
                            </label>
                            <span id="leave-balance" class="text-xs" style="color: var(--text-muted);">Leave Balance: 0 Day(s)</span>
                        </div>
                        <select
                            name="leave_type_id"
                            id="leave_type_id"
                            required
                            class="w-full px-3 py-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all"
                            style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);"
                        >
                            <option value="">-- Select --</option>
                            @foreach($leaveTypes ?? [] as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <!-- From Date -->
                    <div>
                        <x-date-picker 
                            name="from_date"
                            label="From Date"
                            required="true"
                        />
                    </div>
                    
                    <!-- To Date -->
                    <div>
                        <x-date-picker 
                            name="to_date"
                            label="To Date"
                            required="true"
                        />
                    </div>
                </div>
                
                <!-- Comments -->
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-primary);">Comments</label>
                    <textarea
                        name="reason"
                        rows="4"
                        class="w-full px-3 py-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all resize-none"
                        style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);"
                    ></textarea>
                </div>
                
                <!-- Footer -->
                <div class="flex items-center justify-between pt-4 border-t" style="border-color: var(--border-default);">
                    <p class="text-xs" style="color: var(--text-muted);">
                        <span class="text-red-500">*</span> Required
                    </p>
                    <button type="submit" class="hr-btn-primary px-6 py-2 text-sm font-semibold">
                        Assign
                    </button>
                </div>
            </form>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const employeeSelect = document.getElementById('employee_id');
                    const leaveTypeSelect = document.getElementById('leave_type_id');
                    const leaveBalanceSpan = document.getElementById('leave-balance');

                    function updateLeaveBalance() {
                        const employeeId = employeeSelect.value;
                        const leaveTypeId = leaveTypeSelect.value;

                        if (!employeeId || !leaveTypeId) {
                            leaveBalanceSpan.textContent = 'Leave Balance: 0 Day(s)';
                            return;
                        }

                        // Fetch leave balance via AJAX
                        fetch(`{{ route('leave.get-balance') }}?employee_id=${employeeId}&leave_type_id=${leaveTypeId}`)
                            .then(response => response.json())
                            .then(data => {
                                const balance = data.balance || 0;
                                // Remove .00 if it's a whole number
                                const formattedBalance = balance % 1 === 0 ? balance.toString() : balance.toFixed(2);
                                leaveBalanceSpan.textContent = `Leave Balance: ${formattedBalance} Day(s)`;
                            })
                            .catch(error => {
                                console.error('Error fetching leave balance:', error);
                                leaveBalanceSpan.textContent = 'Leave Balance: 0 Day(s)';
                            });
                    }

                    employeeSelect.addEventListener('change', updateLeaveBalance);
                    leaveTypeSelect.addEventListener('change', updateLeaveBalance);
                });
            </script>
        </section>
    </x-main-layout>
@endsection

