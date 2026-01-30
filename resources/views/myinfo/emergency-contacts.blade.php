@extends('layouts.app')

@section('title', 'My Info - Emergency Contacts')

@section('body')
    <x-main-layout title="PIM">
        <div class="flex items-stretch">
            @include('myinfo.partials.sidebar')

            <!-- Right Content Area -->
            <div class="flex-1">
                <!-- Assigned Emergency Contacts Section -->
                <div class="rounded-lg shadow-sm border border-purple-100 p-4 mb-3" style="background-color: var(--bg-card);">
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-sm font-bold text-slate-800">Assigned Emergency Contacts</h2>
                        <button onclick="toggleEmergencyContactForm()" class="px-3 py-1.5 text-xs border border-gray-300 rounded-lg bg-gray-50 hover:bg-gray-100 text-blue-600" style="background-color: #F9FAFB; border-color: #D1D5DB;">
                            + Add
                        </button>
                    </div>

                    <!-- Emergency Contact Form (Inline) -->
                    <div id="emergency-contact-form-container" style="display: none;" class="mb-3">
                        <h2 class="text-sm font-bold mb-3" style="color: var(--text-primary);">Save Emergency Contact</h2>
                        <form id="emergency-contact-form">
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
                                    <input type="text" name="relationship" required class="w-full px-3 py-2 text-sm border rounded-lg" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                                </div>
                                <div></div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">
                                        Home Telephone
                                    </label>
                                    <input type="text" name="home_telephone" class="w-full px-3 py-2 text-sm border rounded-lg" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">
                                        Mobile
                                    </label>
                                    <input type="text" name="mobile" class="w-full px-3 py-2 text-sm border rounded-lg" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium mb-1.5" style="color: var(--text-primary);">
                                        Work Telephone
                                    </label>
                                    <input type="text" name="work_telephone" class="w-full px-3 py-2 text-sm border rounded-lg" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                                </div>
                            </div>
                            <div class="text-xs mb-4" style="color: var(--text-muted);">
                                <span class="text-red-500">*</span> Required
                            </div>
                            <div class="flex justify-end gap-3">
                                <button type="button" onclick="closeEmergencyContactForm()" class="px-4 py-2 text-sm font-medium border rounded-lg" style="background-color: white; border-color: var(--color-hr-primary); color: var(--color-hr-primary);">
                                    Cancel
                                </button>
                                <button type="submit" class="px-4 py-2 text-sm font-medium text-white rounded-lg" style="background-color: var(--color-hr-primary);">
                                    Save
                                </button>
                            </div>
                        </form>
                        <hr class="border-gray-200 mb-3 mt-3">
                    </div>

                    <hr class="border-gray-200 mb-3">

                    <div class="text-xs text-slate-500 mb-3 text-center">No Records Found</div>

                    <hr class="border-gray-200 mb-0">

                    <!-- Table Header -->
                    <div class="bg-gray-100 rounded-t-lg border border-purple-100 border-b-0 px-2 py-1.5 mb-0">
                        <div class="flex items-center gap-1">
                            <div style="width: 40px; flex-shrink: 0;">
                                <input type="checkbox" class="w-3 h-3 text-[var(--color-hr-primary)] border-gray-300 rounded focus:ring-[var(--color-hr-primary)]">
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Name</span>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Relationship</span>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Home Telephone</span>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Mobile</span>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Work Telephone</span>
                            </div>
                            <div class="flex-shrink-0" style="width: 90px;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words text-center">Actions</span>
                            </div>
                        </div>
                    </div>

                    <!-- Table Rows -->
                    <div class="border border-purple-100 border-t-0 rounded-b-lg" style="overflow: visible;">
                        <!-- Empty state - no rows to display -->
                    </div>
                </div>

                <!-- Attachments Section -->
                <div class="rounded-lg shadow-sm border border-purple-100 p-4" style="background-color: var(--bg-card);">
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-sm font-bold text-slate-800">Attachments</h2>
                        <button onclick="toggleAttachmentForm()" class="px-3 py-1.5 text-xs border border-gray-300 rounded-lg bg-gray-50 hover:bg-gray-100 text-blue-600" style="background-color: #F9FAFB; border-color: #D1D5DB;">
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
                                <div class="flex items-center gap-2 flex-wrap">
                                    <input type="file" id="attachment-file-input" name="file" required class="hidden" accept="*">
                                    <button type="button" onclick="document.getElementById('attachment-file-input').click()" class="px-3 py-2 text-sm border rounded-lg" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                                        Browse
                                    </button>
                                    <span id="attachment-file-name" class="text-sm" style="color: var(--text-muted);">No file selected</span>
                                    <button type="button" class="p-2 border rounded-lg" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);" title="Upload">
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

                    <hr class="border-gray-200 mb-3">

                    @if(count($attachments) == 0)
                        <div class="text-xs text-slate-500 mb-3 text-center">No Records Found</div>
                    @else
                        <x-records-found :count="count($attachments)" />
                    @endif

                    <hr class="border-gray-200 mb-0">

                    <!-- Table Header -->
                    <div class="bg-gray-100 rounded-t-lg border border-purple-100 border-b-0 px-2 py-1.5 mb-0">
                        <div class="flex items-center gap-1">
                            <div style="width: 40px; flex-shrink: 0;">
                                <input type="checkbox" class="w-3 h-3 text-[var(--color-hr-primary)] border-gray-300 rounded focus:ring-[var(--color-hr-primary)]">
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
                        @if(count($attachments) == 0)
                            <div class="px-2 py-1.5" style="background-color: var(--bg-card);">
                                <div class="text-xs text-slate-500 text-center py-4">No attachments found</div>
                            </div>
                        @else
                            @foreach($attachments as $attachment)
                                <div class="border-b border-purple-100 last:border-b-0 px-2 py-1.5 transition-colors" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
                                    <div class="flex items-center gap-1">
                                        <div style="width: 40px; flex-shrink: 0;">
                                            <input type="checkbox" class="w-3 h-3 text-[var(--color-hr-primary)] border-gray-300 rounded focus:ring-[var(--color-hr-primary)]">
                                        </div>
                                        <div class="flex-1" style="min-width: 0;">
                                            <div class="text-xs text-slate-700 break-words">{{ $attachment->file_name }}</div>
                                        </div>
                                        <div class="flex-1" style="min-width: 0;">
                                            <div class="text-xs text-slate-700 break-words">{{ $attachment->description ?: '-' }}</div>
                                        </div>
                                        <div class="flex-1" style="min-width: 0;">
                                            <div class="text-xs text-slate-700 break-words">{{ $attachment->size }}</div>
                                        </div>
                                        <div class="flex-1" style="min-width: 0;">
                                            <div class="text-xs text-slate-700 break-words">{{ $attachment->type }}</div>
                                        </div>
                                        <div class="flex-1" style="min-width: 0;">
                                            <div class="text-xs text-slate-700 break-words">{{ $attachment->date_added }}</div>
                                        </div>
                                        <div class="flex-1" style="min-width: 0;">
                                            <div class="text-xs text-slate-700 break-words">{{ $attachment->added_by }}</div>
                                        </div>
                                        <div class="flex-shrink-0" style="width: 90px; overflow: visible;">
                                            <div class="flex items-center justify-center gap-2" style="overflow: visible;">
                                                <button class="hr-action-edit flex-shrink-0" title="Edit">
                                                    <i class="fas fa-edit text-sm"></i>
                                                </button>
                                                <button class="hr-action-delete flex-shrink-0" title="Delete">
                                                    <i class="fas fa-trash-alt text-sm"></i>
                                                </button>
                                                <button class="hr-action-download flex-shrink-0" title="Download">
                                                    <i class="fas fa-download text-sm"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </x-main-layout>

    <script>
        function toggleEmergencyContactForm() {
            const formContainer = document.getElementById('emergency-contact-form-container');
            if (formContainer) {
                if (formContainer.style.display === 'none') {
                    formContainer.style.display = 'block';
                } else {
                    formContainer.style.display = 'none';
                }
            }
        }

        function closeEmergencyContactForm() {
            const formContainer = document.getElementById('emergency-contact-form-container');
            if (formContainer) {
                formContainer.style.display = 'none';
                // Reset form
                const form = document.getElementById('emergency-contact-form');
                if (form) {
                    form.reset();
                }
            }
        }

        // Prevent form submission for now
        document.getElementById('emergency-contact-form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            // Form submission logic can be added here later
            closeEmergencyContactForm();
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
