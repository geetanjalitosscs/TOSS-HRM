@props(['activeTab' => 'candidates'])

<div class="hr-sticky-tabs">
    <div class="flex items-stretch border-b border-purple-100 overflow-x-auto overflow-y-visible">
        <!-- Candidates Tab -->
        <a href="{{ route('recruitment') }}" class="px-4 py-3 {{ $activeTab === 'candidates' ? 'border-b-2 border-[var(--color-hr-primary)] bg-purple-200' : 'hover:bg-purple-100' }} cursor-pointer transition-all min-w-0 block">
            <span class="text-sm {{ $activeTab === 'candidates' ? 'font-semibold text-[var(--color-hr-primary-dark)]' : 'font-medium text-slate-700' }} break-words">Candidates</span>
        </a>
        
        <!-- Vacancies Tab -->
        <a href="{{ route('recruitment.vacancies') }}" class="px-4 py-3 {{ $activeTab === 'vacancies' ? 'border-b-2 border-[var(--color-hr-primary)] bg-purple-200' : 'hover:bg-purple-100' }} cursor-pointer transition-all min-w-0 block">
            <span class="text-sm {{ $activeTab === 'vacancies' ? 'font-semibold text-[var(--color-hr-primary-dark)]' : 'font-medium text-slate-700' }} break-words">Vacancies</span>
        </a>
    </div>
</div>

