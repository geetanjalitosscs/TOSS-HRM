@extends('layouts.app')

@section('title', 'Performance - My Reviews')

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
                        ['url' => route('performance.my-reviews'), 'label' => 'My Reviews', 'active' => true],
                        ['url' => route('performance.employee-reviews'), 'label' => 'Employee Reviews']
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

        <!-- My Reviews Section -->
        <section class="hr-card p-6">
            <h2 class="text-sm font-bold text-slate-800 flex items-baseline gap-2 mb-5">
                <i class="fas fa-clipboard-list text-[var(--color-primary)]"></i> <span class="mt-0.5">My Reviews</span>
            </h2>

            @php
                $reviews = $reviews ?? collect([]);
                $reviewsCount = $reviews->count();
            @endphp
            @if($reviewsCount > 0)
                <x-records-found :count="$reviewsCount" />
            @endif

            <!-- Table -->
            <div class="hr-table-wrapper" style="max-height: 22rem; overflow-y: auto;">
                <!-- Table Header -->
                <div class="rounded-t-lg px-2 py-1.5 flex items-center gap-3 border-b" style="background-color: var(--bg-hover); border-color: var(--border-default);">
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Job Title</div>
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
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Score</div>
                    </div>
                    <div class="flex-1" style="min-width: 0;">
                        <div class="text-xs font-semibold uppercase tracking-wide leading-tight break-words" style="color: var(--text-primary);">Feedback</div>
                    </div>
                </div>

                <!-- Table Rows -->
                <div class="border border-t-0 rounded-b-lg" style="border-color: var(--border-default);">
                    @forelse($reviews as $review)
                    <div class="border-b last:border-b-0 px-2 py-1.5 transition-colors flex items-center gap-3" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
                        <div class="flex-1" style="min-width: 0;">
                            <div class="text-xs font-medium break-words" style="color: var(--text-primary);">{{ $review->job_title ?? '' }}</div>
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
                    @empty
                    <div class="px-2 py-1.5" style="background-color: var(--bg-card);">
                        <div class="text-xs text-slate-500 text-center py-4">No reviews found</div>
                    </div>
                    @endforelse
                </div>
            </div>
        </section>

    </x-main-layout>
@endsection

