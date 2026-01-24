@props(['activeTab' => 'employee-list'])

<div class="hr-sticky-tabs">
    <div class="flex items-stretch border-b border-purple-100 overflow-x-auto overflow-y-visible flex-nowrap">
        <!-- Configuration Dropdown -->
        <x-dropdown-menu 
            :items="[
                ['url' => route('pim.configuration.optional-fields'), 'label' => 'Optional Fields'],
                ['url' => route('pim.configuration.custom-fields'), 'label' => 'Custom Fields'],
                ['url' => route('pim.configuration.data-import'), 'label' => 'Data Import'],
                ['url' => route('pim.configuration.reporting-methods'), 'label' => 'Reporting Methods'],
                ['url' => route('pim.configuration.termination-reasons'), 'label' => 'Termination Reasons']
            ]"
            position="left"
            width="w-48">
            @php
                $isConfigActive = in_array($activeTab, [
                    'configuration-optional-fields',
                    'configuration-custom-fields',
                    'configuration-data-import',
                    'configuration-reporting-methods',
                    'configuration-termination-reasons'
                ]);
            @endphp
            <div class="px-4 py-3 {{ $isConfigActive ? 'border-b-2 border-[var(--color-hr-primary)]' : '' }} cursor-pointer transition-all flex items-center justify-between gap-2 flex-shrink-0 hr-tab-hover whitespace-nowrap" style="{{ $isConfigActive ? 'background-color: var(--bg-hover); color: var(--color-hr-primary-dark); font-weight: 600;' : 'color: var(--text-primary);' }}" onmouseover="if(!{{ $isConfigActive ? 'true' : 'false' }}) { this.style.backgroundColor='var(--bg-hover)'; this.style.color='var(--color-hr-primary)'; }" onmouseout="if(!{{ $isConfigActive ? 'true' : 'false' }}) { this.style.backgroundColor='transparent'; this.style.color='var(--text-primary)'; }">
                <span class="text-sm flex-shrink-0" style="{{ $isConfigActive ? 'font-weight: 600; color: var(--color-hr-primary-dark);' : 'font-weight: 500; color: var(--text-primary);' }}">Configuration</span>
                <x-dropdown-arrow class="flex-shrink-0" />
            </div>
        </x-dropdown-menu>
        
        <!-- Employee List Tab -->
        <a href="{{ route('pim.employee-list') }}" class="px-4 py-3 {{ $activeTab === 'employee-list' ? 'border-b-2 border-[var(--color-hr-primary)]' : '' }} cursor-pointer transition-all flex-shrink-0 flex items-center hr-tab-hover whitespace-nowrap" style="{{ $activeTab === 'employee-list' ? 'background-color: var(--bg-hover); color: var(--color-hr-primary-dark); font-weight: 600;' : 'color: var(--text-primary);' }}" onmouseover="if('{{ $activeTab }}' !== 'employee-list') { this.style.backgroundColor='var(--bg-hover)'; this.style.color='var(--color-hr-primary)'; }" onmouseout="if('{{ $activeTab }}' !== 'employee-list') { this.style.backgroundColor='transparent'; this.style.color='var(--text-primary)'; }">
            <span class="text-sm" style="{{ $activeTab === 'employee-list' ? 'font-weight: 600; color: var(--color-hr-primary-dark);' : 'font-weight: 500; color: var(--text-primary);' }}">Employee List</span>
        </a>
        
        <!-- Add Employee Tab -->
        <a href="{{ route('pim.add-employee') }}" class="px-4 py-3 {{ $activeTab === 'add-employee' ? 'border-b-2 border-[var(--color-hr-primary)]' : '' }} cursor-pointer transition-all flex-shrink-0 flex items-center hr-tab-hover whitespace-nowrap" style="{{ $activeTab === 'add-employee' ? 'background-color: var(--bg-hover); color: var(--color-hr-primary-dark); font-weight: 600;' : 'color: var(--text-primary);' }}" onmouseover="if('{{ $activeTab }}' !== 'add-employee') { this.style.backgroundColor='var(--bg-hover)'; this.style.color='var(--color-hr-primary)'; }" onmouseout="if('{{ $activeTab }}' !== 'add-employee') { this.style.backgroundColor='transparent'; this.style.color='var(--text-primary)'; }">
            <span class="text-sm" style="{{ $activeTab === 'add-employee' ? 'font-weight: 600; color: var(--color-hr-primary-dark);' : 'font-weight: 500; color: var(--text-primary);' }}">Add Employee</span>
        </a>
        
        <!-- Reports Tab -->
        <a href="{{ route('pim.reports') }}" class="px-4 py-3 {{ $activeTab === 'reports' ? 'border-b-2 border-[var(--color-hr-primary)]' : '' }} cursor-pointer transition-all flex-shrink-0 flex items-center hr-tab-hover whitespace-nowrap" style="{{ $activeTab === 'reports' ? 'background-color: var(--bg-hover); color: var(--color-hr-primary-dark); font-weight: 600;' : 'color: var(--text-primary);' }}" onmouseover="if('{{ $activeTab }}' !== 'reports') { this.style.backgroundColor='var(--bg-hover)'; this.style.color='var(--color-hr-primary)'; }" onmouseout="if('{{ $activeTab }}' !== 'reports') { this.style.backgroundColor='transparent'; this.style.color='var(--text-primary)'; }">
            <span class="text-sm" style="{{ $activeTab === 'reports' ? 'font-weight: 600; color: var(--color-hr-primary-dark);' : 'font-weight: 500; color: var(--text-primary);' }}">Reports</span>
        </a>
    </div>
</div>
