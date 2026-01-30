@extends('layouts.app')

@section('title', 'Dashboard')

@section('body')
    <x-main-layout title="Dashboard">
                <div>
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    <!-- Time at Work Card -->
                    <section class="hr-card p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-clock text-purple-500"></i> Time at Work
                        </h2>
                    </div>
                        <div class="flex items-start gap-4 mb-5">
                            <div class="h-14 w-14 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center text-white text-sm font-bold shadow-lg shadow-purple-200/50">
                                A
                            </div>
                            <div class="flex-1">
                                @if($todayAttendance)
                                    <div class="text-xs text-[var(--color-hr-primary)] font-semibold mb-1 uppercase tracking-wide">Punched In</div>
                                    <div class="text-xs text-slate-500 mb-3">
                                        Punched In: {{ \Carbon\Carbon::parse($todayAttendance->punch_in_at)->format('M d') }} at {{ \Carbon\Carbon::parse($todayAttendance->punch_in_at)->format('h:i A') }}
                                        @if($todayAttendance->punch_out_at)
                                            <br>Punched Out: {{ \Carbon\Carbon::parse($todayAttendance->punch_out_at)->format('M d') }} at {{ \Carbon\Carbon::parse($todayAttendance->punch_out_at)->format('h:i A') }}
                                        @endif
                                    </div>
                                @else
                                    <div class="text-xs text-slate-500 font-semibold mb-1 uppercase tracking-wide">Not Punched In</div>
                                    <div class="text-xs text-slate-500 mb-3">No attendance record for today</div>
                                @endif
                                <div class="hr-time-pill">
                                    @php
                                        $hours = floor($todayDuration);
                                        $minutes = floor(($todayDuration - $hours) * 60);
                                    @endphp
                                    <span class="hr-time-pill-text">{{ $hours }}h {{ $minutes }}m Today</span>
                                    <div class="hr-time-pill-icon">
                                        <i class="fas fa-stopwatch"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 pt-4 border-t border-purple-100">
                            @php
                                $today = \Carbon\Carbon::today();
                                $weekStart = $today->copy()->startOfWeek(\Carbon\Carbon::MONDAY);
                                $weekEnd = $today->copy()->endOfWeek(\Carbon\Carbon::SUNDAY);
                            @endphp
                            <div class="text-xs text-slate-600 font-medium mb-3">This Week {{ $weekStart->format('M d') }} - {{ $weekEnd->format('M d') }}</div>
                            <div class="flex items-end gap-1.5 h-24">
                                @foreach($weekData as $day)
                                    <div class="flex-1 min-w-0 flex flex-col items-center">
                                        <div class="w-full bg-gradient-to-t from-purple-400 to-purple-300 rounded-t shadow-sm" style="height: {{ max(3, round($day['height'] * 0.6)) }}px;"></div>
                                        <div class="w-full truncate text-[9px] text-slate-600 mt-1 font-medium text-center" title="{{ $day['hoursFormatted'] }}">{{ $day['hoursFormatted'] }}</div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="flex justify-between text-[9px] text-purple-500 mt-2 font-medium">
                                <span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span>
                            </div>
                        </div>
                    </section>

                    <!-- My Actions Card -->
                    <section class="hr-card p-6">
                        <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2 mb-5">
                            <i class="fas fa-clipboard-list text-purple-500"></i> My Actions
                        </h2>
                        <ul class="space-y-3">
                            @if($pendingSelfReviews > 0)
                                <li>
                                    <a href="{{ route('performance.my-reviews') }}" class="flex items-center justify-between p-2 rounded-lg hover:bg-purple-50 transition-all">
                                        <div class="flex items-center gap-2.5">
                                            <i class="fas fa-user text-purple-500"></i>
                                            <span class="text-xs text-slate-700 font-medium">({{ $pendingSelfReviews }}) Pending Self Review</span>
                                        </div>
                                    </a>
                                </li>
                            @endif
                            @if($pendingCandidates > 0)
                                <li>
                                    <a href="{{ route('recruitment') }}" class="flex items-center justify-between p-2 rounded-lg hover:bg-purple-50 transition-all">
                                        <div class="flex items-center gap-2.5">
                                            <i class="fas fa-user text-purple-500"></i>
                                            <span class="text-xs text-slate-700 font-medium">({{ $pendingCandidates }}) Candidate to Interview</span>
                                        </div>
                                    </a>
                                </li>
                            @endif
                            @if($pendingSelfReviews == 0 && $pendingCandidates == 0)
                                <li>
                                    <div class="flex items-center justify-between p-2 rounded-lg">
                                        <div class="flex items-center gap-2.5">
                                            <i class="fas fa-check-circle text-green-500"></i>
                                            <span class="text-xs text-slate-500 font-medium">No pending actions</span>
                                        </div>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </section>

                    <!-- Quick Launch Card -->
                    <section class="hr-card p-6">
                        <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2 mb-5">
                            <i class="fas fa-bolt text-purple-500"></i> Quick Launch
                        </h2>
                        <div class="grid grid-cols-3 gap-3">
                            <a href="{{ route('leave.assign-leave') }}" class="flex flex-col items-center gap-2 cursor-pointer p-2 rounded-lg hover:bg-purple-50 transition-all group">
                                <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-purple-100 to-purple-200 flex items-center justify-center text-purple-600 text-base shadow-sm group-hover:shadow-md group-hover:scale-105 transition-all"><i class="fas fa-check"></i></div>
                                <span class="text-[10px] text-slate-700 text-center font-medium">Assign Leave</span>
                            </a>
                            <a href="{{ route('leave.leave-list') }}" class="flex flex-col items-center gap-2 cursor-pointer p-2 rounded-lg hover:bg-purple-50 transition-all group">
                                <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-purple-100 to-purple-200 flex items-center justify-center text-purple-600 text-base shadow-sm group-hover:shadow-md group-hover:scale-105 transition-all"><i class="fas fa-list"></i></div>
                                <span class="text-[10px] text-slate-700 text-center font-medium">Leave List</span>
                            </a>
                            <a href="{{ route('time') }}" class="flex flex-col items-center gap-2 cursor-pointer p-2 rounded-lg hover:bg-purple-50 transition-all group">
                                <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-purple-100 to-purple-200 flex items-center justify-center text-purple-600 text-base shadow-sm group-hover:shadow-md group-hover:scale-105 transition-all"><i class="fas fa-clock"></i></div>
                                <span class="text-[10px] text-slate-700 text-center font-medium">Timesheets</span>
                            </a>
                            <a href="{{ route('leave.apply') }}" class="flex flex-col items-center gap-2 cursor-pointer p-2 rounded-lg hover:bg-purple-50 transition-all group">
                                <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-purple-100 to-purple-200 flex items-center justify-center text-purple-600 text-base shadow-sm group-hover:shadow-md group-hover:scale-105 transition-all"><i class="fas fa-paper-plane"></i></div>
                                <span class="text-[10px] text-slate-700 text-center font-medium">Apply Leave</span>
                            </a>
                            <a href="{{ route('leave.my-leave') }}" class="flex flex-col items-center gap-2 cursor-pointer p-2 rounded-lg hover:bg-purple-50 transition-all group">
                                <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-purple-100 to-purple-200 flex items-center justify-center text-purple-600 text-base shadow-sm group-hover:shadow-md group-hover:scale-105 transition-all"><i class="fas fa-user"></i></div>
                                <span class="text-[10px] text-slate-700 text-center font-medium">My Leave</span>
                            </a>
                            <a href="{{ route('time') }}" class="flex flex-col items-center gap-2 cursor-pointer p-2 rounded-lg hover:bg-purple-50 transition-all group">
                                <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-purple-100 to-purple-200 flex items-center justify-center text-purple-600 text-base shadow-sm group-hover:shadow-md group-hover:scale-105 transition-all"><i class="fas fa-clock"></i></div>
                                <span class="text-[10px] text-slate-700 text-center font-medium">My Timesheet</span>
                            </a>
                        </div>
                    </section>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Buzz Latest Posts -->
                    <section class="hr-card p-6">
                        <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2 mb-5">
                            <i class="fas fa-camera text-purple-500"></i> Buzz Latest Posts
                        </h2>
                        <div class="space-y-3 max-h-80 overflow-y-auto buzz-scroll">
                            @forelse($latestBuzz as $post)
                                <a href="{{ route('buzz') }}" class="flex items-start gap-3 pb-3 border-b border-purple-100 last:border-0 hover:bg-purple-50/50 p-2 rounded-lg transition-all cursor-pointer block">
                                    <div class="h-9 w-9 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center text-xs font-bold text-white flex-shrink-0 shadow-sm">
                                        {{ strtoupper(substr($post->author_name, 0, 2)) }}
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-xs font-bold text-slate-800">{{ $post->author_name }}</div>
                                        <div class="text-[10px] text-purple-500 mb-1 font-medium">
                                            {{ $post->created_at }}
                                        </div>
                                        <p class="text-xs text-slate-600 leading-relaxed">
                                            {{ $post->content }}
                                        </p>
                                    </div>
                                </a>
                            @empty
                                <div class="text-xs text-slate-500 italic">
                                    No Buzz posts yet.
                                </div>
                            @endforelse
                        </div>
                    </section>

                    <!-- Employees on Leave Today -->
                    <section class="hr-card p-6">
                        <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2 mb-5">
                            <i class="fas fa-user text-purple-500"></i> Employees on Leave Today
                        </h2>
                        @if($employeesOnLeave->count() > 0)
                            <div class="space-y-2 max-h-48 overflow-y-auto">
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
                            <div class="flex flex-col items-center justify-center h-48 text-center">
                                <i class="fas fa-clipboard text-5xl mb-3 opacity-60 text-purple-400"></i>
                                <p class="text-xs text-slate-600 font-medium">No Employees are on Leave Today</p>
                            </div>
                        @endif
                    </section>

                    <!-- Employee Distribution by Location -->
                    <section id="location-chart-section" class="hr-card p-6 lg:col-span-1">
                        <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2 mb-5">
                            <span class="text-purple-500">📊</span> Employee Distribution by Location
                        </h2>
                        <div class="flex items-center justify-center mb-3 py-4">
                            <div class="relative flex items-center justify-center" style="width: 200px; height: 200px; padding: 10px;">
                                <svg id="location-pie-chart" viewBox="0 0 120 120" class="w-full h-full" preserveAspectRatio="xMidYMid meet" style="overflow: visible;">
                                    <!-- Pie chart will be generated by JavaScript -->
                                </svg>
                            </div>
                        </div>
                        <div class="space-y-1 text-[10px]" id="location-legend">
                            @php
                                $locationColors = ['#ef4444', '#f97316', '#eab308', '#22c55e', '#3b82f6', '#8b5cf6', '#ec4899', '#14b8a6'];
                            @endphp
                            @if(count($locationData) > 0)
                                @foreach($locationData as $index => $item)
                                    <div class="flex items-center gap-2 pie-legend-item cursor-pointer hover:text-[var(--color-hr-primary)] transition-colors" data-segment="{{ $index }}">
                                        <span class="h-2 w-2 rounded-full" style="background-color: {{ $locationColors[$index % count($locationColors)] }};"></span> {{ $item['label'] }} ({{ $item['count'] }})
                                    </div>
                                @endforeach
                            @else
                                <div class="text-xs text-slate-500 text-center py-4">No data available</div>
                            @endif
                        </div>
                    </section>
                </div>
                </div>
    </x-main-layout>

    <script>
        // Helper function to create pie chart paths
        function createPiePath(cx, cy, radius, startAngle, endAngle, innerRadius = 0) {
            const start = polarToCartesian(cx, cy, radius, endAngle);
            const end = polarToCartesian(cx, cy, radius, startAngle);
            const largeArcFlag = endAngle - startAngle <= 180 ? "0" : "1";
            
            if (innerRadius === 0) {
                return `M ${cx},${cy} L ${start.x},${start.y} A ${radius},${radius} 0 ${largeArcFlag},0 ${end.x},${end.y} Z`;
            } else {
                const innerStart = polarToCartesian(cx, cy, innerRadius, endAngle);
                const innerEnd = polarToCartesian(cx, cy, innerRadius, startAngle);
                return `M ${start.x},${start.y} A ${radius},${radius} 0 ${largeArcFlag},0 ${end.x},${end.y} L ${innerEnd.x},${innerEnd.y} A ${innerRadius},${innerRadius} 0 ${largeArcFlag},1 ${innerStart.x},${innerStart.y} Z`;
            }
        }
        
        function polarToCartesian(centerX, centerY, radius, angleInDegrees) {
            const angleInRadians = (angleInDegrees - 90) * Math.PI / 180.0;
            return {
                x: centerX + (radius * Math.cos(angleInRadians)),
                y: centerY + (radius * Math.sin(angleInRadians))
            };
        }

        // Tooltip management
        let tooltipElement = null;
        
        function showTooltip(event, label, value, count, svgElement) {
            // Remove existing tooltip
            if (tooltipElement) {
                tooltipElement.remove();
                tooltipElement = null;
            }
            
            tooltipElement = document.createElement('div');
            tooltipElement.id = 'pie-tooltip';
            tooltipElement.className = 'fixed bg-gray-900 text-white text-xs px-3 py-2 rounded shadow-xl z-[9999] pointer-events-none border border-gray-700';
            tooltipElement.style.fontFamily = 'system-ui, sans-serif';
            tooltipElement.style.whiteSpace = 'nowrap';
            tooltipElement.style.opacity = '0';
            tooltipElement.style.transition = 'opacity 0.15s ease';
            tooltipElement.innerHTML = `<strong>${label}</strong> ${count} (${value.toFixed(2)}%)`;
            document.body.appendChild(tooltipElement);
            
            // Position above chart center
            const svgRect = svgElement.getBoundingClientRect();
            const chartCenterX = svgRect.left + svgRect.width / 2;
            const chartTop = svgRect.top;
            
            const tooltipX = chartCenterX - (tooltipElement.offsetWidth / 2);
            const tooltipY = chartTop - tooltipElement.offsetHeight - 12;
            
            tooltipElement.style.left = Math.max(10, Math.min(window.innerWidth - tooltipElement.offsetWidth - 10, tooltipX)) + 'px';
            tooltipElement.style.top = Math.max(10, tooltipY) + 'px';
            
            // Fade in
            setTimeout(() => {
                if (tooltipElement) {
                    tooltipElement.style.opacity = '1';
                }
            }, 10);
        }
        
        function hideTooltip() {
            if (tooltipElement) {
                tooltipElement.style.opacity = '0';
                setTimeout(() => {
                    if (tooltipElement) {
                        tooltipElement.remove();
                        tooltipElement = null;
                    }
                }, 150);
            }
        }

        // Interactive pie chart functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Data from database
            const locationDataRaw = @json($locationData);
            
            // Color palette
            const colors = ['#ef4444', '#f97316', '#eab308', '#22c55e', '#3b82f6', '#8b5cf6', '#ec4899', '#14b8a6'];
            
            const locationData = locationDataRaw.map((item, index) => ({
                label: item.label,
                value: item.value,
                count: item.count,
                color: colors[index % colors.length]
            }));
            
            // Normalize to ensure exactly 100% total
            function normalizeData(data) {
                if (!data || data.length === 0) {
                    return [];
                }
                
                const total = data.reduce((sum, item) => sum + item.value, 0);
                if (total === 0) {
                    return [];
                }
                
                const normalized = data.map(item => ({
                    ...item,
                    normalizedValue: (item.value / total) * 100
                }));
                
                // Ensure last item accounts for any rounding errors
                let sum = normalized.reduce((s, item) => s + item.normalizedValue, 0);
                if (normalized.length > 0) {
                    normalized[normalized.length - 1].normalizedValue += (100 - sum);
                }
                
                return normalized;
            }
            
            const normalizedLocation = normalizeData(locationData);
            
            // Function to render a pie chart
            function renderPieChart(svgElement, data, chartId) {
                if (!svgElement) {
                    console.error('SVG element not found for chart:', chartId);
                    return;
                }
                
                svgElement.innerHTML = '';
                
                if (!data || data.length === 0) {
                    // Show empty state
                    const text = document.createElementNS('http://www.w3.org/2000/svg', 'text');
                    text.setAttribute('x', '60');
                    text.setAttribute('y', '60');
                    text.setAttribute('text-anchor', 'middle');
                    text.setAttribute('dominant-baseline', 'middle');
                    text.setAttribute('fill', '#94a3b8');
                    text.setAttribute('font-size', '12');
                    text.textContent = 'No Data';
                    svgElement.appendChild(text);
                    return;
                }
                
                let currentAngle = -90; // Start from top (12 o'clock)
                
                data.forEach((item, index) => {
                    const startAngle = currentAngle;
                    let endAngle;
                    
                    if (index === data.length - 1) {
                        // Last segment: ensure it closes the circle perfectly
                        endAngle = -90 + 360;
                    } else {
                        endAngle = currentAngle + (item.normalizedValue / 100 * 360);
                    }
                    
                    const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
                    path.setAttribute('d', createPiePath(60, 60, 50, startAngle, endAngle, 30));
                    path.setAttribute('fill', item.color);
                    path.setAttribute('class', `pie-segment pie-segment-${chartId}`);
                    path.setAttribute('data-label', item.label);
                    path.setAttribute('data-value', item.normalizedValue.toFixed(2));
                    path.setAttribute('data-count', item.count);
                    path.setAttribute('data-index', index);
                    path.style.stroke = 'white';
                    path.style.strokeWidth = '1.5';
                    path.style.pointerEvents = 'all';
                    path.style.cursor = 'pointer';
                    path.style.transition = 'all 0.2s ease';
                    
                    // Hover effects
                    path.addEventListener('mouseenter', function(e) {
                        this.style.opacity = '0.9';
                        this.style.filter = 'brightness(1.1)';
                        this.style.transform = 'scale(1.02)';
                        this.style.transformOrigin = 'center';
                        
                        const label = this.getAttribute('data-label');
                        const value = parseFloat(this.getAttribute('data-value')) || 0;
                        const count = this.getAttribute('data-count') || '0';
                        showTooltip(e, label, value, count, svgElement);
                    });
                    
                    path.addEventListener('mouseleave', function() {
                        this.style.opacity = '1';
                        this.style.filter = 'brightness(1)';
                        this.style.transform = 'scale(1)';
                        hideTooltip();
                    });
                    
                    svgElement.appendChild(path);
                    currentAngle = endAngle;
                });
                
                // Center white circle
                const centerCircle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
                centerCircle.setAttribute('cx', '60');
                centerCircle.setAttribute('cy', '60');
                centerCircle.setAttribute('r', '30');
                centerCircle.setAttribute('fill', 'white');
                centerCircle.style.pointerEvents = 'none';
                svgElement.appendChild(centerCircle);
            }
            
            // Location Chart - using ID selector
            const locationSvg = document.getElementById('location-pie-chart');
            if (locationSvg && normalizedLocation.length > 0) {
                renderPieChart(locationSvg, normalizedLocation, 'location');
            } else if (locationSvg) {
                renderPieChart(locationSvg, [], 'location');
            }

            // Legend hover effects
            const legendItems = document.querySelectorAll('.pie-legend-item');
            legendItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    const segmentIndex = parseInt(this.getAttribute('data-segment'));
                    const section = this.closest('section');
                    const segments = section.querySelectorAll('.pie-segment');
                    if (segments[segmentIndex]) {
                        segments[segmentIndex].style.opacity = '0.7';
                        segments[segmentIndex].style.transform = 'scale(1.05)';
                        segments[segmentIndex].style.transformOrigin = 'center';
                    }
                });
                
                item.addEventListener('mouseleave', function() {
                    const segmentIndex = parseInt(this.getAttribute('data-segment'));
                    const section = this.closest('section');
                    const segments = section.querySelectorAll('.pie-segment');
                    if (segments[segmentIndex]) {
                        segments[segmentIndex].style.opacity = '1';
                        segments[segmentIndex].style.transform = 'scale(1)';
                    }
                });
            });
        });
    </script>

    <style>
        .buzz-scroll {
            scrollbar-width: thin; /* Firefox */
            scrollbar-color: #a855f7 transparent;
        }

        .buzz-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .buzz-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .buzz-scroll::-webkit-scrollbar-thumb {
            background-color: #a855f7;
            border-radius: 9999px;
        }
    </style>
@endsection


 