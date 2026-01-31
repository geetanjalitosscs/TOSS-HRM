@extends('layouts.app')

@section('title', 'My Info - Immigration')

@section('body')
    <x-main-layout title="My Info">
        <div class="flex items-stretch">
            @include('myinfo.partials.sidebar')

            <!-- Right Content Area -->
            <div class="flex-1">
                <!-- Assigned Immigration Records Section -->
                <div class="rounded-lg shadow-sm border border-purple-100 p-4 mb-3" style="background-color: var(--bg-card);">
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-sm font-bold text-slate-800">Assigned Immigration Records</h2>
                        <button type="button" onclick="toggleImmigrationForm()" class="myinfo-add-btn px-3 py-1.5 text-xs border border-gray-300 rounded-lg hover:bg-gray-100" style="background-color: #F9FAFB; border-color: #D1D5DB; color: #374151;">
                            + Add
                        </button>
                    </div>

                    <!-- Add Immigration Form (Inline) -->
                    <div id="immigration-form-container" style="display: none;" class="mb-3">
                        <h2 class="text-sm font-bold mb-3" style="color: var(--text-primary);">Add Immigration</h2>
                        <form id="immigration-form">
                            <div class="mb-4">
                                <label class="block text-xs font-medium mb-1.5 immigration-form-label" style="color: var(--text-primary);">Document</label>
                                <div class="flex gap-4 items-center immigration-form-field-height">
                                    <label class="inline-flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="document" value="Passport" checked class="immigration-form-radio w-4 h-4 text-[var(--color-hr-primary)] border-gray-300 focus:ring-[var(--color-hr-primary)]">
                                        <span class="text-sm" style="color: var(--text-primary);">Passport</span>
                                    </label>
                                    <label class="inline-flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="document" value="Visa" class="immigration-form-radio w-4 h-4 text-[var(--color-hr-primary)] border-gray-300 focus:ring-[var(--color-hr-primary)]">
                                        <span class="text-sm" style="color: var(--text-primary);">Visa</span>
                                    </label>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-medium mb-1.5 immigration-form-label" style="color: var(--text-primary);">Number<span class="text-red-500">*</span></label>
                                    <input type="text" name="number" required class="immigration-form-input w-full px-3 py-2 text-sm border rounded-lg" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);" placeholder="">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium mb-1.5 immigration-form-label" style="color: var(--text-primary);">Issued Date</label>
                                    <x-date-picker id="immigration-issued-date" name="issued_date" value="" placeholder="yyyy-dd-mm" variant="split" wrapperClass="immigration-form-date-wrap" />
                                </div>
                                <div>
                                    <label class="block text-xs font-medium mb-1.5 immigration-form-label" style="color: var(--text-primary);">Expiry Date</label>
                                    <x-date-picker id="immigration-expiry-date" name="expiry_date" value="" placeholder="yyyy-dd-mm" variant="split" wrapperClass="immigration-form-date-wrap" />
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-medium mb-1.5 immigration-form-label" style="color: var(--text-primary);">Eligible Status</label>
                                    <input type="text" name="eligible_status" class="immigration-form-input w-full px-3 py-2 text-sm border rounded-lg" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);" placeholder="">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium mb-1.5 immigration-form-label" style="color: var(--text-primary);">Issued By</label>
                                    <select name="issued_by" class="immigration-form-input w-full px-3 py-2 text-sm border rounded-lg" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                                        <option value="">-- Select --</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium mb-1.5 immigration-form-label" style="color: var(--text-primary);">Eligible Review Date</label>
                                    <x-date-picker id="immigration-eligible-review-date" name="eligible_review_date" value="" placeholder="yyyy-dd-mm" variant="split" wrapperClass="immigration-form-date-wrap" />
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-xs font-medium mb-1.5 immigration-form-label" style="color: var(--text-primary);">Comments</label>
                                <textarea name="comments" rows="3" placeholder="Type Comments here" class="immigration-form-textarea w-full px-3 py-2 text-sm border rounded-lg resize-y" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);"></textarea>
                            </div>
                            <div class="text-xs mb-4" style="color: var(--text-muted);">
                                <span class="text-red-500">*</span> Required
                            </div>
                            <div class="flex justify-end gap-3">
                                <button type="button" onclick="closeImmigrationForm()" class="immigration-form-btn immigration-form-btn-cancel px-4 py-2 text-sm font-medium border rounded-lg" style="background-color: white; border-color: var(--color-hr-primary); color: var(--color-hr-primary);">
                                    Cancel
                                </button>
                                <button type="submit" class="immigration-form-btn immigration-form-btn-save px-4 py-2 text-sm font-medium text-white rounded-lg" style="background-color: var(--color-hr-primary);">
                                    Save
                                </button>
                            </div>
                        </form>
                        <hr class="border-gray-200 mb-3 mt-3">
                    </div>

                    @php
                        $immigrationCount = isset($immigrationRecords) ? $immigrationRecords->count() : 0;
                    @endphp
                    @if($immigrationCount === 0)
                        <div class="text-xs text-slate-500 mb-3">No Records Found</div>
                    @else
                        <div class="text-xs text-slate-500 mb-3">({{ $immigrationCount }}) Record Found</div>
                    @endif

                    <hr class="border-gray-200 mb-0">

                    <!-- Table Header -->
                    <div class="myinfo-table-header bg-gray-100 rounded-t-lg border border-purple-100 border-b-0 px-2 py-1.5 mb-0">
                        <div class="flex items-center gap-1 immigration-table-row">
                            <div class="myinfo-checkbox-cell" style="width: 40px; flex-shrink: 0;">
                                <input type="checkbox" class="myinfo-checkbox w-4 h-4 text-[var(--color-hr-primary)] border-gray-300 rounded focus:ring-[var(--color-hr-primary)]">
                            </div>
                            <div class="myinfo-col-equal flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Document</span>
                            </div>
                            <div class="myinfo-col-equal flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Number</span>
                            </div>
                            <div class="myinfo-col-equal flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Issued By</span>
                            </div>
                            <div class="myinfo-col-equal flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Issued Date</span>
                            </div>
                            <div class="myinfo-col-equal flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Expiry Date</span>
                            </div>
                            <div class="flex-shrink-0 myinfo-actions-col">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words text-center">Actions</span>
                            </div>
                        </div>
                    </div>

                    <!-- Table Rows -->
                    <div class="border border-purple-100 border-t-0 rounded-b-lg" style="overflow: visible;">
                        @forelse($immigrationRecords ?? collect([]) as $record)
                            <div class="border-b border-purple-100 last:border-b-0 px-2 py-1.5 transition-colors myinfo-table-row" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
                                <div class="flex items-center gap-1 immigration-table-row">
                                    <div class="myinfo-checkbox-cell" style="width: 40px; flex-shrink: 0;">
                                        <input type="checkbox" class="myinfo-checkbox w-4 h-4 text-[var(--color-hr-primary)] border-gray-300 rounded focus:ring-[var(--color-hr-primary)]">
                                    </div>
                                    <div class="myinfo-col-equal flex-1" style="min-width: 0;">
                                        <div class="text-xs text-slate-700 break-words">{{ $record->document ?? '' }}</div>
                                    </div>
                                    <div class="myinfo-col-equal flex-1" style="min-width: 0;">
                                        <div class="text-xs text-slate-700 break-words">{{ $record->number ?? '' }}</div>
                                    </div>
                                    <div class="myinfo-col-equal flex-1" style="min-width: 0;">
                                        <div class="text-xs text-slate-700 break-words">{{ $record->issued_by ?? '' }}</div>
                                    </div>
                                    <div class="myinfo-col-equal flex-1" style="min-width: 0;">
                                        <div class="text-xs text-slate-700 break-words">{{ $record->issued_date ?? '' }}</div>
                                    </div>
                                    <div class="myinfo-col-equal flex-1" style="min-width: 0;">
                                        <div class="text-xs text-slate-700 break-words">{{ $record->expiry_date ?? '' }}</div>
                                    </div>
                                    <div class="flex-shrink-0 myinfo-actions-col overflow-visible">
                                        <div class="flex items-center justify-center gap-2 overflow-visible">
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
                                <label class="block text-xs font-medium mb-1.5 attachment-form-label" style="color: var(--text-primary);">Select File<span class="text-red-500">*</span></label>
                                <div class="attachment-form-file-row flex items-center gap-2 flex-wrap">
                                    <input type="file" id="attachment-file-input" name="file" required class="hidden" accept="*">
                                    <button type="button" onclick="document.getElementById('attachment-file-input').click()" class="attachment-form-btn attachment-form-browse px-3 py-2 text-sm border rounded-lg" style="background-color: var(--bg-hover); border-color: var(--border-default); color: var(--text-primary);">
                                        Browse
                                    </button>
                                    <div id="attachment-file-name" class="attachment-form-filename flex-1 px-3 py-2 text-sm border rounded-lg min-w-0" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-muted);">No file selected</div>
                                    <button type="button" class="attachment-form-btn attachment-form-upload flex-shrink-0 px-3 py-2 text-sm border rounded-lg" style="background-color: var(--bg-hover); border-color: var(--border-default); color: var(--text-primary);" title="Upload">
                                        <i class="fas fa-arrow-up text-sm"></i>
                                    </button>
                                </div>
                                <p class="text-xs mt-1" style="color: var(--text-muted);">Accepts up to 1MB</p>
                            </div>
                            <div class="mb-4">
                                <label class="block text-xs font-medium mb-1.5 attachment-form-label" style="color: var(--text-primary);">Comment</label>
                                <textarea name="comment" rows="3" placeholder="Type comment here" class="attachment-form-textarea w-full px-3 py-2 text-sm border rounded-lg resize-y" style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);"></textarea>
                            </div>
                            <div class="flex items-center justify-between gap-3">
                                <div class="text-xs" style="color: var(--text-muted);">
                                    <span class="text-red-500">*</span> Required
                                </div>
                                <div class="flex gap-3">
                                    <button type="button" onclick="closeAttachmentForm()" class="attachment-form-btn attachment-form-btn-cancel px-4 py-2 text-sm font-medium border rounded-lg" style="background-color: white; border-color: var(--color-hr-primary); color: var(--color-hr-primary);">
                                        Cancel
                                    </button>
                                    <button type="submit" class="attachment-form-btn attachment-form-btn-save px-4 py-2 text-sm font-medium text-white rounded-lg" style="background-color: var(--color-hr-primary);">
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
                        <div class="text-xs text-slate-500 mb-3">({{ $attachmentsCount }}) Record Found</div>
                    @endif

                    <hr class="border-gray-200 mb-0">

                    <!-- Table Header -->
                    <div class="myinfo-table-header bg-gray-100 rounded-t-lg border border-purple-100 border-b-0 px-2 py-1.5 mb-0">
                        <div class="flex items-center gap-1 attachments-table-row">
                            <div class="myinfo-checkbox-cell" style="width: 40px; flex-shrink: 0;">
                                <input type="checkbox" class="myinfo-checkbox w-4 h-4 text-[var(--color-hr-primary)] border-gray-300 rounded focus:ring-[var(--color-hr-primary)]">
                            </div>
                            <div class="myinfo-col-equal flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">File Name</span>
                            </div>
                            <div class="myinfo-col-equal flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Description</span>
                            </div>
                            <div class="myinfo-col-equal flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Size</span>
                            </div>
                            <div class="myinfo-col-equal flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Type</span>
                            </div>
                            <div class="myinfo-col-equal flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Date Added</span>
                            </div>
                            <div class="myinfo-col-equal flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Added By</span>
                            </div>
                            <div class="flex-shrink-0 myinfo-actions-col">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words text-center">Actions</span>
                            </div>
                        </div>
                    </div>

                    <!-- Table Rows -->
                    <div class="border border-purple-100 border-t-0 rounded-b-lg" style="overflow: visible;">
                        @forelse($attachments ?? collect([]) as $attachment)
                            <div class="border-b border-purple-100 last:border-b-0 px-2 py-1.5 transition-colors myinfo-table-row" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
                                <div class="flex items-center gap-1 attachments-table-row">
                                    <div class="myinfo-checkbox-cell" style="width: 40px; flex-shrink: 0;">
                                        <input type="checkbox" class="myinfo-checkbox w-4 h-4 text-[var(--color-hr-primary)] border-gray-300 rounded focus:ring-[var(--color-hr-primary)]">
                                    </div>
                                    <div class="myinfo-col-equal flex-1" style="min-width: 0;">
                                        <div class="text-xs text-slate-700 break-words">{{ $attachment->file_name ?? '' }}</div>
                                    </div>
                                    <div class="myinfo-col-equal flex-1" style="min-width: 0;">
                                        <div class="text-xs text-slate-700 break-words">{{ $attachment->description ?? '-' }}</div>
                                    </div>
                                    <div class="myinfo-col-equal flex-1" style="min-width: 0;">
                                        <div class="text-xs text-slate-700 break-words">{{ $attachment->size ?? '' }}</div>
                                    </div>
                                    <div class="myinfo-col-equal flex-1" style="min-width: 0;">
                                        <div class="text-xs text-slate-700 break-words">{{ $attachment->type ?? '' }}</div>
                                    </div>
                                    <div class="myinfo-col-equal flex-1" style="min-width: 0;">
                                        <div class="text-xs text-slate-700 break-words">{{ $attachment->date_added ?? '' }}</div>
                                    </div>
                                    <div class="myinfo-col-equal flex-1" style="min-width: 0;">
                                        <div class="text-xs text-slate-700 break-words">{{ $attachment->added_by ?? '' }}</div>
                                    </div>
                                    <div class="flex-shrink-0 myinfo-actions-col overflow-visible">
                                        <div class="flex items-center justify-center gap-2 overflow-visible">
                                            <button type="button" class="myinfo-action-btn hr-action-edit flex-shrink-0" title="Edit">
                                                <i class="fas fa-edit text-sm"></i>
                                            </button>
                                            <button type="button" class="myinfo-action-btn hr-action-delete flex-shrink-0" title="Delete">
                                                <i class="fas fa-trash-alt text-sm"></i>
                                            </button>
                                            <button type="button" class="myinfo-action-btn flex-shrink-0" title="Download">
                                                <i class="fas fa-download text-sm"></i>
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
        /* Same-size components across Assigned Immigration Records and Attachments */
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
        .myinfo-table-row > div,
        .myinfo-table-header > div {
            align-items: center;
        }
        .myinfo-col-equal {
            flex: 1 1 0;
            min-width: 0;
        }
        .myinfo-actions-col {
            width: 7rem;
            min-width: 7rem;
        }

        /* Add Immigration form – equal-size components */
        .immigration-form-label {
            font-size: 0.75rem;
            margin-bottom: 0.375rem;
        }
        .immigration-form-input,
        .immigration-form-date-wrap .hr-input,
        .immigration-form-date-wrap button {
            min-height: 2.5rem;
            height: 2.5rem;
            box-sizing: border-box;
        }
        .immigration-form-date-wrap {
            min-height: 2.5rem;
            display: flex;
        }
        .immigration-form-date-wrap .hr-input {
            flex: 1;
            min-width: 0;
        }
        .immigration-form-date-wrap button {
            flex-shrink: 0;
        }
        .immigration-form-field-height {
            min-height: 2.5rem;
            align-items: center;
        }
        .immigration-form-radio {
            width: 1rem;
            height: 1rem;
        }
        .immigration-form-textarea {
            min-height: 5rem;
            box-sizing: border-box;
        }
        .immigration-form-btn {
            min-width: 5rem;
            min-height: 2.25rem;
            font-size: 0.875rem;
        }

        /* Add Attachment form – equal-size components */
        .attachment-form-label {
            font-size: 0.75rem;
            margin-bottom: 0.375rem;
        }
        .attachment-form-file-row {
            min-height: 2.5rem;
            align-items: stretch;
        }
        .attachment-form-btn,
        .attachment-form-filename {
            min-height: 2.5rem;
            height: 2.5rem;
            box-sizing: border-box;
            display: inline-flex;
            align-items: center;
        }
        .attachment-form-filename {
            display: flex;
            align-items: center;
        }
        .attachment-form-browse {
            min-width: 5rem;
        }
        .attachment-form-upload {
            width: 2.5rem;
            min-width: 2.5rem;
            padding: 0;
            justify-content: center;
        }
        .attachment-form-textarea {
            min-height: 5rem;
            box-sizing: border-box;
        }
        .attachment-form-btn-cancel,
        .attachment-form-btn-save {
            min-width: 5rem;
            min-height: 2.25rem;
            font-size: 0.875rem;
        }
    </style>

    <script>
        function toggleImmigrationForm() {
            const formContainer = document.getElementById('immigration-form-container');
            if (formContainer) {
                formContainer.style.display = formContainer.style.display === 'none' ? 'block' : 'none';
            }
        }

        function closeImmigrationForm() {
            const formContainer = document.getElementById('immigration-form-container');
            if (formContainer) {
                formContainer.style.display = 'none';
            }
            const form = document.getElementById('immigration-form');
            if (form) {
                form.reset();
            }
        }

        document.getElementById('immigration-form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            closeImmigrationForm();
        });

        function toggleAttachmentForm() {
            const formContainer = document.getElementById('attachment-form-container');
            if (formContainer) {
                formContainer.style.display = formContainer.style.display === 'none' ? 'block' : 'none';
            }
        }

        function closeAttachmentForm() {
            const formContainer = document.getElementById('attachment-form-container');
            if (formContainer) {
                formContainer.style.display = 'none';
            }
            const form = document.getElementById('attachment-form');
            if (form) {
                form.reset();
            }
            const fileNameSpan = document.getElementById('attachment-file-name');
            if (fileNameSpan) {
                fileNameSpan.textContent = 'No file selected';
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
            closeAttachmentForm();
        });
    </script>
@endsection
