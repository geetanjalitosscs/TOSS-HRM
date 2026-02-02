@extends('layouts.app')

@section('title', 'Dashboard')

@section('body')
    <x-main-layout title="Dashboard">
        <div>
            <!-- First Row -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <!-- Total Employees Card -->
                <section class="hr-card p-6">
                    <div class="flex flex-col h-full">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-xs text-slate-500 font-medium mb-1">Total Employees</p>
                                <h3 class="text-xl font-bold text-slate-800">{{ $totalEmployees }}</h3>
                            </div>
                            <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center shadow-lg shadow-purple-200/50">
                                <i class="fas fa-users text-white text-lg"></i>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 mb-4">Active workforce across all departments</p>
                        <div class="mt-auto pt-4 border-t border-purple-100">
                            <div class="flex justify-center">
                                <a href="{{ route('pim.employee-list') }}" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-medium text-purple-600 bg-gradient-to-br from-purple-100 to-purple-200 rounded-lg hover:shadow-md hover:scale-105 transition-all duration-200 shadow-sm">
                                    <i class="fas fa-users"></i>
                                    View Employee List
                                    <i class="fas fa-arrow-right text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Quick Launch Card -->
                <section class="hr-card p-6">
                    <div class="flex flex-col h-full">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-xs text-slate-500 font-medium mb-1">Quick Launch</p>
                                <h3 class="text-xl font-bold text-slate-800">6 Actions</h3>
                            </div>
                            <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center shadow-lg shadow-purple-200/50">
                                <i class="fas fa-bolt text-white text-lg"></i>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 mb-4">Quick access to common tasks</p>
                        <div class="mt-auto pt-4 border-t border-purple-100">
                            <div class="grid grid-cols-3 gap-3">
                                <a href="{{ route('pim.add-employee') }}" class="flex flex-col items-center gap-2 cursor-pointer p-2 rounded-lg hover:bg-purple-50 transition-all group">
                                    <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-purple-100 to-purple-200 flex items-center justify-center text-purple-600 text-base shadow-sm group-hover:shadow-md group-hover:scale-105 transition-all"><i class="fas fa-user-plus"></i></div>
                                    <span class="text-[10px] text-slate-700 text-center font-medium">Add Employee</span>
                                </a>
                                <a href="{{ route('pim.employee-list') }}" class="flex flex-col items-center gap-2 cursor-pointer p-2 rounded-lg hover:bg-purple-50 transition-all group">
                                    <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-purple-100 to-purple-200 flex items-center justify-center text-purple-600 text-base shadow-sm group-hover:shadow-md group-hover:scale-105 transition-all"><i class="fas fa-list"></i></div>
                                    <span class="text-[10px] text-slate-700 text-center font-medium">Employee List</span>
                                </a>
                                <a href="{{ route('leave.leave-list') }}" class="flex flex-col items-center gap-2 cursor-pointer p-2 rounded-lg hover:bg-purple-50 transition-all group">
                                    <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-purple-100 to-purple-200 flex items-center justify-center text-purple-600 text-base shadow-sm group-hover:shadow-md group-hover:scale-105 transition-all"><i class="fas fa-calendar-alt"></i></div>
                                    <span class="text-[10px] text-slate-700 text-center font-medium">Leave List</span>
                                </a>
                                <a href="{{ route('time.project-info.projects') }}" class="flex flex-col items-center gap-2 cursor-pointer p-2 rounded-lg hover:bg-purple-50 transition-all group">
                                    <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-purple-100 to-purple-200 flex items-center justify-center text-purple-600 text-base shadow-sm group-hover:shadow-md group-hover:scale-105 transition-all"><i class="fas fa-project-diagram"></i></div>
                                    <span class="text-[10px] text-slate-700 text-center font-medium">Project Management</span>
                                </a>
                                <a href="{{ route('leave.apply') }}" class="flex flex-col items-center gap-2 cursor-pointer p-2 rounded-lg hover:bg-purple-50 transition-all group">
                                    <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-purple-100 to-purple-200 flex items-center justify-center text-purple-600 text-base shadow-sm group-hover:shadow-md group-hover:scale-105 transition-all"><i class="fas fa-paper-plane"></i></div>
                                    <span class="text-[10px] text-slate-700 text-center font-medium">Apply Leave</span>
                                </a>
                                <a href="{{ route('pim.configuration.data-import') }}" class="flex flex-col items-center gap-2 cursor-pointer p-2 rounded-lg hover:bg-purple-50 transition-all group">
                                    <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-purple-100 to-purple-200 flex items-center justify-center text-purple-600 text-base shadow-sm group-hover:shadow-md group-hover:scale-105 transition-all"><i class="fas fa-file-import"></i></div>
                                    <span class="text-[10px] text-slate-700 text-center font-medium">Data Import</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Employees on Leave Today -->
                <section class="hr-card p-6">
                    <div class="flex flex-col h-full">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-xs text-slate-500 font-medium mb-1">On Leave Today</p>
                                <h3 class="text-xl font-bold text-slate-800">{{ $employeesOnLeave->count() }}</h3>
                            </div>
                            <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center shadow-lg shadow-purple-200/50">
                                <i class="fas fa-calendar-times text-white text-lg"></i>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 mb-4">Employees currently on leave</p>
                        <div class="mt-auto pt-4 border-t border-purple-100">
                            @if($employeesOnLeave->count() > 0)
                                <div class="space-y-2 max-h-32 overflow-y-auto">
                                    @foreach($employeesOnLeave as $leave)
                                        <div class="flex items-start gap-2 p-2 rounded-lg hover:bg-purple-50 transition-all">
                                            <div class="flex-1">
                                                <div class="text-xs font-medium text-slate-800">{{ $leave->employee_name }}</div>
                                                <div class="text-[10px] text-slate-500">{{ $leave->leave_type }}</div>
                                                <div class="text-[10px] text-purple-500">
                                                    {{ \Carbon\Carbon::parse($leave->start_date)->format('M d') }} - {{ \Carbon\Carbon::parse($leave->end_date)->format('M d') }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="flex flex-col items-center justify-center h-20 text-center">
                                    <i class="fas fa-clipboard text-3xl mb-2 opacity-60 text-purple-400"></i>
                                    <p class="text-xs text-slate-600 font-medium">No one on leave today</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </section>
            </div>

            <!-- Second Row: Quick Stats, Work Week, Holidays -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <!-- Quick Stats Card -->
                <section class="hr-card p-6">
                    <div class="flex flex-col h-full">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-xs text-slate-500 font-medium mb-1">Quick Stats</p>
                                <h3 class="text-xl font-bold text-slate-800">2 Stats</h3>
                            </div>
                            <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center shadow-lg shadow-purple-200/50">
                                <i class="fas fa-chart-bar text-white text-lg"></i>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 mb-4">Key workforce metrics</p>
                        <div class="mt-auto pt-4 border-t border-purple-100">
                            <div class="space-y-4">
                                <a href="{{ route('pim.employee-list') }}" class="block transition-all duration-200 hover:scale-[1.02] hover:shadow-md group">
                                    <div class="flex items-center justify-between p-3 rounded-lg cursor-pointer transition-all duration-200 group-hover:shadow-md group-hover:scale-[1.02]" style="background-color: var(--bg-hover); border: 1px solid var(--border-default);">
                                        <div>
                                            <p class="text-xs font-medium transition-colors duration-200" style="color: var(--text-secondary);">Total Employees</p>
                                            <p class="text-lg font-bold mt-1 transition-colors duration-200" style="color: var(--text-primary);">{{ $totalEmployees }}</p>
                                        </div>
                                        <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-purple-100 to-purple-200 flex items-center justify-center shadow-sm transition-all duration-200 group-hover:shadow-md group-hover:scale-105">
                                            <i class="fas fa-users text-purple-600"></i>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('leave.leave-list') }}" class="block transition-all duration-200 hover:scale-[1.02] hover:shadow-md group">
                                    <div class="flex items-center justify-between p-3 rounded-lg cursor-pointer transition-all duration-200 group-hover:shadow-md group-hover:scale-[1.02]" style="background-color: var(--bg-hover); border: 1px solid var(--border-default);">
                                        <div>
                                            <p class="text-xs font-medium transition-colors duration-200" style="color: var(--text-secondary);">On Leave Today</p>
                                            <p class="text-lg font-bold mt-1 transition-colors duration-200" style="color: var(--text-primary);">{{ $employeesOnLeave->count() }}</p>
                                        </div>
                                        <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center shadow-sm transition-all duration-200 group-hover:shadow-md group-hover:scale-105">
                                            <i class="fas fa-calendar-check text-blue-600"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Work Week Chart -->
                <section class="hr-card p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                            <i class="fas fa-calendar-week text-purple-500"></i> Work Week
                        </h2>
                        <a href="{{ route('leave.work-week') }}" class="text-xs text-purple-600 hover:text-purple-700">
                            <i class="fas fa-cog text-base"></i>
                        </a>
                    </div>
                    <div class="flex items-end justify-between gap-2" style="height: 256px;">
                        @php
                            $maxHours = 8;
                            $containerHeight = 256; // Height in pixels
                        @endphp
                        @foreach($workWeekData as $day)
                            <div class="flex-1 flex flex-col items-center justify-end gap-2 h-full">
                                @if($day['is_working'])
                                    @php
                                        $barHeight = ($day['hours'] / $maxHours) * $containerHeight;
                                        $barHeight = max(20, $barHeight); // Minimum 20px
                                    @endphp
                                    <div class="work-week-bar w-full bg-purple-100 rounded-t relative overflow-hidden transition-all duration-300 ease-out hover:bg-purple-200 hover:shadow-lg hover:scale-105 cursor-pointer" style="height: {{ $barHeight }}px;" title="{{ $day['day'] }}: {{ $day['hours'] }} hours">
                                        <div class="bg-gradient-to-t from-purple-400 to-purple-600 w-full h-full rounded-t flex items-center justify-center transition-all duration-300 hover:from-purple-500 hover:to-purple-700">
                                            <span class="text-[9px] font-bold text-white transition-opacity duration-300 opacity-90 hover:opacity-100">{{ $day['hours'] }}h</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="work-week-bar w-full bg-slate-100 rounded-t flex items-center justify-center transition-all duration-300 ease-out hover:bg-slate-200 hover:shadow-md hover:scale-105 cursor-pointer" style="height: 20px;" title="{{ $day['day'] }}: Non-working day">
                                        <span class="text-[8px] font-medium text-slate-500 transition-colors duration-300 hover:text-slate-600">-</span>
                                    </div>
                                @endif
                                <span class="text-[9px] font-medium text-slate-700 text-center">{{ substr($day['day'], 0, 3) }}</span>
                            </div>
                        @endforeach
                    </div>
                </section>

                <!-- Holidays Chart -->
                <section class="hr-card p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                            <i class="fas fa-calendar-alt text-purple-500"></i> Holidays ({{ date('Y') }})
                        </h2>
                        <a href="{{ route('leave.holidays') }}" class="text-xs text-purple-600 hover:text-purple-700">
                            <i class="fas fa-cog text-base"></i>
                        </a>
                    </div>
                    @if(count($holidaysData) > 0)
                        <div class="flex justify-center items-center mb-4">
                            <div class="relative">
                                <canvas id="holidaysPieChart" width="200" height="200"></canvas>
                                <div id="pieChartTooltip" class="absolute hidden px-2 py-1 text-xs font-medium rounded shadow-lg pointer-events-none z-50" style="background-color: var(--bg-card); border: 1px solid var(--border-default); color: var(--text-primary);"></div>
                            </div>
                        </div>
                        <div class="space-y-2 text-xs">
                            @foreach($holidaysData as $index => $monthData)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <div class="w-3 h-3 rounded-full" style="background-color: {{ getPieChartColor($index) }}"></div>
                                        <span class="font-medium" style="color: var(--text-primary)">{{ $monthData['month'] }}</span>
                                    </div>
                                    <span class="font-bold" style="color: var(--text-primary)">{{ $monthData['count'] }}</span>
                                </div>
                            @endforeach
                        </div>
                        
                        @php
                            $totalHolidays = array_sum(array_column($holidaysData, 'count'));
                        @endphp
                        <div class="mt-3 pt-3 border-t" style="border-color: var(--border-default)">
                            <div class="flex justify-between text-xs">
                                <span class="font-medium" style="color: var(--text-muted)">Total Holidays</span>
                                <span class="font-bold" style="color: var(--text-primary)">{{ $totalHolidays }}</span>
                            </div>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center h-32 text-center">
                            <i class="fas fa-calendar-times text-4xl mb-2 opacity-60 text-slate-400"></i>
                            <p class="text-xs text-slate-500">No holidays configured</p>
                        </div>
                    @endif
                </section>
            </div>

            <!-- Third Row: Job Titles Chart -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Job Titles Chart -->
                <section class="hr-card p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                            <i class="fas fa-briefcase text-purple-500"></i> Job Titles Distribution
                        </h2>
                        <a href="{{ route('admin.job-titles') }}" class="text-xs text-purple-600 hover:text-purple-700">
                            <i class="fas fa-cog text-base"></i>
                        </a>
                    </div>
                    @if(count($jobTitlesData) > 0)
                        <div class="flex justify-center items-center mb-4">
                            <div class="relative">
                                <canvas id="jobTitlesPieChart" width="200" height="200"></canvas>
                                <div id="jobTitlesTooltip" class="absolute hidden px-2 py-1 text-xs font-medium rounded shadow-lg pointer-events-none z-50" style="background-color: var(--bg-card); border: 1px solid var(--border-default); color: var(--text-primary);"></div>
                            </div>
                        </div>
                        <div class="space-y-2 text-xs max-h-40 overflow-y-auto">
                            @foreach($jobTitlesData as $index => $jobData)
                                <div class="flex items-center">
                                    <div class="flex items-center gap-2">
                                        <div class="w-3 h-3 rounded-full border border-gray-300" style="background-color: {{ getPieChartColor($index) }}"></div>
                                        <span class="font-medium" style="color: var(--text-primary)" title="{{ $jobData['label'] }}">{{ $jobData['label'] }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        @php
                            $totalJobTitles = count($jobTitlesData);
                        @endphp
                        <div class="mt-3 pt-3 border-t" style="border-color: var(--border-default)">
                            <div class="flex justify-between text-xs">
                                <span class="font-medium" style="color: var(--text-muted)">Total Job Titles</span>
                                <span class="font-bold" style="color: var(--text-primary)">{{ $totalJobTitles }}</span>
                            </div>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center h-32 text-center">
                            <i class="fas fa-briefcase text-4xl mb-2 opacity-60 text-slate-400"></i>
                            <p class="text-xs text-slate-500">No job titles data</p>
                        </div>
                    @endif
                </section>
            </div>
        </div>
    </x-main-layout>
@endsection

@php
    // Helper function to get pie chart colors
    function getPieChartColor($index) {
        $colors = [
            // Primary Purple Family (Your Theme)
            '#8B5CF6', '#6D28D9', '#A78BFA', '#F5F3FF', '#c4b5fd', '#a78bfa',
            
            // Extended Purple Shades
            '#7C3AED', '#9333EA', '#A855F7', '#C084FC', '#c6b2dbff', '#a696aaff',
            
            // Complementary Colors that work with Purple
            '#DC2626', '#EA580C', '#D97706', '#65A30D', '#059669', '#0891B2',
            '#2563EB', '#4F46E5', '#7C3AED', '#BE123C', '#DB2777', '#EC4899',
            
            // Neutral Shades for Balance
            '#64748B', '#475569', '#334155', '#1E293B', '#94A3B8', '#6B7280',
            '#9CA3AF', '#D1D5DB', '#E5E7EB', '#F3F4F6', '#F9FAFB', '#FEFEFE'
        ];
        return $colors[$index % count($colors)];
    }
@endphp

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Dashboard loaded, checking holidays data...');
    
    const holidaysData = @json($holidaysData);
    console.log('Holidays data:', holidaysData);
    
    if (holidaysData && holidaysData.length > 0) {
        console.log('Drawing holidays pie chart...');
        drawHolidaysPieChart(holidaysData);
    } else {
        console.log('No holidays data available');
    }
    
    const jobTitlesData = @json($jobTitlesData);
    console.log('Job titles data received:', jobTitlesData);
    console.log('Job titles data length:', jobTitlesData ? jobTitlesData.length : 0);
    
    if (jobTitlesData && jobTitlesData.length > 0) {
        console.log('Drawing job titles pie chart...');
        drawJobTitlesPieChart(jobTitlesData);
    } else {
        console.log('No job titles data available');
    }
    
    function drawHolidaysPieChart(data) {
        try {
            const canvas = document.getElementById('holidaysPieChart');
            const tooltip = document.getElementById('pieChartTooltip');
            console.log('Canvas found:', canvas);
            
            if (!canvas) {
                console.error('Canvas not found!');
                return;
            }
            
            const ctx = canvas.getContext('2d');
            console.log('Canvas context:', ctx);
            
            // Set canvas size for better quality
            const dpr = window.devicePixelRatio || 1;
            canvas.width = 200 * dpr;
            canvas.height = 200 * dpr;
            canvas.style.width = '200px';
            canvas.style.height = '200px';
            ctx.scale(dpr, dpr);
            
            const centerX = 100;
            const centerY = 100;
            const radius = 80;
            
            // Calculate total
            const total = data.reduce((sum, item) => sum + item.count, 0);
            console.log('Total holidays:', total);
            
            // Colors matching the PHP function - HR Suite Theme
            const colors = [
                // Primary Purple Family (Your Theme)
                '#8B5CF6', '#6D28D9', '#A78BFA', '#F5F3FF', '#c4b5fd', '#a78bfa',
                
                // Extended Purple Shades
                '#7C3AED', '#9333EA', '#A855F7', '#C084FC', '#c6b2dbff', '#a696aaff',
                
                // Complementary Colors that work with Purple
                '#DC2626', '#EA580C', '#D97706', '#65A30D', '#059669', '#0891B2',
                '#2563EB', '#4F46E5', '#7C3AED', '#BE123C', '#DB2777', '#EC4899',
                
                // Neutral Shades for Balance
                '#64748B', '#475569', '#334155', '#1E293B', '#94A3B8', '#6B7280',
                '#9CA3AF', '#D1D5DB', '#E5E7EB', '#F3F4F6', '#F9FAFB', '#FEFEFE'
            ];
            
            // Store slice information for hover detection
            const slices = [];
            let currentAngle = -Math.PI / 2; // Start from top
            
            data.forEach((item, index) => {
                const sliceAngle = (item.count / total) * 2 * Math.PI;
                
                slices.push({
                    startAngle: currentAngle,
                    endAngle: currentAngle + sliceAngle,
                    color: colors[index % colors.length],
                    data: item,
                    index: index
                });
                
                currentAngle += sliceAngle;
            });
            
            // Function to draw the chart
            function drawChart(hoveredIndex = -1, animationProgress = 1) {
                // Clear canvas completely
                ctx.clearRect(0, 0, 200, 200);
                
                slices.forEach((slice, index) => {
                    const isHovered = index === hoveredIndex;
                    
                    // Calculate expansion amount (max 15% for smoother effect)
                    const maxExpand = radius * 0.15;
                    const expandAmount = isHovered ? maxExpand * animationProgress : 0;
                    
                    // Calculate expanded position for hovered slice
                    let midAngle = (slice.startAngle + slice.endAngle) / 2;
                    let offsetX = Math.cos(midAngle) * expandAmount;
                    let offsetY = Math.sin(midAngle) * expandAmount;
                    
                    // Use consistent radius - no size change when hovering
                    const drawRadius = radius * 0.9; // Slightly smaller to prevent any edge issues
                    
                    // Draw slice
                    ctx.beginPath();
                    ctx.moveTo(centerX + offsetX, centerY + offsetY); // Start from center
                    ctx.arc(centerX + offsetX, centerY + offsetY, drawRadius, slice.startAngle, slice.endAngle);
                    ctx.closePath();
                    ctx.fillStyle = slice.color;
                    ctx.fill();
                    
                    // Draw thin border
                    ctx.strokeStyle = '#ffffff';
                    ctx.lineWidth = 1;
                    ctx.stroke();
                });
            }
            
            // Initial draw
            drawChart();
            
            let animationFrameId = null;
            let currentHoveredIndex = -1;
            let targetHoveredIndex = -1;
            let animationProgress = 0;
            let isAnimating = false;
            const animationDuration = 300; // ms for smoother animation

            function animate(timestamp) {
                if (!isAnimating) return;
                
                const targetProgress = targetHoveredIndex !== -1 ? 1 : 0;
                const diff = targetProgress - animationProgress;
                
                if (Math.abs(diff) < 0.01) {
                    // Animation complete
                    animationProgress = targetProgress;
                    currentHoveredIndex = targetHoveredIndex;
                    isAnimating = false;
                    drawChart(currentHoveredIndex, 1);
                    return;
                }
                
                // Smooth easing function
                animationProgress += diff * 0.12; // Smooth factor
                
                drawChart(targetHoveredIndex, animationProgress);
                animationFrameId = requestAnimationFrame(animate);
            }

            function startAnimation(newTargetIndex) {
                if (targetHoveredIndex === newTargetIndex) return; // Already animating to this state
                
                targetHoveredIndex = newTargetIndex;
                
                if (!isAnimating) {
                    isAnimating = true;
                    animationFrameId = requestAnimationFrame(animate);
                }
            }

            // Mouse move handler
            canvas.addEventListener('mousemove', function(e) {
                const rect = canvas.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                // Convert to canvas coordinates
                const canvasX = (x / rect.width) * 200;
                const canvasY = (y / rect.height) * 200;
                
                // Calculate angle from center
                const dx = canvasX - centerX;
                const dy = canvasY - centerY;
                const distance = Math.sqrt(dx * dx + dy * dy);
                let angle = Math.atan2(dy, dx);
                
                // Normalize angle
                if (angle < -Math.PI / 2) angle += 2 * Math.PI;
                
                // Check which slice is hovered
                let hoveredIndex = -1;
                
                if (distance <= radius * 0.9) { // Use the same radius as drawing
                    for (let i = 0; i < slices.length; i++) {
                        let slice = slices[i];
                        let startAngle = slice.startAngle;
                        let endAngle = slice.endAngle;
                        
                        // Normalize angles for comparison
                        if (startAngle < -Math.PI / 2) startAngle += 2 * Math.PI;
                        if (endAngle < -Math.PI / 2) endAngle += 2 * Math.PI;
                        
                        if (angle >= startAngle && angle <= endAngle) {
                            hoveredIndex = i;
                            break;
                        }
                    }
                }
                
                // Start animation if needed
                startAnimation(hoveredIndex);
                
                // Show/hide tooltip
                if (hoveredIndex >= 0) {
                    const slice = slices[hoveredIndex];
                    tooltip.textContent = `${slice.data.month}: ${slice.data.count} holidays`;
                    tooltip.classList.remove('hidden');
                    
                    // Position tooltip more intelligently
                    const tooltipX = e.clientX - rect.left;
                    const tooltipY = e.clientY - rect.top - 35;
                    
                    // Keep tooltip within canvas bounds
                    tooltip.style.left = `${Math.max(10, Math.min(tooltipX, 120))}px`;
                    tooltip.style.top = `${Math.max(10, Math.min(tooltipY, 170))}px`;
                    
                    canvas.style.cursor = 'pointer';
                } else {
                    tooltip.classList.add('hidden');
                    canvas.style.cursor = 'default';
                }
            });
            
            // Mouse leave handler
            canvas.addEventListener('mouseleave', function() {
                startAnimation(-1);
                tooltip.classList.add('hidden');
                canvas.style.cursor = 'default';
            });
            
            console.log('Pie chart drawing completed');
        } catch (error) {
            console.error('Error drawing pie chart:', error);
        }
    }
    
    function drawJobTitlesPieChart(data) {
        try {
            const canvas = document.getElementById('jobTitlesPieChart');
            const tooltip = document.getElementById('jobTitlesTooltip');
            console.log('Job titles canvas found:', canvas);
            
            if (!canvas) {
                console.error('Job titles canvas not found!');
                return;
            }
            
            const ctx = canvas.getContext('2d');
            console.log('Job titles canvas context:', ctx);
            
            // Set canvas size for better quality
            const dpr = window.devicePixelRatio || 1;
            canvas.width = 200 * dpr;
            canvas.height = 200 * dpr;
            canvas.style.width = '200px';
            canvas.style.height = '200px';
            ctx.scale(dpr, dpr);
            
            const centerX = 100;
            const centerY = 100;
            const radius = 80;
            
            // Calculate total - add 1 to each job title to ensure visibility
            const total = data.reduce((sum, item) => sum + (item.count || 0), 0) + data.length; // Add 1 for each job title
            console.log('Total job titles (with minimum):', total);
            
            // Colors matching the PHP function - HR Suite Theme
            const colors = [
                // Primary Purple Family (Your Theme)
                '#8B5CF6', '#6D28D9', '#A78BFA', '#F5F3FF', '#c4b5fd', '#a78bfa',
                
                // Extended Purple Shades
                '#7C3AED', '#9333EA', '#A855F7', '#C084FC', '#E9D5FF', '#FAE8FF',
                
                // Complementary Colors that work with Purple
                '#DC2626', '#EA580C', '#D97706', '#65A30D', '#059669', '#0891B2',
                '#2563EB', '#4F46E5', '#7C3AED', '#BE123C', '#DB2777', '#EC4899',
                
                // Neutral Shades for Balance
                '#64748B', '#475569', '#334155', '#1E293B', '#94A3B8', '#6B7280',
                '#9CA3AF', '#D1D5DB', '#E5E7EB', '#F3F4F6', '#F9FAFB', '#FEFEFE'
            ];
            
            // Store slice information for hover detection
            const slices = [];
            let currentAngle = -Math.PI / 2; // Start from top
            
            data.forEach((item, index) => {
                // Add 1 to ensure every job title has at least some visibility
                const adjustedCount = (item.count || 0) + 1;
                const sliceAngle = (adjustedCount / total) * 2 * Math.PI;
                
                slices.push({
                    startAngle: currentAngle,
                    endAngle: currentAngle + sliceAngle,
                    color: colors[index % colors.length],
                    data: item,
                    index: index,
                    actualCount: item.count || 0
                });
                
                currentAngle += sliceAngle;
            });
            
            // Function to draw the chart
            function drawChart(hoveredIndex = -1, animationProgress = 1) {
                // Clear canvas completely
                ctx.clearRect(0, 0, 200, 200);
                
                slices.forEach((slice, index) => {
                    const isHovered = index === hoveredIndex;
                    
                    // Calculate expansion amount (max 15% for smoother effect)
                    const maxExpand = radius * 0.15;
                    const expandAmount = isHovered ? maxExpand * animationProgress : 0;
                    
                    // Calculate expanded position for hovered slice
                    let midAngle = (slice.startAngle + slice.endAngle) / 2;
                    let offsetX = Math.cos(midAngle) * expandAmount;
                    let offsetY = Math.sin(midAngle) * expandAmount;
                    
                    // Use consistent radius - no size change when hovering
                    const drawRadius = radius * 0.9; // Slightly smaller to prevent any edge issues
                    
                    // Draw slice
                    ctx.beginPath();
                    ctx.moveTo(centerX + offsetX, centerY + offsetY); // Start from center
                    ctx.arc(centerX + offsetX, centerY + offsetY, drawRadius, slice.startAngle, slice.endAngle);
                    ctx.closePath();
                    ctx.fillStyle = slice.color;
                    ctx.fill();
                    
                    // Draw thin border
                    ctx.strokeStyle = '#ffffff';
                    ctx.lineWidth = 1;
                    ctx.stroke();
                });
            }
            
            // Initial draw
            drawChart();
            
            let animationFrameId = null;
            let currentHoveredIndex = -1;
            let targetHoveredIndex = -1;
            let animationProgress = 0;
            let isAnimating = false;

            function animate(timestamp) {
                if (!isAnimating) return;
                
                const targetProgress = targetHoveredIndex !== -1 ? 1 : 0;
                const diff = targetProgress - animationProgress;
                
                if (Math.abs(diff) < 0.01) {
                    // Animation complete
                    animationProgress = targetProgress;
                    currentHoveredIndex = targetHoveredIndex;
                    isAnimating = false;
                    drawChart(currentHoveredIndex, 1);
                    return;
                }
                
                // Smooth easing function
                animationProgress += diff * 0.12; // Smooth factor
                
                drawChart(targetHoveredIndex, animationProgress);
                animationFrameId = requestAnimationFrame(animate);
            }

            function startAnimation(newTargetIndex) {
                if (targetHoveredIndex === newTargetIndex) return; // Already animating to this state
                
                targetHoveredIndex = newTargetIndex;
                
                if (!isAnimating) {
                    isAnimating = true;
                    animationFrameId = requestAnimationFrame(animate);
                }
            }

            // Mouse move handler
            canvas.addEventListener('mousemove', function(e) {
                const rect = canvas.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                // Convert to canvas coordinates
                const canvasX = (x / rect.width) * 200;
                const canvasY = (y / rect.height) * 200;
                
                // Calculate angle from center
                const dx = canvasX - centerX;
                const dy = canvasY - centerY;
                const distance = Math.sqrt(dx * dx + dy * dy);
                let angle = Math.atan2(dy, dx);
                
                // Normalize angle
                if (angle < -Math.PI / 2) angle += 2 * Math.PI;
                
                // Check which slice is hovered
                let hoveredIndex = -1;
                
                if (distance <= radius * 0.9) { // Use the same radius as drawing
                    for (let i = 0; i < slices.length; i++) {
                        let slice = slices[i];
                        let startAngle = slice.startAngle;
                        let endAngle = slice.endAngle;
                        
                        // Normalize angles for comparison
                        if (startAngle < -Math.PI / 2) startAngle += 2 * Math.PI;
                        if (endAngle < -Math.PI / 2) endAngle += 2 * Math.PI;
                        
                        if (angle >= startAngle && angle <= endAngle) {
                            hoveredIndex = i;
                            break;
                        }
                    }
                }
                
                // Start animation if needed
                startAnimation(hoveredIndex);
                
                // Show/hide tooltip
                if (hoveredIndex >= 0) {
                    const slice = slices[hoveredIndex];
                    const employeeCount = slice.actualCount;
                    tooltip.textContent = `${slice.data.label}: ${employeeCount} ${employeeCount === 1 ? 'employee' : 'employees'}`;
                    tooltip.classList.remove('hidden');
                    
                    // Position tooltip more intelligently
                    const tooltipX = e.clientX - rect.left;
                    const tooltipY = e.clientY - rect.top - 35;
                    
                    // Keep tooltip within canvas bounds
                    tooltip.style.left = `${Math.max(10, Math.min(tooltipX, 120))}px`;
                    tooltip.style.top = `${Math.max(10, Math.min(tooltipY, 170))}px`;
                    
                    canvas.style.cursor = 'pointer';
                } else {
                    tooltip.classList.add('hidden');
                    canvas.style.cursor = 'default';
                }
            });
            
            // Mouse leave handler
            canvas.addEventListener('mouseleave', function() {
                startAnimation(-1);
                tooltip.classList.add('hidden');
                canvas.style.cursor = 'default';
            });
            
            console.log('Job titles pie chart drawing completed');
        } catch (error) {
            console.error('Error drawing job titles pie chart:', error);
        }
    }
});
</script>
@endpush