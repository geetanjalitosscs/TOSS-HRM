@props(['activeTab' => 'user-management'])

<div class="hr-sticky-tabs">
    <div class="flex items-stretch border-b border-purple-100 overflow-x-auto overflow-y-visible">
        <!-- User Management Tab -->
        <a href="{{ route('admin') }}" class="px-4 py-3 {{ $activeTab === 'user-management' ? 'border-b-2 border-[var(--color-hr-primary)] bg-purple-200' : 'hover:bg-purple-100' }} cursor-pointer transition-all min-w-0 block">
            <span class="text-sm {{ $activeTab === 'user-management' ? 'font-semibold text-[var(--color-hr-primary-dark)]' : 'font-medium text-slate-700' }} break-words">User Management</span>
        </a>
        
        <!-- Job Dropdown -->
        <x-dropdown-menu 
            :items="[
                ['url' => route('admin.job-titles'), 'label' => 'Job Titles'],
                ['url' => route('admin.pay-grades'), 'label' => 'Pay Grades'],
                ['url' => route('admin.employment-status'), 'label' => 'Employment Status'],
                ['url' => route('admin.job-categories'), 'label' => 'Job Categories'],
                ['url' => route('admin.work-shifts'), 'label' => 'Work Shifts']
            ]"
            position="left"
            width="w-48">
            @php
                $isJobActive = in_array($activeTab, ['job-titles', 'pay-grades', 'employment-status', 'job-categories', 'work-shifts']);
            @endphp
            <div class="px-4 py-3 {{ $isJobActive ? 'border-b-2 border-[var(--color-hr-primary)] bg-purple-200' : 'hover:bg-purple-100' }} cursor-pointer transition-all flex items-center justify-between gap-2 min-w-0">
                <span class="text-sm {{ $isJobActive ? 'font-semibold text-[var(--color-hr-primary-dark)]' : 'font-medium text-slate-700' }} break-words flex-1 min-w-0">Job</span>
                <span class="text-purple-400 flex-shrink-0">▼</span>
            </div>
        </x-dropdown-menu>
        
        <!-- Organization Dropdown -->
        <x-dropdown-menu 
            :items="[
                ['url' => route('admin.organization.general-information'), 'label' => 'General Information'],
                ['url' => route('admin.organization.locations'), 'label' => 'Locations'],
                ['url' => route('admin.organization.structure'), 'label' => 'Structure']
            ]"
            position="left"
            width="w-48">
            @php
                $isOrgActive = in_array($activeTab, ['organization-general', 'organization-locations', 'organization-structure']);
            @endphp
            <div class="px-4 py-3 {{ $isOrgActive ? 'border-b-2 border-[var(--color-hr-primary)] bg-purple-200' : 'hover:bg-purple-100' }} cursor-pointer transition-all flex items-center justify-between gap-2 min-w-0">
                <span class="text-sm {{ $isOrgActive ? 'font-semibold text-[var(--color-hr-primary-dark)]' : 'font-medium text-slate-700' }} break-words flex-1 min-w-0">Organization</span>
                <span class="text-purple-400 flex-shrink-0">▼</span>
            </div>
        </x-dropdown-menu>
        
        <!-- Qualifications Dropdown -->
        <x-dropdown-menu 
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
            <div class="px-4 py-3 {{ $isQualActive ? 'border-b-2 border-[var(--color-hr-primary)] bg-purple-200' : 'hover:bg-purple-100' }} cursor-pointer transition-all flex items-center justify-between gap-2 min-w-0">
                <span class="text-sm {{ $isQualActive ? 'font-semibold text-[var(--color-hr-primary-dark)]' : 'font-medium text-slate-700' }} break-words flex-1 min-w-0">Qualifications</span>
                <span class="text-purple-400 flex-shrink-0">▼</span>
            </div>
        </x-dropdown-menu>
        
        <!-- Nationalities Tab -->
        <a href="{{ route('admin.nationalities') }}" class="px-4 py-3 {{ $activeTab === 'nationalities' ? 'border-b-2 border-[var(--color-hr-primary)] bg-purple-200' : 'hover:bg-purple-100' }} cursor-pointer transition-all min-w-0 block">
            <span class="text-sm {{ $activeTab === 'nationalities' ? 'font-semibold text-[var(--color-hr-primary-dark)]' : 'font-medium text-slate-700' }} break-words">Nationalities</span>
        </a>
        
        <!-- Corporate Branding Tab -->
        <a href="{{ route('admin.corporate-branding') }}" class="px-4 py-3 {{ $activeTab === 'corporate-branding' ? 'border-b-2 border-[var(--color-hr-primary)] bg-purple-200' : 'hover:bg-purple-100' }} cursor-pointer transition-all min-w-0 block">
            <span class="text-sm {{ $activeTab === 'corporate-branding' ? 'font-semibold text-[var(--color-hr-primary-dark)]' : 'font-medium text-slate-700' }} break-words">Corporate Branding</span>
        </a>
        
        <!-- Configuration Dropdown -->
        <x-dropdown-menu 
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
            <div class="px-4 py-3 {{ $isConfigActive ? 'border-b-2 border-[var(--color-hr-primary)] bg-purple-200' : 'hover:bg-purple-100' }} cursor-pointer transition-all flex items-center justify-between gap-2 min-w-0">
                <span class="text-sm {{ $isConfigActive ? 'font-semibold text-[var(--color-hr-primary-dark)]' : 'font-medium text-slate-700' }} break-words flex-1 min-w-0">Configuration</span>
                <span class="text-purple-400 flex-shrink-0">▼</span>
            </div>
        </x-dropdown-menu>
    </div>
</div>

