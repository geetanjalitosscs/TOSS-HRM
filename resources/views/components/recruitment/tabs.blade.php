@props(['activeTab' => 'candidates'])

<div class="hr-sticky-tabs">
    <div class="flex items-stretch border-b border-[var(--border-default)] overflow-x-auto overflow-y-visible flex-nowrap">
        <!-- Candidates Tab -->
        <a href="{{ route('recruitment') }}" class="px-4 py-3 {{ $activeTab === 'candidates' ? 'border-b-2 border-[var(--color-hr-primary)]' : '' }} cursor-pointer transition-all flex-shrink-0 flex items-center hr-tab-hover whitespace-nowrap" style="{{ $activeTab === 'candidates' ? 'background-color: var(--bg-hover); color: var(--color-hr-primary-dark); font-weight: 600;' : 'color: var(--text-primary);' }}" onmouseover="if('{{ $activeTab }}' !== 'candidates') { this.style.backgroundColor='var(--bg-hover)'; this.style.color='var(--color-hr-primary)'; }" onmouseout="if('{{ $activeTab }}' !== 'candidates') { this.style.backgroundColor='transparent'; this.style.color='var(--text-primary)'; }">
            <span class="text-sm" style="{{ $activeTab === 'candidates' ? 'font-weight: 600; color: var(--color-hr-primary-dark);' : 'font-weight: 500; color: var(--text-primary);' }}">Candidates</span>
        </a>
        
        <!-- Vacancies Tab -->
        <a href="{{ route('recruitment.vacancies') }}" class="px-4 py-3 {{ $activeTab === 'vacancies' ? 'border-b-2 border-[var(--color-hr-primary)]' : '' }} cursor-pointer transition-all flex-shrink-0 flex items-center hr-tab-hover whitespace-nowrap" style="{{ $activeTab === 'vacancies' ? 'background-color: var(--bg-hover); color: var(--color-hr-primary-dark); font-weight: 600;' : 'color: var(--text-primary);' }}" onmouseover="if('{{ $activeTab }}' !== 'vacancies') { this.style.backgroundColor='var(--bg-hover)'; this.style.color='var(--color-hr-primary)'; }" onmouseout="if('{{ $activeTab }}' !== 'vacancies') { this.style.backgroundColor='transparent'; this.style.color='var(--text-primary)'; }">
            <span class="text-sm" style="{{ $activeTab === 'vacancies' ? 'font-weight: 600; color: var(--color-hr-primary-dark);' : 'font-weight: 500; color: var(--text-primary);' }}">Vacancies</span>
        </a>
    </div>
</div>
