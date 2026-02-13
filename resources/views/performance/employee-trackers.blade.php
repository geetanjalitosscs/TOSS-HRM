@extends('layouts.app')

@section('title', 'Performance - Employee Trackers')

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
                <a href="{{ route('performance.my-trackers') }}" class="px-6 py-3 hover:bg-[var(--color-primary-light)] cursor-pointer transition-all flex items-center flex-shrink-0 whitespace-nowrap">
                    <span class="text-sm font-medium text-slate-700">My Trackers</span>
                </a>
                <div class="px-6 py-3 border-b-2 border-[var(--color-hr-primary)] bg-[var(--color-primary-light)] flex items-center flex-shrink-0 whitespace-nowrap">
                    <span class="text-sm font-semibold text-[var(--color-hr-primary-dark)]">Employee Trackers</span>
                </div>
            </div>
        </div>

        <!-- Employee Performance Trackers Search Panel -->
        <section class="hr-card p-6 mb-6">
            <h2 class="text-sm font-bold flex items-baseline gap-2 mb-5" style="color: var(--text-primary);">
                <i class="fas fa-users" style="color: var(--color-hr-primary);"></i>
                <span class="mt-0.5">Employee Performance Trackers</span>
            </h2>

            <!-- Filter Form -->
            <form method="GET" action="{{ route('performance.employee-trackers') }}" id="employee-trackers-search-form">
                <div class="rounded-lg p-3 mb-3" style="background-color: var(--bg-card);">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-3">
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Employee Name</label>
                            <input 
                                type="text" 
                                name="employee_name"
                                value="{{ request('employee_name') }}"
                                class="hr-input w-full px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)] bg-white" 
                                placeholder="Type for hints...">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">From Date</label>
                            <x-date-picker 
                                name="from_date"
                                value="{{ request('from_date') }}"
                                placeholder="From"
                                variant="default"
                                class="w-full text-xs"
                            />
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">To Date</label>
                            <x-date-picker 
                                name="to_date"
                                value="{{ request('to_date') }}"
                                placeholder="To"
                                variant="default"
                                class="w-full text-xs"
                            />
                        </div>
                    </div>
                    <x-admin.action-buttons resetType="button" searchType="submit" />
                </div>
            </form>
        </section>

        <!-- Employee Performance Trackers Table Section -->
        <section class="hr-card p-6">
            <h2 class="text-sm font-bold flex items-baseline gap-2 mb-5" style="color: var(--text-primary);">
                <i class="fas fa-list-alt" style="color: var(--color-hr-primary);"></i>
                <span class="mt-0.5">Trackers List</span>
            </h2>

            @if(session('status'))
                <div class="rounded-lg px-4 py-3 text-sm font-medium mb-4" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); color: #10B981;">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('status') }}
                </div>
            @endif

            @if(session('error'))
                <div class="rounded-lg px-4 py-3 text-sm font-medium mb-4" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); color: #DC2626;">
                    <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                </div>
            @endif

            <!-- Records Count -->
            @if(count($trackers) > 0)
                <x-records-found :count="count($trackers)" />
            @else
                <x-records-found :count="0" />
            @endif

            <!-- Table Header -->
            <div class="rounded-t-lg pl-1 pr-2 py-1.5 flex items-center gap-1 border-b" style="background-color: var(--bg-hover); border-color: var(--border-default);">
                <div class="flex-1" style="min-width: 0;">
                    <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Employee Name</div>
                </div>
                <div class="flex-1" style="min-width: 0;">
                    <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Trackers</div>
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
                    <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Overall Rating</div>
                </div>
                <div class="flex-shrink-0" style="width: 120px;">
                    <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words text-center" style="color: var(--text-primary);">Actions</div>
                </div>
            </div>

            <!-- Table Body -->
            <div class="border border-t-0 rounded-b-lg" style="border-color: var(--border-default);">
                @if(count($trackers) > 0)
                    @foreach($trackers as $tracker)
                    <div class="border-b last:border-b-0 pl-1 pr-2 py-1.5 transition-colors flex items-center gap-1" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs font-medium break-words" style="color: var(--text-primary);">{{ $tracker->employee_name }}</div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs break-words" style="color: var(--text-primary);">{{ $tracker->tracker }}</div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs break-words" style="color: var(--text-primary);">{{ $tracker->added_date }}</div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs break-words" style="color: var(--text-primary);">{{ $tracker->modified_date ?: '' }}</div>
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
                            <div class="text-xs break-words" style="color: var(--text-primary);">
                                @if($tracker->overall_rating !== null)
                                    {{ number_format($tracker->overall_rating, 2) }}
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                        <div class="flex-shrink-0" style="width: 120px;">
                            <div class="flex items-center justify-center gap-2">
                                @if(in_array($tracker->status, ['completed', 'approved']))
                                    <button 
                                        class="hr-action-view flex-shrink-0" 
                                        title="View Review" 
                                        type="button"
                                        onclick="openEmployeeTrackerViewModal({{ $tracker->id }})"
                                    >
                                        <i class="fas fa-eye text-sm"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <!-- No Records Found -->
                    <div class="px-4 py-6 text-center text-xs" style="color: var(--text-muted);">
                        No Records Found
                    </div>
                @endif
            </div>
        </section>

        <!-- View Review Modal -->
        <x-admin.modal
            id="employee-tracker-view-modal"
            title="View Review Details"
            icon="fas fa-eye"
            maxWidth="lg"
            backdropOnClick="closeEmployeeTrackerViewModal()"
        >
            <div id="employee-tracker-view-content">
                <p class="text-xs" style="color: var(--text-muted);">Loading...</p>
            </div>
        </x-admin.modal>

        <script>
            // Search form submit handler
            var searchForm = document.getElementById('employee-trackers-search-form');
            if (searchForm) {
                searchForm.addEventListener('submit', function (e) {
                    e.preventDefault();
                    var formAction = searchForm.getAttribute('action') || window.location.pathname;
                    var url = new URL(formAction, window.location.origin);
                    var formData = new FormData(searchForm);
                    for (var pair of formData.entries()) {
                        if (pair[1]) {
                            url.searchParams.set(pair[0], pair[1]);
                        }
                    }
                    window.location.href = url.toString();
                });

                // Reset button handler
                var resetBtn = searchForm.querySelector('button.hr-btn-secondary[type="button"]') || searchForm.querySelector('button[type="button"]');
                if (resetBtn) {
                    resetBtn.addEventListener('click', function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        searchForm.querySelectorAll('input[name], select[name]').forEach(function (el) {
                            el.value = '';
                        });
                        window.location.href = "{{ route('performance.employee-trackers') }}";
                    });
                }
            }

            function openEmployeeTrackerViewModal(reviewId) {
                const modal = document.getElementById('employee-tracker-view-modal');
                const content = document.getElementById('employee-tracker-view-content');

                if (!modal || !content) {
                    console.error('View modal elements not found');
                    return;
                }

                modal.classList.remove('hidden');
                content.innerHTML = '<p class="text-xs" style="color: var(--text-muted);">Loading...</p>';

                // Fetch KPI ratings and review details
                fetch("{{ route('performance.reviews.kpis', ['id' => '__ID__']) }}".replace('__ID__', reviewId))
                    .then(response => response.json())
                    .then(kpis => {
                        let html = '<div style="display: flex; flex-direction: column; height: 100%;">';
                        html += '<div style="flex: 1 1 auto; overflow-y: auto; min-height: 0; max-height: calc(90vh - 200px); padding-right: 4px;">';

                        // Display KPIs
                        if (!Array.isArray(kpis) || kpis.length === 0) {
                            html += '<p class="text-xs mb-3" style="color: var(--text-muted);">No KPIs found for this review.</p>';
                        } else {
                            kpis.forEach(function(kpi) {
                                html += '<div class="mb-4 p-3 rounded" style="background-color: var(--bg-hover); border: 1px solid var(--border-default);">';
                                html += '  <div class="mb-2">';
                                html += '    <label class="block text-xs font-semibold mb-1" style="color: var(--text-primary);">' + (kpi.kpi_name || 'KPI') + '</label>';
                                if (kpi.kpi_description) {
                                    html += '    <p class="text-xs mb-2" style="color: var(--text-muted);">' + kpi.kpi_description + '</p>';
                                }
                                html += '    <span class="text-xs" style="color: var(--text-muted);">Weight: ' + (kpi.kpi_weight || 0) + '</span>';
                                html += '  </div>';

                                html += '  <div class="mb-2">';
                                html += '    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Rating</label>';
                                html += '    <div class="text-xs p-2 rounded" style="background-color: var(--bg-input); color: var(--text-primary);">' + (kpi.rating !== null && kpi.rating !== '' ? kpi.rating : '-') + '</div>';
                                html += '  </div>';

                                html += '  <div>';
                                html += '    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Comments</label>';
                                html += '    <div class="text-xs p-2 rounded whitespace-pre-wrap" style="background-color: var(--bg-input); color: var(--text-primary); min-height: 40px;">' + (kpi.comments || '-') + '</div>';
                                html += '  </div>';

                                html += '</div>';
                            });
                        }

                        // Fetch overall comments
                        fetch("{{ route('performance.reviews.view', ['id' => '__ID__']) }}".replace('__ID__', reviewId))
                            .then(response => response.json())
                            .then(data => {
                                if (data.comments) {
                                    html += '<div class="mb-4 p-3 rounded" style="background-color: var(--bg-hover); border: 1px solid var(--border-default);">';
                                    html += '  <label class="block text-xs font-semibold mb-1" style="color: var(--text-primary);">Overall Comments</label>';
                                    html += '  <div class="text-xs p-2 rounded whitespace-pre-wrap" style="background-color: var(--bg-input); color: var(--text-primary); min-height: 60px;">' + data.comments + '</div>';
                                    html += '</div>';
                                }

                                html += '</div>';
                                html += '</div>';

                                content.innerHTML = html;
                            })
                            .catch(error => {
                                console.error('Error loading review details:', error);
                                html += '</div>';
                                html += '</div>';
                                content.innerHTML = html;
                            });
                    })
                    .catch(error => {
                        console.error('Error loading KPIs:', error);
                        content.innerHTML = '<p class="text-xs" style="color: #DC2626;">Error loading review details. Please try again.</p>';
                    });
            }
            window.openEmployeeTrackerViewModal = openEmployeeTrackerViewModal;

            function closeEmployeeTrackerViewModal() {
                const modal = document.getElementById('employee-tracker-view-modal');
                if (modal) {
                    modal.classList.add('hidden');
                }
            }
            window.closeEmployeeTrackerViewModal = closeEmployeeTrackerViewModal;
        </script>

    </x-main-layout>
@endsection

