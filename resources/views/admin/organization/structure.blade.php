@extends('layouts.app')

@section('title', 'Admin - Organization Structure')

@section('body')
    <x-main-layout title="Admin">
        <x-admin.tabs activeTab="organization-structure" />

        <section class="hr-card p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-sm font-bold text-slate-800 flex items-baseline gap-2">
                    <i class="fas fa-sitemap text-[var(--color-primary)]"></i> <span class="mt-0.5">Organization Structure</span>
                </h2>
                <label class="flex items-center cursor-pointer">
                    <span class="text-sm text-gray-700">Edit</span>
                    <x-admin.toggle-switch 
                        id="edit-toggle"
                        bgId="toggle-bg"
                        circleId="toggle-circle"
                        onChange="toggleEditMode()"
                    />
                </label>
            </div>

            <div class="mb-4" id="add-button-container" style="display: none;">
                <button class="hr-btn-primary px-4 py-2 text-sm font-medium rounded-lg transition-all flex items-center gap-1 shadow-md hover:shadow-lg hover:shadow-[var(--color-primary-light)] hover:scale-105 transform">
                    <span class="text-sm font-bold">+</span> Add
                </button>
            </div>

            <!-- Organization Tree -->
            <div class="org-tree-container">
                <ul class="org-tree">
                    <!-- Root Node -->
                    <li class="org-tree-node org-tree-node-root">
                        <div class="org-tree-node-box">
                            <span class="org-tree-node-label">TOAI HRM Suite</span>
                            <div class="org-tree-node-actions action-buttons" style="display: none;">
                                <button class="org-tree-action-btn org-tree-action-delete" title="Delete">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <button class="org-tree-action-btn org-tree-action-edit" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="org-tree-action-btn org-tree-action-add" title="Add Sub-unit">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Level 1 Children -->
                        <ul class="org-tree-children">
                            <!-- Administration -->
                            <li class="org-tree-node">
                                <div class="org-tree-node-box">
                                    <span class="org-tree-node-label">100: Administration</span>
                                    <div class="org-tree-node-actions action-buttons" style="display: none;">
                                        <button class="org-tree-action-btn org-tree-action-delete" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <button class="org-tree-action-btn org-tree-action-edit" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="org-tree-action-btn org-tree-action-add" title="Add Sub-unit">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </li>

                            <!-- Engineering (Expandable) -->
                            <li class="org-tree-node org-tree-node-expandable">
                                <div class="org-tree-node-box">
                                    <button class="org-tree-toggle" onclick="toggleOrgNode(this)">
                                        <i class="fas fa-chevron-up"></i>
                                    </button>
                                    <span class="org-tree-node-label">Engineering</span>
                                    <div class="org-tree-node-actions action-buttons" style="display: none;">
                                        <button class="org-tree-action-btn org-tree-action-delete" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <button class="org-tree-action-btn org-tree-action-edit" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="org-tree-action-btn org-tree-action-add" title="Add Sub-unit">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <ul class="org-tree-children">
                                    <li class="org-tree-node">
                                        <div class="org-tree-node-box">
                                            <span class="org-tree-node-label">Development</span>
                                            <div class="org-tree-node-actions action-buttons" style="display: none;">
                                                <button class="org-tree-action-btn org-tree-action-delete" title="Delete">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                                <button class="org-tree-action-btn org-tree-action-edit" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="org-tree-action-btn org-tree-action-add" title="Add Sub-unit">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="org-tree-node">
                                        <div class="org-tree-node-box">
                                            <span class="org-tree-node-label">Quality Assurance</span>
                                            <div class="org-tree-node-actions action-buttons" style="display: none;">
                                                <button class="org-tree-action-btn org-tree-action-delete" title="Delete">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                                <button class="org-tree-action-btn org-tree-action-edit" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="org-tree-action-btn org-tree-action-add" title="Add Sub-unit">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="org-tree-node">
                                        <div class="org-tree-node-box">
                                            <span class="org-tree-node-label">TechOps</span>
                                            <div class="org-tree-node-actions action-buttons" style="display: none;">
                                                <button class="org-tree-action-btn org-tree-action-delete" title="Delete">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                                <button class="org-tree-action-btn org-tree-action-edit" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="org-tree-action-btn org-tree-action-add" title="Add Sub-unit">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>

                            <!-- Sales & Marketing (Expandable) -->
                            <li class="org-tree-node org-tree-node-expandable">
                                <div class="org-tree-node-box">
                                    <button class="org-tree-toggle" onclick="toggleOrgNode(this)">
                                        <i class="fas fa-chevron-up"></i>
                                    </button>
                                    <span class="org-tree-node-label">Sales & Marketing</span>
                                    <div class="org-tree-node-actions action-buttons" style="display: none;">
                                        <button class="org-tree-action-btn org-tree-action-delete" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <button class="org-tree-action-btn org-tree-action-edit" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="org-tree-action-btn org-tree-action-add" title="Add Sub-unit">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <ul class="org-tree-children">
                                    <li class="org-tree-node">
                                        <div class="org-tree-node-box">
                                            <span class="org-tree-node-label">Sales</span>
                                            <div class="org-tree-node-actions action-buttons" style="display: none;">
                                                <button class="org-tree-action-btn org-tree-action-delete" title="Delete">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                                <button class="org-tree-action-btn org-tree-action-edit" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="org-tree-action-btn org-tree-action-add" title="Add Sub-unit">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="org-tree-node">
                                        <div class="org-tree-node-box">
                                            <span class="org-tree-node-label">Marketing</span>
                                            <div class="org-tree-node-actions action-buttons" style="display: none;">
                                                <button class="org-tree-action-btn org-tree-action-delete" title="Delete">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                                <button class="org-tree-action-btn org-tree-action-edit" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="org-tree-action-btn org-tree-action-add" title="Add Sub-unit">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>

                            <!-- Client Services (Expandable) -->
                            <li class="org-tree-node org-tree-node-expandable">
                                <div class="org-tree-node-box">
                                    <button class="org-tree-toggle" onclick="toggleOrgNode(this)">
                                        <i class="fas fa-chevron-up"></i>
                                    </button>
                                    <span class="org-tree-node-label">Client Services</span>
                                    <div class="org-tree-node-actions action-buttons" style="display: none;">
                                        <button class="org-tree-action-btn org-tree-action-delete" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <button class="org-tree-action-btn org-tree-action-edit" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="org-tree-action-btn org-tree-action-add" title="Add Sub-unit">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <ul class="org-tree-children">
                                    <li class="org-tree-node">
                                        <div class="org-tree-node-box">
                                            <span class="org-tree-node-label">Technical Support</span>
                                            <div class="org-tree-node-actions action-buttons" style="display: none;">
                                                <button class="org-tree-action-btn org-tree-action-delete" title="Delete">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                                <button class="org-tree-action-btn org-tree-action-edit" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="org-tree-action-btn org-tree-action-add" title="Add Sub-unit">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>

                            <!-- Finance -->
                            <li class="org-tree-node">
                                <div class="org-tree-node-box">
                                    <span class="org-tree-node-label">Finance</span>
                                    <div class="org-tree-node-actions action-buttons" style="display: none;">
                                        <button class="org-tree-action-btn org-tree-action-delete" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <button class="org-tree-action-btn org-tree-action-edit" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="org-tree-action-btn org-tree-action-add" title="Add Sub-unit">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </li>

                            <!-- Human Resources -->
                            <li class="org-tree-node">
                                <div class="org-tree-node-box">
                                    <span class="org-tree-node-label">Human Resources</span>
                                    <div class="org-tree-node-actions action-buttons" style="display: none;">
                                        <button class="org-tree-action-btn org-tree-action-delete" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <button class="org-tree-action-btn org-tree-action-edit" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="org-tree-action-btn org-tree-action-add" title="Add Sub-unit">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </li>

                            <!-- 1: hola -->
                            <li class="org-tree-node">
                                <div class="org-tree-node-box">
                                    <span class="org-tree-node-label">1: hola</span>
                                    <div class="org-tree-node-actions action-buttons" style="display: none;">
                                        <button class="org-tree-action-btn org-tree-action-delete" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <button class="org-tree-action-btn org-tree-action-edit" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="org-tree-action-btn org-tree-action-add" title="Add Sub-unit">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </li>

                            <!-- juan perez -->
                            <li class="org-tree-node">
                                <div class="org-tree-node-box">
                                    <span class="org-tree-node-label">juan perez</span>
                                    <div class="org-tree-node-actions action-buttons" style="display: none;">
                                        <button class="org-tree-action-btn org-tree-action-delete" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <button class="org-tree-action-btn org-tree-action-edit" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="org-tree-action-btn org-tree-action-add" title="Add Sub-unit">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </section>
    </x-main-layout>

    <script>
        function toggleEditMode() {
            const checkbox = document.getElementById('edit-toggle');
            const bg = document.getElementById('toggle-bg');
            const circle = document.getElementById('toggle-circle');
            const addButton = document.getElementById('add-button-container');
            const actionButtons = document.querySelectorAll('.action-buttons');
            
            if (checkbox && bg && circle) {
                if (checkbox.checked) {
                    // Track ON state - match global toggle styling
                    bg.classList.add('bg-[var(--color-hr-primary)]');
                    bg.classList.remove('bg-gray-200');
                    bg.style.background = 'var(--color-hr-primary)';
                    bg.style.borderColor = 'var(--border-strong)';
                    circle.classList.remove('translate-x-0.5');
                    circle.classList.add('translate-x-5');
                    if (addButton) {
                        addButton.style.display = 'block';
                    }
                    actionButtons.forEach(btn => {
                        btn.style.display = 'flex';
                    });
                } else {
                    // Track OFF state
                    bg.classList.remove('bg-[var(--color-hr-primary)]');
                    bg.classList.add('bg-gray-200');
                    bg.style.background = 'var(--bg-input)';
                    bg.style.borderColor = 'var(--border-default)';
                    circle.classList.remove('translate-x-5');
                    circle.classList.add('translate-x-0.5');
                    if (addButton) {
                        addButton.style.display = 'none';
                    }
                    actionButtons.forEach(btn => {
                        btn.style.display = 'none';
                    });
                }
            }
        }

        function toggleOrgNode(button) {
            const node = button.closest('.org-tree-node');
            const children = node.querySelector('.org-tree-children');
            const icon = button.querySelector('i');
            
            if (children && icon) {
                node.classList.toggle('org-tree-node-collapsed');
                if (node.classList.contains('org-tree-node-collapsed')) {
                    icon.classList.remove('fa-chevron-up');
                    icon.classList.add('fa-chevron-down');
                } else {
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-up');
                }
            }
        }
    </script>
@endsection
