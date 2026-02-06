<!-- Left Sidebar - Sub Navigation -->
<aside class="w-64 flex-shrink-0 mr-6 flex flex-col sticky top-0 h-screen" style="height: calc(100vh - 2rem);">
    <!-- User Profile Section -->
    <div class="rounded-lg shadow-sm border border-[var(--border-default)] p-4 mb-3" style="background-color: var(--bg-card);">
        <h2 class="text-sm font-bold text-slate-800 mb-2">
            {{ $employee ? ($employee->display_name ?: trim($employee->first_name . ' ' . ($employee->middle_name ?? '') . ' ' . $employee->last_name)) : 'Employee' }}
        </h2>
        <div class="flex justify-center mb-3">
            @if($employee && $employee->photo_url)
                <div class="h-24 w-24 rounded-full overflow-hidden shadow-lg border-2" style="border-color: var(--border-default); box-shadow: 0 0 20px rgba(228, 87, 69, 0.3), 0 0 40px rgba(228, 87, 69, 0.1);">
                    <img src="{{ $employee->photo_url }}?t={{ time() }}" alt="{{ $employee->first_name }}" class="w-full h-full object-contain">
                </div>
            @else
                <div class="h-24 w-24 rounded-full bg-gradient-to-br from-[var(--color-primary)] to-[var(--color-primary-hover)] flex items-center justify-center text-white text-2xl font-bold" style="box-shadow: 0 0 20px rgba(228, 87, 69, 0.3), 0 0 40px rgba(228, 87, 69, 0.1);">
                    {{ $employee ? strtoupper(substr($employee->first_name, 0, 1)) : 'E' }}
                </div>
            @endif
        </div>
        
        <!-- Update Photo Link -->
        <div class="flex justify-center mb-3">
            <a href="{{ route('myinfo.profile-photo') }}" class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-medium text-white rounded-lg transition-all duration-200 shadow-sm hover:shadow-md hover:scale-105" style="background: linear-gradient(135deg, var(--color-primary), var(--color-primary-hover)); box-shadow: 0 0 15px rgba(228, 87, 69, 0.2), 0 0 30px rgba(228, 87, 69, 0.1);">
                <i class="fas fa-camera"></i>
                <span>Update Photo</span>
            </a>
        </div>
    </div>

    <!-- Sub Navigation Tabs -->
    <div class="rounded-lg shadow-sm border border-[var(--border-default)] overflow-hidden flex-1" style="background-color: var(--bg-card);">
        @php
            $isPersonalDetails = request()->routeIs('myinfo') && !request()->routeIs('myinfo.*');
        @endphp
        <a href="{{ route('myinfo') }}" class="block px-4 py-3 {{ $isPersonalDetails ? 'border-l-4 border-[var(--color-primary)] font-semibold' : 'text-sm font-medium' }} transition-colors flex items-center gap-2" style="{{ $isPersonalDetails ? 'background-color: var(--bg-hover); color: var(--color-primary);' : 'color: var(--text-primary);' }}" onmouseover="{{ !$isPersonalDetails ? "this.style.backgroundColor='var(--bg-hover)'; this.style.transform='translateX(2px)'" : '' }}" onmouseout="{{ !$isPersonalDetails ? "this.style.backgroundColor='transparent'; this.style.transform='translateX(0)'" : '' }}">
            <i class="fas fa-user text-sm" style="color: var(--text-primary);"></i>
            <span>Personal Details</span>
        </a>
        @php
            $isContactDetails = request()->routeIs('myinfo.contact-details');
        @endphp
        <a href="{{ route('myinfo.contact-details') }}" class="block px-4 py-3 {{ $isContactDetails ? 'border-l-4 border-[var(--color-primary)] font-semibold' : 'text-sm font-medium' }} transition-colors flex items-center gap-2" style="{{ $isContactDetails ? 'background-color: var(--bg-hover); color: var(--color-primary);' : 'color: var(--text-primary);' }}" onmouseover="{{ !$isContactDetails ? "this.style.backgroundColor='var(--bg-hover)'; this.style.transform='translateX(2px)'" : '' }}" onmouseout="{{ !$isContactDetails ? "this.style.backgroundColor='transparent'; this.style.transform='translateX(0)'" : '' }}">
            <i class="fas fa-address-card text-sm" style="color: var(--text-primary);"></i>
            <span>Contact Details</span>
        </a>
        @php
            $isEmergencyContacts = request()->routeIs('myinfo.emergency-contacts');
        @endphp
        <a href="{{ route('myinfo.emergency-contacts') }}" class="block px-4 py-3 {{ $isEmergencyContacts ? 'border-l-4 border-[var(--color-primary)] font-semibold' : 'text-sm font-medium' }} transition-colors flex items-center gap-2" style="{{ $isEmergencyContacts ? 'background-color: var(--bg-hover); color: var(--color-primary);' : 'color: var(--text-primary);' }}" onmouseover="{{ !$isEmergencyContacts ? "this.style.backgroundColor='var(--bg-hover)'; this.style.transform='translateX(2px)'" : '' }}" onmouseout="{{ !$isEmergencyContacts ? "this.style.backgroundColor='transparent'; this.style.transform='translateX(0)'" : '' }}">
            <i class="fas fa-phone-alt text-sm" style="color: var(--text-primary);"></i>
            <span>Emergency Contacts</span>
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
        <a href="{{ route('myinfo.qualifications') }}" class="block px-4 py-3 {{ $isQualifications ? 'border-l-4 border-[var(--color-primary)] font-semibold' : 'text-sm font-medium' }} transition-colors flex items-center gap-2" style="{{ $isQualifications ? 'background-color: var(--bg-hover); color: var(--color-primary);' : 'color: var(--text-primary);' }}" onmouseover="{{ !$isQualifications ? "this.style.backgroundColor='var(--bg-hover)'; this.style.transform='translateX(2px)'" : '' }}" onmouseout="{{ !$isQualifications ? "this.style.backgroundColor='transparent'; this.style.transform='translateX(0)'" : '' }}">
            <i class="fas fa-graduation-cap text-sm" style="color: var(--text-primary);"></i>
            <span>Qualifications</span>
        </a>
        {{-- @php
            $isMemberships = request()->routeIs('myinfo.memberships');
        @endphp
        <a href="{{ route('myinfo.memberships') }}" class="block px-4 py-3 {{ $isMemberships ? 'border-l-4 border-[var(--color-hr-primary)] font-semibold' : 'text-sm font-medium' }} transition-colors" style="{{ $isMemberships ? 'background-color: var(--bg-hover); color: var(--color-hr-primary-dark);' : 'color: var(--text-primary);' }}" onmouseover="{{ !$isMemberships ? "this.style.backgroundColor='var(--bg-hover)'" : '' }}" onmouseout="{{ !$isMemberships ? "this.style.backgroundColor='transparent'" : '' }}">
            Memberships
        </a> --}}
    </div>
</aside>
