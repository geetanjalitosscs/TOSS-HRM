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
            <div class="px-4 py-3 {{ $isConfigActive ? 'border-b-2 border-[var(--color-hr-primary)] bg-purple-200' : 'hover:bg-purple-100' }} cursor-pointer transition-all flex items-center justify-between gap-2 min-w-0">
                <span class="text-sm {{ $isConfigActive ? 'font-semibold text-[var(--color-hr-primary-dark)]' : 'font-medium text-slate-700' }} break-words flex-1 min-w-0">Configuration</span>
                <span class="text-purple-400 flex-shrink-0">▼</span>
            </div>
        </x-dropdown-menu>
        
        <!-- Employee List Tab -->
        <a href="{{ route('pim.employee-list') }}" class="px-4 py-3 {{ $activeTab === 'employee-list' ? 'border-b-2 border-[var(--color-hr-primary)] bg-purple-200' : 'hover:bg-purple-100' }} cursor-pointer transition-all min-w-0 block">
            <span class="text-sm {{ $activeTab === 'employee-list' ? 'font-semibold text-[var(--color-hr-primary-dark)]' : 'font-medium text-slate-700' }} break-words">Employee List</span>
        </a>
        
        <!-- Add Employee Tab -->
        <a href="{{ route('pim.add-employee') }}" class="px-4 py-3 {{ $activeTab === 'add-employee' ? 'border-b-2 border-[var(--color-hr-primary)] bg-purple-200' : 'hover:bg-purple-100' }} cursor-pointer transition-all min-w-0 block">
            <span class="text-sm {{ $activeTab === 'add-employee' ? 'font-semibold text-[var(--color-hr-primary-dark)]' : 'font-medium text-slate-700' }} break-words">Add Employee</span>
        </a>
        
        <!-- Reports Tab -->
        <a href="{{ route('pim.reports') }}" class="px-4 py-3 {{ $activeTab === 'reports' ? 'border-b-2 border-[var(--color-hr-primary)] bg-purple-200' : 'hover:bg-purple-100' }} cursor-pointer transition-all min-w-0 block">
            <span class="text-sm {{ $activeTab === 'reports' ? 'font-semibold text-[var(--color-hr-primary-dark)]' : 'font-medium text-slate-700' }} break-words">Reports</span>
        </a>
    </div>
</div>

