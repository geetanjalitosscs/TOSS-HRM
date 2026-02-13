@extends('layouts.app')

@section('title', 'Performance - My Trackers')

@section('body')
    <x-main-layout title="Performance">
        <!-- Top Navigation Tabs -->
        <div class="hr-sticky-tabs">
            <div class="flex items-center border-b border-[var(--border-default)] overflow-x-auto overflow-y-visible flex-nowrap">
                <x-dropdown-menu 
                    :items="[
                        ['url' => route('performance.kpis'), 'label' => 'KPIs'],
                        ['url' => route('performance.trackers'), 'label' => 'Trackers']
                    ]"
                    position="left"
                    width="w-48">
                    <div class="px-6 py-3 hover:bg-[var(--color-primary-light)] cursor-pointer transition-all flex items-center gap-2 flex-shrink-0 whitespace-nowrap">
                        <span class="text-sm font-medium text-slate-700">Configure</span>
                        <x-dropdown-arrow class="flex-shrink-0" />
                    </div>
                </x-dropdown-menu>
                <x-dropdown-menu 
                    :items="[
                        ['url' => route('performance'), 'label' => 'Manage Reviews'],
                        ['url' => route('performance.my-reviews'), 'label' => 'My Reviews'],
                        ['url' => route('performance.employee-reviews'), 'label' => 'Employee Reviews']
                    ]"
                    position="left"
                    width="w-48">
                    <div class="px-6 py-3 hover:bg-[var(--color-primary-light)] cursor-pointer transition-all flex items-center gap-2 flex-shrink-0 whitespace-nowrap">
                        <span class="text-sm font-medium text-slate-700">Manage Reviews</span>
                        <x-dropdown-arrow class="flex-shrink-0" />
                    </div>
                </x-dropdown-menu>
                <div class="px-6 py-3 border-b-2 border-[var(--color-hr-primary)] bg-[var(--color-primary-light)] flex items-center flex-shrink-0 whitespace-nowrap">
                    <span class="text-sm font-semibold text-[var(--color-hr-primary-dark)]">My Trackers</span>
                </div>
                <a href="{{ route('performance.employee-trackers') }}" class="px-6 py-3 hover:bg-[var(--color-primary-light)] cursor-pointer transition-all flex items-center flex-shrink-0 whitespace-nowrap">
                    <span class="text-sm font-medium text-slate-700">Employee Trackers</span>
                </a>
            </div>
        </div>

        <!-- My Performance Trackers Section -->
        <section class="hr-card p-6">
            <h2 class="text-sm font-bold text-slate-800 flex items-baseline gap-2 mb-5">
                <i class="fas fa-chart-line text-[var(--color-primary)]"></i> <span class="mt-0.5">My Performance Trackers</span>
            </h2>

            @if(count($trackers) > 0)
            <!-- Records Count -->
            <x-records-found :count="count($trackers)" />

            <!-- Table Header -->
            <div class="rounded-t-lg pl-1 pr-2 py-1.5 flex items-center gap-1 border-b" style="background-color: var(--bg-hover); border-color: var(--border-default);">
                <div class="flex-1" style="min-width: 0;">
                    <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Tracker</div>
                </div>
                <div class="flex-1" style="min-width: 0;">
                    <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Added Date</div>
                </div>
                <div class="flex-1" style="min-width: 0;">
                    <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Modified Date</div>
                </div>
                <div class="flex-1" style="min-width: 0;">
                    <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Status</div>
                </div>
                <div class="flex-1" style="min-width: 0;">
                    <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Employee</div>
                </div>
                <div class="flex-shrink-0" style="width: 120px;">
                    <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words text-center" style="color: var(--text-primary);">Actions</div>
                </div>
            </div>

            <!-- Table Rows -->
            <div class="border border-t-0 rounded-b-lg" style="border-color: var(--border-default);">
                @foreach($trackers as $tracker)
                <div class="border-b last:border-b-0 pl-1 pr-2 py-1.5 transition-colors flex items-center gap-1" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs font-medium break-words" style="color: var(--text-primary);">{{ $tracker->tracker }}</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs break-words" style="color: var(--text-primary);">{{ $tracker->added_date }}</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs break-words" style="color: var(--text-primary);">{{ $tracker->modified_date }}</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs break-words" style="color: var(--text-primary);">
                            @php
                                $statusLabelMap = [
                                    'not_started' => 'Not Started',
                                    'in_progress' => 'In Progress',
                                    'completed'   => 'Completed',
                                    'approved'    => 'Approved',
                                ];
                                $statusValue = $tracker->status ?? 'not_started';
                            @endphp
                            {{ $statusLabelMap[$statusValue] ?? ucfirst(str_replace('_', ' ', $statusValue)) }}
                        </div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs break-words" style="color: var(--text-primary);">{{ $tracker->employee_name ?? '-' }}</div>
                    </div>
                    <div class="flex-shrink-0" style="width: 120px;">
                        <div class="flex items-center justify-center gap-2">
                            @if(in_array($tracker->status, ['not_started', 'in_progress']))
                                <button
                                    class="hr-btn-primary px-3 py-1 text-xs font-medium"
                                    title="Fill Self-Review"
                                    type="button"
                                    onclick="event.stopPropagation(); openMyTrackerRateKpisModal({{ $tracker->id }}); return false;"
                                >
                                    <i class="fas fa-edit text-xs mr-1"></i> Fill Form
                                </button>
                            @else
                                <button class="hr-action-view flex-shrink-0" title="View" type="button">
                                    <i class="fas fa-file-alt text-sm"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <!-- No Records Found -->
            <div class="mb-3 text-xs font-medium" style="color: var(--text-muted);">
                No Records Found
            </div>
            @endif
        </section>

        <!-- Rate KPIs Modal (My Trackers) -->
        <x-admin.modal
            id="my-tracker-rate-kpis-modal"
            title="Rate KPIs"
            icon="fas fa-star"
            maxWidth="lg"
            backdropOnClick="closeMyTrackerRateKpisModal(true)"
        >
            <form method="POST" id="my-tracker-rate-kpis-form" action="#" style="display: flex; flex-direction: column; height: 100%;">
                @csrf
                <!-- Scrollable content area so header/footer stay fixed and body scrolls -->
                <div
                    id="my-tracker-scroll-container"
                    style="flex: 1 1 auto; overflow-y: auto; min-height: 0; max-height: calc(90vh - 200px); padding-right: 4px;"
                >
                    <div id="my-tracker-kpis-container" class="mb-4">
                        <p class="text-xs mb-3" style="color: var(--text-muted);">Loading KPIs...</p>
                    </div>
                    <div id="my-tracker-overall-comments-section" class="mb-4" style="display: none;">
                        <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                            Overall Comments
                        </label>
                        <textarea
                            name="review_comments"
                            id="my-tracker-review-comments"
                            rows="3"
                            class="hr-input px-3 py-1.5 text-xs w-full"
                            style="background-color: var(--bg-input); color: var(--text-primary);"
                            placeholder="Enter overall review comments..."
                        ></textarea>
                    </div>
                </div>
                <!-- Buttons section - always visible at bottom -->
                <div id="my-tracker-buttons-section" class="flex justify-end gap-2 pt-3 border-t" style="display: none; flex-shrink: 0; border-color: var(--border-default); margin-top: auto;">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeMyTrackerRateKpisModal(true)"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                    >
                        Submit Review
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <script>
            let currentMyTrackerId = null;

            function openMyTrackerRateKpisModal(trackerId) {
                currentMyTrackerId = trackerId;

                const modal = document.getElementById('my-tracker-rate-kpis-modal');
                const container = document.getElementById('my-tracker-kpis-container');
                const form = document.getElementById('my-tracker-rate-kpis-form');
                const overallCommentsSection = document.getElementById('my-tracker-overall-comments-section');
                const buttonsSection = document.getElementById('my-tracker-buttons-section');

                if (!modal || !container || !form) {
                    console.error('My Tracker KPIs modal elements not found');
                    return;
                }

                // Initial loading state - hide overall comments and buttons
                container.innerHTML = '<p class="text-xs mb-3" style="color: var(--text-muted);">Loading KPIs...</p>';
                if (overallCommentsSection) overallCommentsSection.style.display = 'none';
                if (buttonsSection) buttonsSection.style.display = 'none';

                // Show modal with scroll (handled by component max-height)
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';

                // Load KPIs for this tracker
                fetch("{{ route('performance.reviews.kpis', ['id' => '__ID__']) }}".replace('__ID__', trackerId))
                    .then(response => response.json())
                    .then(data => {
                        let html = '';

                        if (!Array.isArray(data) || data.length === 0) {
                            html = '<p class="text-xs mb-3" style="color: var(--text-muted);">No KPIs found for this review.</p>';
                        } else {
                            data.forEach(function (kpi) {
                                html += '<div class="mb-4 p-3 rounded" style="background-color: var(--bg-hover); border: 1px solid var(--border-default);">';
                                html += '  <div class="mb-2">';
                                html += '    <label class="block text-xs font-semibold mb-1" style="color: var(--text-primary);">' + (kpi.kpi_name || 'KPI') + '</label>';
                                if (kpi.kpi_description) {
                                    html += '    <p class="text-xs mb-2" style="color: var(--text-muted);">' + kpi.kpi_description + '</p>';
                                }
                                html += '    <span class="text-xs" style="color: var(--text-muted);">Weight: ' + (kpi.kpi_weight || 0) + '</span>';
                                html += '  </div>';

                                html += '  <div class="mb-2">';
                                html += '    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Rating (0-100)</label>';
                                html += '    <input type="number" name="kpi_ratings[' + kpi.kpi_id + '][rating]" value="' + (kpi.rating || '') + '" min="0" max="100" step="0.01" class="hr-input px-3 py-1.5 text-xs w-full" style="background-color: var(--bg-input); color: var(--text-primary);" placeholder="Enter rating (0-100)...">';
                                html += '  </div>';

                                html += '  <div>';
                                html += '    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Comments</label>';
                                html += '    <textarea name="kpi_ratings[' + kpi.kpi_id + '][comments]" rows="2" class="hr-input px-3 py-1.5 text-xs w-full" style="background-color: var(--bg-input); color: var(--text-primary);" placeholder="Enter comments...">' + (kpi.comments || '') + '</textarea>';
                                html += '  </div>';

                                html += '</div>';
                            });
                        }

                        container.innerHTML = html;
                        // Set form action so normal submit hits controller and updates DB
                        form.action = "{{ route('performance.reviews.submit', ['id' => '__ID__']) }}".replace('__ID__', trackerId);
                        
                        // Show overall comments and buttons after KPIs are loaded
                        if (overallCommentsSection) overallCommentsSection.style.display = 'block';
                        if (buttonsSection) buttonsSection.style.display = 'flex';
                    })
                    .catch(error => {
                        console.error('Error loading KPIs:', error);
                        container.innerHTML = '<p class="text-xs mb-3" style="color: #DC2626;">Error loading KPIs. Please try again.</p>';
                    });
            }
            window.openMyTrackerRateKpisModal = openMyTrackerRateKpisModal;

            function closeMyTrackerRateKpisModal(reset) {
                const modal = document.getElementById('my-tracker-rate-kpis-modal');
                if (modal) {
                    modal.classList.add('hidden');
                }
                document.body.style.overflow = '';

                if (reset) {
                    const form = document.getElementById('my-tracker-rate-kpis-form');
                    if (form) {
                        form.reset();
                    }
                    const container = document.getElementById('my-tracker-kpis-container');
                    if (container) {
                        container.innerHTML = '<p class="text-xs mb-3" style="color: var(--text-muted);">Loading KPIs...</p>';
                    }
                    const overallCommentsSection = document.getElementById('my-tracker-overall-comments-section');
                    const buttonsSection = document.getElementById('my-tracker-buttons-section');
                    if (overallCommentsSection) overallCommentsSection.style.display = 'none';
                    if (buttonsSection) buttonsSection.style.display = 'none';
                    currentMyTrackerId = null;
                }
            }
            window.closeMyTrackerRateKpisModal = closeMyTrackerRateKpisModal;
        </script>

    </x-main-layout>
@endsection

