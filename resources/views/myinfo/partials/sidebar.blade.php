<!-- Left Sidebar - Sub Navigation -->
<aside class="w-64 flex-shrink-0 mr-6 flex flex-col">
    <!-- User Profile Section -->
    <div class="rounded-lg shadow-sm border border-purple-100 p-4 mb-3" style="background-color: var(--bg-card);">
        <h2 class="text-sm font-bold text-slate-800 mb-2">
            {{ $employee ? ($employee->display_name ?: trim($employee->first_name . ' ' . ($employee->middle_name ?? '') . ' ' . $employee->last_name)) : 'Employee' }}
        </h2>
        <div class="flex justify-center mb-3">
            <div class="h-24 w-24 rounded-full bg-gradient-to-br from-[var(--color-hr-primary)] to-[var(--color-hr-primary-dark)] flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                {{ $employee ? strtoupper(substr($employee->first_name, 0, 1)) : 'E' }}
            </div>
        </div>
    </div>

    <!-- Sub Navigation Tabs -->
    <div class="rounded-lg shadow-sm border border-purple-100 overflow-hidden flex-1" style="background-color: var(--bg-card);">
        @php
            $isPersonalDetails = request()->routeIs('myinfo') && !request()->routeIs('myinfo.*');
        @endphp
        <a href="{{ route('myinfo') }}" class="block px-4 py-3 {{ $isPersonalDetails ? 'border-l-4 border-[var(--color-hr-primary)] font-semibold' : 'text-sm font-medium' }} transition-colors" style="{{ $isPersonalDetails ? 'background-color: var(--bg-hover); color: var(--color-hr-primary-dark);' : 'color: var(--text-primary);' }}" onmouseover="{{ !$isPersonalDetails ? "this.style.backgroundColor='var(--bg-hover)'" : '' }}" onmouseout="{{ !$isPersonalDetails ? "this.style.backgroundColor='transparent'" : '' }}">
            Personal Details
        </a>
        @php
            $isContactDetails = request()->routeIs('myinfo.contact-details');
        @endphp
        <a href="{{ route('myinfo.contact-details') }}" class="block px-4 py-3 {{ $isContactDetails ? 'border-l-4 border-[var(--color-hr-primary)] font-semibold' : 'text-sm font-medium' }} transition-colors" style="{{ $isContactDetails ? 'background-color: var(--bg-hover); color: var(--color-hr-primary-dark);' : 'color: var(--text-primary);' }}" onmouseover="{{ !$isContactDetails ? "this.style.backgroundColor='var(--bg-hover)'" : '' }}" onmouseout="{{ !$isContactDetails ? "this.style.backgroundColor='transparent'" : '' }}">
            Contact Details
        </a>
        @php
            $isEmergencyContacts = request()->routeIs('myinfo.emergency-contacts');
        @endphp
        <a href="{{ route('myinfo.emergency-contacts') }}" class="block px-4 py-3 {{ $isEmergencyContacts ? 'border-l-4 border-[var(--color-hr-primary)] font-semibold' : 'text-sm font-medium' }} transition-colors" style="{{ $isEmergencyContacts ? 'background-color: var(--bg-hover); color: var(--color-hr-primary-dark);' : 'color: var(--text-primary);' }}" onmouseover="{{ !$isEmergencyContacts ? "this.style.backgroundColor='var(--bg-hover)'" : '' }}" onmouseout="{{ !$isEmergencyContacts ? "this.style.backgroundColor='transparent'" : '' }}">
            Emergency Contacts
        </a>
        {{-- @php
            $isDependents = request()->routeIs('myinfo.dependents');
        @endphp
        <a href="{{ route('myinfo.dependents') }}" class="block px-4 py-3 {{ $isDependents ? 'border-l-4 border-[var(--color-hr-primary)] font-semibold' : 'text-sm font-medium' }} transition-colors" style="{{ $isDependents ? 'background-color: var(--bg-hover); color: var(--color-hr-primary-dark);' : 'color: var(--text-primary);' }}" onmouseover="{{ !$isDependents ? "this.style.backgroundColor='var(--bg-hover)'" : '' }}" onmouseout="{{ !$isDependents ? "this.style.backgroundColor='transparent'" : '' }}">
            Dependents
        </a> --}}
        {{-- @php
            $isImmigration = request()->routeIs('myinfo.immigration');
        @endphp
        <a href="{{ route('myinfo.immigration') }}" class="block px-4 py-3 {{ $isImmigration ? 'border-l-4 border-[var(--color-hr-primary)] font-semibold' : 'text-sm font-medium' }} transition-colors" style="{{ $isImmigration ? 'background-color: var(--bg-hover); color: var(--color-hr-primary-dark);' : 'color: var(--text-primary);' }}" onmouseover="{{ !$isImmigration ? "this.style.backgroundColor='var(--bg-hover)'" : '' }}" onmouseout="{{ !$isImmigration ? "this.style.backgroundColor='transparent'" : '' }}">
            Immigration
        </a> --}}
        {{-- @php
            $isJob = request()->routeIs('myinfo.job');
        @endphp
        <a href="{{ route('myinfo.job') }}" class="block px-4 py-3 {{ $isJob ? 'border-l-4 border-[var(--color-hr-primary)] font-semibold' : 'text-sm font-medium' }} transition-colors" style="{{ $isJob ? 'background-color: var(--bg-hover); color: var(--color-hr-primary-dark);' : 'color: var(--text-primary);' }}" onmouseover="{{ !$isJob ? "this.style.backgroundColor='var(--bg-hover)'" : '' }}" onmouseout="{{ !$isJob ? "this.style.backgroundColor='transparent'" : '' }}">
            Job
        </a> --}}
        {{-- @php
            $isSalary = request()->routeIs('myinfo.salary');
        @endphp
        <a href="{{ route('myinfo.salary') }}" class="block px-4 py-3 {{ $isSalary ? 'border-l-4 border-[var(--color-hr-primary)] font-semibold' : 'text-sm font-medium' }} transition-colors" style="{{ $isSalary ? 'background-color: var(--bg-hover); color: var(--color-hr-primary-dark);' : 'color: var(--text-primary);' }}" onmouseover="{{ !$isSalary ? "this.style.backgroundColor='var(--bg-hover)'" : '' }}" onmouseout="{{ !$isSalary ? "this.style.backgroundColor='transparent'" : '' }}">
            Salary
        </a> --}}
        {{-- @php
            $isReportTo = request()->routeIs('myinfo.report-to');
        @endphp
        <a href="{{ route('myinfo.report-to') }}" class="block px-4 py-3 {{ $isReportTo ? 'border-l-4 border-[var(--color-hr-primary)] font-semibold' : 'text-sm font-medium' }} transition-colors" style="{{ $isReportTo ? 'background-color: var(--bg-hover); color: var(--color-hr-primary-dark);' : 'color: var(--text-primary);' }}" onmouseover="{{ !$isReportTo ? "this.style.backgroundColor='var(--bg-hover)'" : '' }}" onmouseout="{{ !$isReportTo ? "this.style.backgroundColor='transparent'" : '' }}">
            Report-to
        </a> --}}
        @php
            $isQualifications = request()->routeIs('myinfo.qualifications');
        @endphp
        <a href="{{ route('myinfo.qualifications') }}" class="block px-4 py-3 {{ $isQualifications ? 'border-l-4 border-[var(--color-hr-primary)] font-semibold' : 'text-sm font-medium' }} transition-colors" style="{{ $isQualifications ? 'background-color: var(--bg-hover); color: var(--color-hr-primary-dark);' : 'color: var(--text-primary);' }}" onmouseover="{{ !$isQualifications ? "this.style.backgroundColor='var(--bg-hover)'" : '' }}" onmouseout="{{ !$isQualifications ? "this.style.backgroundColor='transparent'" : '' }}">
            Qualifications
        </a>
        {{-- @php
            $isMemberships = request()->routeIs('myinfo.memberships');
        @endphp
        <a href="{{ route('myinfo.memberships') }}" class="block px-4 py-3 {{ $isMemberships ? 'border-l-4 border-[var(--color-hr-primary)] font-semibold' : 'text-sm font-medium' }} transition-colors" style="{{ $isMemberships ? 'background-color: var(--bg-hover); color: var(--color-hr-primary-dark);' : 'color: var(--text-primary);' }}" onmouseover="{{ !$isMemberships ? "this.style.backgroundColor='var(--bg-hover)'" : '' }}" onmouseout="{{ !$isMemberships ? "this.style.backgroundColor='transparent'" : '' }}">
            Memberships
        </a> --}}
    </div>
</aside>
