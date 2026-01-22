@props(['activeTab' => 'employee-list'])

<div class="hr-sticky-tabs">
    <div class="flex items-stretch border-b border-purple-100 overflow-x-auto overflow-y-visible">
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
            <div class="px-4 py-3 {{ $isConfigActive ? 'border-b-2 border-[var(--color-hr-primary)]' : '' }} cursor-pointer transition-all flex items-center justify-between gap-2 min-w-0 hr-tab-hover" style="{{ $isConfigActive ? 'background-color: var(--bg-hover); color: var(--color-hr-primary-dark); font-weight: 600;' : 'color: var(--text-primary);' }}" onmouseover="if(!{{ $isConfigActive ? 'true' : 'false' }}) { this.style.backgroundColor='var(--bg-hover)'; this.style.color='var(--color-hr-primary)'; }" onmouseout="if(!{{ $isConfigActive ? 'true' : 'false' }}) { this.style.backgroundColor='transparent'; this.style.color='var(--text-primary)'; }">
                <span class="text-sm break-words flex-1 min-w-0" style="{{ $isConfigActive ? 'font-weight: 600; color: var(--color-hr-primary-dark);' : 'font-weight: 500; color: var(--text-primary);' }}">Configuration</span>
                <span class="flex-shrink-0" style="color: var(--color-hr-primary);">▼</span>
            </div>
        </x-dropdown-menu>
        
        <!-- Employee List Tab -->
        <a href="{{ route('pim.employee-list') }}" class="px-4 py-3 {{ $activeTab === 'employee-list' ? 'border-b-2 border-[var(--color-hr-primary)]' : '' }} cursor-pointer transition-all min-w-0 block hr-tab-hover" style="{{ $activeTab === 'employee-list' ? 'background-color: var(--bg-hover); color: var(--color-hr-primary-dark); font-weight: 600;' : 'color: var(--text-primary);' }}" onmouseover="if('{{ $activeTab }}' !== 'employee-list') { this.style.backgroundColor='var(--bg-hover)'; this.style.color='var(--color-hr-primary)'; }" onmouseout="if('{{ $activeTab }}' !== 'employee-list') { this.style.backgroundColor='transparent'; this.style.color='var(--text-primary)'; }">
            <span class="text-sm break-words" style="{{ $activeTab === 'employee-list' ? 'font-weight: 600; color: var(--color-hr-primary-dark);' : 'font-weight: 500; color: var(--text-primary);' }}">Employee List</span>
        </a>
        
        <!-- Add Employee Tab -->
        <a href="{{ route('pim.add-employee') }}" class="px-4 py-3 {{ $activeTab === 'add-employee' ? 'border-b-2 border-[var(--color-hr-primary)]' : '' }} cursor-pointer transition-all min-w-0 block hr-tab-hover" style="{{ $activeTab === 'add-employee' ? 'background-color: var(--bg-hover); color: var(--color-hr-primary-dark); font-weight: 600;' : 'color: var(--text-primary);' }}" onmouseover="if('{{ $activeTab }}' !== 'add-employee') { this.style.backgroundColor='var(--bg-hover)'; this.style.color='var(--color-hr-primary)'; }" onmouseout="if('{{ $activeTab }}' !== 'add-employee') { this.style.backgroundColor='transparent'; this.style.color='var(--text-primary)'; }">
            <span class="text-sm break-words" style="{{ $activeTab === 'add-employee' ? 'font-weight: 600; color: var(--color-hr-primary-dark);' : 'font-weight: 500; color: var(--text-primary);' }}">Add Employee</span>
        </a>
        
        <!-- Reports Tab -->
        <a href="{{ route('pim.reports') }}" class="px-4 py-3 {{ $activeTab === 'reports' ? 'border-b-2 border-[var(--color-hr-primary)]' : '' }} cursor-pointer transition-all min-w-0 block hr-tab-hover" style="{{ $activeTab === 'reports' ? 'background-color: var(--bg-hover); color: var(--color-hr-primary-dark); font-weight: 600;' : 'color: var(--text-primary);' }}" onmouseover="if('{{ $activeTab }}' !== 'reports') { this.style.backgroundColor='var(--bg-hover)'; this.style.color='var(--color-hr-primary)'; }" onmouseout="if('{{ $activeTab }}' !== 'reports') { this.style.backgroundColor='transparent'; this.style.color='var(--text-primary)'; }">
            <span class="text-sm break-words" style="{{ $activeTab === 'reports' ? 'font-weight: 600; color: var(--color-hr-primary-dark);' : 'font-weight: 500; color: var(--text-primary);' }}">Reports</span>
        </a>
    </div>
</div>
