@props(['activeTab' => 'apply'])

<div class="hr-sticky-tabs">
    <div class="flex items-stretch border-b overflow-x-auto overflow-y-visible" style="border-color: var(--border-default);">
        <!-- Apply Tab -->
        <a href="{{ route('leave.apply') }}" class="px-4 py-3 {{ $activeTab === 'apply' ? 'border-b-2' : '' }} cursor-pointer transition-all min-w-0 block hr-tab-hover" style="{{ $activeTab === 'apply' ? 'border-bottom-color: var(--color-hr-primary); background-color: var(--bg-hover); color: var(--color-hr-primary-dark); font-weight: 600;' : 'color: var(--text-primary);' }}" onmouseover="if('{{ $activeTab }}' !== 'apply') { this.style.backgroundColor='var(--bg-hover)'; this.style.color='var(--color-hr-primary)'; }" onmouseout="if('{{ $activeTab }}' !== 'apply') { this.style.backgroundColor='transparent'; this.style.color='var(--text-primary)'; }">
            <span class="text-sm break-words" style="{{ $activeTab === 'apply' ? 'font-weight: 600; color: var(--color-hr-primary-dark);' : 'font-weight: 500; color: var(--text-primary);' }}">Apply</span>
        </a>
        
        <!-- My Leave Tab -->
        <a href="{{ route('leave.my-leave') }}" class="px-4 py-3 {{ $activeTab === 'my-leave' ? 'border-b-2' : '' }} cursor-pointer transition-all min-w-0 block hr-tab-hover" style="{{ $activeTab === 'my-leave' ? 'border-bottom-color: var(--color-hr-primary); background-color: var(--bg-hover); color: var(--color-hr-primary-dark); font-weight: 600;' : 'color: var(--text-primary);' }}" onmouseover="if('{{ $activeTab }}' !== 'my-leave') { this.style.backgroundColor='var(--bg-hover)'; this.style.color='var(--color-hr-primary)'; }" onmouseout="if('{{ $activeTab }}' !== 'my-leave') { this.style.backgroundColor='transparent'; this.style.color='var(--text-primary)'; }">
            <span class="text-sm break-words" style="{{ $activeTab === 'my-leave' ? 'font-weight: 600; color: var(--color-hr-primary-dark);' : 'font-weight: 500; color: var(--text-primary);' }}">My Leave</span>
        </a>
        
        <!-- Entitlements Dropdown -->
        <x-dropdown-menu 
            :items="[
                ['url' => '#', 'label' => 'My Entitlements'],
                ['url' => '#', 'label' => 'Employee Entitlements']
            ]"
            position="left"
            width="w-48">
            @php
                $isEntitlementsActive = in_array($activeTab, ['my-entitlements', 'employee-entitlements']);
            @endphp
            <div class="px-4 py-3 {{ $isEntitlementsActive ? 'border-b-2 border-[var(--color-hr-primary)]' : '' }} cursor-pointer transition-all flex items-center justify-between gap-2 min-w-0 hr-tab-hover" style="{{ $isEntitlementsActive ? 'background-color: var(--bg-hover); color: var(--color-hr-primary-dark); font-weight: 600;' : 'color: var(--text-primary);' }}" onmouseover="if(!{{ $isEntitlementsActive ? 'true' : 'false' }}) { this.style.backgroundColor='var(--bg-hover)'; this.style.color='var(--color-hr-primary)'; }" onmouseout="if(!{{ $isEntitlementsActive ? 'true' : 'false' }}) { this.style.backgroundColor='transparent'; this.style.color='var(--text-primary)'; }">
                <span class="text-sm break-words flex-1 min-w-0" style="{{ $isEntitlementsActive ? 'font-weight: 600; color: var(--color-hr-primary-dark);' : 'font-weight: 500; color: var(--text-primary);' }}">Entitlements</span>
                <span class="flex-shrink-0" style="color: var(--color-hr-primary);">▼</span>
            </div>
        </x-dropdown-menu>
        
        <!-- Reports Dropdown -->
        <x-dropdown-menu 
            :items="[
                ['url' => '#', 'label' => 'Leave Entitlements and Usage Report'],
                ['url' => '#', 'label' => 'My Leave Entitlements and Usage Report']
            ]"
            position="left"
            width="w-64">
            @php
                $isReportsActive = in_array($activeTab, ['leave-entitlements-report', 'my-leave-entitlements-report']);
            @endphp
            <div class="px-4 py-3 {{ $isReportsActive ? 'border-b-2 border-[var(--color-hr-primary)]' : '' }} cursor-pointer transition-all flex items-center justify-between gap-2 min-w-0 hr-tab-hover" style="{{ $isReportsActive ? 'background-color: var(--bg-hover); color: var(--color-hr-primary-dark); font-weight: 600;' : 'color: var(--text-primary);' }}" onmouseover="if(!{{ $isReportsActive ? 'true' : 'false' }}) { this.style.backgroundColor='var(--bg-hover)'; this.style.color='var(--color-hr-primary)'; }" onmouseout="if(!{{ $isReportsActive ? 'true' : 'false' }}) { this.style.backgroundColor='transparent'; this.style.color='var(--text-primary)'; }">
                <span class="text-sm break-words flex-1 min-w-0" style="{{ $isReportsActive ? 'font-weight: 600; color: var(--color-hr-primary-dark);' : 'font-weight: 500; color: var(--text-primary);' }}">Reports</span>
                <span class="flex-shrink-0" style="color: var(--color-hr-primary);">▼</span>
            </div>
        </x-dropdown-menu>
        
        <!-- Configure Dropdown -->
        <x-dropdown-menu 
            :items="[
                ['url' => '#', 'label' => 'Leave Types'],
                ['url' => '#', 'label' => 'Leave Period'],
                ['url' => '#', 'label' => 'Work Week'],
                ['url' => '#', 'label' => 'Holidays']
            ]"
            position="left"
            width="w-48">
            @php
                $isConfigureActive = in_array($activeTab, ['leave-types', 'leave-period', 'work-week', 'holidays']);
            @endphp
            <div class="px-4 py-3 {{ $isConfigureActive ? 'border-b-2 border-[var(--color-hr-primary)]' : '' }} cursor-pointer transition-all flex items-center justify-between gap-2 min-w-0 hr-tab-hover" style="{{ $isConfigureActive ? 'background-color: var(--bg-hover); color: var(--color-hr-primary-dark); font-weight: 600;' : 'color: var(--text-primary);' }}" onmouseover="if(!{{ $isConfigureActive ? 'true' : 'false' }}) { this.style.backgroundColor='var(--bg-hover)'; this.style.color='var(--color-hr-primary)'; }" onmouseout="if(!{{ $isConfigureActive ? 'true' : 'false' }}) { this.style.backgroundColor='transparent'; this.style.color='var(--text-primary)'; }">
                <span class="text-sm break-words flex-1 min-w-0" style="{{ $isConfigureActive ? 'font-weight: 600; color: var(--color-hr-primary-dark);' : 'font-weight: 500; color: var(--text-primary);' }}">Configure</span>
                <span class="flex-shrink-0" style="color: var(--color-hr-primary);">▼</span>
            </div>
        </x-dropdown-menu>
        
        <!-- Leave List Tab -->
        <a href="{{ route('leave.leave-list') }}" class="px-4 py-3 {{ $activeTab === 'leave-list' ? 'border-b-2' : '' }} cursor-pointer transition-all min-w-0 block hr-tab-hover" style="{{ $activeTab === 'leave-list' ? 'border-bottom-color: var(--color-hr-primary); background-color: var(--bg-hover); color: var(--color-hr-primary-dark); font-weight: 600;' : 'color: var(--text-primary);' }}" onmouseover="if('{{ $activeTab }}' !== 'leave-list') { this.style.backgroundColor='var(--bg-hover)'; this.style.color='var(--color-hr-primary)'; }" onmouseout="if('{{ $activeTab }}' !== 'leave-list') { this.style.backgroundColor='transparent'; this.style.color='var(--text-primary)'; }">
            <span class="text-sm break-words" style="{{ $activeTab === 'leave-list' ? 'font-weight: 600; color: var(--color-hr-primary-dark);' : 'font-weight: 500; color: var(--text-primary);' }}">Leave List</span>
        </a>
        
        <!-- Assign Leave Tab -->
        <a href="{{ route('leave.assign-leave') }}" class="px-4 py-3 {{ $activeTab === 'assign-leave' ? 'border-b-2' : '' }} cursor-pointer transition-all min-w-0 block hr-tab-hover" style="{{ $activeTab === 'assign-leave' ? 'border-bottom-color: var(--color-hr-primary); background-color: var(--bg-hover); color: var(--color-hr-primary-dark); font-weight: 600;' : 'color: var(--text-primary);' }}" onmouseover="if('{{ $activeTab }}' !== 'assign-leave') { this.style.backgroundColor='var(--bg-hover)'; this.style.color='var(--color-hr-primary)'; }" onmouseout="if('{{ $activeTab }}' !== 'assign-leave') { this.style.backgroundColor='transparent'; this.style.color='var(--text-primary)'; }">
            <span class="text-sm break-words" style="{{ $activeTab === 'assign-leave' ? 'font-weight: 600; color: var(--color-hr-primary-dark);' : 'font-weight: 500; color: var(--text-primary);' }}">Assign Leave</span>
        </a>
    </div>
</div>

