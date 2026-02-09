@props(['activeTab' => 'user-management'])

<div class="hr-sticky-tabs">
    <div class="flex items-stretch border-b border-[var(--border-default)] overflow-x-auto overflow-y-visible flex-nowrap">
        <!-- User Management Tab -->
        <a href="{{ route('admin') }}" class="px-4 py-3 {{ $activeTab === 'user-management' ? 'border-b-2 border-[var(--color-hr-primary)]' : '' }} cursor-pointer transition-all flex-shrink-0 flex items-center hr-tab-hover whitespace-nowrap" style="{{ $activeTab === 'user-management' ? 'background-color: var(--bg-hover); color: var(--color-hr-primary-dark); font-weight: 600;' : 'color: var(--text-primary);' }}">
            <span class="text-sm" style="{{ $activeTab === 'user-management' ? 'font-weight: 600; color: var(--color-hr-primary-dark);' : 'font-weight: 500; color: var(--text-primary);' }}">User Management</span>
        </a>
        
        <!-- Job Dropdown -->
        @php
            $jobItems = [
                ['url' => route('admin.job-titles'), 'label' => 'Job Titles'],
                ['url' => route('admin.pay-grades'), 'label' => 'Pay Grades', 'hidden' => true],
                ['url' => route('admin.employment-status'), 'label' => 'Employment Status'],
                ['url' => route('admin.job-categories'), 'label' => 'Job Categories', 'hidden' => true],
                ['url' => route('admin.work-shifts'), 'label' => 'Work Shifts', 'hidden' => true]
            ];
            $isJobActive = in_array($activeTab, ['job-titles', 'employment-status']);
        @endphp
        <x-dropdown-menu 
            :items="$jobItems"
            position="left"
            width="w-48">
            <!-- @php
                $isJobActive = in_array($activeTab, ['job-titles', 'pay-grades', 'employment-status', 'job-categories', 'work-shifts']);
            @endphp -->
            <div class="px-4 py-3 {{ $isJobActive ? 'border-b-2 border-[var(--color-hr-primary)]' : '' }} cursor-pointer transition-all flex items-center justify-between gap-2 flex-shrink-0 hr-tab-hover whitespace-nowrap" style="{{ $isJobActive ? 'background-color: var(--bg-hover); color: var(--color-hr-primary-dark); font-weight: 600;' : 'color: var(--text-primary);' }}" onmouseover="if(!{{ $isJobActive ? 'true' : 'false' }}) { this.style.backgroundColor='var(--bg-hover)'; this.style.color='var(--color-hr-primary)'; }" onmouseout="if(!{{ $isJobActive ? 'true' : 'false' }}) { this.style.backgroundColor='transparent'; this.style.color='var(--text-primary)'; }">
                <span class="text-sm flex-shrink-0" style="{{ $isJobActive ? 'font-weight: 600; color: var(--color-hr-primary-dark);' : 'font-weight: 500; color: var(--text-primary);' }}">Job</span>
                <x-dropdown-arrow class="flex-shrink-0" />
            </div>
        </x-dropdown-menu>
        
        <!-- Roles Tab -->
        <a href="{{ route('admin.roles') }}" class="px-4 py-3 {{ $activeTab === 'roles' ? 'border-b-2 border-[var(--color-hr-primary)]' : '' }} cursor-pointer transition-all flex-shrink-0 flex items-center hr-tab-hover whitespace-nowrap" style="{{ $activeTab === 'roles' ? 'background-color: var(--bg-hover); color: var(--color-hr-primary-dark); font-weight: 600;' : 'color: var(--text-primary);' }}">
            <span class="text-sm" style="{{ $activeTab === 'roles' ? 'font-weight: 600; color: var(--color-hr-primary-dark);' : 'font-weight: 500; color: var(--text-primary);' }}">Roles</span>
        </a>
        
        <!-- Theme Manager Tab -->
        <a href="{{ route('admin.theme-manager') }}" class="px-4 py-3 {{ $activeTab === 'theme-manager' ? 'border-b-2 border-[var(--color-hr-primary)]' : '' }} cursor-pointer transition-all flex-shrink-0 flex items-center hr-tab-hover whitespace-nowrap" style="{{ $activeTab === 'theme-manager' ? 'background-color: var(--bg-hover); color: var(--color-hr-primary-dark); font-weight: 600;' : 'color: var(--text-primary);' }}">
            <span class="text-sm" style="{{ $activeTab === 'theme-manager' ? 'font-weight: 600; color: var(--color-hr-primary-dark);' : 'font-weight: 500; color: var(--text-primary);' }}">Theme Manager</span>
        </a>
        
        <!-- General Information Tab -->
        <a href="{{ route('admin.organization.general-information') }}" class="px-4 py-3 {{ $activeTab === 'organization-general' ? 'border-b-2 border-[var(--color-hr-primary)]' : '' }} cursor-pointer transition-all flex-shrink-0 flex items-center hr-tab-hover whitespace-nowrap" style="{{ $activeTab === 'organization-general' ? 'background-color: var(--bg-hover); color: var(--color-hr-primary-dark); font-weight: 600;' : 'color: var(--text-primary);' }}">
            <span class="text-sm" style="{{ $activeTab === 'organization-general' ? 'font-weight: 600; color: var(--color-hr-primary-dark);' : 'font-weight: 500; color: var(--text-primary);' }}">General Information</span>
        </a>
        
        <!-- Qualifications Dropdown - Hidden -->
        {{-- <x-dropdown-menu 
            :items="[
                ['url' => route('admin.qualifications.skills'), 'label' => 'Skills'],
                ['url' => route('admin.qualifications.education'), 'label' => 'Education'],
                ['url' => route('admin.qualifications.licenses'), 'label' => 'Licenses'],
                ['url' => route('admin.qualifications.languages'), 'label' => 'Languages'],
                ['url' => route('admin.qualifications.memberships'), 'label' => 'Memberships']
            ]"
            position="left"
            width="w-48">
            @php
                $isQualActive = in_array($activeTab, ['qualifications-skills', 'qualifications-education', 'qualifications-licenses', 'qualifications-languages', 'qualifications-memberships']);
            @endphp
            <div class="px-4 py-3 {{ $isQualActive ? 'border-b-2 border-[var(--color-hr-primary)]' : '' }} cursor-pointer transition-all flex items-center justify-between gap-2 flex-shrink-0 hr-tab-hover whitespace-nowrap" style="{{ $isQualActive ? 'background-color: var(--bg-hover); color: var(--color-hr-primary-dark); font-weight: 600;' : 'color: var(--text-primary);' }}" onmouseover="if(!{{ $isQualActive ? 'true' : 'false' }}) { this.style.backgroundColor='var(--bg-hover)'; this.style.color='var(--color-hr-primary)'; }" onmouseout="if(!{{ $isQualActive ? 'true' : 'false' }}) { this.style.backgroundColor='transparent'; this.style.color='var(--text-primary)'; }">
                <span class="text-sm flex-shrink-0" style="{{ $isQualActive ? 'font-weight: 600; color: var(--color-hr-primary-dark);' : 'font-weight: 500; color: var(--text-primary);' }}">Qualifications</span>
                <x-dropdown-arrow class="flex-shrink-0" />
            </div>
        </x-dropdown-menu> --}}
        
        <!-- Nationalities Tab - Hidden -->
        {{-- <a href="{{ route('admin.nationalities') }}" class="px-4 py-3 {{ $activeTab === 'nationalities' ? 'border-b-2 border-[var(--color-hr-primary)]' : '' }} cursor-pointer transition-all flex-shrink-0 flex items-center hr-tab-hover whitespace-nowrap" style="{{ $activeTab === 'nationalities' ? 'background-color: var(--bg-hover); color: var(--color-hr-primary-dark); font-weight: 600;' : 'color: var(--text-primary);' }}" onmouseover="if('{{ $activeTab }}' !== 'nationalities') { this.style.backgroundColor='var(--bg-hover)'; this.style.color='var(--color-hr-primary)'; }" onmouseout="if('{{ $activeTab }}' !== 'nationalities') { this.style.backgroundColor='transparent'; this.style.color='var(--text-primary)'; }">
            <span class="text-sm" style="{{ $activeTab === 'nationalities' ? 'font-weight: 600; color: var(--color-hr-primary-dark);' : 'font-weight: 500; color: var(--text-primary);' }}">Nationalities</span>
        </a> --}}
        
        <!-- Corporate Branding Tab - Hidden -->
        {{-- <a href="{{ route('admin.corporate-branding') }}" class="px-4 py-3 {{ $activeTab === 'corporate-branding' ? 'border-b-2 border-[var(--color-hr-primary)]' : '' }} cursor-pointer transition-all flex-shrink-0 flex items-center hr-tab-hover whitespace-nowrap" style="{{ $activeTab === 'corporate-branding' ? 'background-color: var(--bg-hover); color: var(--color-hr-primary-dark); font-weight: 600;' : 'color: var(--text-primary);' }}" onmouseover="if('{{ $activeTab }}' !== 'corporate-branding') { this.style.backgroundColor='var(--bg-hover)'; this.style.color='var(--color-hr-primary)'; }" onmouseout="if('{{ $activeTab }}' !== 'corporate-branding') { this.style.backgroundColor='transparent'; this.style.color='var(--text-primary)'; }">
            <span class="text-sm" style="{{ $activeTab === 'corporate-branding' ? 'font-weight: 600; color: var(--color-hr-primary-dark);' : 'font-weight: 500; color: var(--text-primary);' }}">Corporate Branding</span>
        </a> --}}
        
        <!-- Configuration Dropdown - Hidden -->
        {{-- <x-dropdown-menu 
            :items="[
                ['url' => route('admin.configuration.email-configuration'), 'label' => 'Email Configuration'],
                ['url' => route('admin.configuration.email-subscriptions'), 'label' => 'Email Subscriptions'],
                ['url' => route('admin.configuration.localization'), 'label' => 'Localization'],
                ['url' => route('admin.configuration.language-packages'), 'label' => 'Language Packages'],
                ['url' => route('admin.configuration.modules'), 'label' => 'Modules'],
                ['url' => route('admin.configuration.social-media-authentication'), 'label' => 'Social Media Authentication'],
                ['url' => route('admin.configuration.oauth-client-list'), 'label' => 'Register OAuth Client'],
                ['url' => route('admin.configuration.ldap'), 'label' => 'LDAP Configuration']
            ]"
            position="left"
            width="w-56">
            @php
                $isConfigActive = in_array($activeTab, [
                    'configuration-email-configuration',
                    'configuration-email-subscriptions',
                    'configuration-localization',
                    'configuration-language-packages',
                    'configuration-modules',
                    'configuration-social-media-authentication',
                    'configuration-oauth-client-list',
                    'configuration-ldap'
                ]);
            @endphp
            <div class="px-4 py-3 {{ $isConfigActive ? 'border-b-2 border-[var(--color-hr-primary)]' : '' }} cursor-pointer transition-all flex items-center justify-between gap-2 flex-shrink-0 hr-tab-hover whitespace-nowrap" style="{{ $isConfigActive ? 'background-color: var(--bg-hover); color: var(--color-hr-primary-dark); font-weight: 600;' : 'color: var(--text-primary);' }}" onmouseover="if(!{{ $isConfigActive ? 'true' : 'false' }}) { this.style.backgroundColor='var(--bg-hover)'; this.style.color='var(--color-hr-primary)'; }" onmouseout="if(!{{ $isConfigActive ? 'true' : 'false' }}) { this.style.backgroundColor='transparent'; this.style.color='var(--text-primary)'; }">
                <span class="text-sm flex-shrink-0" style="{{ $isConfigActive ? 'font-weight: 600; color: var(--color-hr-primary-dark);' : 'font-weight: 500; color: var(--text-primary);' }}">Configuration</span>
                <x-dropdown-arrow class="flex-shrink-0" />
            </div>
        </x-dropdown-menu> --}}
    </div>
</div>
