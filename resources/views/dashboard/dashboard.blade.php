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
                                <div class="text-xs text-[var(--color-hr-primary)] font-semibold mb-1 uppercase tracking-wide">Punched Out</div>
                                <div class="text-xs text-slate-500 mb-2">Punched Out: Mar 29th at 01:19 PM (GMT 7)</div>
                                <div class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-purple-800 bg-clip-text text-transparent">0h 0m Today</div>
                            </div>
                        </div>
                        <div class="mt-5 pt-4 border-t border-purple-100">
                            <div class="text-xs text-slate-600 font-medium mb-3">This Week Jan 19 - Jan 25</div>
                            <div class="flex items-end gap-1.5 h-24">
                                @for ($i = 0; $i < 7; $i++)
                                    <div class="flex-1 flex flex-col items-center">
                                        <div class="w-full bg-gradient-to-t from-purple-400 to-purple-300 rounded-t shadow-sm" style="height: 20px;"></div>
                                        <div class="text-[9px] text-slate-600 mt-1 font-medium">0h 0m</div>
                                    </div>
                                @endfor
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
                            <li class="flex items-center justify-between p-2 rounded-lg hover:bg-purple-50 transition-all">
                                <div class="flex items-center gap-2.5">
                                    <i class="fas fa-user text-purple-500"></i>
                                    <span class="text-xs text-slate-700 font-medium">(1) Pending Self Review</span>
                                </div>
                            </li>
                            <li class="flex items-center justify-between p-2 rounded-lg hover:bg-purple-50 transition-all">
                                <div class="flex items-center gap-2.5">
                                    <i class="fas fa-user text-purple-500"></i>
                                    <span class="text-xs text-slate-700 font-medium">(1) Candidate to Interview</span>
                                </div>
                            </li>
                        </ul>
                    </section>

                    <!-- Quick Launch Card -->
                    <section class="hr-card p-6">
                        <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2 mb-5">
                            <i class="fas fa-bolt text-purple-500"></i> Quick Launch
                        </h2>
                        <div class="grid grid-cols-3 gap-3">
                            <a href="{{ route('leave') }}" class="flex flex-col items-center gap-2 cursor-pointer p-2 rounded-lg hover:bg-purple-50 transition-all group">
                                <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-purple-100 to-purple-200 flex items-center justify-center text-purple-600 text-base shadow-sm group-hover:shadow-md group-hover:scale-105 transition-all"><i class="fas fa-check"></i></div>
                                <span class="text-[10px] text-slate-700 text-center font-medium">Assign Leave</span>
                            </a>
                            <a href="{{ route('leave') }}" class="flex flex-col items-center gap-2 cursor-pointer p-2 rounded-lg hover:bg-purple-50 transition-all group">
                                <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-purple-100 to-purple-200 flex items-center justify-center text-purple-600 text-base shadow-sm group-hover:shadow-md group-hover:scale-105 transition-all"><i class="fas fa-list"></i></div>
                                <span class="text-[10px] text-slate-700 text-center font-medium">Leave List</span>
                            </a>
                            <a href="{{ route('time') }}" class="flex flex-col items-center gap-2 cursor-pointer p-2 rounded-lg hover:bg-purple-50 transition-all group">
                                <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-purple-100 to-purple-200 flex items-center justify-center text-purple-600 text-base shadow-sm group-hover:shadow-md group-hover:scale-105 transition-all"><i class="fas fa-clock"></i></div>
                                <span class="text-[10px] text-slate-700 text-center font-medium">Timesheets</span>
                            </a>
                            <a href="{{ route('leave') }}" class="flex flex-col items-center gap-2 cursor-pointer p-2 rounded-lg hover:bg-purple-50 transition-all group">
                                <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-purple-100 to-purple-200 flex items-center justify-center text-purple-600 text-base shadow-sm group-hover:shadow-md group-hover:scale-105 transition-all"><i class="fas fa-paper-plane"></i></div>
                                <span class="text-[10px] text-slate-700 text-center font-medium">Apply Leave</span>
                            </a>
                            <a href="{{ route('leave') }}" class="flex flex-col items-center gap-2 cursor-pointer p-2 rounded-lg hover:bg-purple-50 transition-all group">
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
                        <div class="space-y-3 max-h-80 overflow-y-auto">
                            @for ($i = 0; $i < 3; $i++)
                                <div class="flex items-start gap-3 pb-3 border-b border-purple-100 last:border-0 hover:bg-purple-50/50 p-2 rounded-lg transition-all">
                                    <div class="h-9 w-9 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center text-xs font-bold text-white flex-shrink-0 shadow-sm">
                                        RS
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-xs font-bold text-slate-800">Raman Sharma</div>
                                        <div class="text-[10px] text-purple-500 mb-1 font-medium">2026-01-20 09:48 PM</div>
                                        <p class="text-xs text-slate-600 leading-relaxed">This is a sample update in the TOAI HR buzz feed.</p>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </section>

                    <!-- Employees on Leave Today -->
                    <section class="hr-card p-6">
                        <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2 mb-5">
                            <i class="fas fa-user text-purple-500"></i> Employees on Leave Today
                        </h2>
                        <div class="flex flex-col items-center justify-center h-48 text-center">
                            <i class="fas fa-clipboard text-5xl mb-3 opacity-60 text-purple-400"></i>
                            <p class="text-xs text-slate-600 font-medium">No Employees are on Leave Today</p>
                        </div>
                    </section>

                    <!-- Employee Distribution by Sub Unit -->
                    <section class="hr-card p-6">
                        <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2 mb-5">
                            <i class="fas fa-chart-pie text-purple-500"></i> Employee Distribution by Sub Unit
                        </h2>
                        <div class="flex items-center justify-center mb-3 py-4">
                            <div class="relative flex items-center justify-center" style="width: 200px; height: 200px; padding: 10px;">
                                <svg viewBox="0 0 120 120" class="w-full h-full" preserveAspectRatio="xMidYMid meet" style="overflow: visible;">
                                    <!-- Pie chart will be generated by JavaScript -->
                                </svg>
                            </div>
                        </div>
                        <div class="space-y-1 text-[10px]">
                            <div class="flex items-center gap-2 pie-legend-item cursor-pointer hover:text-[var(--color-hr-primary)] transition-colors" data-segment="0">
                                <span class="h-2 w-2 rounded-full" style="background-color: #ef4444;"></span> Engineering
                            </div>
                            <div class="flex items-center gap-2 pie-legend-item cursor-pointer hover:text-[var(--color-hr-primary)] transition-colors" data-segment="1">
                                <span class="h-2 w-2 rounded-full" style="background-color: #f97316;"></span> Human Resources
                            </div>
                            <div class="flex items-center gap-2 pie-legend-item cursor-pointer hover:text-[var(--color-hr-primary)] transition-colors" data-segment="2">
                                <span class="h-2 w-2 rounded-full" style="background-color: #eab308;"></span> Administration
                            </div>
                            <div class="flex items-center gap-2 pie-legend-item cursor-pointer hover:text-[var(--color-hr-primary)] transition-colors" data-segment="3">
                                <span class="h-2 w-2 rounded-full" style="background-color: #22c55e;"></span> Client Services
                            </div>
                        </div>
                    </section>

                    <!-- Employee Distribution by Location -->
                    <section class="bg-white rounded-lg shadow-sm p-5 lg:col-span-1">
                        <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2 mb-5">
                            <span class="text-purple-500">📊</span> Employee Distribution by Location
                        </h2>
                        <div class="flex items-center justify-center mb-3 py-4">
                            <div class="relative flex items-center justify-center" style="width: 200px; height: 200px; padding: 10px;">
                                <svg viewBox="0 0 120 120" class="w-full h-full" preserveAspectRatio="xMidYMid meet" style="overflow: visible;">
                                    <!-- Pie chart will be generated by JavaScript -->
                                </svg>
                            </div>
                        </div>
                        <div class="space-y-1 text-[10px]">
                            <div class="flex items-center gap-2 pie-legend-item cursor-pointer hover:text-[var(--color-hr-primary)] transition-colors" data-segment="0">
                                <span class="h-2 w-2 rounded-full" style="background-color: #ef4444;"></span> Unassigned
                            </div>
                            <div class="flex items-center gap-2 pie-legend-item cursor-pointer hover:text-[var(--color-hr-primary)] transition-colors" data-segment="1">
                                <span class="h-2 w-2 rounded-full" style="background-color: #f97316;"></span> Texas R&D
                            </div>
                            <div class="flex items-center gap-2 pie-legend-item cursor-pointer hover:text-[var(--color-hr-primary)] transition-colors" data-segment="2">
                                <span class="h-2 w-2 rounded-full" style="background-color: #eab308;"></span> New York Sales
                            </div>
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
            // Data with exact percentages that sum to 100%
            const subUnitData = [
                { label: 'Engineering', value: 95.5, count: 127, color: '#ef4444' },
                { label: 'Human Resources', value: 2.0, count: 3, color: '#f97316' },
                { label: 'Administration', value: 1.75, count: 2, color: '#eab308' },
                { label: 'Client Services', value: 0.75, count: 1, color: '#22c55e' }
            ];
            
            const locationData = [
                { label: 'Unassigned', value: 95.2, count: 127, color: '#ef4444' },
                { label: 'Texas R&D', value: 2.0, count: 3, color: '#f97316' },
                { label: 'New York Sales', value: 2.8, count: 4, color: '#eab308' }
            ];
            
            // Normalize to ensure exactly 100% total
            function normalizeData(data) {
                const total = data.reduce((sum, item) => sum + item.value, 0);
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
            
            const normalizedSubUnit = normalizeData(subUnitData);
            const normalizedLocation = normalizeData(locationData);
            
            // Function to render a pie chart
            function renderPieChart(svgElement, data, chartId) {
                svgElement.innerHTML = '';
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
            
            // Sub Unit Chart
            const subUnitSection = Array.from(document.querySelectorAll('section')).find(s => 
                s.textContent.includes('Employee Distribution by Sub Unit')
            );
            const subUnitSvg = subUnitSection?.querySelector('svg');
            if (subUnitSvg) {
                renderPieChart(subUnitSvg, normalizedSubUnit, 'subunit');
            }
            
            // Location Chart
            const locationSection = Array.from(document.querySelectorAll('section')).find(s => 
                s.textContent.includes('Employee Distribution by Location')
            );
            const locationSvg = locationSection?.querySelector('svg');
            if (locationSvg) {
                renderPieChart(locationSvg, normalizedLocation, 'location');
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
@endsection


 