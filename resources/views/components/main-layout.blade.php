@props([
    'title',
    'showSidebarSearch' => true,
])

<div class="w-full min-h-screen relative" style="background-color: var(--bg-main);">
    <x-sidebar :showSearch="$showSidebarSearch" />
    
    <!-- Main content - Offset for fixed sidebar -->
    <div class="hr-main-wrapper">
        <x-header :title="$title" />
        
        <!-- Main Content Area -->
        <main class="hr-main-content">
            {{ $slot }}
        </main>
    </div>
</div>

