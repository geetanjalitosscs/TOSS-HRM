@extends('layouts.app')

@section('title', 'Performance - Employee Reviews')

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
                        ['url' => route('performance.employee-reviews'), 'label' => 'Employee Reviews', 'active' => true]
                    ]"
                    position="left"
                    width="w-48">
                    <div class="px-6 py-3 border-b-2 border-[var(--color-hr-primary)] bg-[var(--color-primary-light)] cursor-pointer flex items-center gap-2 flex-shrink-0 whitespace-nowrap">
                        <span class="text-sm font-semibold text-[var(--color-hr-primary-dark)]">Manage Reviews</span>
                        <x-dropdown-arrow class="flex-shrink-0" />
                    </div>
                </x-dropdown-menu>
                <a href="{{ route('performance.my-trackers') }}" class="px-6 py-3 hover:bg-[var(--color-primary-light)] cursor-pointer transition-all flex items-center flex-shrink-0 whitespace-nowrap">
                    <span class="text-sm font-medium text-slate-700">My Trackers</span>
                </a>
                <a href="{{ route('performance.employee-trackers') }}" class="px-6 py-3 hover:bg-[var(--color-primary-light)] cursor-pointer transition-all flex items-center flex-shrink-0 whitespace-nowrap">
                    <span class="text-sm font-medium text-slate-700">Employee Trackers</span>
                </a>
            </div>
        </div>

        <!-- Employee Reviews Search Panel -->
        <section class="hr-card p-6 mb-6">
            <h2 class="text-sm font-bold flex items-baseline gap-2 mb-5" style="color: var(--text-primary);">
                <i class="fas fa-users" style="color: var(--color-hr-primary);"></i>
                <span class="mt-0.5">Employee Reviews</span>
            </h2>

            <!-- Filter Form -->
            <form method="GET" action="{{ route('performance.employee-reviews') }}" id="employee-reviews-search-form">
                <div class="rounded-lg p-3 mb-3" style="background-color: var(--bg-card);">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Employee Name</label>
                            <input 
                                type="text" 
                                name="employee_name"
                                class="hr-input w-full px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)] bg-white" 
                                placeholder="Type for hints..."
                                value="{{ request('employee_name') }}"
                            >
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Job Title</label>
                            <select 
                                name="job_title"
                                class="hr-select w-full px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)] bg-white"
                            >
                                <option value="">-- Select --</option>
                                @foreach(($jobTitles ?? []) as $title)
                                    <option value="{{ $title }}" {{ request('job_title') === $title ? 'selected' : '' }}>{{ $title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-3">
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Review Status</label>
                            <select 
                                name="review_status"
                                class="hr-select w-full px-2 py-1.5 text-xs border border-[var(--border-strong)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)] bg-white"
                            >
                                <option value="">-- Select --</option>
                                <option value="not_started" {{ request('review_status') === 'not_started' ? 'selected' : '' }}>Not Started</option>
                                <option value="in_progress" {{ request('review_status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ request('review_status') === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="approved" {{ request('review_status') === 'approved' ? 'selected' : '' }}>Approved</option>
                            </select>
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

        <!-- Employee Reviews Table Section -->
        <section class="hr-card p-6" id="employee-reviews-table-section">
            <h2 class="text-sm font-bold flex items-baseline gap-2 mb-5" style="color: var(--text-primary);">
                <i class="fas fa-list-alt" style="color: var(--color-hr-primary);"></i>
                <span class="mt-0.5">Reviews List</span>
            </h2>

            @if(isset($reviews) && count($reviews) > 0)
            <!-- Records Count -->
            <div class="flex items-center justify-between mb-2">
                <x-records-found :count="count($reviews)" />
            </div>

            <!-- Table -->
            <div class="hr-table-wrapper" style="max-height: 22rem; overflow-y: auto;">
                <!-- Table Header -->
                <div class="rounded-t-lg px-2 py-1.5 flex items-center gap-3 border-b" style="background-color: var(--bg-hover); border-color: var(--border-default);">
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Employee</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Job Title</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Sub Unit</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Review Period</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Due Date</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Reviewer</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Review Status</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Overall Rating</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Comments</div>
                    </div>
                </div>

                <!-- Table Rows -->
                <div class="border border-t-0 rounded-b-lg" style="border-color: var(--border-default);">
                    @foreach($reviews as $review)
                    <div class="border-b last:border-b-0 pl-1 pr-2 py-1.5 transition-colors flex items-center gap-3" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs font-medium break-words" style="color: var(--text-primary);">{{ $review->employee ?? '' }}</div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs break-words" style="color: var(--text-primary);">{{ $review->job_title ?? '' }}</div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs break-words" style="color: var(--text-primary);">{{ $review->sub_unit ?? '' }}</div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs break-words" style="color: var(--text-primary);">{{ $review->review_period ?? '' }}</div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs break-words" style="color: var(--text-primary);">{{ $review->due_date ?? '' }}</div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs break-words" style="color: var(--text-primary);">{{ $review->reviewer ?? '-' }}</div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs break-words" style="color: var(--text-primary);">
                                @php
                                    $statusLabelMap = [
                                        'not_started' => 'Not Started',
                                        'in_progress' => 'In Progress',
                                        'completed' => 'Completed',
                                        'approved' => 'Approved',
                                    ];
                                    $statusValue = strtolower($review->review_status ?? '');
                                @endphp
                                {{ $statusLabelMap[$statusValue] ?? ucfirst(str_replace('_', ' ', $statusValue)) }}
                            </div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs font-semibold break-words" style="color: var(--text-primary);">{{ $review->overall_rating ?? '-' }}</div>
                        </div>
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs break-words" style="color: var(--text-primary);">{{ $review->feedback ?? '-' }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            <!-- No Records Found -->
            <div class="flex items-center justify-between mb-2">
                <x-records-found :count="0" />
            </div>

            <!-- Empty table structure -->
            <div class="hr-table-wrapper" style="max-height: 22rem; overflow-y: auto;">
                <div class="rounded-t-lg px-2 py-1.5 flex items-center gap-3 border-b" style="background-color: var(--bg-hover); border-color: var(--border-default);">
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Employee</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Job Title</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Sub Unit</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Review Period</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Due Date</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Reviewer</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Review Status</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Overall Rating</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Comments</div>
                    </div>
                </div>
                <div class="border border-t-0 rounded-b-lg" style="border-color: var(--border-default);">
                    <div class="px-4 py-6 text-center text-xs" style="color: var(--text-muted);">
                        No records found.
                    </div>
                </div>
            </div>
            @endif
        </section>

        <script>
            // Search form submit: add hash so page scrolls to table after reload
            var searchForm = document.getElementById('employee-reviews-search-form');
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

                    url.hash = 'employee-reviews-table-section';
                    window.location.href = url.toString();
                });

                // Reset button: clear filters and go back to base route
                var resetBtn = searchForm.querySelector('button.hr-btn-secondary[type="button"]') || searchForm.querySelector('button[type="button"]');
                if (resetBtn) {
                    resetBtn.addEventListener('click', function (e) {
                        e.preventDefault();
                        e.stopPropagation();

                        searchForm.querySelectorAll('input[name], select[name]').forEach(function (el) {
                            el.value = '';
                        });

                        window.location.href = "{{ route('performance.employee-reviews') }}";
                    });
                }
            }

            // Scroll to table section if hash exists or if search parameters are present
            if (window.location.hash === '#employee-reviews-table-section' ||
                (window.location.search && (window.location.search.includes('employee_name=') ||
                                            window.location.search.includes('job_title=') ||
                                            window.location.search.includes('review_status=') ||
                                            window.location.search.includes('from_date=') ||
                                            window.location.search.includes('to_date=')))) {
                var tableSection = document.getElementById('employee-reviews-table-section');
                if (tableSection) {
                    setTimeout(function () {
                        tableSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }, 300);
                }
            }

            function approveReview(reviewId) {
                if (!confirm('Are you sure you want to approve this review?')) return;
                var csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                var formData = new FormData();
                formData.append('_token', csrfToken);
                fetch("{{ route('performance.reviews.approve', ['id' => '__ID__']) }}".replace('__ID__', reviewId), {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken || '',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (response.redirected) {
                        window.location.href = response.url;
                    }
                })
                .catch(error => {
                    console.error('Error approving review:', error);
                    alert('Error approving review. Please try again.');
                });
            }
            window.approveReview = approveReview;
        </script>
    </x-main-layout>
@endsection

