@extends('layouts.app')

@section('title', 'My Info - Dependents')

@section('body')
    <x-main-layout title="PIM">
        <div class="flex items-stretch">
            @include('myinfo.partials.sidebar')

            <!-- Right Content Area -->
            <div class="flex-1">
                <!-- Assigned Dependents Section -->
                <div class="rounded-lg shadow-sm border border-purple-100 p-4 mb-3" style="background-color: var(--bg-card);">
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-sm font-bold text-slate-800">Assigned Dependents</h2>
                        <button type="button" onclick="toggleDependentForm()" class="myinfo-add-btn px-3 py-1.5 text-xs border border-gray-300 rounded-lg hover:bg-gray-100" style="background-color: #F9FAFB; border-color: #D1D5DB; color: #374151;">
                            + Add
                        </button>
                    </div>

                    <!-- Add Dependent Form (Inline) -->
                    <div id="dependent-form-container" style="display: none;" class="mb-3">
                        <h2 class="text-sm font-bold mb-3" style="color: var(--text-primary);">Add Dependent</h2>
                        <form id="dependent-form">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">
                                        Name<span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="name" required class="w-full px-3 py-2 text-sm border rounded-lg" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">
                                        Relationship<span class="text-red-500">*</span>
                                    </label>
                                    <select name="relationship" required class="w-full px-3 py-2 text-sm border rounded-lg" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                                        <option value="">-- Select --</option>
                                        <option value="Child">Child</option>
                                        <option value="Spouse">Spouse</option>
                                        <option value="Parent">Parent</option>
                                        <option value="Sibling">Sibling</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div></div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">
                                        Date of Birth
                                    </label>
                                    <x-date-picker 
                                        id="dependent-date-of-birth"
                                        name="date_of_birth"
                                        value=""
                                        placeholder="yyyy-dd-mm"
                                        variant="split"
                                    />
                                </div>
                                <div></div>
                                <div></div>
                            </div>
                            <div class="text-xs mb-4" style="color: var(--text-muted);">
                                <span class="text-red-500">*</span> Required
                            </div>
                            <div class="flex justify-end gap-3">
                                <button type="button" onclick="closeDependentForm()" class="px-4 py-2 text-sm font-medium border rounded-lg" style="background-color: white; border-color: var(--color-hr-primary); color: var(--color-hr-primary);">
                                    Cancel
                                </button>
                                <button type="submit" class="px-4 py-2 text-sm font-medium text-white rounded-lg" style="background-color: var(--color-hr-primary);">
                                    Save
                                </button>
                            </div>
                        </form>
                        <hr class="border-gray-200 mb-3 mt-3">
                    </div>

                    @php
                        $dependentsCount = isset($dependents) ? $dependents->count() : 0;
                    @endphp
                    @if($dependentsCount === 0)
                        <div class="text-xs text-slate-500 mb-3">No Records Found</div>
                    @else
                        <div class="text-xs text-slate-500 mb-3">({{ $dependentsCount }}) Records Found</div>
                    @endif

                    <hr class="border-gray-200 mb-0">

                    <!-- Table Header -->
                    <div class="myinfo-table-header bg-gray-100 rounded-t-lg border border-purple-100 border-b-0 px-2 py-1.5 mb-0">
                        <div class="flex items-center gap-1">
                            <div class="myinfo-checkbox-cell" style="width: 40px; flex-shrink: 0;">
                                <input type="checkbox" class="myinfo-checkbox w-4 h-4 text-[var(--color-hr-primary)] border-gray-300 rounded focus:ring-[var(--color-hr-primary)]">
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Name</span>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Relationship</span>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Date of Birth</span>
                            </div>
                            <div class="flex-shrink-0" style="width: 90px;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words text-center">Actions</span>
                            </div>
                        </div>
                    </div>

                    <!-- Table Rows -->
                    <div class="border border-purple-100 border-t-0 rounded-b-lg" style="overflow: visible;">
                        @forelse($dependents ?? collect([]) as $dependent)
                            <div class="border-b border-purple-100 last:border-b-0 px-2 py-1.5 transition-colors myinfo-table-row" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
                                <div class="flex items-center gap-1">
                                    <div class="myinfo-checkbox-cell" style="width: 40px; flex-shrink: 0;">
                                        <input type="checkbox" class="myinfo-checkbox w-4 h-4 text-[var(--color-hr-primary)] border-gray-300 rounded focus:ring-[var(--color-hr-primary)]">
                                    </div>
                                    <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs text-slate-700 break-words">{{ $dependent->name ?? '' }}</div>
                                    </div>
                                    <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs text-slate-700 break-words">{{ $dependent->relationship ?? '' }}</div>
                                    </div>
                                    <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs text-slate-700 break-words">{{ $dependent->date_of_birth ?? '' }}</div>
                                    </div>
                                    <div class="flex-shrink-0" style="width: 90px; overflow: visible;">
                                        <div class="flex items-center justify-center gap-2" style="overflow: visible;">
                                            <button type="button" class="myinfo-action-btn hr-action-delete flex-shrink-0" title="Delete">
                                                <i class="fas fa-trash-alt text-sm"></i>
                                            </button>
                                            <button type="button" class="myinfo-action-btn hr-action-edit flex-shrink-0" title="Edit">
                                                <i class="fas fa-edit text-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            {{-- No rows --}}
                        @endforelse
                    </div>
                </div>

                <!-- Attachments Section -->
                <div class="rounded-lg shadow-sm border border-purple-100 p-4" style="background-color: var(--bg-card);">
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-sm font-bold text-slate-800">Attachments</h2>
                        <button type="button" onclick="toggleAttachmentForm()" class="myinfo-add-btn px-3 py-1.5 text-xs border border-gray-300 rounded-lg hover:bg-gray-100" style="background-color: #F9FAFB; border-color: #D1D5DB; color: #374151;">
                            + Add
                        </button>
                    </div>

                    <!-- Add Attachment Form (Inline) -->
                    <div id="attachment-form-container" style="display: none;" class="mb-3">
                        <h2 class="text-sm font-bold mb-3" style="color: var(--text-primary);">Add Attachment</h2>
                        <form id="attachment-form">
                            <div class="mb-4">
                                <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">
                                    Select File<span class="text-red-500">*</span>
                                </label>
                                <div class="myinfo-attachment-upload flex items-center gap-2 flex-wrap">
                                    <input type="file" id="attachment-file-input" name="file" required class="hidden" accept="*">
                                    <button type="button" onclick="document.getElementById('attachment-file-input').click()" class="px-3 py-2 text-sm border rounded-lg" style="background-color: var(--bg-hover); border-color: var(--border-default); color: var(--text-primary);">
                                        Browse
                                    </button>
                                    <span id="attachment-file-name" class="text-sm" style="color: var(--text-muted);">No file selected</span>
                                    <button type="button" class="myinfo-action-btn border rounded-lg" style="background-color: var(--bg-hover); border-color: var(--border-default); color: var(--text-primary);" title="Upload">
                                        <i class="fas fa-arrow-up text-sm"></i>
                                    </button>
                                </div>
                                <p class="text-xs mt-1" style="color: var(--text-muted);">Accepts up to 1MB</p>
                            </div>
                            <div class="mb-4">
                                <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">
                                    Comment
                                </label>
                                <textarea name="comment" rows="3" placeholder="Type comment here" class="w-full px-3 py-2 text-sm border rounded-lg resize-y" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);"></textarea>
                            </div>
                            <div class="flex items-center justify-between gap-3">
                                <div class="text-xs" style="color: var(--text-muted);">
                                    <span class="text-red-500">*</span> Required
                                </div>
                                <div class="flex gap-3">
                                    <button type="button" onclick="closeAttachmentForm()" class="px-4 py-2 text-sm font-medium border rounded-lg" style="background-color: white; border-color: var(--color-hr-primary); color: var(--color-hr-primary);">
                                        Cancel
                                    </button>
                                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white rounded-lg" style="background-color: var(--color-hr-primary);">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </form>
                        <hr class="border-gray-200 mb-3 mt-3">
                    </div>

                    @php
                        $attachmentsCount = isset($attachments) ? $attachments->count() : 0;
                    @endphp
                    @if($attachmentsCount === 0)
                        <div class="text-xs text-slate-500 mb-3">No Records Found</div>
                    @else
                        <div class="text-xs text-slate-500 mb-3">({{ $attachmentsCount }}) Records Found</div>
                    @endif

                    <hr class="border-gray-200 mb-0">

                    <!-- Table Header -->
                    <div class="myinfo-table-header bg-gray-100 rounded-t-lg border border-purple-100 border-b-0 px-2 py-1.5 mb-0">
                        <div class="flex items-center gap-1">
                            <div class="myinfo-checkbox-cell" style="width: 40px; flex-shrink: 0;">
                                <input type="checkbox" class="myinfo-checkbox w-4 h-4 text-[var(--color-hr-primary)] border-gray-300 rounded focus:ring-[var(--color-hr-primary)]">
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">File Name</span>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Description</span>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Size</span>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Type</span>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Date Added</span>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Added By</span>
                            </div>
                            <div class="flex-shrink-0" style="width: 90px;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words text-center">Actions</span>
                            </div>
                        </div>
                    </div>

                    <!-- Table Rows -->
                    <div class="border border-purple-100 border-t-0 rounded-b-lg" style="overflow: visible;">
                        @forelse($attachments ?? collect([]) as $attachment)
                            <div class="border-b border-purple-100 last:border-b-0 px-2 py-1.5 transition-colors myinfo-table-row" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
                                <div class="flex items-center gap-1">
                                    <div class="myinfo-checkbox-cell" style="width: 40px; flex-shrink: 0;">
                                        <input type="checkbox" class="myinfo-checkbox w-4 h-4 text-[var(--color-hr-primary)] border-gray-300 rounded focus:ring-[var(--color-hr-primary)]">
                                    </div>
                                    <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs text-slate-700 break-words">{{ $attachment->file_name ?? '' }}</div>
                                    </div>
                                    <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs text-slate-700 break-words">{{ $attachment->description ?? '-' }}</div>
                                    </div>
                                    <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs text-slate-700 break-words">{{ $attachment->size ?? '' }}</div>
                                    </div>
                                    <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs text-slate-700 break-words">{{ $attachment->type ?? '' }}</div>
                                    </div>
                                    <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs text-slate-700 break-words">{{ $attachment->date_added ?? '' }}</div>
                                    </div>
                                    <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs text-slate-700 break-words">{{ $attachment->added_by ?? '' }}</div>
                                    </div>
                                    <div class="flex-shrink-0" style="width: 90px; overflow: visible;">
                                        <div class="flex items-center justify-center gap-2" style="overflow: visible;">
                                            <button type="button" class="myinfo-action-btn hr-action-delete flex-shrink-0" title="Delete">
                                                <i class="fas fa-trash-alt text-sm"></i>
                                            </button>
                                            <button type="button" class="myinfo-action-btn hr-action-edit flex-shrink-0" title="Edit">
                                                <i class="fas fa-edit text-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            {{-- No rows --}}
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </x-main-layout>

    <style>
        /* Same-size components across Assigned Dependents and Attachments */
        .myinfo-add-btn {
            min-width: 4rem;
            min-height: 1.75rem;
            font-size: 0.75rem;
        }
        .myinfo-checkbox {
            width: 1rem;
            height: 1rem;
        }
        .myinfo-checkbox-cell {
            width: 40px;
            min-width: 40px;
        }
        .myinfo-table-header .myinfo-checkbox-cell,
        .myinfo-table-row .myinfo-checkbox-cell {
            width: 40px;
            min-width: 40px;
        }
        .myinfo-action-btn {
            width: 1.75rem;
            height: 1.75rem;
            padding: 0.375rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .myinfo-action-btn i {
            font-size: 0.875rem;
        }
        .myinfo-table-header,
        .myinfo-table-row {
            min-height: 2.25rem;
        }
        .myinfo-table-row > div {
            align-items: center;
        }
    </style>

    <script>
        function toggleDependentForm() {
            const formContainer = document.getElementById('dependent-form-container');
            if (formContainer) {
                if (formContainer.style.display === 'none') {
                    formContainer.style.display = 'block';
                } else {
                    formContainer.style.display = 'none';
                }
            }
        }

        function closeDependentForm() {
            const formContainer = document.getElementById('dependent-form-container');
            if (formContainer) {
                formContainer.style.display = 'none';
                // Reset form
                const form = document.getElementById('dependent-form');
                if (form) {
                    form.reset();
                }
            }
        }

        // Prevent form submission for now
        document.getElementById('dependent-form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            // Form submission logic can be added here later
            closeDependentForm();
        });

        function toggleAttachmentForm() {
            const formContainer = document.getElementById('attachment-form-container');
            if (formContainer) {
                if (formContainer.style.display === 'none') {
                    formContainer.style.display = 'block';
                } else {
                    formContainer.style.display = 'none';
                }
            }
        }

        function closeAttachmentForm() {
            const formContainer = document.getElementById('attachment-form-container');
            if (formContainer) {
                formContainer.style.display = 'none';
                const form = document.getElementById('attachment-form');
                if (form) {
                    form.reset();
                }
                const fileNameSpan = document.getElementById('attachment-file-name');
                if (fileNameSpan) {
                    fileNameSpan.textContent = 'No file selected';
                }
            }
        }

        document.getElementById('attachment-file-input')?.addEventListener('change', function() {
            const span = document.getElementById('attachment-file-name');
            if (span) {
                span.textContent = this.files && this.files[0] ? this.files[0].name : 'No file selected';
            }
        });

        document.getElementById('attachment-form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            // Form submission logic can be added here later
            closeAttachmentForm();
        });
    </script>
@endsection
